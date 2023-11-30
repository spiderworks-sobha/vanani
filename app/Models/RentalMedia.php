<?php 
namespace App\Models;

use App\Models\BaseModel as Model;

class RentalMedia extends Model
{
    
    public function __construct() {
        
        parent::__construct();
    }

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'rental_media';


    protected $dates = ['created_at','updated_at'];


    protected function setRules() {

        $this->val_rules = array(
        );
    }

    protected function setAttributes() {
        $this->val_attributes = array(
        );
    }

    public function media() {
        return $this->belongsTo('App\Models\Media', 'media_id');
    }

}
