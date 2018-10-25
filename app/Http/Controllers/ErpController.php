<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ErpRequest;
use App\Models\Erp;
use App\Models\Office;
use App\Models\Branch;
use App\Models\Category;
use App\Models\EgressType;
use Illuminate\Support\Facades\File;
use Excel, Image;

class ErpController extends Controller
{
	public function index(Request $req, $id = null, $start_date = null, $end_date = null){
		$earnings = Erp::where('type', 1)->whereHas('office', function($q) use ($id){
			if ( auth()->user()->role_id == 2 ){
				$q->whereIn('branch_id', auth()->user()->branches->pluck('id'));
			} elseif ( auth()->user()->role_id == 3 ){
				$q->where('branch_id', auth()->user()->branch_id);
			} else{
				if( $id ){
					$q->where('branch_id', $id);
				}
			}
		});
		$expenses_fixed = Erp::where(['type' => 2, 'egress_type_id' => 1])->whereHas('branch', function($q) use ($id){
			if ( auth()->user()->role_id == 2 ){
				$q->whereIn('id', auth()->user()->branches->pluck('id'));
			} elseif ( auth()->user()->role_id == 3 ){
				$q->where('id', auth()->user()->branch_id);
			} else {
				if( $id ){
					$q->where('id', $id);
				}
			}
		});
		$expenses_variable = Erp::where(['type' => 2, 'egress_type_id' => 2])->whereHas('branch', function($q) use ($id){
			if ( auth()->user()->role_id == 2 ){
				$q->whereIn('id', auth()->user()->branches->pluck('id'));
			} elseif ( auth()->user()->role_id == 3 ){
				$q->where('id', auth()->user()->branch_id);
			} else {
				if( $id ){
					$q->where('id', $id);
				}
			}
		});

		if ( $start_date ){
			$earnings->where('created_at','>',$start_date.' 00:00:00');
			$expenses_fixed->where('created_at','>',$start_date.' 00:00:00');
			$expenses_variable->where('created_at','>',$start_date.' 00:00:00');
		}
		if( $end_date ){
			$earnings->where('created_at','<=',$end_date.' 23:59:59');
			$expenses_fixed->where('created_at','<=',$end_date.' 23:59:59');
			$expenses_variable->where('created_at','<=',$end_date.' 23:59:59');
		}

		$earnings = $earnings->get();
		$expenses_fixed = $expenses_fixed->get();
		$expenses_variable = $expenses_variable->get();

		$branches = Branch::pluck('name', 'id')->prepend("Mostrar todas",0);
		if ( auth()->user()->role_id == 2 ){
			if ( auth()->user()->branches  ){
				$offices = Office::whereHas('branch', function($q){
					$q->whereIn('id', auth()->user()->branches->pluck('id'));
				})->pluck('name', 'id')->prepend("Mostrar todas", 0);
			} else {
				$offices = [];
			}
		} else {
			$offices = Office::pluck('name', 'id')->prepend("Mostrar todas", 0);
		}

		if ($req->ajax()) {
			return view('erp.content', compact('earnings', 'expenses_fixed', 'expenses_variable'));
		}
		return view('erp.index', compact('earnings', 'expenses_fixed', 'expenses_variable', 'branches', 'offices'));
	}

	public function form($id = null){
		$erp = new Erp();

		$branches = Branch::all();
		$offices = Office::all();
		if ( auth()->user()->role_id == 2 ){
			$branches = $branches->where('user_id', auth()->user()->id);
			$offices = $offices->whereIn('branch_id', auth()->user()->branches->pluck('id'));
		}
		if ( auth()->user()->role_id == 3 ){
			$branches = $branches->where('id', auth()->user()->office->branch_id);
			$offices = $offices->where('branch_id', auth()->user()->branch_id);
		}
		$branches = $branches->pluck('name', 'id')->prepend("Seleccione una franquicia", 0);
		$offices = $offices->pluck('name', 'id')->prepend("Seleccione una oficina", 0);

		$categories = [0 => 'Seleccione una categoría'];
		$egress_types = EgressType::pluck('name', 'id')->prepend('Seleccione un tipo egreso');

		if ( $id ) {
			$erp = Erp::findOrFail($id);
			$erp->date = date('d M Y', strtotime($erp->date));
			$categories = Category::where('type', $erp->type)->pluck('name', 'id')->prepend('Seleccione una categoría', 0);
		}
		return view('erp.form', compact('erp', 'offices', 'branches', 'categories', 'egress_types'));
	}

