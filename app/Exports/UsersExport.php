<?php

namespace App\Exports;

use App\Models\Transactions;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithHeadings;

class UsersExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    
        use Exportable;

    public function __construct($acnt)
    {
        $this->acnt = $acnt;
    }
    
     public function headings(): array
    {
        return [
            'id',
            'Date',
            'Amount',
            'Account',
            'Jamah id',
            'Banam id',
            'Description',
            'Transcation Type',
            'Voucher',
            'Jamah',
            'Banam',
            'Created Date',
            'Updated Date',
        ];
    }
    
    public function collection()
    {
        
        $this->result=Transactions::where('jamah_account_id',$this->acnt)->orwhere('banam_account_id',$this->acnt)->get();
        return $this->result;
    }
}
