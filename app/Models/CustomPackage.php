<?php

namespace App\Models;

use App\Models\BaseModel as Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class CustomPackage extends Model
{
    use SoftDeletes;

    protected $table = 'custom_packages';

    protected $guarded = ['id', 'updated_by', 'created_at', 'updated_at', 'deleted_at'];

    protected $dates = ['created_at','updated_at'];


    public function accommodation(): BelongsTo
    {
        return $this->belongsTo(Accommodation::class, 'accommodation_id');
    }

    public function activities() :BelongsToMany
    {
        return $this->belongsToMany(Activity::class, 'custom_package_activity', 'custom_package_id', 'activity_id');
    }

}
