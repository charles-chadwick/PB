<?php

namespace App\Models;

use App\Models\Traits\HasAvatar;
use App\Models\Traits\HasNotes;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Auth\Authenticatable;
use Illuminate\Auth\MustVerifyEmail;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Support\Carbon;

class Patient extends Base implements AuthenticatableContract, AuthorizableContract, CanResetPasswordContract {
	use Authenticatable, Authorizable, CanResetPassword, MustVerifyEmail;
	use HasNotes, HasAvatar;

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
		'status',
		'first_name',
		'middle_name',
		'last_name',
		'email',
		'dob',
		'gender',
		'password',
		'email_verified_at',
	];

	/**
	 * The attributes that should be hidden for serialization.
	 *
	 * @var array
	 */
	protected $hidden = [
		'password',
		'remember_token',
	];

	protected $appends = [
		"full_name",
		'dob_short'
	];

	/**
	 * Get the attributes that should be cast.
	 *
	 * @return array<string, string>
	 */
	protected function casts() : array {
		return [
			'id'                => 'integer',
			'email_verified_at' => 'timestamp',
			'password'          => 'string',
			'dob'               => "datetime"
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
	 * @return string
	 */
	protected function getFullNameAttribute() : string {
		return "$this->first_name $this->middle_name $this->last_name";
	}

	/**
	 * @return string
	 */
	protected function getDobShortAttribute() : string {
		return Carbon::parse($this->dob)->format("m/d/Y");
	}

	/**
	 * @return HasMany
	 */
	public function appointments() : HasMany {
		return $this->HasMany(Appointment::class, "patient_id", "id");
	}

	/**
	 * @return BelongsToMany
	 */
	public function diagnoses() : BelongsToMany {
		return $this->belongsToMany(Patient::class, "patient_diagnostic_codes", "patient_id", "diagnostic_code_id");
	}
}
