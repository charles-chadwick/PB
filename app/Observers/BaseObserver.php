<?php

namespace App\Observers;

use App\Models\Base;

class BaseObserver
{
    /**
     * Handle the Base "created" event.
     */
    public function creating(Base $base): void
    {
        $base->created_by_id = 8; // auth()->user()->id;
    }

    /**
     * Handle the Base "updated" event.
     */
    public function updating(Base $base): void
    {
		$base->updated_by_id = 6; // auth()->user()->id;
    }

    /**
     * Handle the Base "deleted" event.
     */
    public function deleting(Base $base): void
    {
		$base->deleted_by_id = 2; // auth()->user()->id;
    }

    /**
     * Handle the Base "restored" event.
     */
    public function restored(Base $base): void
    {
        //
    }

    /**
     * Handle the Base "force deleted" event.
     */
    public function forceDeleted(Base $base): void
    {
        //
    }
}
