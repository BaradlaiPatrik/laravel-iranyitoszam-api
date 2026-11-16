<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class County extends Model
{
    protected $fillable = ['name'];
    protected $hidden = ['created_at', 'updated_at'];

    public function cities()
    {
        return $this->hasMany(City::class);
    }
}