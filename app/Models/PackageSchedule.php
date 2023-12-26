<?php

namespace App\Models;

use App\Models\BaseModel as Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class PackageSchedule extends Model
{
    use SoftDeletes;

    protected $table = 'package_schedules';

    protected $guarded = ['id', 'created_by', 'updated_by', 'created_at', 'updated_at', 'deleted_at'];

    protected $dates = ['created_at','updated_at'];

    public function icon_image(): BelongsTo
    {
        return $this->belongsTo(Media::class, 'icon_image_id');
    }

    public function featured_image(): BelongsTo
    {
        return $this->belongsTo(Media::class, 'featured_image_id');
    }

    public function activities() :BelongsToMany
    {
        return $this->belongsToMany(Activity::class, 'package_schedule_activity', 'package_schedule_id', 'activity_id')->withPivot('priority', 'created_by', 'updated_by', 'created_at', 'updated_at')->orderByPivot('priority', 'ASC');
    }

}
