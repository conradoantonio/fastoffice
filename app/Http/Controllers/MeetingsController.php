<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Meeting;

class MeetingsController extends Controller
{
	public function index(Request $req){
		$meetings = Meeting::all();

		if ( $req->ajax() ){
			return view('meetings.table', compact('meetings'))->render();
		}
		return view('meetings.index', compact('meetings'))->render();
	}

	public function form($id = null){
		$meeting = new Meeting();
		if ( $id ) {
			$meeting = Meeting::findOrFail($id);
		}
		return view('meetings.form', compact('meeting'));
	}

	public function store(NewRequest $req){
		$meeting = new News();
		$meeting->fill($req->all());

		if ( $meeting->save() ){
			return Redirect()->route('Meeting')->with('msg', 'Reunion creada');
		} else {
			return Redirect()->back()->with('msg', 'Error al crear noticia');
		}
	}

	public function update(NewRequest $req, $id){
		$meeting = Meeting::find($id);
		$meeting->fill($req->all());

		if ( $meeting->save() ){
			return Redirect()->route('Meeting')->with('msg', 'Reunion actualizada');
		} else {
			return Redirect()->back()->with('msg', 'Error al actualizar noticia');
		}
	}

	public function destroy($id){
		if ( Meeting::destroy($id) ) {
			return ['delete' => 'true'];
		} else {
			return ['delete' => 'false'];
		}
	}

	public function multipleDestroys(NewRequest $req){
		if ( Meeting::destroy($req->ids) ){
			return ["delete" => "true"];
		}
		return ['delete' => 'false'];
	}

	public function status(Request $req){
		$meeting = Meeting::find($req->id);
		$meeting->status = $meeting->status?'0':'1';

		if ( $meeting->save() ) {
			return ['status' => true, 'msg' => 'Solicitud agendada exitosamente'];
		} else {
			return ['status' => false, 'msg' => 'Ocurrio un problema al agendar la solicitud, intente más tarde'];
		}
	}
}
