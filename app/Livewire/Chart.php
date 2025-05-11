<?php

namespace App\Livewire;

use App\Models\Appointment;
use App\Models\Patient;
use Carbon\Carbon;
use Illuminate\View\View;
use Livewire\Component;
use Livewire\WithPagination;

class Chart extends Component {

	use WithPagination;

	public Patient $patient;
	public         $editModal = false;

	public function appointmentHeaders() : array {
		return [
			[
				"key"   => "id",
				"label" => "ID"
			],
			[
				"key"   => "date_and_time_range",
				"label" => "Date and Time"
			],
			[
				"key"   => "title",
				"label" => "Title"
			],
			[
				"key"   => "users",
				"label" => "User"
			]
		];
	}

	public function appointments() {
		return $this->patient->appointments()
							 ->orderBy('date_and_time', 'desc')
							 ->paginate(3);
	}

	public function render() : View {
		return view('livewire.patients.chart', [
			"appointments" => $this->appointments(),
			"headers"      => $this->appointmentHeaders()
		]);
	}
}
