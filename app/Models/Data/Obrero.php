<?php

namespace App\Models\Data;

use Illuminate\Database\Eloquent\Model;

class Obrero extends Model
{
    protected $fillable = [
        'grupo_obrero_id', 'name', 'jornalhora', 'factor'
    ];

    public function grupo_obrero()
    {
        return $this->belongsTo(GrupoObrero::class);
    }

    public function precio_obrero()
    {
        return $this->hasOne(PrecioObrero::class);
    }

    public static function form()
    {
        return [
            'grupo_obrero_id' => '',
            'name' => '',
            'jornalhora' => 0,
            'factor' => 0
        ];
    }
}
