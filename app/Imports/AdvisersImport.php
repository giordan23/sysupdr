<?php

namespace App\Imports;

use App\Models\Adviser;
use Maatwebsite\Excel\Concerns\ToModel;

class AdvisersImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Adviser([
            'dni' => $row[0],
            'full_name' => $row[1],
            'faculty' => $row[2],
            'email' => $row[3],
            'orcid' => $row[4],
        ]);
    }
}
