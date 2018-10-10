<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Zona extends Model
{
    protected $fillable = [
        'name', 'description', 'user_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function grupo_equipos()
    {
        return $this->hasMany(GrupoEquipo::class);
    }

    public function grupo_materials()
    {
        return $this->hasMany(GrupoMaterial::class);
    }

    public function grupo_obreros()
    {
        return $this->hasMany(GrupoObrero::class);
    }

    public function transportes()
    {
        return $this->hasMany(Transporte::class);
    }

    public function grupo_precios()
    {
        return $this->hasMany(GrupoPrecio::class);
    }

    public static function form()
    {
        return [
            'name' => '',
            'description' => '',
            'user_id' => ''
        ];
    }
}
