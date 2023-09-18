<?php 
namespace App\Models;

use App\Models\BaseModel as Model;
use App\Traits\ValidationTrait;

class EventMedia extends Model
{
    
    public function __construct() {
        
        parent::__construct();
    }

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'event_medias';

    protected $fillable = array('events_id', 'upload_type', 'youtube_preview', 'youtube_url', 'media_id', 'title', 'description');

    protected $dates = ['created_at','updated_at'];


    protected function setRules() {

        $this->val_rules = array(
        );
    }

    protected function setAttributes() {
        $this->val_attributes = array(
        );
    }

    public function event() {
        return $this->belongsTo('App\Models\Event', 'events_id');
    }

    public function media() {
        return $this->belongsTo('App\Models\Media', 'media_id');
    }

}
