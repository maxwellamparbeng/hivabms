<?php

namespace App\Exports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ExportInventory implements FromCollection,WithHeadings
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
        return ['inventory Id',
        'Branch Id',
        'Product Id',
        'Company Id',
        'Inventory Quantity',
        'Created at',
        'Updated on',
        'Product Id',
        'Category Id',
        'Supplier',
        'Name of Product',
        'Unit',
        'Unit Price',
        'Quantity',
        'Image',
        'Product Description',
        'Company',
        'Product Date Creation',
        'Expiry Date',
        'Status',
        'Company Id',
        'Product Cost Price',
        'Product WholeSale Price',
        'Product Bulk WholeSale Price',
        'Product Promotional Bulk WholeSale Price',
        'Product Retail Price',
        'Product Promotional Retail Price',]
        ;
    }

}
