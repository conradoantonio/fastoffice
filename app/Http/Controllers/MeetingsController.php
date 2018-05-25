<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use App\Http\Requests\MeetingRequest;
use App\Models\Meeting;
use App\Models\Office;
use App\Models\Branch;
use App\Models\User;

class MeetingsController extends Controller
{
	public function index(Request $req, $id = null, $start_date = null, $end_date = null){
		$meetings = Meeting::whereHas('office', function($q) use($id){
			if ( auth()->user()->role_id == 2 ){
				$q->where('branch_id', auth()->user()->branch->id);
				if( $id ){
					$q->where('id', $id);
				}
			} elseif ( auth()->user()->role_id == 3 ){
				if( $id ){
					$q->where('id', $id);
				} else {
					$q->where('id', auth()->user()->office->id);
				}
			} else {
				if( $id ){
					$q->where('branch_id', $id);
				}
			}
		});

		if ( $start_date ){
			$meetings->where('datetime_start','>',$start_date.' 00:00:00');
		}
		if( $end_date ){
			$meetings->where('datetime_start','<=',$end_date.' 23:59:59');
		}

		$meetings = $meetings->get();

		$events = [];

		foreach ($meetings as $value) {
			if ( $value->status ){
				$events[] = \Calendar::event(
					$value->title, //event title
					false, //full day event?
					new \DateTime($value->datetime_start), //start time (you can also use Carbon instead of DateTime)
					new \DateTime($value->datetime_end), //end time (you can also use Carbon instead of DateTime)
					0, //optionally, you can specify an event ID
					[
						'color' => "#1e671d"
					]
				);
			}
		}

		$calendar = \Calendar::addEvents($events) //add an array with addEvents
		->setOptions([ //set fullcalendar options
			'firstDay' => 0,
			'id' => 'calendarDisplay'
		]);

		$branches = Branch::pluck('name', 'id')->prepend("Mostrar todas",0);
		$offices = Office::get();
		if ( auth()->user()->role_id == 2 ){
			$offices = $offices->where('branch_id', auth()->user()->branch->id);
		}
		$offices = $offices->pluck('name', 'id')->prepend("Mostrar todas", 0);

		if ( $req->ajax() ){
			return view('meetings.content', compact('meetings', 'calendar'))->render();
		}
		return view('meetings.index', compact('meetings', 'calendar', 'branches', 'offices'))->render();
	}

	public function events(Request $req, $id = null, $start_date = null, $end_date = null){
		$meetings = Meeting::whereHas('office', function($q) use($id){
			if ( auth()->user()->role_id == 2 ){
				$q->where('branch_id', auth()->user()->branch->id);
			} else{
				if( $id ){
					$q->where('branch_id', $id);
				}
			}
		});

		if ( $start_date ){
			$meetings->where('datetime_start','>',$start_date.' 00:00:00');
		}
		if( $end_date ){
			$meetings->where('datetime_start','<=',$end_date.' 23:59:59');
		}

		$meetings = $meetings->get();

		$events = [];

		foreach ($meetings as $value) {
			if ( $value->status ){
				$events[] = \Calendar::event(
					$value->title, //event title
					false, //full day event?
					new \DateTime($value->datetime_start), //start time (you can also use Carbon instead of DateTime)
					new \DateTime($value->datetime_end), //end time (you can also use Carbon instead of DateTime)
					0, //optionally, you can specify an event ID
					[
						'color' => "#1e671d"
					]
				);
			}
		}

		return $events;
	}

	public function form($id = null){
		$meeting = new Meeting();
		$users = User::where(['role_id' => 4, 'status' => 1])->pluck('fullname', 'id')->prepend("Usuario no registrado", 0);
		$offices = Office::where('status', 1)->pluck('name','id')->prepend("Seleccione una oficina", 0);

		if ( $id ) {
			$meeting = Meeting::findOrFail($id);
			$meeting->date = date('d M Y', strtotime($meeting->datetime_start));
			$meeting->hour = date('H:i', strtotime($meeting->datetime_start));
		}
		return view('meetings.form', compact('meeting', 'users', 'offices'));
	}

	public function store(MeetingRequest $req){
		$meeting = new Meeting();
		$meeting->fill($req->all());

		$old = Meeting::
		where([
			['datetime_start', '>', $req->datetime_start],
			['datetime_start', '<', $req->datetime_end]
		])
		->orWhere(function($query) use ($req){
			$query->where('datetime_end', '>', $req->datetime_start);
			$query->where('datetime_end', '<', $req->datetime_end);
		})
		->where('office_id', $req->office_id)
		->get();

		if ( !$old->isEmpty() ){
			$meeting->date = date('d M Y', strtotime($meeting->datetime_start));
			$meeting->hour = date('H:i', strtotime($meeting->datetime_start));

			return Redirect()->back()->withInput(Input::all())->with('msg', 'Fecha y hora coinciden con otra solicitud, verifique disponibilidad.');
		}

		if ( $meeting->save() ){
			return Redirect()->route('Meeting')->with('msg', 'Reunión creada');
		} else {
			return Redirect()->back()->with('msg', 'Error al crear reunión');
		}
	}

	public function update(MeetingRequest $req, $id){
		$meeting = Meeting::find($id);
		$meeting->fill($req->all());

		$old = Meeting::
		where([
			['datetime_start', '>', $req->datetime_start],
			['datetime_start', '<', $req->datetime_end],
		])
		->orWhere(function($query) use ($req){
			$query->where('datetime_end', '>', $req->datetime_start);
			$query->where('datetime_end', '<', $req->datetime_end);
		})
		->where([
			['id', '!=', $id],
			'office_id' => $req->office_id
		])->get();

		if ( !$old->isEmpty() ){
			$meeting->date = date('d M Y', strtotime($meeting->datetime_start));
			$meeting->hour = date('H:i', strtotime($meeting->datetime_start));

			return Redirect()->back()->with('msg', 'Fecha y hora coinciden con otra solicitud, verifique disponibilidad.');
		}

		if ( $meeting->save() ){
			return Redirect()->route('Meeting')->with('msg', 'Reunión actualizada');
		} else {
			return Redirect()->back()->with('msg', 'Error al actualizar reunión');
		}
	}

	public function destroy($id){
		if ( Meeting::destroy($id) ) {
			return ['delete' => 'true'];
		} else {
			return ['delete' => 'false'];
		}
	}

	public function multipleDestroys(Request $req){
		if ( Meeting::destroy($req->ids) ){
			return ["delete" => "true"];
		}
		return ['delete' => 'false'];
	}

	public function status(Request $req){
		$meeting = Meeting::find($req->id);
		$meeting->status = $meeting->status?'0':'1';

		if ( $meeting->save() ) {
			return ['status' => true, 'msg' => 'Solicitud cambiada exitosamente'];
		} else {
			return ['status' => false, 'msg' => 'Ocurrio un problema al cambiar la solicitud, intente más tarde'];
		}
	}
}
