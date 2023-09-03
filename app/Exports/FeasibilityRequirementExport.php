<?php

namespace App\Exports;
use Modules\Sales\Entities\FeasibilityRequirement;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithHeadings;

class FeasibilityRequirementExport implements WithHeadings
{
    use Exportable;

    public function headings(): array
    {
  
        return [
            'Name of the Link',
            'Agreegation Type',
            'Division',
            'District',
            'Thana',
            'Location',
            'Latitue',
            'Longitude',
            'Name',
            'Designation',
            'Con. No.',
            'Email',
        ];
    }
}
