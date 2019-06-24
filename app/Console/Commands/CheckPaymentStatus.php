<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use App\Models\Contract;
use App\Models\PaymentHistory;
use App\Models\ChargeContract;

use App\Traits\GeneralFunctions;


class CheckPaymentStatus extends Command
{

    use GeneralFunctions;
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
        #$contracts = Contract::all();
        $contracts = Contract::whereHas('application', function($query) {
            $query->where('status', 1);#Only current contracts
        })->whereHas('office', function($que){
            #Active office is required
        })->get();
        $n_words = new \NumberFormatter("es", \NumberFormatter::SPELLOUT);


        $contracts->each(function($item, $key) use ($year, $month, $today, $n_words, &$count, $ext_m) {
            $cus_st_da = new \DateTime($year.'-'.$month.'-'.$item->payment_range_start);//Real one date
            $saldo = number_format($item->balance - number_format($item->charges->sum('amount'), 2, '.', ''), 2, '.', '');#Calcula la diferencia de lo que ha pagado con lo que debe

            //dd($cus_st_da);
            //$start_date = date('Y-m-d', strtotime($item->actual_pay_date));
            $start_date = $cus_st_da->format('Y-m-d');
            $end_date = date('Y-m-d', strtotime($start_date. '+ 4 days'));
            $delay_date = date('Y-m-d', strtotime($start_date. '+ 5 days'));
            $last_charge = $item->charges->last();

            if ( count($item->payment_history) ) {//Ya ha pagado antes
                $last_pay = PaymentHistory::where('contract_id', $item->id)->orderBy('id', 'desc')->first();
                $last_pay_date = $last_pay->created_at->format('Y-m-d');

                if ( $today >= $start_date && $today <= $end_date ) { //Si el contrato está entre los días de pago normal
                    if ( $last_pay_date < $start_date ) {//Si el último pago que se hizo no es entre este mes de pago, se añade cargo adicional
                        if ( $today == $start_date ) {//Si hoy es el primer día de paga, se hace un cargo normal
                            $this->make_charge_contract($item, $item->office->monthly_price, $start_date, 1);

                            if ( $item->additional_people ) {
                                $this->make_charge_contract($item, ( $item->additional_people * 580 ), $start_date, 3);
                                #$count ++;
                            }

                            $count ++;
                        }
                    }
                        
                } elseif ( $today > $end_date ) {//si la fecha de pagos ya pasó y sigue sin pagarse...
                    if ( $last_pay_date < $start_date && $today == $delay_date ) {//Si el último pago que se hizo no es entre este mes de pago, se añade cargo adicional y es el primer día de retraso
                        if ( $saldo < 0 ) {#Si el cliente tiene saldo negativo, es decir, tiene adeudo, entonces se le cobra un adicional extra por no pagar a tiempo
                            $this->make_charge_contract($item, ($item->office->price - $item->office->monthly_price), $start_date, 2);
                            
                            $count ++;
                        }
                        //dd('Se realizó cargo extra porque no se pagó en el rango de días normal');
                    }
                    //Validar si el monto a pagar rebasa el atraso
                }

            } else {//Si nunca ha pagado
                if ( $today >= $start_date && $today <= $end_date ) { //Si el contrato está entre los días de pago normal
                    if ( $today == $start_date ) {//Si hoy es el primer día de pago...
                        $exist = ChargeContract::where('contract_id', $item->id)->where('pay_date', $start_date)->get();
                        if (! count( $exist ) ) {//Si existe un cargo ya realizado (puede ser que no pagó el primer mes..) se crea un cargo normal
                            $this->make_charge_contract($item, $item->office->monthly_price, $start_date, 1);

                            #If contract indicates that has aditional people, then, we are going to make an aditional charge too
                            if ( $item->additional_people ) {
                                $this->make_charge_contract($item, ( $item->additional_people * 580 ), $start_date, 3);
                                #$count ++;
                            }

                            $count ++;
                            //dd('Se realizó cargo normal sin tener historial de pago');
                        } 
                        //Nothing to do
                    }
                } elseif ( $today > $end_date ) {//si la fecha de pagos ya pasó y sigue sin pagarse...
                    if ( $today == $delay_date ) {//Si es el primer día de retraso, crear cargo por retraso
                        //Only add the difference beetwen list price and monthly price, and also mark as delayed
                        $this->make_charge_contract($item, ($item->office->price - $item->office->monthly_price), $start_date, 2);

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
