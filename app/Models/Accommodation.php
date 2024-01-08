<?php

namespace App\Models;

use App\Models\BaseModel as Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Accommodation extends Model
{
    use SoftDeletes;

    protected $table = 'accommodations';

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

    public function features() :BelongsToMany
    {
        return $this->belongsToMany(Amenity::class, 'rental_feature', 'rental_id', 'amenity_id')->withPivot('priority', 'created_by', 'updated_by', 'created_at', 'updated_at')->orderByPivot('priority', 'ASC');
    }

    public function featured_features() :BelongsToMany
    {
        return $this->belongsToMany(Amenity::class, 'rental_feature', 'rental_id', 'amenity_id')->withPivot('priority', 'created_by', 'updated_by', 'created_at', 'updated_at')->orderByPivot('priority', 'ASC')->limit(4);
    }

    public function amenities() :BelongsToMany
    {
        return $this->belongsToMany(Amenity::class, 'accommodation_amenity', 'accommodation_id', 'amenity_id')->withPivot('priority', 'created_by', 'updated_by', 'created_at', 'updated_at')->orderByPivot('priority', 'ASC');
    }

    public function activities() :BelongsToMany
    {
        return $this->belongsToMany(Activity::class, 'accommodation_activity', 'accommodation_id', 'activity_id')->withPivot('priority', 'created_by', 'updated_by', 'created_at', 'updated_at')->orderByPivot('priority', 'ASC');
    }

    public function tags() :BelongsToMany
    {
        return $this->belongsToMany(Tag::class, 'accommodation_tag', 'accommodation_id', 'tag_id')->withPivot('created_by', 'updated_by', 'created_at', 'updated_at');
    }

    public function medias() :BelongsToMany
    {
        return $this->belongsToMany(Media::class, 'accommodation_media', 'accommodation_id', 'media_id')->withPivot('id', 'title', 'description', 'video_preview_image', 'created_by', 'updated_by', 'created_at', 'updated_at');
    }

    public function featured_medias() :BelongsToMany
    {
        return $this->belongsToMany(Media::class, 'accommodation_media', 'accommodation_id', 'media_id')->withPivot('id', 'video_preview_image', 'created_by', 'updated_by', 'created_at', 'updated_at')->wherePivot('is_featured', 1);
    }

    public function reviews(): MorphMany
    {
        return $this->morphMany(Review::class, 'reviewable')->orderBy('priority', 'ASC')->orderBy('created_at', 'DESC');
    }

    public function features_image(): BelongsTo
    {
        return $this->belongsTo(Media::class, 'features_image_id');
    }

    public function amenities_image(): BelongsTo
    {
        return $this->belongsTo(Media::class, 'amenities_image_id');
    }

    public function activities_image(): BelongsTo
    {
        return $this->belongsTo(Media::class, 'activities_image_id');
    }

    public function featured_video(): BelongsTo
    {
        return $this->belongsTo(Media::class, 'featured_video_id');
    }

    public function home_image(): BelongsTo
    {
        return $this->belongsTo(Media::class, 'featured_home_listing_image_id');
    }
}
