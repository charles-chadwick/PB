<?php

namespace App\Models;

use App\Enums\UserRole;
use Exception;
use Illuminate\Auth\Authenticatable;
use Illuminate\Auth\MustVerifyEmail;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\Access\Authorizable;

class User extends Base implements AuthenticatableContract, AuthorizableContract, CanResetPasswordContract {
	use Authenticatable, Authorizable, CanResetPassword, MustVerifyEmail;

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
		'role',
		'first_name',
		'middle_name',
		'last_name',
		'email',
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
	 * @return User
	 */
	public function scopePatient() : User {
		return $this->where("role", UserRole::Patient);
	}

	/**
	 * @return User
	 */
	public function scopeStaff() : User {
		return $this->where("role", UserRole::Staff);
	}

	/**
	 * @return User
	 */
	public function scopeDoctor() : User {
		return $this->where("role", UserRole::Doctor);
	}

	/**
	 * @return User
	 */
	public function scopeNurse() : User {
		return $this->where("role", UserRole::Nurse);
	}

	/**
	 * @return HasOne
	 */
	public function profile() : HasOne {
		return $this->hasOne(Profile::class, "patient_id", "id");
	}

	public function appointments() : HasMany {
		return $this->HasMany(Appointment::class, "patient_id", "id");
	}

	/**
	 * @return HasMany
	 */
	public function icd10Codes() : HasMany {
		return $this->hasMany(ICD10Code::class, "icd10_code_id", "id");
	}
}
