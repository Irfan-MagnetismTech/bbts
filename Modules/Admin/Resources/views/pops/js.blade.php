<script src="{{ asset('js/custom-function.js') }}"></script>

<script>
    // get data by associative dropdown
    associativeDropdown("{{ route('get-districts') }}", 'division_id', '#division_id', '#district_id', 'get', null)
    associativeDropdown("{{ route('get-thanas') }}", 'district_id', '#district_id', '#thana_id', 'get', null)

    {{--select2Ajax("{{ route('searchBranch') }}", '#branch_id')--}}

    $('.date').datepicker({
        format: "dd-mm-yyyy",
        autoclose: true,
        todayHighlight: true,
        showOtherMonths: true
    });

    $('.bankList').select2({
        placeholder: 'Select an option'
    });
</script>
