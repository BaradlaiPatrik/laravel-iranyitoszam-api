<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    protected $fillable = ['zip', 'name', 'county_id'];
    protected $hidden = ['created_at', 'updated_at'];

    public function county()
    {
        return $this->belongsTo(County::class);
    }
}