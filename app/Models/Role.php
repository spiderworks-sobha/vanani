<?php

namespace App\Models;

use App\Models\BaseModel as Model;
use App\Traits\ValidationTrait;

class Role extends Model
{
    
    use ValidationTrait {
        ValidationTrait::validate as private parent_validate;
    }

    public function __construct(array $attributes = array()) {
        
        parent::__construct($attributes);
        $this->__validationConstruct();
    }

    protected $table = 'roles';


    protected $fillable = ['name', 'guard_name'];

    protected $dates = ['created_at','updated_at'];

    protected function setRules() {

        $this->val_rules = array(
            'name' => 'required|max:250|unique:roles,name,ignoreId',
        );
    }

    protected function setAttributes() {
        $this->val_attributes = array(
        );
    }

    public function validate($data = null, $ignoreId = 'NULL') {
        if( isset($this->val_rules['name']) )
        {
            $this->val_rules['name'] = str_replace('ignoreId', $ignoreId, $this->val_rules['name']);
        }
        return $this->parent_validate($data);
    }

    public function permissions()
    {
        return $this->belongsToMany('App\Models\Permission', 'role_has_permissions', 'role_id', 'permission_id');
    }

}