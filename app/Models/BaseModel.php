<?php 
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Schema, Auth;
use Haruncpi\LaravelUserActivity\Traits\Loggable;

class BaseModel extends Model {
    use Loggable;

    public static function boot() {
        parent::boot();
        $input = request()->all();
        static::creating(function ($model) {
            if(Schema::hasColumn($model->getTableName(), 'created_by')) {
                if($user = Auth::user())
                    $model->created_by = $user->id;
            }
        });
        
        static::saving(function ($model) {
            if(Schema::hasColumn($model->getTableName(), 'updated_by')) {
                if($user = Auth::user())
                    $model->updated_by = $user->id;
            }
            // return true;
        });
    }
    
    public static function getTableName() {
        return with(new static)->getTable();
    }

    public function created_user() {
        if (isset($this->attributes['created_by'])) return $this->belongsTo('App\Models\Admin', 'created_by');
        return null;
    }

    public function updated_user() {
        if (isset($this->attributes['updated_by'])) return $this->belongsTo('App\Models\Admin', 'updated_by');
        return null;
    }

}
