<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Barang extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function ruangan()
    {
        return $this->belongsTo(Ruangan::class, 'ruangan_id');
    }

    public function keluhans()
    {
        return $this->hasMany(Keluhan::class, 'barang_id');
    }

    protected static function booted()
    {
        static::deleting(function ($barang) {
            $barang->keluhans()->delete();
        });
    }
}