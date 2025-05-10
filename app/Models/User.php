<?php

namespace App\Models;

use App\Enums\UserRole;
use App\Models\Traits\HasAvatar;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Auth\Authenticatable;
use Illuminate\Auth\MustVerifyEmail;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Illuminate\Database\Eloquent\Attributes\Scope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Foundation\Auth\Access\Authorizable;

class User extends Base implements AuthenticatableContract, AuthorizableContract, CanResetPasswordContract {
	use Authenticatable, Authorizable, CanResetPassword, MustVerifyEmail;
	use HasAvatar;

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
		'role',
		'first_name',
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

	protected $appends = [
		"full_name"
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

	protected function fullName() : Attribute {
		return Attribute::make(
			get: fn($value, $attributes) => $attributes['first_name'] . ' ' . $attributes['last_name'],
		);
	}

	/**
	 * @param  Builder  $query
	 * @return void
	 */
	#[Scope]
	protected function doctor(Builder $query): void {
		$query->where("role", UserRole::Doctor);
	}

	/**
	 * @param  Builder  $query
	 * @return void
	 */
	#[Scope]
	protected function nurse(Builder $query): void {
		$query->where("role", UserRole::Nurse);
	}

	/**
	 * @param  Builder  $query
	 * @return void
	 */
	#[Scope]
	protected function staff(Builder $query): void {
		$query->where("role", UserRole::Staff);
	}
}
