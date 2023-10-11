<?php

namespace Modules\Sales\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Models\Dataencoding\Division;
use Modules\Sales\Services\CommonService;
use App\Models\Dataencoding\District;
use App\Models\Dataencoding\Thana;
use Modules\Sales\Entities\Client;
use Modules\Sales\Entities\BillingAddress;
use Modules\Sales\Entities\CollectionAddress;
use Illuminate\Support\Facades\DB;


class ClientProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */

    function __construct()
    {
        $this->middleware('permission:client-view|client-create|client-edit|client-delete', ['only' => ['index', 'show']]);
        $this->middleware('permission:client-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:client-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:client-delete', ['only' => ['destroy']]);
    }

    public function index()
    {
        $client_profiles = Client::with('division', 'district', 'thana')->get();
        return view('sales::client_profile.index', compact('client_profiles'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        $divisions = Division::all();
        $organizations = [
            '1' => 'School',
            '2' => 'Hospital',
            '3' => 'Hotel',
            '4' => 'Restaurant',
            '5' => 'Office',
            '6' => 'Others',
        ];
        return view("sales::client_profile.create", compact('divisions', 'organizations'));
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
        $client_profile_data = $request->only('client_no', 'client_name', 'address', 'division_id', 'district_id', 'thana_id', 'location', 'lat_long', 'contact_person', 'designation', 'contact_no',  'email', 'business_type', 'client_type');
        $client_billing_info = $request->only('billing_address', 'billing_division', 'billing_district', 'billing_thana', 'billing_contact_person', 'billing_designation', 'billing_contact_no',  'billing_email', 'submitted_user_id', 'bill_submission_date');
        $client_collection_info = $request->only('collection_address', 'collection_division', 'collection_district', 'collection_thana', 'collection_contact_person', 'collection_designation', 'collection_contact_no',  'collection_email', 'payment_method', 'approximate_payment_date');
        if ($request->hasFile('trade_license')) {
            $trade_license = CommonService::fileUpload($request->file('trade_license'), 'uploads/client_profile/trade_license');
            $client_profile_data['trade_license'] = $trade_license;
        }

        if ($request->hasFile('nid')) {
            $nid = CommonService::fileUpload($request->file('nid'), 'uploads/client_profile/nid');
            $client_profile_data['nid'] = $nid;
        }

        if ($request->hasFile('photo')) {
            $photo = CommonService::fileUpload($request->file('photo'), 'uploads/client_profile/photo');
            $client_profile_data['photo'] = $photo;
        }

        $client_profile_data['user_id'] = auth()->user()->id;
        $client_profile_data['branch_id'] = auth()->user()->branch_id;

        DB::transaction(function () use ($client_profile_data, $client_billing_info, $client_collection_info) {
            $client_profile = Client::create($client_profile_data);
            $client_billing_info['client_id'] = $client_profile->id;
            $client_billing_info['client_no'] = $client_profile_data['client_no'];
            $client_collection_info['client_id'] = $client_profile->id;
            $client_collection_info['client_no'] = $client_profile_data['client_no'];
            BillingAddress::create($this->formatBillingAddress($client_billing_info));
            CollectionAddress::create($this->formateCollectionAddress($client_collection_info));
        });
        return redirect()->route('client-profile.index')->with('success', 'Client Profile Created Successfully');
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show(Client $client)
    {
        return view('sales::client_profile.show', compact('client'));
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        $client_profile = Client::with('division', 'district', 'thana', 'billingAddress', 'collectionAddress')->find($id);
        $divisions = Division::all();
        $districts = District::where('division_id', $client_profile->division_id)->get();
        $thanas = Thana::where('district_id', $client_profile->district_id)->get();
        $billing_thanas = Thana::where('district_id', $client_profile->billingAddress->district_id)->get();
        $collection_thanas = Thana::where('district_id', $client_profile->collectionAddress->district_id)->get();
        $billing_districts = District::where('division_id', $client_profile->billingAddress->division_id)->get();
        $collection_districts = District::where('division_id', $client_profile->collectionAddress->division_id)->get();
        $organizations = [
            '1' => 'School',
            '2' => 'Hospital',
            '3' => 'Hotel',
            '4' => 'Restaurant',
            '5' => 'Office',
            '6' => 'Others',
        ];
        return view("sales::client_profile.create", compact('client_profile', 'divisions', 'districts', 'thanas', 'organizations', 'billing_thanas', 'collection_thanas', 'billing_districts', 'collection_districts'));
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $request, $id)
    {
        $client_profile_data = $request->only('client_no', 'client_name', 'address', 'division_id', 'district_id', 'thana_id', 'location', 'lat_long', 'contact_person', 'designation', 'contact_no',  'email', 'business_type', 'client_type');
        $client_billing_info = $request->only('billing_address', 'billing_division', 'billing_district', 'billing_thana', 'billing_contact_person', 'billing_designation', 'billing_contact_no',  'billing_email', 'submitted_user_id', 'bill_submission_date');
        $client_collection_info = $request->only('collection_address', 'collection_division', 'collection_district', 'collection_thana', 'collection_contact_person', 'collection_designation', 'collection_contact_no',  'collection_email', 'payment_method', 'approximate_payment_date');
        if ($request->hasFile('trade_license')) {
            $trade_license = CommonService::updateFileUpload($request->file('trade_license'), 'uploads/client_profile/trade_license', $request->trade_license);
            $client_profile_data['trade_license'] = $trade_license;
        }

        if ($request->hasFile('nid')) {
            $nid = CommonService::updateFileUpload($request->file('nid'), 'uploads/client_profile/nid', $request->nid);
            $client_profile_data['nid'] = $nid;
        }

        if ($request->hasFile('photo')) {
            $photo = CommonService::updateFileUpload($request->file('photo'), 'uploads/client_profile/photo', $request->photo);
            $client_profile_data['photo'] = $photo;
        }

        $client_profile_data['user_id'] = auth()->user()->id;

        DB::transaction(function () use ($client_profile_data, $client_billing_info, $client_collection_info, $id) {
            $client_profile = Client::find($id);
            $client_profile->update($client_profile_data);
            $client_billing_info['client_id'] = $client_profile->id;
            $client_billing_info['client_no'] = $client_profile_data['client_no'];
            $client_collection_info['client_id'] = $client_profile->id;
            $client_collection_info['client_no'] = $client_profile_data['client_no'];
            BillingAddress::where('client_id', $client_profile->id)->update($this->formatBillingAddress($client_billing_info));
            CollectionAddress::where('client_id', $client_profile->id)->update($this->formateCollectionAddress($client_collection_info));
        });
        return redirect()->route('client-profile.index')->with('success', 'Client Profile Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
        $client_profile = Client::find($id);
        $client_profile->trade_license ? CommonService::deleteFile('uploads/client_profile/trade_license/' . $client_profile->trade_license) : '';
        $client_profile->nid ? CommonService::deleteFile('uploads/client_profile/nid/' . $client_profile->nid) : '';
        $client_profile->photo ? CommonService::deleteFile('uploads/client_profile/photo/' . $client_profile->photo) : '';
        $client_profile->delete();
        $client_profile->billingAddress()->delete();
        $client_profile->collectionAddress()->delete();
        return redirect()->route('client-profile.index')->with('success', 'Client Profile Deleted Successfully');
    }

    function formatBillingAddress($information)
    {
        $client_billing_info = [
            'address' => $information['billing_address'],
            'division_id' => $information['billing_division'],
            'district_id' => $information['billing_district'],
            'thana_id' => $information['billing_thana'],
            'contact_person' => $information['billing_contact_person'],
            'designation' => $information['billing_designation'],
            'phone' => $information['billing_contact_no'],
            'email' => $information['billing_email'],
            'submission_by' => $information['submitted_user_id'],
            'submission_date' => $information['bill_submission_date'],
            'client_id' => $information['client_id'],
            'client_no' => $information['client_no'],
        ];
        return $client_billing_info;
    }

    function formateCollectionAddress($information)
    {
        $client_collection_info = [
            'address' => $information['collection_address'],
            'division_id' => $information['collection_division'],
            'district_id' => $information['collection_district'],
            'thana_id' => $information['collection_thana'],
            'contact_person' => $information['collection_contact_person'],
            'designation' => $information['collection_designation'],
            'phone' => $information['collection_contact_no'],
            'email' => $information['collection_email'],
            'payment_method' => $information['payment_method'],
            'payment_date' => $information['approximate_payment_date'],
            'client_id' => $information['client_id'],
            'client_no' => $information['client_no'],
        ];
        return $client_collection_info;
    }
}
