@extends('admin.layouts.master')

@section('Page Title')
    Coach Details
@endsection

@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                <b> Coach Management</b>
                <small>Coach Details</small>
            </h1>
            <!-- You can dynamically generate breadcrumbs here -->
            <ol class="breadcrumb">
                <li><a href="#">Coach Management</a></li>
                <li class="active">Coach Details</li>
            </ol>
        </section>

        <!-- Main content -->
        <section class="content">
            <!-- Your Page Content Here -->
            <div class="row">
                <div class="col-xs-12">
                    <!-- general form elements -->
                    <div class="box box-info">
                        <div class="box-header with-border">
                            <h3 class="box-title"><b>Coach Details</b></h3>
                            <a href="{{ url('/bus/coach-management/add-coach') }}" class="btn btn-primary pull-right">Add Coach</a>
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body">
                            <table id="coachDetailsTable" class="table table-bordered table-striped dataTable"
                                style="width:100%">
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Bus Number</th>
                                        <th scope="col">Bus Seat Quantity</th>
                                        <th scope="col">Coach Type</th>
                                        <th scope="col" style="width: 15%">Action</th>
                                    </tr>
                                </thead>
                                <tbody>

                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Bus Number</th>
                                        <th scope="col">Bus Seat Quantity</th>
                                        <th scope="col">Coach Type</th>
                                        <th scope="col" style="width: 15%">Action</th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                    <!-- /.box -->
                </div>
            </div>
        </section><!-- /.content -->
    </div><!-- /.content-wrapper -->
@endsection

@section('addtional-scripts')
    <script>
        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000
        });
        $(document).ready(function() {
            $('#coachDetailsTable').DataTable({
                "orderCellsTop": true,
                "fixedHeader": true,
                "processing": true,
                "serverSide": true,
                "ajax": {
                    "url": "{{ url('/bus/coach-management/get-coaches') }}",
                    "method": "post",
                    // "data": data,
                    "data": function(d) {
                        return d;
                    }
                },
                columns: [{
                        "data": 'DT_RowIndex',
                        searchable: false
                    },
                    {
                        data: 'bus_number',
                        name: 'bus_number'
                    },
                    {
                        data: 'bus_seat_quantity',
                        name: 'bus_seat_quantity'
                    },
                    {
                        data: 'coach_type',
                        name: 'coach_type'
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false
                    }
                ]
            });
        });
        /**
         *@name deleteCoach
         *@description send request for deleting a coach
         *@parameter id
         *@return  alert
         */
        function deleteCoach(id) {
            Swal.fire({
                title: "Are you sure to Delete This Coach Info?",
                text: "You will not be able to recover this!",
                type: "warning",
                showCancelButton: true,
                confirmButtonClass: "btn-danger btn-lg",
                cancelButtonClass: "btn-secondary btn-lg",
                confirmButtonText: "Yes",
                cancelButtonText: "No",
                closeOnConfirm: false,
                closeOnCancel: false,
                showLoaderOnConfirm: true
            }).then((result) => {
                if (result.value) {
                    $.ajax({
                        url: "{{ url('/bus/coach-management/delete-coach-ajax') }}",
                        method: "POST",
                        data: {
                            id: id
                        },
                        success: function(data, textStatus, xhr) {
                            let responseCode = xhr.status;
                            if (responseCode === 204) {
                                Toast.fire({
                                    icon: 'success',
                                    title: "Success " + responseCode,
                                    text: "Deleted Successfully",
                                });
                                $("#coachDetailsTable").DataTable().ajax.reload();
                            }
                        },
                        error: function(jqXHR, exception) {
                            Toast.fire({
                                icon: 'error',
                                title: "Error " + jqXHR.status,
                                text: jqXHR.responseJSON.message,
                            });
                        }
                    });
                } else {
                    Swal.fire("Cancelled", "Your canceled this operation", "warning");
                }
            });
        }

    </script>
@endsection
