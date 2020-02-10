<?php

namespace App\Repositories;

use App\Models\Table;
use App\Repositories\BaseRepository;

/**
 * Class TableRepository
 * @package App\Repositories
 * @version February 10, 2020, 7:45 am UTC
*/

class TableRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'name',
        'age'
    ];

    /**
     * Return searchable fields
     *
     * @return array
     */
    public function getFieldsSearchable()
    {
        return $this->fieldSearchable;
    }

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Table::class;
    }

    public function indexTrans()
    {
        return config('app.locale') == 'vi' ? $this->model->whereNotNull('name->vi')->paginate(10) : $this->model->whereNotNull('name->en')->paginate(10) ;
    }
}
