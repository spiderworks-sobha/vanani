<?php 
namespace App\Models;

use App\Models\BaseModel as Model;
use App\Traits\ValidationTrait;

class ProjectImage extends Model
{
    
    public function __construct() {
        
        parent::__construct();
    }

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'project_images';

    protected $fillable = array('projects_id', 'media_id');

    protected $dates = ['created_at','updated_at'];


    protected function setRules() {

        $this->val_rules = array(
        );
    }

    protected function setAttributes() {
        $this->val_attributes = array(
        );
    }

    public function project() {
        return $this->belongsTo('App\Models\Project', 'projects_id');
    }

    public function media() {
        return $this->belongsTo('App\Models\Media', 'media_id');
    }

}
