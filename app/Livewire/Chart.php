<?php

namespace App\Livewire;

use App\Models\Patient;
use Illuminate\View\View;
use Livewire\Component;

class Chart extends Component
{
	public Patient $patient;
	public $editModal = false;

    public function render() : View {
        return view('livewire.chart');
    }
}
