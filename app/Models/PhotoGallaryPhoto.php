<?php 
namespace App\Models;

use App\Models\BaseModel as Model;
use App\Traits\ValidationTrait;

class PhotoGallaryPhoto extends Model
{
    
    public function __construct() {
        
        parent::__construct();
    }

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'photo_gallery_photos';

    protected $fillable = array('photo_galleries_id', 'media_id', 'title', 'description', 'alt_text');

    protected $dates = ['created_at','updated_at'];


    protected function setRules() {

        $this->val_rules = array(
        );
    }

    protected function setAttributes() {
        $this->val_attributes = array(
        );
    }

    public function gallery() {
        return $this->belongsTo('App\Models\PhotoGallary', 'photo_galleries_id');
    }

    public function media() {
        return $this->belongsTo('App\Models\Media', 'media_id');
    }

}
