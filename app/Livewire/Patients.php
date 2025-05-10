<?php

namespace App\Livewire;

use App\Models\Patient;
use Illuminate\View\View;
use Livewire\Component;
use Livewire\WithPagination;

class Patients extends Component {
	use WithPagination;

	public string $search = '';
	public $sortBy     = [
		"column"    => "first_name",
		"direction" => "asc"
	];
	public $sort_order = "asc";

	public function render() : View {

		return view('livewire.patients', [
			'patients' => $this->patients(),
			'headers'  => $this->headers(),
		]);
	}

	public function patients() : array|\LaravelIdea\Helper\App\Models\_IH_Patient_C|\Illuminate\Pagination\LengthAwarePaginator|\LaravelIdea\Helper\App\Models\_IH_Base_C {
		return Patient::orderBy(...array_values($this->sortBy))
			->when($this->search, function ($query, $search) {
				$query->where("last_name", 'LIKE ', '%'.$search.'%');
			})
			   ->paginate(10);
	}

	public function headers() : array {
		return  [
			[
				'key'    => 'id',
				'label'  => '# ID',
				'format' => function ( $row, $field ) {
					return "$field";
				}
			],
			[
				'key'   => 'first_name',
				'label' => 'First Name',
			],
			[
				'key'   => 'last_name',
				'label' => 'Last Name'
			],
			[
				'key'    => 'dob',
				'label'  => 'Date of Birth',
				'format' => [
					'date',
					'm/d/Y'
				]
			],
			[
				'key'    => 'created_at',
				'label'  => 'Created',
				'format' => [
					'date',
					'm/d/Y'
				]
			],
		];
	}
}
