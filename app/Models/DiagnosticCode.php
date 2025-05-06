<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class DiagnosticCode extends Base
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'code',
        'description',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'id' => 'integer',
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

    public function patients(): BelongsToMany
    {
        return $this->belongsToMany(User::class, "patient_diagnostic_codes", "diagnostic_code_id", "patient_id");
    }
}
