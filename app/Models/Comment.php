<?php

namespace App\Models;

use App\Models\BaseModel as Model;
use App\Traits\ValidationTrait;
use Illuminate\Database\Eloquent\SoftDeletes;

class Comment extends Model
{
    use SoftDeletes;
    use ValidationTrait {
        ValidationTrait::validate as private parent_validate;
    }

    public function __construct(array $attributes = array()) {
        
        parent::__construct($attributes);
        $this->__validationConstruct();
    }


    protected $table = 'comments';


    protected $fillable = array('name', 'email', 'comment', 'parent_id', 'parent_levels_id', 'linkable_type', 'linkable_id', 'status');

    protected $dates = ['created_at','updated_at'];

    protected function setRules() {

        $this->val_rules = array(
            'name' => 'required|max:250',
            'comment' => 'required',
        );
    }

    protected function setAttributes() {
        $this->val_attributes = array(
        );
    }

    public function validate($data = null, $ignoreId = 'NULL') {
        return $this->parent_validate($data);
    }

    public function children()
    {
        return $this->hasMany('App\Models\Comment', 'parent_levels_id', 'id');
    }

    public function parant()
    {
        return $this->belongsTo('App\Models\Comment', 'parent_id');
    }

    public function linkable()
    {
        return $this->morphTo();
    }

}
