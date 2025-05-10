<?php
/** @noinspection ALL */

namespace App\Models\Traits;

use Illuminate\Database\Eloquent\Casts\Attribute;

trait HasAvatar {

	public function avatar() : Attribute {
		return Attribute::make(
			get: function() {
				$avatar = $this->getFirstMediaUrl("avatars");
				return str_replace("localhost", "localhost:8080", $avatar);

			}
		);
	}

}