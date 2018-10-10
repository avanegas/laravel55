<?php

namespace App\Models\Precio;

use Illuminate\Database\Eloquent\Model;
use App\User;

class Precio extends Model
{
    protected $fillable = [
        'grupo_precio_id','name', 'unidad', 'detalle', 'directo', 'indirecto'
    ];

    protected $filter = [
        'id', 'grupo_precio_id', 'name', 'unidad', 'detalle', 'directo', 'indirecto', 'user_id', 'created_at',

        //filter relation also, eg: user
        'user.id', 'user.name', 'user.email', 'user.password', 'user.created_at'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function grupo_precio()
    {
        return $this->belongsTo(GrupoPrecio::class);
    }

    public function equipos()
    {
        return $this->hasMany(PrecioEquipo::class);
    }

    public function materials()
    {
        return $this->hasMany(PrecioMaterial::class);
    }

    public function obreros()
    {
        return $this->hasMany(PrecioObrero::class);
    }

    public function transportes()
    {
        return $this->hasMany(PrecioTransporte::class);
    }

    public static function form()
    {
        return [
            'grupo_precio_id' => '',
            'name' => '',
            'unidad' => '',
            'detalle' => '',
            'directo' => 0,
            'indirecto' => 0,
            'equipos' => [
                PrecioEquipo::form()
            ],
            'materials' => [
                PrecioMaterial::form()
            ],
            'obreros' => [
                PrecioObrero::form()
            ],
            'transportes' => [
                PrecioTransporte::form()
            ]
        ];
    }
}
