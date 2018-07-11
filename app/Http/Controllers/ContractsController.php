<?php

namespace App\Http\Controllers;

use PDF;

use App\Models\User;
use App\Models\Office;
use App\Models\Meeting;
use App\Models\Contract;
use App\Models\OfficeType;
use App\Models\Application;
use App\Models\ApplicationComment;
use App\Models\ApplicationDetail;

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
        $contract = Contract::find($contract_id);
        if ($contract) {
            $pdf = PDF::loadView('contracts.physical_person.physical_office', ['contract' => $contract])
            ->setPaper('letter')->setWarnings(false);
            return $pdf->stream('contrato.pdf');//Visualiza el archivo sin descargarlo
        }
    }

    /**
     * Show the pdf contract.
     *
     */
    public function show_money_receipt($contract_id)
    {
        $contract = Contract::find($contract_id);
        if ($contract) {
            $pdf = PDF::loadView('contracts.other_documents.money_receipt_office', ['contract' => $contract])
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
        $prospect = $contract = null;
        if ($app_id) {
            $prospect = Application::/*where('status', 0)->*/where('id', $app_id)->first();
        }

        if ($contract_id) {
            $contract = Contract::find($contract_id);
        }

        if ($prospect) { $this->create_user($app_id); }//Creates an application user if is neccesary

        return view('applications.generate_contract.form', ['prospect' => $prospect, 'contract' => $contract, 'menu' => $menu, 'title' => $title]);
    }

    /**
     * Save the contract data.
     *
     * @return \Illuminate\Http\Response
     */
    public function save(Request $req)
    {
        $contract = New Contract;

        $payment_range_start = date('d', strtotime($req->start_date_validity));
        $payment_range_end = date('d', strtotime($req->start_date_validity. ' + 4 days'));

        $req->has('user_id') ? $contract->user_id = $req->user_id : '';
        $req->has('application_id') ? $contract->application_id = $req->application_id : '';
        $contract->office_id = $req->office_id;
        $contract->contract_date = $req->contract_date;
        $contract->provider_name = $req->provider_name;
        $contract->provider_ine_number = $req->provider_ine_number;
        $contract->customer_ine_number = $req->customer_ine_number;
        $contract->customer_activity = $req->customer_activity;
        $contract->customer_address = $req->customer_address;
        $contract->start_date_validity = $req->start_date_validity;
        $contract->end_date_validity = $req->end_date_validity;
        $contract->monthly_payment_str = $req->monthly_payment_str;
        $contract->payment_range_start = $payment_range_start;
        $contract->payment_range_end = $payment_range_end;
        $contract->monthly_payment_delay_str = $req->monthly_payment_delay_str;

        $contract->save();

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

        if (!$contract) { return response(['msg' => 'ID de contrato inválido', 'status' => 'success'], 404); }

        $payment_range_start = date('d', strtotime($req->start_date_validity));
        $payment_range_end = date('d', strtotime($req->start_date_validity. ' + 4 days'));

        $contract->office_id = $req->office_id;
        $contract->contract_date = $req->contract_date;
        $contract->provider_name = $req->provider_name;
        $contract->provider_ine_number = $req->provider_ine_number;
        $contract->customer_ine_number = $req->customer_ine_number;
        $contract->customer_activity = $req->customer_activity;
        $contract->customer_address = $req->customer_address;
        $contract->start_date_validity = $req->start_date_validity;
        $contract->end_date_validity = $req->end_date_validity;
        $contract->monthly_payment_str = $req->monthly_payment_str;
        $contract->payment_range_start = $payment_range_start;
        $contract->payment_range_end = $payment_range_end;
        $contract->monthly_payment_delay_str = $req->monthly_payment_delay_str;

        $contract->save();

        return response(['msg' => 'Contracto modificado exitósamente', 'status' => 'success', 'url' => url('crm/contracts')], 200);
    }
}
