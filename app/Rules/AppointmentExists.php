<?php
/** @noinspection ALL */

namespace App\Rules;

use App\Models\Appointment;
use Carbon\Carbon;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Support\Facades\DB;


class AppointmentExists implements ValidationRule {
	protected string $start_date;
	protected int    $length;
	protected int    $user_id;
	protected int    $ignore_id;

	public function __construct( $start_date, $length, $user_id, $ignore_id = null ) {
		$this->start_date = $start_date;
		$this->length = $length;
		$this->user_id = $user_id;
		$this->ignore_id = $ignore_id ?? 0;
	}

	public function validate( string $attribute, mixed $value, \Closure $fail ) : void {

		// parse and build the start/end dates
		$start = $this->start_date;
		$end = Carbon::parse(strtotime($this->start_date))
					 ->addMinutes($this->length)
					 ->format('Y-m-d H:i:s');

		// build the query in separate lines due to IDE formatting
		$appointment = Appointment::whereBetween('date_and_time', [
			$start,
			$end
		]);

		$appointment->with([
			'user' => function ( $query ) {
				$query->select('id', $this->user_id);
			}
		]);

		// if we are ignoring the particular record (in case of an update)
		if ( $this->ignore_id ) {
			$appointment->where('id', '!=', $this->ignore_id);
		}

		// did we pass or fail?
		if ( $appointment->exists() ) {
			$fail(__("There is already an appointment for this user/date and time"));
		}
	}
}
