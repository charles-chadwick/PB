<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Image\Enums\Fit;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Base extends Model implements HasMedia {

	use SoftDeletes, InteractsWithMedia;

	public function __construct( array $attributes = [] ) {
		parent::__construct($attributes);

		$this->fillable = array_merge($this->fillable, [
			"created_by_id",
			"updated_by_id",
			"deleted_by_id"
		]);

		$this->casts = array_merge($this->casts, [
			"created_by",
			"updated_by",
			"deleted_by"
		]);
	}

	public function getCreatedByAttribute() : BelongsTo {
		return $this->belongsTo(User::class, "created_by_id", "id");
	}

	public function getUpdatedByAttribute() : BelongsTo {
		return $this->belongsTo(User::class, "updated_by_id", "id");
	}

	public function getDeletedByAttribute() : BelongsTo {
		return $this->belongsTo(User::class, "deleted_by_id", "id");
	}

	public function registerMediaConversions(?Media $media = null): void
	{
		$this
			->addMediaConversion('preview')
			->fit(Fit::Contain, 300, 300)
			->nonQueued();
	}
}