<?php

namespace App\Imports;

use Maatwebsite\Excel\Concerns\ToModel;

class GeneralImport implements ToModel
{

    public function __construct()
    {
        // $this->model = $model;
        // $this->columns = $columns;
    }
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        // $data = [];
        // foreach ($this->columns as $key => $column) {
        //     $data[$column] = $row[$key];
        // }
        // return new $this->model($data);

    }
}
