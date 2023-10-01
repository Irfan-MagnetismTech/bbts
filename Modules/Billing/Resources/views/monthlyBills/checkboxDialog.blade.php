@extends('layouts.backend-layout')
@section('title', 'Monthly Bill')

@section('breadcrumb-title')
    @if ($format=='detail')
        Monthly Connectivity Charge (Details)
    @else
        Monthly Connectivity Charge (Summary)
    @endif
@endsection
@section('breadcrumb-button')
    <a href="{{ route('monthly-bills.index') }}" class="btn btn-out-dashed btn-sm btn-warning"><i class="fas fa-database"></i></a>
@endsection

@section('content')
    <br>
    <div id="checkboxDialog">
        <h6 style="color: red">Select options to view in pdf format :</h6>
        <div style="margin: 10px">
            <form id="checkboxForm">
                <label>
                    <input type="checkbox" name="with_due" value="with_due"> With Due Amount
                </label>
                <br>
                <label>
                    <input type="checkbox" name="without_due" value="without_due"> Without Due Amount
                </label>
                <br>
                <label>
                    <input type="checkbox" name="with_pad" value="with_pad"> With Pad Format
                </label>
                <br>
                <label>
                    <input type="checkbox" name="without_pad" value="without_pad"> Without Pad Format
                </label>
                <br>
                <br>
                <button type="submit" id="generatePdfBtn" class="btn btn-primary">Generate PDF</button>
            </form>
        </div>
    </div>
@endsection

@section('script')
    <script>
        $(document).ready(function () {
            // Add event listeners to checkboxes
            $("input[type='checkbox']").change(function () {
                var name = $(this).attr("name");
                var value = $(this).val();

                // If "With Due Amount" is checked, uncheck "Without Due Amount" and vice versa
                if (name === "with_due") {
                    $("input[name='without_due']").prop("checked", !$(this).prop("checked"));
                } else if (name === "without_due") {
                    $("input[name='with_due']").prop("checked", !$(this).prop("checked"));
                }

                // If "With Pad Format" is checked, uncheck "Without Pad Format" and vice versa
                if (name === "with_pad") {
                    $("input[name='without_pad']").prop("checked", !$(this).prop("checked"));
                } else if (name === "without_pad") {
                    $("input[name='with_pad']").prop("checked", !$(this).prop("checked"));
                }
            });
        });
    </script>

    <script>
        var id= '{{$id}}';
        var format= '{{$format}}';

        $(document).ready(function () {
            $('#generatePdfBtn').click(function (e) {
                e.preventDefault();

                // Collect selected checkbox values and build an array
                var selectedOptions = [];
                $("input[type='checkbox']:checked").each(function () {
                    selectedOptions.push($(this).val());
                });

                // Convert the array to a comma-separated string
                var selectedOptionsString = selectedOptions.join(',');

                // Redirect to the PDF generation route with selected options and id as query parameters
                if (format === 'detail') {
                    window.location.href = '/billing/mrc_bill?selectedOptions=' + selectedOptionsString + '&id=' + id;
                } else {
                    window.location.href = '/billing/mrc_bill_summary?selectedOptions=' + selectedOptionsString + '&id=' + id;
                }
            });
        });
    </script>

@endsection
