@extends('layouts.backend-layout')
@section('title', 'Ips')

@section('breadcrumb-title')
    @if ($formType == 'edit')
        Edit
    @else
        Create
    @endif
    Ips Info
@endsection

@section('style')
    <style>
        .input-group-addon {
            min-width: 120px;
        }

        .input-group-info .input-group-addon {
            /*background-color: #04748a!important;*/
        }
    </style>
@endsection
@section('breadcrumb-button')
    <a href="{{ route('ips.index') }}" class="btn btn-out-dashed btn-sm btn-warning"><i class="fas fa-database"></i></a>
@endsection

@section('sub-title')
    <span class="text-danger">*</span> Marked are required.
@endsection

@section('content-grid', 'offset-md-1 col-md-10 offset-lg-2 col-lg-8 my-3')

@section('content')
    <div class="container">
        <form action="{{ $formType == 'edit' ? route('ips.update', $ip->id) : route('ips.store') }}"
            method="post" class="custom-form">
            @if ($formType == 'edit')
                @method('PUT')
            @endif
            @csrf
            <div class="row">

                <div class="col-12">
                    <div class="input-group input-group-sm input-group-primary">
                        <label class="input-group-addon" for="address">Ip Address <span
                                class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="address" name="address"
                            placeholder="Enter ip address" value="{{ old('address') ?? ($ip->address ?? '') }}" required>
                    </div>
                </div>

                <div class="col-12">
                    <div class="input-group input-group-sm input-group-primary">
                        <label class="input-group-addon" for="type">Type <span
                                class="text-danger">*</span></label>
                        <select class="form-control" id="type" name="type" required>
                            <option value="">Select type</option>
                            @foreach (config('businessinfo.ipAddressType') as $type)
                                <option value="{{ $type }}"
                                    {{ (old('type') ?? ($ip->type ?? '')) == $type ? 'selected' : '' }}>
                                    {{ $type }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                
                <div class="col-12">
                    <div class="input-group input-group-sm input-group-primary">
                        <label class="input-group-addon" for="ip_type">Ip Type <span
                                class="text-danger">*</span></label>
                        <select class="form-control" id="ip_type" name="ip_type" required>
                            <option value="">Select ip type</option>
                            @foreach (config('businessinfo.ipType') as $type)
                                <option value="{{ $type }}"
                                    {{ (old('ip_type') ?? ($ip->ip_type ?? '')) == $type ? 'selected' : '' }}>
                                    {{ $type }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                
                <div class="col-12">
                    <div class="input-group input-group-sm input-group-primary">
                        <label class="input-group-addon" for="purpose">Purpose <span
                                class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="purpose" name="purpose"
                            placeholder="Enter purpose" value="{{ old('purpose') ?? ($ip->purpose ?? '') }}" required>
                    </div>
                </div>

                <div class="col-12">
                    <div class="input-group input-group-sm input-group-primary">
                        <label class="input-group-addon" for="vlan_id">Vlan ID <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="vlan_id" name="vlan_id"
                            placeholder="Enter Vlan id" value="{{ old('vlan_id') ?? ($ip->vlan_id ?? '') }}"
                            required>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <div class="input-group input-group-sm input-group-primary">
                        <label class="input-group-addon" for="zone_id">Zone <span class="text-danger">*</span></label>
                        <select class="form-control select2" id="zone_id" name="zone_id" required>
                            <option value="" selected disabled>Select zone</option>
                            @foreach ($zones as $zone)
                                <option value="{{ $zone->id }}"
                                    {{ (old('zone_id') ?? ($ip->zone_id ?? '')) == $zone->id ? 'selected' : '' }}>
                                    {{ $zone->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>            

            <div class="row">
                <div class="offset-md-4 col-md-4 mt-2">
                    <div class="input-group input-group-sm ">
                        <button class="btn btn-success btn-round btn-block py-2">Submit</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection

@section('script')
    <script>
        $('.select2').select2();
    </script>
@endsection
