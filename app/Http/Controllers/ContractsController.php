<?php

namespace App\Http\Controllers;

use PDF;
use Mail;

use App\Models\User;
use App\Models\State;
use App\Models\Branch;
use App\Models\Office;
use App\Models\Meeting;
use App\Models\Contract;
use App\Models\OfficeType;
use App\Models\Application;
use App\Models\SuggestedPrice;
use App\Models\ChargeContract;
use App\Models\PaymentHistory;
use App\Models\CancelledContract;
use App\Models\OfficeTypeCategory;

use Illuminate\Http\Request;

class ContractsController extends Controller
{
    /**
     * Show the customers contracts.
     *
     */
    public function index(Request $req, $id = null)
    {
        $l_usr = $this->log_user;
        $contracts = Contract::filter_rows($l_usr, 1, $id);
        $branches = Branch::where('status', 1)->get();
        if ($req->ajax()) {
            return view('applications.customers_contracts.table', ['contracts' => $contracts]);
        }
        return view('applications.customers_contracts.index', ['contracts' => $contracts, 'branches' => $branches]);
    }

    /**
     * Show the pdf contract.
     *
     */
    public function show_contract($contract_id)
    {
        set_time_limit(0);
        $contract = Contract::find($contract_id);
        if ($contract) {
            $view = $this->get_contract_path($contract);
            if (view()->exists($view)) {
                $pdf = PDF::loadView($view, ['contract' => $contract])
                ->setPaper('letter')->setWarnings(false);
                return $pdf->stream('contrato.pdf');//Visualiza el archivo sin descargarlo
            }
            return redirect()->back()->with('msg', 'Plantilla de contrato no encontrada, contacte al administrador.');
        }
        return redirect()->back()->with('msg', 'ID de contrato inválido, trate nuevamente.');
    }

    /**
     * Show the pdf contract.
     *
     */
    public function show_money_receipt($contract_id, $type_payment, $status)
    {
        $contract = Contract::find($contract_id);
        if ($contract) {
            $pdf = PDF::loadView('contracts.other_documents.money_receipt_office', ['contract' => $contract, 'type_payment' => $type_payment, 'status' => $status])
            ->setPaper('letter')->setWarnings(false);
            return $pdf->stream('recibo_de_pago.pdf');//Visualiza el archivo sin descargarlo
        }
    }

    /**
     * Show the form for creating/editing a resource about a new contract.
     *
     * @return \Illuminate\Http\Response
     */
    public function form($app_id, $contract_id = 0)
    {
        $title = $contract_id ? "Editar contrato" : "Crear contrato";
        $menu = "Prospectos";
        $states = State::all();
        $of_ty_cat = $prospect = $contract = null;
        if ($app_id) {
            $prospect = Application::/*where('status', 0)->*/where('id', $app_id)->first();
            $of_ty_cat = OfficeTypeCategory::where('office_type_id', $prospect->office->type->id)->get();
        }

        if ($contract_id) {
            $contract = Contract::find($contract_id);
        }
        if ($prospect) { $this->create_user($app_id); }//Creates an application user if is neccesary
        $prospect = Application::find($app_id);

        return view('applications.generate_contract.form', ['prospect' => $prospect, 'states' => $states, 'contract' => $contract, 'of_ty_cat' => $of_ty_cat, 'n_ext' => $this->ext_m, 'menu' => $menu, 'title' => $title]);
    }

