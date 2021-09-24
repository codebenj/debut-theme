<?php

namespace App\Exports\Sheets;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStrictNullComparison;
use Maatwebsite\Excel\Concerns\WithTitle;

class TopColorsSheet implements FromArray, WithHeadings, ShouldAutoSize, WithStrictNullComparison, WithTitle {
    private $color_name;
    private $color_array;

    public function __construct($color_name, array $color_array) {
        $this->color_name = $color_name;
        $this->color_array = $color_array;
    }

    /**
    * @return Sheet heders array
    */
    public function headings(): array {
        return ['Color Name', 'Count'];
    }

    /**
     * @return array
     */
    public function array(): array {
        $dataArr = [];
        foreach ($this->color_array as $key => $val) {
           $dataArr[] = [$key, $val];
        }
        return $dataArr;
    }

    /**
     * @return string
     */
    public function title(): string {
        return $this->color_name;
    }
}
