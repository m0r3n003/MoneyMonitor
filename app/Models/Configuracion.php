<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property string $ColorHeader
 * @property string $ColorFondo
 * @property int    $borrado
 */
class Configuraciones extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'configuraciones';

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'ConfiguracionID';

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = [
        'ColorHeader', 'ColorFondo', 'TipoFormatoTablaID', 'borrado'
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
        'ColorHeader' => 'string', 'ColorFondo' => 'string', 'borrado' => 'int'
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [
        
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
