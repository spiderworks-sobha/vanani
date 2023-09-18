<?php
namespace App\Models;

use App\Models\BaseModel as Model;
use App\Traits\ValidationTrait;
use Illuminate\Database\Eloquent\SoftDeletes;

class PhotoGallary extends Model
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
    protected $table = 'photo_galleries';

    protected $fillable = array('gallery_name', 'description');

    protected $dates = ['created_at','updated_at'];


    protected function setRules() {

        $this->val_rules = array(
            'gallery_name' => 'required|max:250|unique:photo_galleries,gallery_name,ignoreId,id,deleted_at,NULL'
        );
    }

    protected function setAttributes() {
        $this->val_attributes = array(
        );
    }

    public function validate($data = null, $ignoreId = 'NULL') {
        if( isset($this->val_rules['gallery_name']) )
        {
            $this->val_rules['gallery_name'] = str_replace('ignoreId', $ignoreId, $this->val_rules['gallery_name']);
        }
        return $this->parent_validate($data);
    }

    public function photos()
    {
        return $this->hasMany('App\Models\PhotoGallaryPhoto', 'photo_galleries_id');
    }

}