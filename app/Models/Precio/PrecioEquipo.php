<?php

namespace App\Models\Precio;

use Illuminate\Database\Eloquent\Model;

class PrecioEquipo extends Model
{
    protected $fillable = [
        'equipo_id', 'name', 'tarifa', 'cantidad', 'rendimiento', 'total'
    ];

    public $timestamps = false;

    public function precio()
    {
        return $this->belongsTo(Precio::class);
    }

    public function equipo()
    {
        return $this->belongsTo(Equipo::class);
    }

    public static function form()
    {
        return [
            'equipo_id' => '',
            'name' => '',
            'tarifa' => 0,
            'cantidad' => 0,
            'rendimiento' => 0,
            'total' => 0
        ];
    }
}
