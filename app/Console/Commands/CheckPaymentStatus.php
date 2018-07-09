<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Contract;

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
		$contracts->each(function($item, $key) use ($year, $month, $today){
			if ( $today >= date('Y-m-d', strtotime($year.'-'.$month.'-'.$item->payment_range_start)) && $today <= date('Y-m-d', strtotime($year.'-'.$month.'-'.$item->payment_range_end)) ){
				if ( $item->status != 1 ){
					$item->status = 0;
				}
			} elseif ( $today > date('Y-m-d', strtotime($year.'-'.$month.'-'.$item->payment_range_end)) ){
				$item->status = 2;
			}
			$item->save();
		});
	}
}
