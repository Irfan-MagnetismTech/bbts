<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use App\Models\Dataencoding\Division;
use App\Models\Dataencoding\District;
use App\Models\Dataencoding\Thana;

class FeasibilityRequirementImportUpdate implements ToCollection
{
    /**
     * @param Collection $collection
     */
    private $additionalData;
    private $feasibilityRequirement;

    public function __construct($additionalData, $feasibilityRequirement)
    {
        $this->additionalData = $additionalData;
        $this->feasibilityRequirement = $feasibilityRequirement;
    }
    public function collection(Collection $collection)
    {
        // dd($this->feasibilityRequirement);
        $data = $this->additionalData->only('client_no', 'is_existing', 'date');
        $data['user_id'] = auth()->user()->id;
        $data['branch_id'] = auth()->user()->branch_id ?? '1';
        $this->feasibilityRequirement->update($data);
        $feasibilityRequirement =  $this->feasibilityRequirement;

        $skippedArray = $collection->skip(1);
        $details = [];
        foreach ($skippedArray as $key => $detail) {
            $detailId = $this->additionalData['detail_id'][$key] ?? null;

            $frNo = 'fr' . '-' . $data['client_no'] . '-';
            $division = Division::where('name', $detail[2])->first();
            $district = District::where('name', $detail[3])->first();
            $thana = Thana::where('name', $detail[4])->first();

            $details[] = [
                'feasibility_requirement_id' => $feasibilityRequirement->id,
                'aggregation_type' => $detail[1],
                'client_no' => $feasibilityRequirement->client_no,
                'fr_no' => $frNo,
                'connectivity_point' => $detail[0],
                'division_id' => $division->id,
                'district_id' => $district->id,
                'thana_id' => $thana->id,
                'location' => $detail[5],
                'lat' => $detail[6],
                'long' => $detail[7],
                'contact_name' => $detail[8],
                'contact_designation' => $detail[9],
                'contact_number' => $detail[10],
                'contact_email' => $detail[11],
            ];
        }
        $feasibilityRequirement->feasibilityRequirementDetails()->delete();
        $feasibilityRequirement->feasibilityRequirementDetails()->createMany($details);
        // if ($detailId) {
        //     $feasibility = FeasibilityRequirementDetail::find($detailId);
        //     dd($feasibility);
        //     if ($feasibility) {
        //         $feasibility->update($details);
        //     }
        // } else {
        //     $maxFrNo = FeasibilityRequirementDetail::where('client_no', $data['client_no'])->max('fr_no');

        //     if ($maxFrNo) {
        //         $frArray = explode('-', $maxFrNo);
        //         $frSerial = intval($frArray[count($frArray) - 1]) + 1;
        //         $frNo .= $frSerial;
        //     } else {
        //         $frNo .= '1';
        //     }
        //     $detailsData['fr_no'] = $frNo;
        //     $feasibilityRequirement->feasibilityRequirementDetails()->create($details);
        // }  
        // $feasibilityRequirement->feasibilityRequirementDetails()->createMany($details);
    }
}
