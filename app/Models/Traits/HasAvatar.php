<?php
/** @noinspection ALL */

namespace App\Models\Traits;

use Illuminate\Database\Eloquent\Casts\Attribute;

trait HasAvatar {

	public function avatar() : Attribute {
		return Attribute::make(
			get: function() {
				return $this->getFirstMediaUrl("avatars");
			}
		);
	}

}