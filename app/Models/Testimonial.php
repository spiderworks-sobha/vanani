<?php

namespace App\Models;

use App\Models\BaseModel as Model;
use App\Traits\ValidationTrait;
use Illuminate\Database\Eloquent\SoftDeletes;

class Testimonial extends Model
{
    use SoftDeletes;
    use ValidationTrait {
        ValidationTrait::validate as private parent_validate;
    }
    
    public function __construct() {
        
        parent::__construct();
        $this->__validationConstruct();
    }

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'testimonials';


    protected $fillable = array('name', 'title', 'short_comment', 'related_products_id','comment','comment_type','featured_image_id', 
    'youtube_link', 'designation', 'video_link_id', 'is_featured', 'priority');

    


    protected function setRules() {

        $this->val_rules = array(
            'name' => 'required|max:250',
            'title' => 'required|max:250',
            'short_comment' => 'required',
        );
    }

    protected function setAttributes() {
        $this->val_attributes = array(
        );
    }

    public function featured_image()
    {
        return $this->belongsTo('App\Models\Media', 'featured_image_id');
    }

    public function video()
    {
        return $this->belongsTo('App\Models\Media', 'video_link_id');
    }

    public function related_product(){
        return $this->belongsTo('App\Models\Product', 'related_products_id');
    }

}
