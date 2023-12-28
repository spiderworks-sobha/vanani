<?php

namespace App\Models;

use App\Models\BaseModel as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Lead extends Model
{
    use SoftDeletes;

    protected $table = 'leads';

    protected $fillable = array('name', 'email', 'phone_number', 'location', 'message', 'extra_data', 'lead_type', 'utm_source', 'source_url', 'ip_address', 'user_agent', 'referrer_link', 'remarks', 'status');

    protected $dates = ['created_at','updated_at'];

    public function updated_user()
    {
        return $this->belongsTo('App\Models\User', 'updated_by');
    }

}