<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ErpRequest;
use App\Models\Erp;
use App\Models\Office;
use App\Models\Branch;
use App\Models\Category;
use Excel;

class ErpController extends Controller
{
	public function index(Request $req, $id = null, $start_date = null, $end_date = null){
		$earnings = Erp::where('type', 1)->whereHas('office', function($q) use($id){
			if ( auth()->user()->role_id == 2 ){
				$q->where('branch_id', auth()->user()->branch->id);
			} elseif ( auth()->user()->role_id == 3 ){
				$q->where('id', auth()->user()->office->id);
			} else{
				if( $id ){
					$q->where('branch_id', $id);
				}
			}
		});
		$expenses = Erp::where('type', 2)->whereHas('office', function($q) use($id){
			if ( auth()->user()->role_id == 2 ){
				$q->where('branch_id', auth()->user()->branch->id);
			} else{
				if( $id ){
					$q->where('branch_id', $id);
				}
			}
		});


		if ( $start_date ){
			$earnings->where('created_at','>',$start_date.' 00:00:00');
			$expenses->where('created_at','>',$start_date.' 00:00:00');
		}
		if( $end_date ){
			$earnings->where('created_at','<=',$end_date.' 23:59:59');
			$expenses->where('created_at','<=',$end_date.' 23:59:59');
		}

		$earnings = $earnings->get();
		$expenses = $expenses->get();

		$branches = Branch::pluck('name', 'id')->prepend("Mostrar todas",0);
		$offices = Office::pluck('name', 'id')->prepend("Mostrar todas", 0);

		if ($req->ajax()) {
			return view('erp.content', compact('earnings', 'expenses'));
		}
		return view('erp.index', compact('earnings', 'expenses', 'branches', 'offices'));
	}

	public function form($type, $id = null){
		$erp = new Erp();
		$offices = Office::where('status', '!=', 0)->pluck('name','id')->prepend("Seleccione una oficina", 0);
		$categories = [0 => 'Seleccione una categoría'];

		if ( $id ) {
			$erp = Erp::findOrFail($id);
			$categories = Category::where('type', $erp->type_id)->get();
		}
		return view('erp.form', compact('erp', 'offices', 'categories'));
	}

	public function store(ErpRequest $req){
		$erp = new Erp();
		$erp->fill($req->all());

		if ( $erp->save() ){
			return Redirect()->route('Erp')->with('msg', 'Registro creado');
		} else {
			return Redirect()->back()->with('msg', 'Error al crear noticia');
		}
	}

	public function update(ErpRequest $req, $id){
		$erp = Erp::find($id);
		$erp->fill($req->all());

		if ( $erp->save() ){
			return Redirect()->route('Erp')->with('msg', 'Registro actualizado');
		} else {
			return Redirect()->back()->with('msg', 'Error al crear noticia');
		}
	}

	public function destroy($id){
		if ( Erp::destroy($id) ) {
			return ['delete' => 'true'];
		} else {
			return ['delete' => 'false'];
		}
	}

	public function getCategoriesByType($type_id){
		return Category::where(['type' => $type_id])->get();
	}

