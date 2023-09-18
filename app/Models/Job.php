<?php

namespace App\Models;

use App\Models\BaseModel as Model;
use App\Traits\ValidationTrait;
use Illuminate\Database\Eloquent\SoftDeletes;

class Job extends Model
{
    use SoftDeletes;
	use ValidationTrait {
        ValidationTrait::validate as private parent_validate;
    }
    
    public function __construct() {
        
        parent::__construct();
        $this->__validationConstruct();
    }

    protected $table = 'careers';


    protected $fillable = array('departments_id', 'job_code', 'slug', 'name', 'title', 'job_location', 'short_description', 'responsibilities', 'eligibility', 'skills', 'how_to_aply', 'last_application_date', 'featured_image_id', 'banner_image_id', 'browser_title', 'meta_description', 'meta_keywords', 'og_title', 'og_description', 'og_image_id', 'bottom_description', 'extra_js', 'status', 'priority', 'is_featured');

    protected $dates = ['created_at','updated_at'];

    protected function setRules() {

        $this->val_rules = array(
            'name' => 'required|max:250',
            'slug' => 'required|alpha_dash|unique:careers,slug,ignoreId,id,deleted_at,NULL',
            'job_code' => 'required|unique:careers,job_code,ignoreId,id,deleted_at,NULL',
        );
    }

    protected function setAttributes() {
        $this->val_attributes = array(
        );
    }

    public function validate($data = null, $ignoreId = 'NULL') {
        $ignore_array = ['slug', 'job_code'];
        foreach($ignore_array as $ignore){
            $this->val_rules[$ignore] = str_replace('ignoreId', $ignoreId, $this->val_rules[$ignore]);
        }
        return $this->parent_validate($data);
    }

    public function featured_image()
    {
        return $this->belongsTo('App\Models\Media', 'featured_image_id');
    }

    public function banner_image()
    {
        return $this->belongsTo('App\Models\Media', 'banner_image_id');
    }

    public function og_image()
    {
        return $this->belongsTo('App\Models\Media', 'og_image_id');
    }

    public function department()
    {
        return $this->belongsTo('App\Models\Department', 'department_id');
    }


}