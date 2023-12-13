<?php

namespace App\Models;

use App\Models\BaseModel as Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Package extends Model
{
    use SoftDeletes;

    protected $table = 'packages';

    protected $guarded = ['id', 'created_by', 'updated_by', 'created_at', 'updated_at', 'deleted_at'];

    protected $dates = ['created_at','updated_at'];

    public function faq(): MorphMany
    {
        return $this->morphMany(Faq::class, 'linkable')->orderBy('display_order', 'ASC')->orderBy('created_at', 'DESC');
    }

    public function featured_image(): BelongsTo
    {
        return $this->belongsTo(Media::class, 'featured_image_id');
    }

    public function banner_image(): BelongsTo
    {
        return $this->belongsTo(Media::class, 'banner_image_id');
    }

    public function og_image(): BelongsTo
    {
        return $this->belongsTo(Media::class, 'og_image_id');
    }

    public function icon_image(): BelongsTo
    {
        return $this->belongsTo(Media::class, 'icon_image_id');
    }

    public function attractions() :BelongsToMany
    {
        return $this->belongsToMany(Attraction::class, 'package_attraction', 'package_id', 'attraction_id')->withPivot('priority', 'created_by', 'updated_by', 'created_at', 'updated_at')->orderByPivot('priority', 'ASC');
    }

    public function activities() :BelongsToMany
    {
        return $this->belongsToMany(Activity::class, 'package_activity', 'package_id', 'activity_id')->withPivot('priority', 'created_by', 'updated_by', 'created_at', 'updated_at')->orderByPivot('priority', 'ASC');
    }

    public function tags() :BelongsToMany
    {
        return $this->belongsToMany(Tag::class, 'package_tag', 'package_id', 'tag_id')->withPivot('created_by', 'updated_by', 'created_at', 'updated_at');
    }

    public function medias() :BelongsToMany
    {
        return $this->belongsToMany(Media::class, 'package_media', 'package_id', 'media_id')->withPivot('id', 'title', 'description', 'video_preview_image', 'created_by', 'updated_by', 'created_at', 'updated_at');
    }

    public function featured_medias() :BelongsToMany
    {
        return $this->belongsToMany(Media::class, 'package_media', 'package_id', 'media_id')->withPivot('id', 'video_preview_image', 'created_by', 'updated_by', 'created_at', 'updated_at')->wherePivot('is_featured', 1);
    }

    public function reviews(): MorphMany
    {
        return $this->morphMany(Review::class, 'reviewable')->orderBy('priority', 'ASC')->orderBy('created_at', 'DESC');
    }

    public function listing(): BelongsTo
    {
        return $this->belongsTo(Listing::class, 'listings_id');
    }
}
