<?php

namespace App\Models\Data;

use Illuminate\Database\Eloquent\Model;
use App\Zona;

class GrupoMaterial extends Model
{
    protected $fillable = [
        'zona_id', 'name', 'description'
    ];

    public function zona()
    {
        return $this->belongsTo(Zona::class);
    }

    public function materials()
    {
        return $this->hasMany(Material::class);
    }

    public static function form()
    {
        return [
            'zona_id' => '',
            'name' => '',
            'description' => ''
        ];
    }
}
