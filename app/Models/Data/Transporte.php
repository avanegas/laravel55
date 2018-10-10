<?php

namespace App\Models\Data;

use Illuminate\Database\Eloquent\Model;
use App\Zona;

class Transporte extends Model
{
    protected $fillable = [
        'zona_id', 'name', 'unidad', 'tipo', 'tarifa'
    ];

    public function zona()
    {
        return $this->belongsTo(Zona::class);
    }

    public function precio_transporte()
    {
        return $this->hasOne(PrecioTransporte::class);
    }

    public static function form()
    {
        return [
            'zona_id' => '',
            'name' => '',
            'unidad' => '',
            'tipo' => '',
            'tarifa' => 0
        ];
    }
}
