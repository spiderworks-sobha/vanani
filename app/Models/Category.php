<?php

namespace App\Models;

use App\Models\BaseModel as Model;
use App\Traits\ValidationTrait;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use SoftDeletes;
    use ValidationTrait {
        ValidationTrait::validate as private parent_validate;
    }
    
    public function __construct() {
        
        parent::__construct();
        $this->__validationConstruct();
    }

    protected $table = 'categories';

    protected $fillable = [
        'slug', 'name', 'category_type', 'tag_line', 'short_description', 'description', 'title', 'parent_id', 'banner_image_id', 'featured_image_id', 
        'browser_title', 'meta_description', 'meta_keywords', 'bottom_description', 'og_title', 'og_description', 'og_image_id', 'extra_js', 
        'is_featured', 'status'
    ];

    protected $dates = ['created_at','updated_at'];

    protected function setRules() {

        $this->val_rules = array(
            'name' => 'required|max:250',
            'slug' => 'required|max:250|unique:categories,slug,ignoreId,id,deleted_at,NULL',
        );
    }

    protected function setAttributes() {
        $this->val_attributes = array(
        );
    }

    public function validate($data = null, $ignoreId = 'NULL') {
        if( isset($this->val_rules['slug']) )
        {
            $this->val_rules['slug'] = str_replace('ignoreId', $ignoreId, $this->val_rules['slug']);
        }
        return $this->parent_validate($data);
    }


    public function faq()
    {
        return $this->morphMany('App\Models\Faq', 'linkable')->orderBy('display_order', 'ASC')->orderBy('created_at', 'DESC');
    }

    public function parent()
    {
        return $this->belongsTo('App\Models\Category', 'parent_id');
    }

    public function banner_image()
    {
    	return $this->belongsTo('App\Models\Media', 'banner_image_id');
    }

    public function featured_image()
    {
    	return $this->belongsTo('App\Models\Media', 'featured_image_id');
    }

    public function og_image()
    {
    	return $this->belongsTo('App\Models\Media', 'og_image_id');
    }

    public function menu()
    {
        return $this->morphOne('App\Models\MenuItem', 'linkable');
    }

    public function children()
    {
        return $this->hasMany('App\Models\Category', 'parent_id', 'id');
    }

    public function blogs(){
        return $this->hasMany(Blog::class, 'category_id');
    }
}
