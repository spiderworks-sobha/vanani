<?php 
namespace App\Models;

use App\Models\BaseModel as Model;
use App\Traits\ValidationTrait;

class SliderPhoto extends Model
{
    
    public function __construct() {
        
        parent::__construct();
    }

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'slider_photos';

    protected $fillable = array('sliders_id', 'media_id', 'meta_data');

    protected $dates = ['created_at','updated_at'];


    protected function setRules() {

        $this->val_rules = array(
        );
    }

    protected function setAttributes() {
        $this->val_attributes = array(
        );
    }

    public function slider() {
        return $this->belongsTo('App\Models\Slider', 'sliders_id');
    }

    public function media() {
        return $this->belongsTo('App\Models\Media', 'media_id');
    }

    public function getMetaDataAttribute($value)
    {
        $output = json_decode($value);
        return $output;
    }

}
