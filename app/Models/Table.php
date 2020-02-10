<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Translatable\HasTranslations;

/**
 * Class Table
 * @package App\Models
 * @version February 10, 2020, 7:45 am UTC
 *
 * @property string name
 * @property string age
 */
class Table extends Model
{
    use SoftDeletes,HasTranslations;

    public $table = 'tables';

    public $translatable = ['name'];

    protected $dates = ['deleted_at'];



    public $fillable = [
        'name',
        'age'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        
    ];

    
}
