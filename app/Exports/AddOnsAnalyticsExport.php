<?php

namespace App\Exports;

use App\AddOnsReport;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStrictNullComparison;
use Maatwebsite\Excel\Concerns\WithMapping;

class AddOnsAnalyticsExport implements FromQuery, WithHeadings, ShouldAutoSize, WithStrictNullComparison, WithMapping {

    protected $id;

    function __construct($id) {
        $this->id = $id;
    }

    /**
     * @return Builder
     */
    public function query() {
        return AddOnsReport::whereId($this->id);
    }

    /**
    * @return Sheet heders array
    */
    public function headings(): array {
        return ['Add-On', 'Count'];
    }

    /**
    * @return Sheet rows/data array
    */
    public function map($report): array {
        $dataArr = [];
        if($report) {
            foreach ($report->all_active_addons as $key => $result) {
               $dataArr[] = (array) $result;
            }
        }
        return $dataArr;
    }
}