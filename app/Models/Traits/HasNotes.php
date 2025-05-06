<?php
/** @noinspection ALL */

namespace App\Models\Traits;

use App\Enums\NoteType;
use App\Models\Note;
use Illuminate\Database\Eloquent\Relations\MorphMany;

trait HasNotes
{

	/**
	 * Relationship table
	 * @return MorphMany
	 */
	public function notes() : MorphMany {
		return $this->morphMany(Note::class, "contactable", "on", "on_id");
	}

}