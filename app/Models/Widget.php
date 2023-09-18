<?php

namespace App\Models;

use App\Models\BaseModel;
use App\Traits\ValidationTrait;
use App\Models\Media;

class Widget extends BaseModel
{
    use ValidationTrait {
        ValidationTrait::validate as private parent_validate;
    }
    
    public function __construct() {
        
        parent::__construct();
        $this->__validationConstruct();
    }

    protected $fillable = [
        'code','name','content'
    ];

    protected $dates = ['created_at','updated_at'];

    protected function setRules() {

        $this->val_rules = array(
            'content' => 'required',
        );
    }

    protected function setAttributes() {
        $this->val_attributes = array(
        );
    }

    public function validate($data = null, $ignoreId = 'NULL') {
        return $this->parent_validate($data);
    }

    public function getContentAttribute($value)
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

}
