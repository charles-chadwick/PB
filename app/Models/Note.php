<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\MorphTo;

class Note extends Base {
	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
		'on',
		'on_id',
		'type',
		'content',
	];

	/**
	 * Get the attributes that should be cast.
	 *
	 * @return array<string, string>
	 */
	protected function casts() : array {
		return [
			'id' => 'integer'
		];
	}

	/**
	 * Constructor
	 *
	 * @param  array  $attributes
	 */
	public function __construct( array $attributes = [] ) {
		parent::__construct($attributes);
	}

	/**
	 * @return MorphTo
	 */
	public function noteable() : MorphTo {
		return $this->morphTo();
	}

}
