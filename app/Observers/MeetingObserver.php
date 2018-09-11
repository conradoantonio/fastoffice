<?php

namespace App\Observers;

use App\Models\Meeting;

class MeetingObserver
{
	/**
	 * Listen to the Meeting created event.
	 *
	 * @param  \App\Meeting  $meeting
	 * @return void
	 */
	public function saved(Meeting $meeting)
	{
		if ( auth()->check() && auth()->user()->role_id = 3 ){
			if ( auth()->user()->office ){
				session()->forget('reminders');
				$today = date('Y-m-d');
				$meetings = Meeting::with(['office', 'user'])->where('datetime_start', '>=', $today.' 00:00:00')->where('datetime_start', '<=', $today.' 23:59:59')->where('status', '1')->where('office_id', auth()->user()->office->id)->get();
				session(['reminders' => $meetings]);
			}
		}
	}

	/**
	 * Listen to the Meeting deleting event.
	 *
	 * @param  \App\Meeting  $meeting
	 * @return void
	 */
	public function deleted(Meeting $meeting)
	{
		if ( auth()->check() && auth()->user()->role_id = 3 ){
			if ( auth()->user()->office ){
				session()->forget('reminders');
				$today = date('Y-m-d');
				$meetings = Meeting::with(['office', 'user'])->where('datetime_start', '>=', $today.' 00:00:00')->where('datetime_start', '<=', $today.' 23:59:59')->where('status', '1')->where('office_id', auth()->user()->office->id)->get();
				session(['reminders' => $meetings]);
			}
		}
	}
}