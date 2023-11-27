<?php

namespace App\Models;

use App\Models\BaseModel as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SustainableTourismProcess extends Model
{
    use SoftDeletes;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'sustainable_tourism_processes';


    protected $guarded = ['id', 'created_by', 'updated_by', 'created_at', 'updated_at', 'deleted_at'];

    protected $dates = ['created_at','updated_at'];


    public function featured_image()
    {
        return $this->belongsTo(Media::class, 'featured_image_id');
    }

    public function icon()
    {
        return $this->belongsTo(Media::class, 'icon_image_id');
    }

    public function banner_image()
    {
        return $this->belongsTo(Media::class, 'banner_image_id');
    }

    public function og_image()
    {
        return $this->belongsTo(Media::class, 'og_image_id');
    }

}
