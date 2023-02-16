@extends('layouts.backend-layout')
@section('title', 'Complain Type')

@section('style')
    
@endsection

@section('breadcrumb-title')
    @if (!empty($supportTeam))
    Edit Complain Type
    @else
    Create Complain Type
    @endif
@endsection

@section('style')
    <style>
    </style>
@endsection
@section('breadcrumb-button')
    <a href="{{ route('support-complain-types.index')}}" class="btn btn-out-dashed btn-sm btn-warning"><i class="fas fa-database"></i></a>
@endsection

@section('content-grid', 'offset-md-1 col-md-10 offset-lg-2 col-lg-8 my-3')

@section('content')
    <div class="col-md-10 mx-auto">
        <div class="row">
            <div class="col-md-12">
                <form
                action="{{ (!empty($supportComplainType)) ? route('support-complain-types.update', ['support_complain_type' => $supportComplainType->id]) : route('support-complain-types.store') }}"
                method="post" class="custom-form">
                @if (!empty($supportComplainType))
                    @method('PUT')
                @else
                    @method('POST')
                @endif
                @csrf
                
                    <div class="row">
                        <div class="form-group col-12">
                            <div class="form-group">
                                <label for="complain_type">Complain Type:</label>
                                <input type="text" class="form-control" id="complain_type" name="name" aria-describedby="name"
                                    value="{{ old('name') ?? (!empty($supportComplainType) ? $supportComplainType?->name : '') }}" placeholder="Complain Type">
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
        </div>
    </div>
@endsection

@section('script')

@endsection
