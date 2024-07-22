<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class LandslideDataExport implements FromArray, WithCustomStartCell, ShouldAutoSize
{
    protected $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function array(): array
    {
        $export = [];

        // Thêm tiêu đề cột
        $export[] = ['Trường dữ liệu (đã qua chuyển đổi)'];

        // Thêm tên các trường
        $fields = [
            'id', 'Batt(Volts)', 'Temp_Dataloger(Celsius)', 'PZ1_(Digit)', 'PZ2_(Digit)',
            'CR1_(Digit)', 'CR2_(Digit)', 'CR3_(Digit)', 'Tilt_A_Or_1(sin)',
            'Tilt_B_Or_1(sin)', 'Tilt_A_Or_2(sin)', 'Tilt_B_Or_2(sin)',
            'Tilt_A_Or_3(sin)', 'Tilt_B_Or_3(sin)', 'PZ1_Temp', 'PZ2_Temp',
            'CR1_Temp', 'CR2_Temp', 'CR3_Temp', 'Tilt_1_Temp', 'Tilt_2_Temp', 'Tilt_3_Temp',
            'created_at', 'updated_at'
        ];

        foreach ($fields as $field) {
            $export[] = [$field];
        }

        // Thêm dữ liệu
        foreach ($this->data as $index => $item) {
            $columnIndex = $index + 1;
            $export[0][] = "Bản ghi " . $columnIndex;
            foreach ($fields as $rowIndex => $field) {
                $export[$rowIndex + 1][] = $item[$field] ?? '';
            }
        }

        return $export;
    }

    public function startCell(): string
    {
        return 'A1';
    }
}