<?php

namespace App\Http\Controllers;

use PDF;

use App\Models\User;
use App\Models\State;
use App\Models\Office;
use App\Models\Meeting;
use App\Models\Contract;
use App\Models\OfficeType;
use App\Models\Application;
use App\Models\PaymentHistory;
use App\Models\CancelledContract;

use Illuminate\Http\Request;

class ContractsController extends Controller
{
    /**
     * Show the customers contracts.
     *
     */
    public function index(Request $req)
    {
        $title = "Contratos de clientes";
        $menu = "CRM";
        $contracts = Contract::whereHas('application', function($query) {//Verify if the contract has an application row
            $query->orderBy('id', 'desc')->where('status', 1);
        })
        ->get();

        if ($req->ajax()) {
            return view('applications.customers_contracts.table', ['contracts' => $contracts]);
        }
        return view('applications.customers_contracts.index', ['contracts' => $contracts, 'menu' => $menu , 'title' => $title]);
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
        }

        return redirect()->back()->with('msg', 'El contrato no puede mostrarse ya que falta información sobre el franquiciatario, revise su información y trate de nuevo.');
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
    public function form($app_id = 0, $contract_id = 0)
    {
        $title = $contract_id ? "Editar contrato" : "Crear contrato";
        $menu = "Prospectos";
        $states = State::all();
        $prospect = $contract = null;
        if ($app_id) {
            $prospect = Application::/*where('status', 0)->*/where('id', $app_id)->first();
        }

        if ($contract_id) {
            $contract = Contract::find($contract_id);
        }

        if ($prospect) { $this->create_user($app_id); }//Creates an application user if is neccesary

        return view('applications.generate_contract.form', ['prospect' => $prospect, 'states' => $states, 'contract' => $contract, 'menu' => $menu, 'title' => $title]);
    }

    /**
     * Save the contract data.
     *
     * @return \Illuminate\Http\Response
     */
    public function save(Request $req)
    {
        $available = $this->check_office_status($req->office_id);
        
        if (!$available) { return response(['msg' => 'Oficina no disponible, porfavor, seleccione una diferente', 'status' => 'error'], 400); }

        $contract = New Contract;

        $payment_range_start = date('d', strtotime($req->start_date_validity));
        $payment_range_end = date('d', strtotime($req->start_date_validity. ' + 4 days'));

        //General contract data
        $req->has('user_id') ? $contract->user_id = $req->user_id : '';
        $req->has('application_id') ? $contract->application_id = $req->application_id : '';
        $contract->office_id = $req->office_id;
        $contract->contract_date = $req->contract_date;
        $contract->start_date_validity = $req->start_date_validity;
        $contract->end_date_validity = $req->end_date_validity;
        $contract->monthly_payment_str = $req->monthly_payment_str;
        $contract->payment_range_start = $payment_range_start;
        $contract->payment_range_end = $payment_range_end;
        $contract->monthly_payment_delay_str = $req->monthly_payment_delay_str;

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

        $this->change_office_status($req->office_id, 2);//Rented!!

        if ($req->has('application_id')) {
            $app = Application::find($req->application_id);
            if ($app) {
                $app->status = 1;//Marked as customer
                $app->save();
            }
        }

        return response(['msg' => 'Contrato generado exitósamente', 'status' => 'success', 'url' => url('crm/contracts')], 200);
    }

    /**
     * Updates the contract data.
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $req)
    {
        $contract = Contract::find($req->id);

        if (!$contract) { return response(['msg' => 'ID de contrato inválido', 'status' => 'error'], 404); }

        $payment_range_start = date('d', strtotime($req->start_date_validity));
        $payment_range_end = date('d', strtotime($req->start_date_validity. ' + 4 days'));

        //General contract data
        $req->has('user_id') ? $contract->user_id = $req->user_id : '';
        $req->has('application_id') ? $contract->application_id = $req->application_id : '';
        $contract->office_id = $req->office_id;
        $contract->contract_date = $req->contract_date;
        $contract->start_date_validity = $req->start_date_validity;
        $contract->end_date_validity = $req->end_date_validity;
        $contract->monthly_payment_str = $req->monthly_payment_str;
        $contract->payment_range_start = $payment_range_start;
        $contract->payment_range_end = $payment_range_end;
        $contract->monthly_payment_delay_str = $req->monthly_payment_delay_str;

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

        return response(['msg' => 'Contracto modificado exitósamente', 'status' => 'success', 'url' => url('crm/contracts')], 200);
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

        $row = New PaymentHistory;

        $row->contract_id = $req->contract_id;
        $row->payment_method = $req->payment_method;
        $row->status = $req->type;
        $row->payment_str = $req->payment_str;
        $row->payment = $req->payment;

        $row->save();

        $contract->status = 1;
        $contract->save();

        return response(['msg' => 'Pago registrado correctamente', 'status' => 'success', 'url' => url('crm/contracts')], 200);
    }

    /**
     * Get all the payment history from a contract
     *
     * @return \Illuminate\Http\Response
     */
    public function get_payment_history(Request $req)
    {
        $rows = PaymentHistory::where('contract_id', $req->id)->orderBy('id', 'DESC')->get();

        foreach($rows as &$row) {
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
    public function show_finished(Request $req)
    {
        $title = "Contratos finalizados";
        $menu = "CRM";
        $contracts = Contract::whereHas('application', function($query) {//Verify if the contract has an application row
            $query->orderBy('id', 'desc')->where('status', 2);//Finished
        })
        ->get();

        if ($req->ajax()) {
            return view('applications.contracts_finished.table', ['contracts' => $contracts]);
        }
        return view('applications.contracts_finished.index', ['contracts' => $contracts, 'menu' => $menu , 'title' => $title]);
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
                return response(['msg' => 'PDF se abrirá a continuación', 'status' => 'success', 'url' => url('crm/contracts'), 'reload' => 'table', 'route' => url("pdf/cancelled/contrato_$req->id.pdf")], 200);
            } else {
                $this->make_path('pdf/cancelled');
                
                $row = New CancelledContract;
                $row->contract_id = $req->id;
                $row->save();

                $contract = Contract::find($req->id);//Need to findit because we need his cancelation relation

                $pdf = PDF::loadView('contracts.other_documents.cancel_contract', ['contract' => $contract])
                ->setPaper('letter')
                ->setWarnings(false)
                ->save("pdf/cancelled/contrato_$req->id.pdf");

                return response(['msg' => 'PDF creado, se abrirá a continuación', 'status' => 'success', 'url' => url('crm/contracts'), 'reload' => 'table', 'route' => url("pdf/cancelled/contrato_$req->id.pdf")], 200);
            }
        }

        return redirect()->back()->with('msg', 'ID de contrato inválido');
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

        return response(['msg' => 'Contrato finalizado', 'status' => 'success', 'url' => url('crm/contracts')], 200);
    }
}
