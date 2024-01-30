<?php

namespace App\Exports;

use App\Models\Product;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ExportClients implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */


    protected $details;

    function __construct($details) {
           $this->details = $details;
    }

    public function collection()
    {
        return  collect($this->details);
    }

}