    /**
     * Save the contract data.
     *
     * @return \Illuminate\Http\Response
     */
    public function save(Request $req)
    {
        $available = $this->check_office_status($req->office_id);
        $office = Office::find($req->office_id);
        $user = User::find($req->user_id);
        if (!$available) { return response(['msg' => 'Oficina no disponible, porfavor, seleccione una diferente', 'status' => 'error'], 400); }
        if (!$user) { return response(['msg' => 'ID de cliente inválido', 'status' => 'error'], 400); }

        $n_words = new \NumberFormatter("es", \NumberFormatter::SPELLOUT);

        $contract = New Contract;

        $initial_day = date('Y-m-d', strtotime($req->start_date_validity));

        $initial_day = date($req->start_date_validity);
        $initial_day = date_create($initial_day);
        $total_days = intval($initial_day->format('t'));
        $day = intval($initial_day->format('d'));

        //if ($office->type->name == 'Sala de juntas' || $office->type->name == 'Sala de conferencias') {
            if ($day > 24) {
                $aux = $total_days - $day;
                $aux ++;
                $initial_day = date_add($initial_day, date_interval_create_from_date_string($aux.' days'));
            }
        //}
            

        $end_day = clone $initial_day;
        $end_day = date_add($end_day, date_interval_create_from_date_string('4 days'));

        //General contract data
        $req->has('user_id') ? $contract->user_id = $req->user_id : '';
        $req->has('application_id') ? $contract->application_id = $req->application_id : '';
        $contract->office_id = $req->office_id;
        //Virtual office
        $contract->office_type_category_id = $req->office_type_category_id;
        //Meeting room
        $contract->start_hour = $req->start_hour;
        $contract->end_hour = $req->end_hour;
        $contract->total_hours = $req->total_hours;
        $contract->contract_date = $req->contract_date;
        $contract->start_date_validity = $initial_day->format('Y-m-d');
        $contract->end_date_validity = $req->end_date_validity;
        $contract->monthly_payment_str = ucfirst($n_words->format($office->price * 0.90))." $this->ext_m";
        $contract->monthly_payment_delay_str = ucfirst($n_words->format($office->price))." $this->ext_m";
        //Date fields
        $contract->actual_pay_date = $initial_day->format('Y-m-d');//Month to pay
        $contract->payment_range_start = $initial_day->format('d');
        $contract->payment_range_end = $end_day->format('d');

        //Balance fields
        $contract->balance = 0;
        $contract->balance_str = ucfirst($n_words->format(0))." $this->ext_m";
        
        //Provider
        $contract->provider_name = $req->provider_name;
        $contract->provider_address = $req->provider_address;
        //Physical
        $contract->provider_ine_number = $req->provider_ine_number;
        //Moral
        $contract->provider_act_number = $req->provider_act_number;
        $contract->provider_notary_number = $req->provider_notary_number;
        $contract->provider_notary_state_id = $req->provider_notary_state_id;
        $contract->provider_notary_name = $req->provider_notary_name;

        //Customer
        $contract->customer_address = $req->customer_address;//Also for company address in moral customer
        //Physical
        $contract->customer_ine_number = $req->customer_ine_number;
        $contract->customer_activity = $req->customer_activity;
        //Moral
        $contract->customer_company = $req->customer_company;
        $contract->customer_act_number = $req->customer_act_number;
        $contract->customer_notary_number = $req->customer_notary_number;
        $contract->customer_notary_state_id = $req->customer_notary_state_id;
        $contract->customer_notary_name = $req->customer_notary_name;
        $contract->customer_deed_number = $req->customer_deed_number;
        $contract->customer_deed_date = $req->customer_deed_date;
        $contract->customer_social_object = $req->customer_social_object;
        $contract->status = 0;//Pending of payment

        $contract->save();

        //Create charge for contract
        $charge = New ChargeContract;

        $charge->contract_id = $contract->id;
        $charge->amount = $office->price * 0.90;
        $charge->amount_str = ucfirst($n_words->format($office->price * 0.90))." $this->ext_m";
        $charge->pay_date = $contract->actual_pay_date;
        $charge->status = 1;//Pago normal

        $charge->save();

        $this->change_office_status($req->office_id, 2);//Rented!!

        if ($req->has('application_id')) {
            $app = Application::find($req->application_id);
            if ($app) {
                $app->status = 1;//Marked as customer
                $app->save();
            }
        }

        //Lets check if a new price has been suggested
        if ($req->new_price) {
            $n_price = New SuggestedPrice;

            $n_price->contract_id = $contract->id;
            $n_price->user_id = $this->log_user->id;
            $n_price->office_id = $office->id;
            $n_price->new_price = $req->new_price;

            $n_price->save();
        }

        $to = $user->email;
        $subject = "Fastoffice | Contrato concedido";

        Mail::send('mails.general', ['title' => 'Nuevo contrato conseguido', 'content' => 'Felicidades, ha rentado una nueva oficina, podrá ver su estado de cuenta desde nuestra aplicación en cualquier momento'], function ($message)  use ($to, $subject)
        {
            $message->from(env('MAIL_USERNAME'), env('APP_NAME'));
            $message->to($to);
            $message->subject($subject);
        });

        if ( !Mail::failures() ){
            return response(['msg' => 'Contrato generado exitósamente, se ha enviado un correo al cliente', 'status' => 'success', 'url' => url('crm/contracts')], 200);
        } else {
            return response(['msg' => 'Contrato generado exitósamente', 'status' => 'success', 'url' => url('crm/contracts')], 200);
        }
    }

