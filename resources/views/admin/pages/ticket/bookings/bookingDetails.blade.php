@extends('admin.layouts.master')

@section('Page Title')
    Booking Details
@endsection

@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                <b> Book Tickets</b>
                <small>Booking Details</small>
            </h1>
            <!-- You can dynamically generate breadcrumbs here -->
            <ol class="breadcrumb">
                <li><a href="#">Book Tickets</a></li>
                <li class="active">Booking Details</li>
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
                            <h3 class="box-title"><b>Booking Details</b></h3>
                            <a href="{{ url('/') }}" class="btn btn-primary pull-right">Add Booking</a>
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body">
                            <table id="bookingDetailsTable" class="table table-bordered table-striped dataTable"
                                style="width:100%">
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Ticket Number</th>
                                        <th scope="col">Bus Number</th>
                                        <th scope="col">From</th>
                                        <th scope="col">To</th>
                                        <th scope="col">Departure Date</th>
                                        <th scope="col">Departure Time</th>
                                        <th scope="col">Customer Name</th>
                                        <th scope="col">Customer Address</th>
                                        <th scope="col">Customer Mobile</th>
                                        <th scope="col">Customer Seat Booked</th>
                                        <th scope="col" style="width: 15%">Action</th>
                                    </tr>
                                </thead>
                                <tbody>

                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Ticket Number</th>
                                        <th scope="col">Bus Number</th>
                                        <th scope="col">From</th>
                                        <th scope="col">To</th>
                                        <th scope="col">Departure Date</th>
                                        <th scope="col">Departure Time</th>
                                        <th scope="col">Customer Name</th>
                                        <th scope="col">Customer Address</th>
                                        <th scope="col">Customer Mobile</th>
                                        <th scope="col">Customer Seat Booked</th>
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
            $('#bookingDetailsTable').DataTable({
                "orderCellsTop": true,
                "fixedHeader": true,
                "processing": true,
                "serverSide": true,
                "ajax": {
                    "url": "{{ url('/ticket/book-ticket/booking-details') }}",
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
                        data: 'ticket_no',
                        name: 'ticket_no'
                    },
                    {
                        data: 'coach_id',
                        name: 'coach_id'
                    },
                    {
                        data: 'start_route',
                        name: 'start_route'
                    },
                    {
                        data: 'end_route',
                        name: 'end_route'
                    },
                    {
                        data: 'departure_date',
                        name: 'departure_date'
                    },
                    {
                        data: 'departure_time',
                        name: 'departure_time'
                    },
                    {
                        data: 'customer_name',
                        name: 'customer_name'
                    },
                    {
                        data: 'customer_address',
                        name: 'customer_address'
                    },
                    {
                        data: 'customer_mobile',
                        name: 'customer_mobile'
                    },
                    {
                        data: 'seat_ids',
                        name: 'seat_ids'
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
         *@name deleteBooking
         *@description send request for deleting a booking
         *@parameter id
         *@return  alert
         */
        function deleteBooking(id) {
            Swal.fire({
                title: "Are you sure to Cancel This Ticket?",
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
                        url: "{{ url('/ticket/book-ticket/delete-booking-ajax') }}",
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
                                $("#bookingDetailsTable").DataTable().ajax.reload();
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
