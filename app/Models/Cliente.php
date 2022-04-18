<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Cliente
 *
 * @property $id
 * @property $identificacion
 * @property $nombre
 * @property $apellido
 * @property $genero
 * @property $fecha-nacimiento
 *
 * @package App
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class Cliente extends Model
{
    
    static $rules = [
		'identificacion' => 'required',
		'nombre' => 'required',
		'apellido' => 'required',
		'genero' => 'required',
		'fecha-nacimiento' => 'required',
    ];

    protected $perPage = 20;

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['identificacion','nombre','apellido','genero','fecha-nacimiento'];

    
    public $timestamps = false;
}
