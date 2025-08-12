<?php

namespace App\Imports;

use App\Models\Election;
use Maatwebsite\Excel\Concerns\ToModel;

class ElectionImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Election([
            'election_id' => $row[0], 
            'title' => $row[1],
            'description' => $row[2],
            'start_time' => \Carbon\Carbon::createFromFormat('d-m-y H:i', $row[3])->format('Y-m-d H:i:s'),
            'end_time' => \Carbon\Carbon::createFromFormat('d-m-y H:i', $row[4])->format('Y-m-d H:i:s'),
            'status' => $row[5], 
            'is_active' => $row[6],
            'type' => $row[7],
        ]);
    }
}
