@extends('layouts.backend-layout')
@section('title', 'Warranty Claims')

@section('style')
    <link rel="stylesheet" type="text/css" href="{{ asset('css/Datatables/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{asset('css/component.css')}}">
@endsection

@section('breadcrumb-title')
    List of Warranty Claim Info
@endsection


@section('breadcrumb-button')
    <a href="{{ route('warranty-claims.create') }}" class="btn btn-out-dashed btn-sm btn-warning"><i class="fas fa-plus"></i></a>
@endsection
@section('sub-title')
    Total: {{ count($ScmDatas) }}
@endsection

@section('content')
    <div class="dt-responsive table-responsive">
        <table id="dataTable" class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th>#SL</th>
                    <th>WCR No</th>
                    <th>Type</th>
                    <th>From Branch</th>
                    <th>Date</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tfoot>
                <tr>
                    <th>#SL</th>
                    <th>WCR No</th>
                    <th>Type</th>
                    <th>From Branch</th>
                    <th>Date</th>
                    <th>Action</th>
                </tr>
            </tfoot>
            <tbody>
                @foreach ($ScmDatas as $key => $ScmData)
                    <tr>
                        <td>{{ $key + 1 }}</td>
                        <td class="text-center">{{ $ScmData->wcr_no }}</td>
                        <td class="text-center">{{ ucfirst($ScmData->type) }}</td>
                        <td class="text-center">{{ ucfirst($ScmData->branch->name) }}</td>
                        <td class="text-center">{{ $ScmData->date }}</td>
                        <td>
                            <div class="icon-btn">
                                <nobr>
                                    <a href="{{ route('warranty-claims.edit', $ScmData->id) }}" data-toggle="tooltip"
                                        title="Edit" class="btn btn-outline-warning"><i class="fas fa-pen"></i></a>

                                    <form action="{{ url("scm/warranty-claims/$ScmData->id") }}" method="POST"
                                        data-toggle="tooltip" title="Delete" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-outline-danger btn-sm delete"><i
                                                class="fas fa-trash"></i></button>
                                    </form>
                                    <button type="button" class="btn btn-primary btn-outline-primary waves-effect md-trigger" onclick="trig()">3D Slit</button>
                                    {{-- @if(in_array($ScmData->type, ['client', 'pop']))
                                    <a href="{{ route('material-utilizations.create', ['challan_id' => $challan->id]) }}" data-toggle="tooltip"
                                        title="Edit" class="btn btn-outline-secondary">MUR</a>
                                    @endif --}}
                                </nobr>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <!-- animation modal Dialogs start -->
    <div class="md-modal md-effect-13" id="modal-13">
        <div class="md-content">
            {!! Form::open([
                'url' => route('sentToSupplier'),
                'method' => 'post',
                'encType' => 'multipart/form-data',
                'class' => 'custom-form',
            ]) !!}
            <h3>Sent To Supplier</h3>
            <div>
                <p></p>
                <ul>
                    <li> <input type="text" class="form-control date" id="client_name" aria-describedby="date" name="date"
                        value="{{ old('date') ?? (@$date ?? '') }}" placeholder="Search..."></li>
                <div class="row">
                    <div class="offset-md-4 col-md-4 mt-2">
                        <div class="input-group input-group-sm ">
                            <button class="btn btn-success btn-round btn-block py-2">Sent</button>
                        </div>
                    </div>
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
       <!--animation modal  Dialogs ends -->
       <div class="md-overlay"></div>
@endsection

@section('script')
<script src="{{asset('js/classie.js')}}"></script>
{{-- <script  src="{{asset('js/modalEffects.js')}}"></script> --}}
<!-- Custom js -->
<script  src="{{asset('js/script.js')}}"></script>
    <script>
        $(document).ready(function(){
            $('.date').datepicker({
                format: "dd-mm-yyyy",
                autoclose: true,
                todayHighlight: true,
                showOtherMonths: true
            }).datepicker("setDate", new Date());;
        });
        function trig(){
            $('#modal-13').addClass('md-show');
        }
    </script>
@endsection
