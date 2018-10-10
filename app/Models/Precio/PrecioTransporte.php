<?php

namespace App\Models\Precio;

use Illuminate\Database\Eloquent\Model;

class PrecioTransporte extends Model
{
    protected $fillable = [
        'transporte_id', 'name', 'unidad', 'tarifa', 'cantidad', 'distancia', 'total'
    ];

    public $timestamps = false;

    public function precio()
    {
        return $this->belongsTo(Precio::class);
    }

    public function transporte()
    {
        return $this->belongsTo(Transporte::class);
    }

    public static function form()
    {
        return [
            'transporte_id' => '',
            'name' => '',
            'unidad' => '',
            'tarifa' => 0,
            'cantidad' => 0,
            'distancia' => 0,
            'total' => 0
        ];
    }
}
