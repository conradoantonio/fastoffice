<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Branch;
use App\Models\Audit;
use App\Models\AuditDetail;

class AuditsController extends Controller
{
	public function index(Request $req, $id = null){
		$audits = Audit::with('office', 'user')->whereHas('office', function($q) use ($id){
			if ( auth()->user()->role_id == 2 ){
				$q->whereIn('branch_id', auth()->user()->branches->pluck('id'));
			} else{
				if( $id ){
					$q->where('branch_id', $id);
				}
			}
		})
		->where('status', 1)
		->get();

		$branches = Branch::pluck('name', 'id')->prepend('Mostrar todas', 0);
		if ( $req->ajax() ) {
			return view('audits.table', compact('audits'));
		}
		return view('audits.index', compact('audits', 'branches'));
	}

	public function show($id){
		$audit = Audit::find($id);

		$details = array();

		foreach($audit->auditDetail as $key => $item)	{
			$details[$item->question->category->name][$key] = $item;
		}
		unset($audit->auditDetail);

		return view('audits.show', compact('audit', 'details'));
	}

	public function form($id = null){
		$office = new Office();
		$types = OfficeType::pluck('name', 'id')->prepend("Seleccione un tipo", 0);
		$users = [0 => "Seleccione un usuario"];
		$offices = Branch::where('status', 1)->pluck('name','id')->prepend("Seleccione una sucursal", 0);
		$states = State::pluck('name', 'id')->prepend('Selecciona un estado', 0);
		$municipalities = [0 => 'Seleccione un municipio'];

		if ( $id ) {
			$office = Office::findOrFail($id);
			$users = User::where(['role_id' => 3, 'branch_id' => $office->branch_id])->pluck('fullname', 'id')->prepend("Seleccione un usuario", 0);
			$municipalities = Municipality::whereHas('state', function($query) use ($office){
				$query->where('id', $office->state_id);
			})->pluck('name', 'id')->prepend('Seleccione una ciudad', 0);
		}
		return view('offices.form', compact('office', 'users', 'offices', 'types', 'states', 'municipalities'));
	}

	public function update(OfficeRequest $req, $id){
		$office = Office::find($id);
		$office->fill($req->except('photo'));

		if ( $req->hasFile('photo') ){
			$directorio = public_path()."/img/offices/".$office->id."/";
			if (!File::exists($directorio)){
				File::makeDirectory($directorio, 0777, true, true);
			}

			$image = $req->file('photo');
			$name = date("His").$office->pictures->count().'.'.$image->getClientOriginalExtension();
			$path = $directorio.$name;

			if ( $image ) {
				$picture = new OfficePicture();
				$picture->path = '/img/offices/'.$id.'/'.$name;
				$picture->size = $image->getClientSize();
				$office->pictures()->save($picture);

				Image::make($image)->save($path);
			}
			return;
		}

		if ( $office->save() ){
			return Redirect()->route('Office')->with('msg', 'Oficina actualizada');
		} else {
			return Redirect()->back()->with('msg', 'Error al actualizar oficina');
		}
	}
}
