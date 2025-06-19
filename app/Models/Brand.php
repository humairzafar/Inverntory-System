<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
    protected $fillable = ['name'];

    public function items()
    {
        return $this->hasMany(Item::class);
    }

    public function models()
{
    return $this->hasMany(DeviceModel::class);
}
}

