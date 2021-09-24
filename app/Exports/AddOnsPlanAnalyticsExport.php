<?php

namespace App\Exports;

use App\AddOnsReport;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use App\Exports\Sheets\PlanWiseAddonsSheet;

class AddOnsPlanAnalyticsExport implements WithMultipleSheets {

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
            foreach ($report->plan_wise_active_addons as $result) {
               $sheets[] = new PlanWiseAddonsSheet($result->plan_name, $result->addons_info);
            }
        }
        return $sheets;
    }
}
