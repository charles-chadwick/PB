<?php

use App\Livewire\Chart;
use App\Livewire\Patients;
use App\Livewire\Welcome;
use Illuminate\Support\Facades\Route;

Route::get('/', Welcome::class)->name('welcome');
Route::get('/patients', Patients::class)->name('patients');
Route::get('/chart/{patient}', Chart::class)->name('chart');
