<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

class FeasibilityRequirementImport implements ToCollection
{
    /**
    * @param Collection $collection
    */
    private $additionalData;

    public function __construct($additionalData)
    {
        $this->additionalData = $additionalData;

    }
    public function collection(Collection $collection)
    {
        return new User([
            'name'     => $row[0],
            'email'    => $row[1],
            'password' => Hash::make($row[2]),
         ]);
         dd($collection[0]);
         $feasibilityDetails[] = [
            // 'connectivity_point' => $connectivityPoint,
            'aggregation_type' => $request['aggregation_type'][$key],
            'client_no' => $data['client_no'],
            'fr_no' => $frNo,
            'division_id' => $request['division_id'][$key],
            'district_id' => $request['district_id'][$key],
            'thana_id' => $request['thana_id'][$key],
            'location' => $request['location'][$key],
            'lat' => $request['lat'][$key],
            'long' => $request['long'][$key],
            'contact_name' => $request['contact_name'][$key],
            'contact_designation' => $request['contact_designation'][$key],
            'contact_number' => $request['contact_number'][$key],
            'contact_email' => $request['contact_email'][$key],
        ];
        // $skippedArray = $collection->skip(1);
        // dd($skippedArray);
    }
   
}
