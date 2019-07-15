<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Branch;
use App\Models\Audit;
use App\Models\AuditDetail;

class AuditsController extends Controller
{
	public function index(Request $req, $id = null){
		$audits = Audit::with('branch', 'user')->whereHas('branch', function($q) use ($id){
			if ( auth()->user()->role_id == 2 ){
				$q->whereIn('id', auth()->user()->branches->pluck('id'));
			} else{
				if( $id ){
					$q->where('id', $id);
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

	public function getSummary($id){
		$audit = Audit::find($id);

		if (! $audit ){ return view('errors.404'); }

		$details = array();

		foreach($audit->auditDetail as $key => $item) {
			$details[$item->question->category->name][$key] = $item;
		}
		unset($audit->auditDetail);

		return view('audits.summary', compact('audit', 'details'));
	}

	/**
     * Send an email to the franchise with an audit result
     *
     * @return Mensaje de exito o msg al enviar correo
     */
    public function sendSummary(Request $req)
    {
		$audit = Audit::find($req->audit_id);

        $params = array();
        $params['subject'] = "Resumen de auditoría";
        $params['title'] = "Resumen de auditoría";
        $params['content'] = "Hola <span class='capitalize'>".$audit->branch->user->fullname."</span>, una auditoría ha sido realizada en una de sus franquicias, accede al siguiente <a target='_blank' href='".url('resumen-de-auditoria/'.$audit->id)."'>enlace</a> para ver los detalles.";
        $params['email'] = $audit->branch->user->email;
        $params['view'] = 'mails.general';

        if ( $this->mail($params) ) {
            return response(['msg' => 'Se ha enviado un enlace para visualizar el resultado de auditoría al franquiciatario', 'status' => 'success'], 200);
        }
        return response(['msg' => "Algo salió mal al enviar el correo... intente nuevamente", 'status' => 'error'], 200);
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
