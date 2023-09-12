@extends('layouts.backend-layout')
@section('title', 'Comparative Statement Details')

@section('breadcrumb-title')
    Showing information of CS#{{$comparativestatement->id}}
@endsection

@section('breadcrumb-button')
    <a href="{{ route('cs.index') }}" class="btn btn-out-dashed btn-sm btn-warning"><i class="fas fa-database"></i></a>
@endsection

@section('sub-title')
    <span class="text-danger">*</span> Marked are required.
@endsection

@section('content-grid',null)

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="table-responsive">
                <table id="dataTable" class="table table-striped table-bordered">
                    <tbody class="text-left">
                    <tr style="background-color: #0C4A77;;color: white;"><td> <strong>Cs No.</strong> </td> <td> <strong>CS#{{ $comparativestatement->id}}</strong></td></tr>
                    <tr><td> <strong>Effective Date</strong> </td> <td>  {{ $comparativestatement->effective_date}}</td></tr>
{{--                    <tr><td> <strong>Expiry Date</strong> </td> <td>  {{ $comparativestatement->expiry_date}}</td></tr>--}}
                    <tr><td> <strong>Remarks</strong> </td> <td>  {{ $comparativestatement->remarks}}</td></tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="tableHeading">
                <h5> <span>&#10070;</span>Comparative Statement & Supplier Selection Form<span>&#10070;</span> </h5>
            </div>
            <div class="table-responsive">
                <table id="supplierTable" class="table table-striped table-sm text-center table-bordered" >
                    <thead>
                    <tr>
                        <th width="300px">Material Name</th>
                        <th> unit</th>
                        @foreach( $csSuppliers as  $csSupplier)
                            @if($csSupplier->cs_id == $comparativestatement->id)
                                <th>
                                    {{$csSupplier->supplier->name}}
                                    <br>{{$csSupplier->supplier->address}}
                                    <br>{{$csSupplier->supplier->contact}}
                                    <br>Price Collected by {{$csSupplier->collection_way}}
                                </th>
                            @endif
                        @endforeach
                    </tr>
                    </thead>
                    <tbody>
                    @foreach( $csMaterials as $csMaterial)
                        @if($csMaterial->cs_id == $comparativestatement->id)
                        <tr>
                            <td>
                                <strong>{{$csMaterial->material->name}}
                                    @if($csMaterial->type)
                                        <br>Type-{{$csMaterial->type}}
                                    @endif
                                    @if($csMaterial->type)
                                        <br>Size-{{$csMaterial->size}}
                                    @endif
                                </strong>
                            </td>
                            <td>{{$csMaterial->material->unit?? ''}}</td>

                            @foreach( $csSuppliers as  $csSupplier)
                                @if($csSupplier->cs_id == $comparativestatement->id)
                                <td>
                                    <?php
                                        $priceData = \Illuminate\Support\Facades\DB::table('cs_material_suppliers')
                                            ->where('cs_supplier_id',$csSupplier->id)
                                                        ->where('cs_material_id',$csMaterial->id)
                                            ->first();
                                    ?>
                                    {{$priceData->price ?? ''}}
                                </td>
                                @endif
                            @endforeach
                        </tr>
                        @endif
                    @endforeach
{{--                    <tr>--}}
{{--                        <td style="background-color: #0C4A77;;color: white;"><strong>Terms & Condiitions</strong></td>--}}
{{--                    </tr>--}}
{{--                    <tr>--}}
{{--                        <td>Grade</td>--}}
{{--                        <td></td>--}}

{{--                        @foreach( $csSuppliers as  $csSupplier)--}}
{{--                            <td>--}}
{{--                            <?php--}}
{{--                            $gradeData = \Illuminate\Support\Facades\DB::table('cs_conditions')--}}
{{--                                ->where('supplier_id',$csSupplier->id)--}}
{{--                                ->first();--}}
{{--                            ?>--}}
{{--                            {{$gradeData->grade ?? '' }}--}}
{{--                            </td>--}}
{{--                        @endforeach--}}

{{--                    </tr>--}}
                    <tr>
                        <td>Vat & Tax</td>
                        <td></td>
                        @foreach( $csSuppliers as  $csSupplier)
                            @if($csSupplier->cs_id == $comparativestatement->id)
                            <td>
                                <?php
                                $vatData = \Illuminate\Support\Facades\DB::table('cs_suppliers')
                                    ->where('supplier_id',$csSupplier->supplier_id)
                                    ->where('cs_id',$csSupplier->cs_id)
                                    ->first();
                                ?>
                                {{$vatData->vat_tax ?? '' }}
                            </td>
                            @endif
                        @endforeach
                    </tr>
                    <tr>
                        <td>Credit Period</td>
                        <td></td>
                        @foreach( $csSuppliers as  $csSupplier)
                            @if($csSupplier->cs_id == $comparativestatement->id)
                            <td>
                                <?php
                                $creditData = \Illuminate\Support\Facades\DB::table('cs_suppliers')
                                    ->where('supplier_id',$csSupplier->supplier_id)
                                    ->where('cs_id',$csSupplier->cs_id)
                                    ->first();
                                ?>
                                {{$creditData->credit_period ?? '' }}
                            </td>
                            @endif
                        @endforeach
                    </tr>
{{--                    <tr>--}}
{{--                        <td>Material Availability</td>--}}
{{--                        <td></td>--}}
{{--                        @foreach( $csSuppliers as  $csSupplier)--}}
{{--                            <td>--}}
{{--                                <?php--}}
{{--                                $availabilityData = \Illuminate\Support\Facades\DB::table('cs_conditions')--}}
{{--                                    ->where('supplier_id',$csSupplier->id)--}}
{{--                                    ->first();--}}
{{--                                ?>--}}
{{--                                {{$availabilityData->material_availability ?? '' }}--}}

{{--                            </td>--}}
{{--                        @endforeach--}}
{{--                    </tr>--}}

{{--                    <tr>--}}
{{--                        <td>Delivery Condition</td>--}}
{{--                        <td></td>--}}
{{--                        @foreach( $csSuppliers as  $csSupplier)--}}
{{--                            <td>--}}
{{--                                <?php--}}
{{--                                $deliveryData = \Illuminate\Support\Facades\DB::table('cs_conditions')--}}
{{--                                    ->where('supplier_id',$csSupplier->id)--}}
{{--                                    ->first();--}}
{{--                                ?>--}}
{{--                                {{$deliveryData->delivery_condition ?? '' }}--}}

{{--                            </td>--}}
{{--                        @endforeach--}}
{{--                    </tr>--}}
{{--                    <tr>--}}
{{--                        <td>Lead Time Required by Supplier</td>--}}
{{--                        <td></td>--}}
{{--                        @foreach( $csSuppliers as  $csSupplier)--}}
{{--                            <td>--}}
{{--                                <?php--}}
{{--                                $requiredTimeData = \Illuminate\Support\Facades\DB::table('cs_conditions')--}}
{{--                                    ->where('supplier_id',$csSupplier->id)--}}
{{--                                    ->first();--}}
{{--                                ?>--}}
{{--                                {{$requiredTimeData->required_time ?? '' }}--}}

{{--                            </td>--}}
{{--                        @endforeach--}}
{{--                    </tr>--}}
                    </tbody>
                </table>  <!-- supplier table  -->
            </div>
        </div>
    </div>
@endsection

@section('script')

@endsection
