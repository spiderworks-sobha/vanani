<?php

namespace App\Models;

use App\Models\BaseModel as Model;
use App\Traits\ValidationTrait;

class Setting extends Model
{

    use ValidationTrait {
        ValidationTrait::validate as private parent_validate;
    }

    public function __construct() {

        parent::__construct();
        $this->__validationConstruct();
    }

    protected $table = 'settings';

    protected $fillable = ['code', 'value_text', 'input_type', 'settings_type'];

    protected function setRules() {
        $this->val_rules = [
            'code' => 'required|alpha_dash|unique:settings,code,ignoreId',
            'value_text' => 'required',
        ];
    }

    protected function setAttributes() {
        $this->val_attributes = [
            'code' => 'key name',
            'value_text' => 'key value',
        ];
    }

    public function validate($data = null, $ignoreId = 'NULL') {
        if( isset($this->val_rules['code']) )
        {
            $this->val_rules['code'] = str_replace('ignoreId', $ignoreId, $this->val_rules['code']);
        }
        return $this->parent_validate($data);
    }

    public function common_settings(){
        $common_settings = [];
        $settings = static::all();
        foreach($settings as $setting)
        {
            $common_settings[$setting->code] = $setting->value_text;
        }
        return $common_settings;
    }

}
