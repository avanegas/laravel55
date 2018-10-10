<?php

namespace App\Models\Proyecto;

use Illuminate\Database\Eloquent\Model;

class ProyectoRubro extends Model
{
    protected $fillable = [
        'precio_id', 'orden', 'rubro', 'unidad', 'cantidad', 'precio', 'total'
    ];

    public $timestamps = false;

    public function proyecto()
    {
        return $this->belongsTo(Proyecto::class);
    }

    public function precio()
    {
        return $this->belongsTo(Precio::class);
    }

    public static function form()
    {
        return [
            'precio_id' => '',
            'orden' => '',
            'rubro' => '',
            'unidad' => '',
            'cantidad' => 0,
            'precio' => 0,
            'total' => 0
        ];
    }
}
