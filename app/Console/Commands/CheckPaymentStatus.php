<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use App\Models\Contract;
use App\Models\PaymentHistory;

class CheckPaymentStatus extends Command
{
	/**
	 * The name and signature of the console command.
	 *
	 * @var string
	 */
	protected $signature = 'command:CheckPaymentStatus';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Checar de manera diaria el status de los contratos para mostrar su status actual (Por pagar, Corriente, Atrasado)';

	/**
	 * Create a new command instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		parent::__construct();
		date_default_timezone_set('America/Mexico_city');
	}

	/**
	 * Execute the console command.
	 *
	 * @return mixed
	 */
	public function handle()
	{
        $today = date('Y-m-d', strtotime('now'));
        $year = date('Y');
        $month = date('m');
        $contracts = Contract::all();

        $contracts->each(function($item, $key) use ($year, $month, $today) {
            $start_date = date('Y-m-d', strtotime($item->actual_pay_date));
            $end_date = date('Y-m-d', strtotime($start_date. '+ 4 days'));
            $max_date = date('Y-m-d', strtotime($end_date. ' + 15 days'));//En caso de que se haya pagado retrasado

            //Si tiene historial de pagos
            if (count($item->payment_history)) {

                $last_pay = PaymentHistory::where('contract_id', $item->id)->orderBy('id', 'desc')->first();
                $pay_date = $last_pay->created_at->format('Y-m-d');
                
                //Si el contrato tiene historial de pago pero NO dentro de su rango de fecha actual, marcar como pendiente de pago normal, si no, ignorar
                if ( ($pay_date >= $start_date && $pay_date <= $end_date) || ($pay_date >= $start_date && $pay_date <= $max_date) ) {
                    //No necesita actualizarse, se entiende que ya se pagó
                    //dd('NO necesita actualizarse', $item->id);
                } else { //Se actualiza
                    
                    if ( $today >= $start_date && $today <= $end_date ) { //Si el contrato está entre los días de pago normal
                        //dd('Se actualiza a pago normal', $item->id);
                        $item->status = 0;
                    
                    } elseif ( $today > $end_date ) {//si la fecha de pagos ya pasó y sigue sin pagarse...
                        //dd('Se actualiza a pago retrasado', $item->id);
                        $item->status = 2;
                    }
                }
            //Si no tiene historial de pago alguno, se marca como pendiente de pago
            } else {
                if ( $today >= $start_date && $today <= $end_date ) { //Si está entre el rango de pago normal
                    $item->status = 0;
                    //dd('no tiene historial, pero se pone pendiente de pago normal', $start_date, $end_date, $max_date, $item->id);
                } elseif ( $today > $end_date ) { //si la fecha de pagos ya pasó...
                    //dd('no tiene historial, pero se pone pendiente de pago atrasado', $start_date, $end_date, $max_date, $item->id);
                    $item->status = 2;
                }
            }

            $item->save();
        });

        //return $contracts;
    }
}
