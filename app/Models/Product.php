<?php

namespace App\Models;

use App\Models\BaseModel as Model;
use App\Traits\ValidationTrait;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use SoftDeletes;
    use ValidationTrait {
        ValidationTrait::validate as private parent_validate;
    }

    public function __construct(array $attributes = array()) {
        
        parent::__construct($attributes);
        $this->__validationConstruct();
    }


    protected $table = 'products';


    protected $fillable = array('slug', 'name', 'title', 'sub_title', 'short_description', 'content', 'parent_id', 'featured_image_id', 'banner_image_id', 'icon_image_id', 
    'browser_title', 'meta_description', 'meta_keywords', 'bottom_description', 'og_title', 'og_description', 'og_image_id', 
    'extra_js', 'category_id', 'is_featured', 'extra_image_id', 'list_in_home_about', 'list_in_home_bottom', 'status', 'priority');

    protected $dates = ['created_at','updated_at'];

    protected function setRules() {

        $this->val_rules = array(
            'name' => 'required|max:250',
            'slug' => 'required|max:250|unique:products,slug,ignoreId,id,deleted_at,NULL',
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
        return $this->morphMany('App\Models\Faq', 'linkable')->orderBy('display_order', 'DESC')->orderBy('created_at', 'DESC');
    }

    public function featured_image()
    {
    	return $this->belongsTo('App\Models\Media', 'featured_image_id');
    }

    public function banner_image()
    {
    	return $this->belongsTo('App\Models\Media', 'banner_image_id');
    }

    public function icon()
    {
    	return $this->belongsTo('App\Models\Media', 'icon_image_id');
    }

    public function extra_image()
    {
    	return $this->belongsTo('App\Models\Media', 'extra_image_id');
    }

    public function og_image()
    {
    	return $this->belongsTo('App\Models\Media', 'og_image_id');
    }

    public function category()
    {
        return $this->belongsTo('App\Models\Category', 'category_id');
    }

    public function tags(){
        return $this->belongsToMany('App\Models\Tag', 'product_tags', 'products_id', 'tags_id');
    }
}
