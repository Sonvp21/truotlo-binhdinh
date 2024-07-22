<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class LandslideDataExport implements FromCollection, WithHeadings
{
    protected $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function collection()
    {
        return $this->data;
    }

    public function headings(): array
    {
        return [
            'id', 'Batt(Volts)', 'Temp*Dataloger(Celsius)', 'PZ1*(Digit)', 'PZ2*(Digit)',
            'CR1*(Digit)', 'CR2*(Digit)', 'CR3*(Digit)', 'calculated_Tilt_A_Or_1(sin)',
            'calculated_Tilt_B_Or_1(sin)', 'calculated_Tilt_A_Or_2(sin)', 'calculated_Tilt_B_Or_2(sin)',
            'calculated_Tilt_A_Or_3(sin)', 'calculated_Tilt_B_Or_3(sin)', 'PZ1_Temp', 'PZ2_Temp',
            'CR1_Temp', 'CR2_Temp', 'CR3_Temp', 'Tilt_1_Temp', 'Tilt_2_Temp', 'Tilt_3_Temp',
            'created_at', 'updated_at'
        ];
    }
}