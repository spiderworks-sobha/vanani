<?php

namespace App\Models;

use App\Models\BaseModel as Model;
use App\Traits\ValidationTrait;
use Illuminate\Database\Eloquent\SoftDeletes;

class JobApplication extends Model
{
    use SoftDeletes;
	use ValidationTrait {
        ValidationTrait::validate as private parent_validate;
    }
    
    public function __construct() {
        
        parent::__construct();
        $this->__validationConstruct();
    }

    protected $table = 'job_applications';


    protected $fillable = array('careers_id', 'name', 'email', 'phone_number', 'message', 'extra_data', 'resume', 'ip_address', 'user_agent', 'referrer_link', 'remarks', 'status');

    protected $dates = ['created_at','updated_at'];

    protected function setRules() {

        $this->val_rules = array(
        );
    }

    protected function setAttributes() {
        $this->val_attributes = array(
        );
    }

    public function validate($data = null, $ignoreId = 'NULL') {
        return $this->parent_validate($data);
    }

    public function job(){
        return $this->belongsTo('App\Models\Job', 'careers_id');
    }

    public function updated_user()
    {
        return $this->belongsTo('App\Models\User', 'updated_by');
    }

}