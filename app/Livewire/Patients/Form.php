<?php

namespace App\Livewire\Patients;

use App\Enums\Gender;
use App\Enums\PatientStatus;
use App\Models\Patient;
use Illuminate\View\View;
use Livewire\Component;
use Mary\Traits\Toast;

class Form extends Component {

	use Toast;

	public ?Patient $patient     = null;
	public          $first_name  = "";
	public          $middle_name = "";
	public          $last_name   = "";
	public          $email       = "";
	public          $dob         = "";
	public          $gender      = "";
	public          $genders     = null;

	public function mount( ?Patient $patient = null ) : void {

		if ( !is_null($patient->id) ) {
			$this->patient = $patient;
			$this->fill($patient);
		}
		else {
			$this->patient = new Patient();
		}
		$this->genders = [
			[
				"id"   => "Male",
				"name" => "Male"
			],
			[
				"id"   => "Female",
				"name" => "Female"
			],
			[
				"id"   => "Other",
				"name" => "Other"
			],
		];
	}

	public function save() : void {

		$this->validate([
			'first_name'  => 'required',
			'middle_name' => 'nullable',
			'last_name'   => 'required',
			'email'       => 'required|email',
			'gender'      => 'required',
			'dob'         => 'required',
		]);

		$patient_data = $this->all();
		if ( !empty($this->patient) && !is_null($this->patient->id) ) {

			$this->patient->update($patient_data);
			$this->success('Patient saved.', position: 'toast-top toast-center', redirectTo: route('chart',
				$this->patient));
		}
		else {
			$patient_data[ 'status' ] = PatientStatus::Active;
			$patient_data[ 'password' ] = bcrypt("password");
			$this->patient = Patient::create($patient_data);
			$this->success('Patient created.', position: 'toast-top toast-center', redirectTo: route('chart',
				$this->patient));

		}

	}

	public function render() : View {
		return view('livewire.patients.form', [
			'genders' => [
				[
					"value" => "Male",
					"name"  => "Male"
				],
				[
					"value" => "Female",
					"name"  => "Female"
				],
			]
		]);
	}
}