    /**
     * Updates the contract data.
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $req)
    {
        $contract = Contract::find($req->id);
        $office = Office::find($req->office_id);

        if (!$contract) { return response(['msg' => 'ID de contrato inválido', 'status' => 'error'], 404); }

        $n_words = new \NumberFormatter("es", \NumberFormatter::SPELLOUT);

        //General contract data
        $req->has('user_id') ? $contract->user_id = $req->user_id : '';
        $req->has('application_id') ? $contract->application_id = $req->application_id : '';
        $contract->office_id = $req->office_id;
        //Virtual office
        $contract->office_type_category_id = $req->office_type_category_id;
        //Meeting room
        $contract->start_hour = $req->start_hour;
        $contract->end_hour = $req->end_hour;
        $contract->total_hours = $req->total_hours;
        //
        //$contract->contract_date = $req->contract_date;
        //$contract->start_date_validity = $req->start_date_validity;
        $contract->end_date_validity = $req->end_date_validity;
        $contract->monthly_payment_str = ucfirst($n_words->format($office->price * 0.90))." $this->ext_m";
        $contract->monthly_payment_delay_str = ucfirst($n_words->format($office->price))." $this->ext_m";

        //Provider
        $contract->provider_name = $req->provider_name;
        $contract->provider_address = $req->provider_address;
        //Physical
        $contract->provider_ine_number = $req->provider_ine_number;
        //Moral
        $contract->provider_act_number = $req->provider_act_number;
        $contract->provider_notary_number = $req->provider_notary_number;
        $contract->provider_notary_state_id = $req->provider_notary_state_id;
        $contract->provider_notary_name = $req->provider_notary_name;

        //Customer
        $contract->customer_address = $req->customer_address;//Also for company address in moral customer
        //Physical
        $contract->customer_ine_number = $req->customer_ine_number;
        $contract->customer_activity = $req->customer_activity;
        //Moral
        $contract->customer_company = $req->customer_company;
        $contract->customer_act_number = $req->customer_act_number;
        $contract->customer_notary_number = $req->customer_notary_number;
        $contract->customer_notary_state_id = $req->customer_notary_state_id;
        $contract->customer_notary_name = $req->customer_notary_name;
        $contract->customer_deed_number = $req->customer_deed_number;
        $contract->customer_deed_date = $req->customer_deed_date;
        $contract->customer_social_object = $req->customer_social_object;

        $contract->save();

        $this->change_office_status($req->office_id, 2);//Rented!!

        return response(['msg' => 'Contrato modificado exitósamente', 'status' => 'success', 'url' => url('crm/contracts')], 200);
    }

    /**
     * Register a payment for a contract.
     *
     * @return \Illuminate\Http\Response
     */
    public function make_payment(Request $req)
    {
        $contract = Contract::find($req->contract_id);
        if (!$contract) { return response(['msg' => 'ID de contrato inválido, trate nuevamente', 'status' => 'error'], 404); }

        $n_words = new \NumberFormatter("es", \NumberFormatter::SPELLOUT);
        $debt = $contract->charges->sum('amount') - $contract->balance;
        $today = New \DateTime(date("Y-m-d"));
        
        if ($req->payment > $debt) {//Si el monto se pasa de la deuda actual
            return response(['msg' => 'La cantidad a pagar no puede ser mayor al total del monto de pago, por favor, trate con otra cantidad', 'status' => 'error'], 400);
            //Puede que sea necesario validar que el monto a webo sea mayor al precio de la oficina
        } elseif ($req->payment <= $debt ) {//si pagó todo lo que debe, o parte de...
            $contract->balance = $contract->balance + $req->payment;//Add the amount to the balance
        } 

        //Updates balance string
        $contract->balance_str = ucfirst($n_words->format($contract->balance))." $this->ext_m";
    
        $contract->save();

        //Create a new payment history
        $row = New PaymentHistory;

        $row->contract_id = $req->contract_id;
        $row->payment_method = $req->payment_method;
        $row->status = $req->type;
        $row->payment_str = ucfirst($n_words->format($req->payment))." $this->ext_m";
        $row->payment = $req->payment;

        $row->save();

        return response(['msg' => 'Pago registrado correctamente', 'status' => 'success', 'url' => url('crm/contracts')], 200);
    }

    /**
     * Verify if the new price is valid
     *
     * @return \Illuminate\Http\Response
     */
    public function verify_new_price(Request $req)
    {
        $contract = Contract::find($req->id);
        if (!$contract) { return response(['msg' => 'ID de contrato inválido, trate nuevamente', 'status' => 'error'], 404); }
        
        if ($req->status == 1) {//Se aceptó el nuevo precio, probablemente validar en un futuro que el cambio se haga sólo si está dentro del primer mes del contrato
            $n_words = new \NumberFormatter("es", \NumberFormatter::SPELLOUT);
            
            $contract->monthly_payment_str = ucfirst($n_words->format($req->price * 0.90))." $this->ext_m";
            $contract->monthly_payment_delay_str = ucfirst($n_words->format($req->price))." $this->ext_m";//Puede ser que cambiemos esto en un futuro

            $contract->save();

            $office = Office::find($contract->office->id);
            $office->price = $req->price;
            $office->save();
        }
            

        //Eliminar el registro de precio sugerido
        $contract->suggested_price->delete();
        return response(['msg' => 'Precio validado correctamente', 'status' => 'success', 'url' => url('crm/contracts')], 200);
    }
    

