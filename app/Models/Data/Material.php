<?php

namespace App\Models\Data;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Material extends Model
{
    protected $fillable = [
        'grupo_material_id', 'name', 'unidad', 'precio'
    ];

    public function getCreatedAtAttribute($value)
    {
        return Carbon::parse($value)->toDateString();
    }

    public function grupo_material()
    {
        return $this->belongsTo(GrupoMaterial::class);
    }

    public function precio_material()
    {
        return $this->hasOne(PrecioMaterial::class);
    }

    public static function form()
    {
        return [
            'grupo_material_id' => '',
            'name' => '',
            'unidad' => '',
            'precio' => 0
        ];
    }
}
