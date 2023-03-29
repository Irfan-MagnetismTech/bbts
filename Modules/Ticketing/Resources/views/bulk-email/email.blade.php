@extends('layouts.backend-layout')
@section('title', "Bulk Notification")

@section('style')
<style>
    label {
        font-weight: 600 !important;
    }
    textarea {
        min-height: 60px;
    }
</style>
@endsection

@section('breadcrumb-title')
    Bulk Notification
@endsection

@section('breadcrumb-button')
@endsection

@section('content-grid', 'offset-md-1 col-md-10 offset-lg-2 col-lg-8 my-3')

@section('content')
    <div class="col-md-10 mx-auto">
        <div class="row">
            <div class="col-md-12">
                <form
                action="{{ route('send-bulk-email') }}"
                method="post" class="custom-form">
                
                @csrf
                
                    <div class="row">
                        <div class="form-group col-10 mx-auto">
                            <label for="branch_id">Branch Name:</label>
                            <select name="branch_id" id="branch_id" class="form-control select2">
                                <option value="">Select Branch</option>
                            
                            </select>
                        </div>
                        <div class="form-group col-10 mx-auto">
                            <label for="pop_id">POP Name:</label>
                            <select name="pop_id" id="pop_id" class="form-control select2">
                                <option value="">Select POP</option>
                            
                            </select>
                        </div>
                        <div class="form-group col-10 mx-auto">
                            <label for="issue_started">Occurance Time</label>
                            <input type="datetime-local" class="form-control" id="issue_started" name="issue_started" aria-describedby="issue_started"
                                value="{{ old('issue_started') ?? null }}">
                        </div>
                        <div class="form-group col-10 mx-auto">
                            <label for="issue_resolved">Solution Time</label>
                            <input type="datetime-local" class="form-control" id="issue_resolved" name="issue_resolved" aria-describedby="issue_resolved"
                                value="{{ old('issue_resolved') ?? null }}">
                        </div>
                        <div class="form-group col-10 mx-auto">
                            <label for="cc">CC: <small><strong>[Multiple email should be separated by ";" mark]</strong></small></label>
                            <textarea type="text" class="form-control" id="cc" name="cc" aria-describedby="cc"
                                placeholder="CC">{{ old('cc') ?? null }}</textarea>
                        </div>
                        <div class="form-group col-10 mx-auto">
                            <label for="subject">Subject:</label>
                            <input type="text" class="form-control" id="subject" name="subject" aria-describedby="subject"
                                value="{{ old('subject') ?? null }}" placeholder="Subject">
                        </div>
                        <div class="form-group col-10 mx-auto">
                            <label for="description">Description:</label>
                            <textarea type="text" class="form-control" id="description" name="description" aria-describedby="description"
                                placeholder="Description">{{ old('description') ?? null }}</textarea>
                        </div>
                        <div class="col-10 offset-1">
                            <div class="form-group">
                                <label for="" class="d-block">Issue Resolved:</label>
                                
                                <div class="form-check-inline">
                                    <label class="form-check-label" for="closed">
                                        <input type="radio" class="form-check-input radioButton" id="closed" name="status" value="Resolved" @checked(old('status') == 'Resolved')
                                        >
                                        <span style="position: relative; top: 3px">
                                            Yes
                                        </span>
                                    </label>
                                </div>
        
                                <div class="form-check-inline">
                                    <label class="form-check-label" for="opened">
                                        <input type="radio" class="form-check-input radioButton" id="opened" name="status" @checked(old('status') != 'Resolved')
                                            value="Open">
                                        <span style="position: relative; top: 3px">
                                            No
                                        </span>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="offset-md-4 col-md-4 mt-2">
                            <div class="input-group input-group-sm ">
                                <button class="btn btn-success btn-round btn-block py-2">Send Email</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('script')
<script>

    $(document).ready(function() {
        select2Ajax("{{ route('searchBranch') }}", '#branch_id')
        select2Ajax("{{ route('searchPopByBranch') }}", '#pop_id', '#branch_id')
    });

</script>
@endsection
