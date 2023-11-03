<?php

namespace App\Models;

use App\Models\BaseModel as Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Accommodation extends Model
{
    use SoftDeletes;

    protected $table = 'accommodations';

    protected $guarded = ['id', 'created_by', 'updated_by', 'created_at', 'updated_at', 'deleted_at'];

    protected $dates = ['created_at','updated_at'];

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

    public function amenities() :BelongsToMany
    {
        return $this->belongsToMany(Amenity::class, 'accommodation_amenity', 'accommodation_id', 'amenity_id');
    }

    public function activities() :BelongsToMany
    {
        return $this->belongsToMany(Activity::class, 'accommodation_activity', 'accommodation_id', 'activity_id');
    }

    public function tags() :BelongsToMany
    {
        return $this->belongsToMany(Tag::class, 'accommodation_activity', 'accommodation_id', 'tag_id');
    }

    public function medias() :BelongsToMany
    {
        return $this->belongsToMany(Activity::class, 'accommodation_media', 'accommodation_id', 'media_id');
    }
}
