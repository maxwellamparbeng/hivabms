<?php

namespace App\Exports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ExportInventoryLog implements FromCollection
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

    public function headings(): array
    {
        return ['Inventory Id',
        'Product Name',
        'Quantity Before',
        'Quantity After',
        'Date Created',
        'Action by',];
    }



}