	public function store(ErpRequest $req){
		$erp = new Erp();
		$erp->fill($req->except('file'));

		$directorio = public_path().'/img/erp/'.$req->id.'/';
		if (!File::exists($directorio)){
			File::makeDirectory($directorio, 0777, true, true);
		}
		$image = $req->file('file');
		$name = date("His");
		$name = $name.'.'.$image->getClientOriginalExtension();
		$path = $directorio.$name;
		$erp->file = '';
		if ( array_search( strtolower($image->getClientOriginalExtension()), ['pdf', 'doc', 'docx', 'xls', 'xlsx'] ) !== false ){
			$image->move($directorio, $name);
		} else {
			Image::make($image)->save($path);
		}

		if ( $erp->save() ){
			$erp->file = '/img/erp/'.$req->id.'/'.$name;
			$erp->save();
			return Redirect()->route('Erp')->with('msg', 'Registro creado');
		} else {
			return Redirect()->back()->with('msg', 'Error al crear noticia');
		}
	}

	public function update(ErpRequest $req, $id){
		$erp = Erp::find($id);
		$erp->fill($req->except('file'));

		if ( $erp->save() ){
			if ( $req->hasFile('file') ){
				File::cleanDirectory(public_path()."/img/erp/".$id."/");
				$directorio = public_path().'/img/erp/'.$req->id.'/';
				if (!File::exists($directorio)){
					File::makeDirectory($directorio, 0777, true, true);
				}
				$image = $req->file('file');
				$name = date("His");
				$name = $name.'.'.$image->getClientOriginalExtension();
				$path = $directorio.$name;
				$erp->file = '/img/erp/'.$id.'/'.$name;
				$erp->save();
				if ( array_search( strtolower($image->getClientOriginalExtension()), ['pdf', 'doc', 'docx', 'xls', 'xlsx'] ) !== false ){
					$image->move($directorio, $name);
				} else {
					Image::make($image)->save($path);
				}
			}

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
		$earnings = Erp::where('type', 1)->whereHas('office', function($q) use ($id){
			if ( auth()->user()->role_id == 2 ) {
				$q->whereIn('branch_id', auth()->user()->branches->pluck('id'));
			} elseif ( auth()->user()->role_id == 3 ) {
				$q->where('id', auth()->user()->office->id);
			} else {
				if ( $id ) {
					$q->where('branch_id', $id);
				}
			}
		});
		$expenses_fixed = Erp::where(['type' => 2, 'egress_type_id' => 1])->whereHas('branch', function($q) use ($id){
			if ( auth()->user()->role_id == 2 ){
				$q->whereIn('branch_id', auth()->user()->branches->pluck('id'));
			} elseif ( auth()->user()->role_id == 3 ){
				$q->where('id', auth()->user()->branch_id);
			} else{
				if( $id ){
					$q->where('branch_id', $id);
				}
			}
		});
		$expenses_variable = Erp::where(['type' => 2, 'egress_type_id' => 2])->whereHas('branch', function($q) use ($id){
			if ( auth()->user()->role_id == 2 ){
				$q->whereIn('branch_id', auth()->user()->branches->pluck('id'));
			} elseif ( auth()->user()->role_id == 3 ){
				$q->where('id', auth()->user()->branch_id);
			} else{
				if( $id ){
					$q->where('branch_id', $id);
				}
			}
		});


		if ( $start_date ){
			$earnings->where('created_at','>',$start_date.' 00:00:00');
			$expenses_fixed->where('created_at','>',$start_date.' 00:00:00');
			$expenses_variable->where('created_at','>',$start_date.' 00:00:00');
		}
		if( $end_date ){
			$earnings->where('created_at','<=',$end_date.' 23:59:59');
			$expenses_fixed->where('created_at','<=',$end_date.' 23:59:59');
			$expenses_variable->where('created_at','<=',$end_date.' 23:59:59');
		}

		$earnings = $earnings->get();
		$expenses_fixed = $expenses_fixed->get();
		$expenses_variable = $expenses_variable->get();

		$ganancias = $gastos_fijos = $gastos_variables = [];

		$earnings->each(function($row, $key) use (&$ganancias){
			$ganancias[] = [
				'Categoría' => $row->category->name,
				'Concepto' => $row->concept,
				'Cantidad' => $row->amount,
				'Sucursal' => $row->office->branch->name,
				'Oficina' => $row->office->name
			];
		});

		$expenses_fixed->each(function($row, $key) use (&$gastos_fijos){
			$gastos_fijos[] = [
				'Categoría' => $row->category->name,
				'Concepto' => $row->concept,
				'Cantidad' => $row->amount,
				'Sucursal' => $row->branch->name
			];
		});

		$expenses_variable->each(function($row, $key) use (&$gastos_variables){
			$gastos_variables[] = [
				'Categoría' => $row->category->name,
				'Concepto' => $row->concept,
				'Cantidad' => $row->amount,
				'Sucursal' => $row->branch->name
			];
		});

		$excel = Excel::create('Utilidades', function($excel) use ($ganancias, $gastos_fijos, $gastos_variables, $id, $start_date, $end_date) {
			$excel->sheet('Ingresos', function($sheet) use($ganancias, $gastos_fijos, $gastos_variables, $id, $start_date, $end_date) {

				$sheet->cell('A1', function($cell) use ($ganancias){
					$cell->setFontWeight('bold');
					$cell->setFontSize(14);
					$cell->setValue('Ingresos: $'.number_format(collect($ganancias)->sum('Cantidad'),2));
				});

				$sheet->cell('B1', function($cell) use ($ganancias, $gastos_fijos, $gastos_variables){
					$cell->setFontWeight('bold');
					$cell->setFontSize(14);
					$cell->setValue('Utilidad: $'.number_format( (collect($ganancias)->sum('Cantidad') - collect($gastos_fijos)->sum('Cantidad') - collect($gastos_variables)->sum('Cantidad') ),2));
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
					$id = !$id?auth()->user()->branches->pluck('id'):$id;
					$sucursal = Branch::find($id);
					$sheet->cell('A3', function($cell) use ($sucursal){
						$cell->setFontWeight('bold');
						$cell->setFontSize(14);
						if ( count($sucursal) > 1 ){
							$cell->setValue('Sucursal: '.$sucursal->implode('name', ', '));
						} else {
							$cell->setValue('Sucursal: '.$sucursal->name);
						}
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

			$excel->sheet('Egresos Fijos', function($sheet) use($ganancias, $gastos_fijos, $gastos_variables, $id, $start_date, $end_date) {
				$sheet->cell('A1', function($cell) use ($ganancias, $gastos_fijos, $gastos_variables) {
					$cell->setFontWeight('bold');
					$cell->setFontSize(14);
					$cell->setValue('Egresos: $'.number_format( collect($gastos_fijos)->sum('Cantidad') ,2));
				});

				$sheet->cell('B1', function($cell) use ($ganancias, $gastos_fijos, $gastos_variables) {
					$cell->setFontWeight('bold');
					$cell->setFontSize(14);
					$cell->setValue('Utilidad: $'.number_format( (collect($ganancias)->sum('Cantidad') - collect($gastos_fijos)->sum('Cantidad') - collect($gastos_variables)->sum('Cantidad') ),2));
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
					$id = !$id?auth()->user()->branches->pluck('id'):$id;
					$sucursal = Branch::find($id);
					$sheet->cell('A3', function($cell) use ($sucursal){
						$cell->setFontWeight('bold');
						$cell->setFontSize(14);
						if ( count($sucursal) > 1 ){
							$cell->setValue('Sucursal: '.$sucursal->implode('name', ', '));
						} else {
							$cell->setValue('Sucursal: '.$sucursal->name);
						}
					});
				}

				$sheet->cells('A:I', function($cells) {
					$cells->setAlignment('left');
					$cells->setValignment('center');
				});

				$sheet->cells('A5:D5', function($cells) {
					$cells->setAlignment('center');
					$cells->setValignment('center');
					$cells->setFontWeight('bold');
					$cells->setFontSize(12);
				});
				$sheet->fromArray($gastos_fijos, null, 'A5', true);
				$sheet->setAutoFilter('A5:D5');
			});

			$excel->sheet('Egresos Variables', function($sheet) use($ganancias, $gastos_fijos, $gastos_variables, $id, $start_date, $end_date) {
				$sheet->cell('A1', function($cell) use ($ganancias, $gastos_fijos, $gastos_variables) {
					$cell->setFontWeight('bold');
					$cell->setFontSize(14);
					$cell->setValue('Egresos: $'.number_format( collect($gastos_variables)->sum('Cantidad') ,2));
				});

				$sheet->cell('B1', function($cell) use ($ganancias, $gastos_fijos, $gastos_variables) {
					$cell->setFontWeight('bold');
					$cell->setFontSize(14);
					$cell->setValue('Utilidad: $'.number_format( (collect($ganancias)->sum('Cantidad') - collect($gastos_fijos)->sum('Cantidad') - collect($gastos_variables)->sum('Cantidad') ),2));
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
					$id = !$id?auth()->user()->branches->pluck('id'):$id;
					$sucursal = Branch::find($id);
					$sheet->cell('A3', function($cell) use ($sucursal){
						$cell->setFontWeight('bold');
						$cell->setFontSize(14);
						if ( count($sucursal) > 1 ){
							$cell->setValue('Sucursal: '.$sucursal->implode('name', ', '));
						} else {
							$cell->setValue('Sucursal: '.$sucursal->name);
						}
					});
				}

				$sheet->cells('A:I', function($cells) {
					$cells->setAlignment('left');
					$cells->setValignment('center');
				});

				$sheet->cells('A5:D5', function($cells) {
					$cells->setAlignment('center');
					$cells->setValignment('center');
					$cells->setFontWeight('bold');
					$cells->setFontSize(12);
				});
				$sheet->fromArray($gastos_variables, null, 'A5', true);
				$sheet->setAutoFilter('A5:D5');
			});
		})->download('xlsx');

		return $excel;
	}
}
