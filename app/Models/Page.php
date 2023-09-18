<?php

namespace App\Models;

use App\Models\BaseModel as Model;
use App\Traits\ValidationTrait;
use Illuminate\Database\Eloquent\SoftDeletes;

class Page extends Model
{
    use SoftDeletes;
    use ValidationTrait {
        ValidationTrait::validate as private parent_validate;
    }

    public function __construct() {
        
        parent::__construct();
        $this->__validationConstruct();
    }

    protected $table = 'pages';


    protected $fillable = array('slug', 'name', 'title', 'content', 'parent_id', 'featured_image_id', 'banner_image_id', 'browser_title', 'meta_description', 'meta_keywords', 'bottom_description', 'og_title', 'og_description', 'og_image_id', 'extra_js', 'status');

    protected $dates = ['created_at','updated_at'];

    protected function setRules() {

        $this->val_rules = array(
            'name' => 'required|max:250',
            'slug' => 'required|max:250|unique:pages,slug,ignoreId,id,deleted_at,NULL',
            'content' => 'required',
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

    public function og_image()
    {
    	return $this->belongsTo('App\Models\Media', 'og_image_id');
    }

    public function menu()
    {
        return $this->morphOne('App\Models\MenuItem', 'linkable');
    }

    public function parent()
    {
        return $this->belongsTo('App\Models\Page', 'parent_id');
    }

    public function children()
    {
        return $this->hasMany('App\Models\Page', 'parent_id', 'id');
    }

    public function create_admin_menu()
    {
        $pages = static::where('status', 1)->get();
        $output = $this->parse_hierarchical_page_list($pages);
        return $output;
    }

    public function parse_hierarchical_page_list($array, $currentParent = 0, $deep=0)
    {
        $html = '';

        $indent = "";
        for($i = 0; $i < $deep; $i++){
              $indent .= "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
        }

        if($array)
            foreach ($array as $key => $item) {
                if($item->parent_id == $currentParent){
                    
                    $html .= '<div class="checkbox">'.$indent.'<input type="checkbox" name="pages_links[]" class="pages_links" value="pages_link-'.$item->id.'" data-id="'.$item->id.'" data-name="'.$item->name.'" id="pages-'.$item->id.'"> <label for="pages-'.$item->id.'">'.$item->name.'</label></div>';
                        
                    if($item->children)
                    {
                        $html .= $this->parse_hierarchical_page_list ($array, $item->id, ($deep+1));
                    }
                }
            }
        return $html;
    }
}
