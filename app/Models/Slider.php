<?php
namespace App\Models;

use App\Models\BaseModel as Model;
use App\Traits\ValidationTrait;
use Illuminate\Database\Eloquent\SoftDeletes;

class Slider extends Model
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
    protected $table = 'sliders';

    protected $fillable = array('slider_name', 'width', 'height');

    protected $dates = ['created_at','updated_at'];


    protected function setRules() {

        $this->val_rules = array(
            'slider_name' => 'required|max:250|unique:sliders,slider_name,ignoreId,id,deleted_at,NULL',
            'width' => 'required',
            'height' => 'required',
        );
    }

    protected function setAttributes() {
        $this->val_attributes = array(
        );
    }

    public function validate($data = null, $ignoreId = 'NULL') {
        if( isset($this->val_rules['slider_name']) )
        {
            $this->val_rules['slider_name'] = str_replace('ignoreId', $ignoreId, $this->val_rules['slider_name']);
        }
        return $this->parent_validate($data);
    }

    public function photos()
    {
        return $this->hasMany('App\Models\SliderPhoto', 'sliders_id')->orderBy('priority');
    }

}
