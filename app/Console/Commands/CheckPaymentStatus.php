<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use App\Models\Contract;
use App\Models\PaymentHistory;
use App\Models\ChargeContract;


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
        $count = 0;
        $ext_m = "pesos 00/100 M.N.";
        $today = date('Y-m-d', strtotime('now'));
        $year = date('Y');
        $month = date('m');
        $contracts = Contract::all();
        $n_words = new \NumberFormatter("es", \NumberFormatter::SPELLOUT);


        $contracts->each(function($item, $key) use ($year, $month, $today, $n_words, &$count, $ext_m) {
            $cus_st_da = new \DateTime($year.'-'.$month.'-'.$item->payment_range_start);//Real one date
            //dd($cus_st_da);
            //$start_date = date('Y-m-d', strtotime($item->actual_pay_date));
            $start_date = $cus_st_da->format('Y-m-d');
            $end_date = date('Y-m-d', strtotime($start_date. '+ 4 days'));
            $delay_date = date('Y-m-d', strtotime($start_date. '+ 5 days'));
            $last_charge = $item->charges->last();

            if (count($item->payment_history)) {//Ya ha pagado antes
                $last_pay = PaymentHistory::where('contract_id', $item->id)->orderBy('id', 'desc')->first();
                $last_pay_date = $last_pay->created_at->format('Y-m-d');

                if ( $today >= $start_date && $today <= $end_date ) { //Si el contrato está entre los días de pago normal
                    if ($last_pay_date < $start_date) {//Si el último pago que se hizo no es entre este mes de pago, se añade cargo adicional
                        if ($today == $start_date) {//Si hoy es el primer día de paga, se hace un cargo normal
                            $charge = New ChargeContract;

                            $charge->contract_id = $item->id;
                            $charge->amount = $item->office->price * 0.90;//Add the 90% of the office
                            $charge->amount_str = ucfirst($n_words->format($item->office->price * 0.90))." $ext_m";
                            $charge->pay_date = $start_date;
                            $charge->status = 1;//Pago normal

                            $charge->save();
                            $count ++;
                            //dd('Se realizó cargo normal porque no se ha pagado actualmente');
                        }
                    }
                        
                } elseif ( $today > $end_date ) {//si la fecha de pagos ya pasó y sigue sin pagarse...
                    if ($last_pay_date < $start_date && $today == $delay_date) {//Si el último pago que se hizo no es entre este mes de pago, se añade cargo adicional y es el primer día de retraso
                        $charge = New ChargeContract;

                        $charge->contract_id = $item->id;
                        $charge->amount = $item->office->price * 0.10;//Add the 10% of the office
                        $charge->amount_str = ucfirst($n_words->format($item->office->price * 0.10))." $ext_m";
                        $charge->pay_date = $start_date;
                        $charge->status = 2;//Pago atrasado

                        $charge->save();
                        $count ++;
                        //dd('Se realizó cargo extra porque no se pagó en el rango de días normal');
                    }
                    //Validar si el monto a pagar rebasa el atraso
                }

            } else {//Si nunca ha pagado
                if ( $today >= $start_date && $today <= $end_date ) { //Si el contrato está entre los días de pago normal
                    if ($today == $start_date) {//Si hoy es el primer día de pago...
                        $exist = ChargeContract::where('contract_id', $item->id)->where('pay_date', $start_date)->get();
                        if (!count($exist)) {//Si existe un cargo ya realizado (puede ser que no pagó el primer mes..) se crea un cargo normal
                            $charge = New ChargeContract;

                            $charge->contract_id = $item->id;
                            $charge->amount = $item->office->price * 0.90;//Add the 90% of the office
                            $charge->amount_str = ucfirst($n_words->format($item->office->price * 0.90))." $ext_m";
                            $charge->pay_date = $start_date;
                            $charge->status = 1;//Pago normal

                            $charge->save();
                            $count ++;
                            //dd('Se realizó cargo normal sin tener historial de pago');
                        } 
                        //Nothing to do
                    }
                } elseif ( $today > $end_date ) {//si la fecha de pagos ya pasó y sigue sin pagarse...
                    if ($today == $delay_date) {//Si es el primer día de retraso, crear cargo por retraso
                        $charge = New ChargeContract;

                        $charge->contract_id = $item->id;
                        $charge->amount = $item->office->price * 0.10;//Add the 10% of the office
                        $charge->amount_str = ucfirst($n_words->format($item->office->price * 0.10))." $ext_m";
                        $charge->pay_date = $start_date;
                        $charge->status = 2;//Pago atrasado

                        $charge->save();
                        $count ++;
                        //dd('Se realizó cargo extra sin tener historial de pago');

                    }
                }
            }
            //dd('no necesita de acciones');
        });
        
        \Log::info('Cronjob de checar status de pago ejecutado a las '.date('Y-m-d H:i:s').', se revisaron un total de '.count($contracts).' contratos y se generaron cargos para '.$count.' contratos');
    }
}
