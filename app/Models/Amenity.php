<?php

namespace App\Models;

use App\Models\BaseModel as Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Amenity extends Model
{
    use SoftDeletes;

    protected $table = 'amenities';

    protected $guarded = ['id', 'created_by', 'updated_by', 'created_at', 'updated_at', 'deleted_at'];

    protected $dates = ['created_at','updated_at'];

    public function icon(): BelongsTo
    {
        return $this->belongsTo(Media::class, 'icon_image_id');
    }

    public function featured_image(): BelongsTo
    {
        return $this->belongsTo(Media::class, 'featured_image_id');
    }
}
