<?php

namespace App\Models\Proyecto;

use Illuminate\Database\Eloquent\Model;
use App\User;

class Proyecto extends Model
{
    protected $fillable = [
        'name', 'contratante', 'ubicacion', 'oferente', 'entrega', 'referencial', 'indirecto', 'descuento',
        'distancia', 'sub_total', 'gran_total', 'formato', 'precision', 'representante'
    ];

    protected $filter = [
        'id', 'name', 'contratante', 'ubicacion', 'oferente', 'entrega', 'referencial', 'indirecto', 'descuento',
        'distancia', 'sub_total', 'gran_total', 'formato', 'precision', 'representante', 'user_id', 'created_at',

        //filter relation also, eg: user
        'user.id', 'user.name', 'user.email', 'user.password', 'user.created_at'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function rubros()
    {
        return $this->hasmany(ProyectoRubro::class);
    }

    public static function form()
    {
        return [
            'name' => 'Proyecto para',
            'contratante' => '',
            'ubicacion' => '',
            'oferente' => '',
            'entrega' => '',
            'referencial' => 0,
            'indirecto' => 0,
            'descuento' => 0,
            'distancia' => 0,
            'sub_total' => 0,
            'gran_total' => 0,
            'formato' => 1,
            'precision' => 4,
            'representante' => '',
            'rubros' => [
                ProyectoRubro::form()
            ]
        ];
    }
}