	public function export($id, $start_date, $end_date){
		$earnings = Erp::where('type', 1)->whereHas('office', function($q) use($id){
			if ( auth()->user()->role_id == 2 ) {
				$q->where('branch_id', auth()->user()->branch->id);
			} elseif ( auth()->user()->role_id == 3 ) {
				$q->where('id', auth()->user()->office->id);
			} else {
				if ( $id ) {
					$q->where('branch_id', $id);
				}
			}
		});
		$expenses = Erp::where('type', 2)->whereHas('office', function($q) use($id){
			if ( auth()->user()->role_id == 2 ){
				$q->where('branch_id', auth()->user()->branch->id);
			} else{
				if( $id ){
					$q->where('branch_id', $id);
				}
			}
		});


		if ( $start_date ) {
			$earnings->where('created_at','>',$start_date.' 00:00:00');
			$expenses->where('created_at','>',$start_date.' 00:00:00');
		}
		if( $end_date ) {
			$earnings->where('created_at','<=',$end_date.' 23:59:59');
			$expenses->where('created_at','<=',$end_date.' 23:59:59');
		}

		$earnings = $earnings->get();
		$expenses = $expenses->get();

		$ganancias = [];
		$gastos = [];

		foreach ($earnings as $row) {
			$ganancias[] = [
				'Categoría' => $row->category->name,
				'Concepto' => $row->concept,
				'Cantidad' => $row->amount,
				'Sucursal' => $row->office->branch->name,
				'Oficina' => $row->office->name
			];
		}

		foreach ($expenses as $row) {
			$gastos[] = [
				'Categoría' => $row->category->name,
				'Concepto' => $row->concept,
				'Cantidad' => $row->amount,
				'Sucursal' => $row->office->branch->name,
				'Oficina' => $row->office->name
			];
		}

		$excel = Excel::create('Utilidades', function($excel) use($ganancias, $gastos, $id, $start_date, $end_date) {
			$excel->sheet('Ingresos', function($sheet) use($ganancias, $gastos, $id, $start_date, $end_date) {

				$sheet->cell('A1', function($cell) use ($ganancias){
					$cell->setFontWeight('bold');
					$cell->setFontSize(14);
					$cell->setValue('Ingresos: $'.number_format(collect($ganancias)->sum('Cantidad'),2));
				});

				$sheet->cell('B1', function($cell) use ($ganancias, $gastos){
					$cell->setFontWeight('bold');
					$cell->setFontSize(14);
					$cell->setValue('Utilidad: $'.number_format( (collect($ganancias)->sum('Cantidad') - collect($gastos)->sum('Cantidad') ),2));
				});

				$sheet->cell('A2', function($cell) use($start_date, $end_date){
					if ( $start_date && $end_date ){
						$periodo = $start_date.' - '.$end_date;
					} elseif( $start_date ) {
						$periodo = "Después del ".$start_date;
					} elseif ( $end_date ) {
						$periodo = "Antes del ".$end_date;
					}
					else {
						$periodo = "Todo el tiempo";
					}
					$cell->setFontWeight('bold');
					$cell->setFontSize(14);
					$cell->setValue('Periodo: '.$periodo);
				});

				if( $id || auth()->user()->role_id != 1 ){
					$id = !$id?auth()->user()->id:$id;
					$sucursal = Branch::find($id);
					$sheet->cell('A3', function($cell) use ($sucursal){
						$cell->setFontWeight('bold');
						$cell->setFontSize(14);
						$cell->setValue('Sucursal: '.$sucursal->name);
					});
				}

				$sheet->cells('A:I', function($cells) {
					$cells->setAlignment('left');
					$cells->setValignment('center');
				});

				$sheet->cells('A5:E5', function($cells) {
					$cells->setAlignment('center');
					$cells->setValignment('center');
					$cells->setFontWeight('bold');
					$cells->setFontSize(12);
				});
				$sheet->fromArray($ganancias, null, 'A5', true);
				$sheet->setAutoFilter('A5:E5');
			});

			$excel->sheet('Egresos', function($sheet) use($ganancias, $gastos, $id, $start_date, $end_date) {
				$sheet->cell('A1', function($cell) use ($ganancias, $gastos) {
					$cell->setFontWeight('bold');
					$cell->setFontSize(14);
					$cell->setValue('Egresos: $'.number_format( collect($gastos)->sum('Cantidad') ,2));
				});

				$sheet->cell('B1', function($cell) use ($ganancias, $gastos) {
					$cell->setFontWeight('bold');
					$cell->setFontSize(14);
					$cell->setValue('Utilidad: $'.number_format( (collect($ganancias)->sum('Cantidad') - collect($gastos)->sum('Cantidad') ),2));
				});

				$sheet->cell('A2', function($cell) use($start_date, $end_date){
					if ( $start_date && $end_date ){
						$periodo = $start_date.' - '.$end_date;
					} elseif( $start_date ) {
						$periodo = "Después del ".$start_date;
					} elseif ( $end_date ) {
						$periodo = "Antes del ".$end_date;
					}
					else {
						$periodo = "Todo el tiempo";
					}
					$cell->setFontWeight('bold');
					$cell->setFontSize(14);
					$cell->setValue('Periodo: '.$periodo);
				});

				if( $id || auth()->user()->role_id != 1 ){
					$id = !$id?auth()->user()->id:$id;
					$sucursal = Branch::find($id);
					$sheet->cell('A3', function($cell) use ($sucursal){
						$cell->setFontWeight('bold');
						$cell->setFontSize(14);
						$cell->setValue('Sucursal: '.$sucursal->name);
					});
				}

				$sheet->cells('A:I', function($cells) {
					$cells->setAlignment('left');
					$cells->setValignment('center');
				});

				$sheet->cells('A5:E5', function($cells) {
					$cells->setAlignment('center');
					$cells->setValignment('center');
					$cells->setFontWeight('bold');
					$cells->setFontSize(12);
				});
				$sheet->fromArray($gastos, null, 'A5', true);
				$sheet->setAutoFilter('A5:E5');
			});
		})->download('xlsx');

		return $excel;
	}
}
