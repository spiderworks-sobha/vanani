<?php 
namespace App\Models;

use App\Models\BaseModel as Model;
use App\Traits\ValidationTrait;
use Illuminate\Database\Eloquent\SoftDeletes;

class ListingContent extends Model
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
    protected $table = 'listing_contents';

    protected $fillable = array('listings_id', 'meida_type', 'media_id', 'icon', 'title', 'description', 'priority');

    protected $dates = ['created_at','updated_at'];


    protected function setRules() {

        $this->val_rules = array(
            'title' => 'required|max:250',
        );
    }

    protected function setAttributes() {
        $this->val_attributes = array(
        );
    }

    public function validate($data = null, $ignoreId = 'NULL') {
        return $this->parent_validate($data);
    }

    public function listings() {
        return $this->belongsTo('App\Models\Listing', 'listings_id');
    }

    public function media() {
        return $this->belongsTo('App\Models\Media', 'media_id');
    }

}
