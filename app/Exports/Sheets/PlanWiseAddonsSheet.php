<?php

namespace App\Exports\Sheets;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStrictNullComparison;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithTitle;

class PlanWiseAddonsSheet implements FromArray, WithHeadings, WithMapping, ShouldAutoSize, WithStrictNullComparison, WithTitle {
    private $plan_name;
    private $addons_info;

    public function __construct($plan_name, array $addons_info) {
        $this->plan_name = $plan_name;
        $this->addons_info  = $addons_info;
    }

    /**
     * @return array
     */
    public function array(): array {
        return $this->addons_info;
    }

    /**
    * @return Sheet rows/data array
    */
    public function map($row): array {
        return (array) $row;
    }

    /**
    * @return Sheet heders array
    */
    public function headings(): array {
        return ['Add-On', 'Count'];
    }

    /**
     * @return string
     */
    public function title(): string {
        return $this->plan_name;
    }
}
