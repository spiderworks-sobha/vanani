<?php

namespace App\Models;

use App\Models\BaseModel as Model;
use App\Traits\ValidationTrait;
use App\Models\Media;
use Illuminate\Database\Eloquent\SoftDeletes;

class FrontendPage extends Model
{
    use SoftDeletes;
    use ValidationTrait {
        ValidationTrait::validate as private parent_validate;
    }
    
    public function __construct() {
        
        parent::__construct();
        $this->__validationConstruct();
    }
    
    protected $table = 'frontend_pages';

     protected $fillable = array('slug', 'name', 'title', 'content', 'browser_title', 'meta_description', 'meta_keywords', 'bottom_description', 'og_title', 'og_description', 'og_image_id', 'extra_js', 'status');

    protected $dates = ['created_at','updated_at'];

    protected function setRules() {

        $this->val_rules = array(
        );
    }

    protected function setAttributes() {
        $this->val_attributes = array(
        );
    }

    public function faq()
    {
        return $this->morphMany('App\Models\Faq', 'linkable')->orderBy('created_at', 'ASC')->orderBy('display_order', 'DESC');
    }

    public function og_image()
    {
    	return $this->belongsTo('App\Models\Media', 'og_image_id');
    }

    public function menu()
    {
        return $this->morphOne('App\Models\MenuItem', 'linkable');
    }

    public function getContentAttribute($value)
    {
        if(Config('admin.services.sections'))
        {
            $content = json_decode($value);
            $output = collect($content)->map(function($item, $key){
                
                if (strpos($key, 'media_id') !== false) {
                    if($item)
                        return Media::find((int)$item);
                    else
                        return $item;
                }
                else
                   return $item;

            });

            return $output;
            
        }
        return $value;
    }

    public function create_admin_menu()
    {
        $pages = static::where('status', 1)->get();
        $html = '';
        foreach ($pages as $key => $item) {
            $html .= '<div class="checkbox"><input type="checkbox" name="frontend_pages_links[]" class="frontend_pages_links" value="frontend_pages_link-'.$item->id.'" data-id="'.$item->id.'" data-name="'.$item->name.'" id="frontend_pages-'.$item->id.'"> <label for="frontend_pages-'.$item->id.'">'.$item->name.'</label></div>';
        }
        return $html;
    }
}
