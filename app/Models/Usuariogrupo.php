<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $created_at
 * @property int $updated_at
 * @property int $borrado
 */
class Usuariosgrupos extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'usuariosgrupos';

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'UsuarioGrupoID';

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = [
        'GrupoID', 'UsuarioID', 'created_at', 'updated_at', 'borrado'
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'created_at' => 'timestamp', 'updated_at' => 'timestamp', 'borrado' => 'int'
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [
        'created_at', 'updated_at'
    ];

    /**
     * Indicates if the model should be timestamped.
     *
     * @var boolean
     */
    public $timestamps = true;

    // Scopes...

    // Functions ...

    // Relations ...
}
