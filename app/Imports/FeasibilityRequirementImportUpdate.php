<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Modules\Sales\Entities\FeasibilityRequirementDetail;
use Modules\Sales\Entities\FeasibilityRequirement;
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
        $feasibilityRequirement = $this->feasibilityRequirement->update($data);
    



        // $data =  $this->additionalData->only('client_no', 'is_existing', 'date', 'lead_generation_id');
        // $data['user_id'] = auth()->user()->id;
        // $data['branch_id'] = auth()->user()->branch_id ?? '1';

        // $maxMqNo = FeasibilityRequirement::where('client_no', $data['client_no'])->max('mq_no');
        // $data['mq_no'] = 'MQ' . '-' . $data['client_no'] . '-' . ($maxMqNo ? (explode('-', $maxMqNo)[3] + 1) : '1');
        // $feasibilityRequirement = FeasibilityRequirement::create($data);
        // $maxFrNo = FeasibilityRequirementDetail::where('client_no', $data['client_no'])->max('fr_no');
        // if ($maxFrNo) {
        //     $frArray = explode('-', $maxFrNo);
        //     $fr_serial = intval($frArray[count($frArray) - 1]) + 1;
        // } else {
        //     $fr_serial = 1;
        // }



        $skippedArray = $collection->skip(1);   
        $details = [];
        foreach ($skippedArray as $key => $detail) {
            $detailId = $this->additionalData['detail_id'][$key];
            dd($detailId);
            $frNo = 'fr' . '-' . $data['client_no'] . '-';
            $division = Division::where('name', $detail[2])->first();
            $district = District::where('name', $detail[3])->first();
            $thana = Thana::where('name', $detail[4])->first();
            
            $details[] = [
                'feasibility_requirement_id' => $feasibilityRequirement->id, 
                'aggregation_type' => $detail[1],
                'client_no' => $feasibilityRequirement->client_no,
                'fr_no' => $frNo,
                'connectivity_point'=> $detail[0],
                'division_id' => $division->id,
                'district_id' => $district->id,
                'thana_id' => $thana->id,
                'location' => $detail[5],
                'lat' => $detail[6],
                'long' => $detail[7],
                'contact_name' =>$detail[8],
                'contact_designation' => $detail[9],
                'contact_number' => $detail[10],
                'contact_email' => $detail[11],
            ];
        }  
        $feasibilityRequirement->feasibilityRequirementDetails()->createMany($details);
    }
}
