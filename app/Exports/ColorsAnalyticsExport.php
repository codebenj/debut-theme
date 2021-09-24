<?php

namespace App\Exports;

use App\AddOnsReport;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use App\Exports\Sheets\TopColorsSheet;

class ColorsAnalyticsExport implements WithMultipleSheets {

    use Exportable;

    protected $id;

    function __construct($id) {
        $this->id = $id;
    }

    /**
     * @return array
     */
    public function sheets(): array {
        $sheets = [];
        if($report = AddOnsReport::whereId($this->id)->first()) {
            foreach ($report->top_used_colors as $result) {
               $sheets[] = new TopColorsSheet($result->color_name, (array) $result->color_array);
            }
        }
        return $sheets;
    }
}

