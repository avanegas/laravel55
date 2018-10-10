<?php

namespace App\Models\Data;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Equipo extends Model
{
    protected $fillable = [
        'grupo_equipo_id', 'name', 'marca', 'tipo', 'tarifa'
    ];

    public function getCreatedAtAttribute($value)
    {
        return Carbon::parse($value)->toDateString();
    }

    public function grupo_equipo()
    {
        return $this->belongsTo(GrupoEquipo::class);
    }

    public function precio_equipo()
    {
        return $this->hasOne(PrecioEquipo::class);
    }

    public static function form()
    {
        return [
            'grupo_equipo_id' => '',
            'name' => '',
            'marca' => '',
            'tipo' => '',
            'tarifa' => 0
        ];
    }
}
