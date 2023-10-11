@extends('layouts.backend-layout')
@section('title', 'Pre Sale Client')

@section('style')
    <link rel="stylesheet" type="text/css" href="{{ asset('css/Datatables/dataTables.bootstrap4.min.css') }}">
@endsection

@section('breadcrumb-title')
    Pre Sale Client
@endsection

@section('style')
    <style>
    </style>
@endsection
@section('breadcrumb-button')
    <a href="{{ route('client-profile.create') }}" class="btn btn-out-dashed btn-sm btn-warning"><i
            class="fas fa-plus"></i></a>
    <a href="{{ route('client-profile.index') }}" class="btn btn-out-dashed btn-sm btn-warning"><i
            class="fas fa-database"></i></a>
@endsection
@section('sub-title')
    Client: {{ $client->client_name }}
@endsection


@section('content')
    <div class="container">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <!-- table  -->
                    <div class="col-md-12">
                        <div class="table-responsive">
                            <table class="table custom_table table-bordered" style="font-size: 12px;">
                                <tr>
                                    <th>Client Name</th>
                                    <td>{{ $client->client_name }}</td>
                                    <th>Address</th>
                                    <td>{{ $client->address }}</td>
                                </tr>
                                <tr>
                                    <th>Division</th>
                                    <td>{{ $client->division->name ?? '' }}</td>
                                    <th>District</th>
                                    <td>{{ $client->district->name ?? '' }}</td>
                                </tr>
                                <tr>
                                    <th>Thana</th>
                                    <td>{{ $client->thana->name ?? '' }}</td>
                                    <th>Landmark</th>
                                    <td>{{ $client->landmark }}</td>
                                </tr>
                                <tr>
                                    <th>Lat-Long</th>
                                    <td>{{ $client->lat_long }}</td>
                                    <th>Contact Person</th>
                                    <td>{{ $client->contact_person }}</td>
                                </tr>
                                <tr>
                                    <th>Contact No</th>
                                    <td>{{ $client->contact_no }}</td>
                                    <th>Email</th>
                                    <td>{{ $client->email }}</td>
                                </tr>
                                <tr>
                                    <th>Website</th>
                                    <td>{{ $client->website }}</td>
                                    <th>Document</th>
                                    <td>
                                        @if ($client->document)
                                            <a href="{{ asset('uploads/lead_generation/' . $client->document) }}"
                                                target="_blank" class="btn btn-sm btn-warning" style="font-size:14px;"><i
                                                    class="fas fa-eye"></i></a>
                                        @endif
                                    </td>
                                </tr>
                            </table>
                        </div>
                        <div class="d-flex justify-content-around mt-4">
                            <button type="submit" value="Accept" class="btn btn-outline-success status">Accept</button>
                            <button type="button" value="Deny" class="btn btn-outline-danger status">Deny</button>
                            <button type="button" value="Review" class="btn btn-outline-warning status">Review</button>
                            <button type="submit" value="Cancel" class="btn btn-outline-info status">Cancel</button>
                        </div>
                    </div>
                    <input type="hidden" name="status" value="">
                </div>
            </div>
        </div>
    </div>
    <!-- Boostrap Modal  -->
    <div class="modal fade" tabindex="-1" role="dialog" id="myModal">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Comment</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="text" name="comment" class="form-control" placeholder="Comment">
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-sm btn-primary">Save</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script src="{{ asset('js/Datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('js/Datatables/dataTables.bootstrap4.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            $('.status').click(function() {
                $('input[name="status"]').val($(this).val());
                if ($(this).val() == 'Deny') {
                    $('#myModal').find('.modal-title').text('Deny Comment');
                } else if ($(this).val() == 'Review') {
                    $('#myModal').find('.modal-title').text('Review Comment');
                } else if ($(this).val() == 'Accept' || $(this).val() == 'Cancel') {
                    form.submit();
                }
                $('#myModal').modal('show');
            });
        });


        $(window).scroll(function() {
            //set scroll position in session storage
            sessionStorage.scrollPos = $(window).scrollTop();
        });
        var init = function() {
            //get scroll position in session storage
            $(window).scrollTop(sessionStorage.scrollPos || 0)
        };
        window.onload = init;

        $(document).ready(function() {
            $('#dataTable').DataTable({
                stateSave: true
            });
        });
    </script>
@endsection