    /**
     * Get all the payment history from a contract
     *
     * @return \Illuminate\Http\Response
     */
    public function get_payment_history(Request $req)
    {
        $rows = PaymentHistory::where('contract_id', $req->id)->orderBy('id', 'DESC')->get();

        foreach ($rows as &$row) {
            $time = $row->created_at;
            $row->new_time = strftime('%d', strtotime($time)).' de '.strftime('%B', strtotime($time)). ' del año '.strftime('%Y', strtotime($time)). ' a las '.strftime('%H:%M', strtotime($time)). ' hrs.';
        }

        return $rows;
    }

    /**
     *=============================================================================================================================================================
     *=                                                         Canceled and finished contracts functions                                                         =
     *=============================================================================================================================================================
     */

    /**
     * Show the customers contracts.
     *
     */
    public function show_finished(Request $req, $id = null)
    {
        $branches = Branch::where('status', 1)->get();
        $contracts = Contract::filter_rows($this->log_user, 2);

        if ($req->ajax()) {
            return view('applications.contracts_finished.table', ['contracts' => $contracts]);
        }
        return view('applications.contracts_finished.index', ['contracts' => $contracts, 'branches' => $branches]);
    }

    /**
     * Create or download the cancellation pdf for a contract
     *
     * @return \Illuminate\Http\Response
     */
    public function show_cancelled_pdf(Request $req)
    {
        $contract = Contract::find($req->id);
        if ($contract) {
            if ($contract->cancelation) {
                return response(['msg' => 'PDF se abrirá a continuación', 'status' => 'success', 'url' => url('crm/contracts'), 'reload' => 'table', 'route' => url("pdf/cancelled/contrato_no_$req->id.pdf")], 200);
            } else {
                $this->make_path('pdf/cancelled');
                
                $row = New CancelledContract;
                $row->contract_id = $req->id;
                $row->save();

                $contract = Contract::find($req->id);//Need to findit because we need his cancelation relation

                $pdf = PDF::loadView('contracts.other_documents.cancel_contract', ['contract' => $contract])
                ->setPaper('letter')
                ->setWarnings(false)
                ->save("pdf/cancelled/contrato_no_$req->id.pdf");

                return response(['msg' => 'PDF creado, se abrirá a continuación', 'status' => 'success', 'url' => url('crm/contracts'), 'reload' => 'table', 'route' => url("pdf/cancelled/contrato_no_$req->id.pdf")], 200);
            }
        }

        return response(['msg' => 'ID de contrato inválido', 'status' => 'error'], 200);
    }

    /**
     * Finish a contract
     *
     * @return \Illuminate\Http\Response
     */
    public function mark_as_finished(Request $req)
    {
        $contract = Contract::find($req->id);
        if (!$contract) { return response(['msg' => 'Contrato no encontrado', 'status' => 'error'], 404); }

        $application = Application::find($contract->application_id);
        if (!$application) { return response(['msg' => 'Contrato no encontrado', 'status' => 'error'], 404); }
        
        $application->status = 2;

        $application->save();

        $this->change_office_status($contract->office->id, 1);//Available again!!

        return response(['msg' => 'Contrato finalizado', 'status' => 'success', 'url' => url('crm/contracts')], 200);
    }

    public function testing(Request $req)
    {
        $subject = "Fastoffice | Contrato concedido";
        $to = $req->mail;

        Mail::send('mails.general', ['title' => 'Nuevo contrato conseguido', 'content' => 'Felicidades, ha rentado una nueva oficina, podrá ver su estado de cuenta desde nuestra aplicación en cualquier momento'], function ($message)  use ($to, $subject)
        {
            $messate->from(env('MAIL_USERNAME'), env('APP_NAME'));
            $message->to($to);
            $message->subject($subject);
        });

        if (!Mail::failures()) {
            return response(['msg' => 'Correo enviado exitósamente', 'status' => 'ok'], 200);
        } else {
            return response(['msg' => 'Error al envíar el correo, porfavor, trate nuevamente', 'status' => 'error'], 200);
        }
    }
}
