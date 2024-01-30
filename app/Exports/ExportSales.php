<?php

namespace App\Exports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ExportSales implements FromCollection,WithHeadings
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
        return ['Transaction Id',
        'Customer Name',
        'Total Amount',
        'Email',
        'Phone',
        'Payment Method',
        'Discount',
        'Vat',
        'vatPercentage',
        'Discount Percentage',
        'Status',
        'Date Created',
        'Sales by',];
    }



}
