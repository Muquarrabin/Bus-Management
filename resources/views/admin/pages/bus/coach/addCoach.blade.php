@extends('admin.layouts.master')

@section('Page Title')
    Add Coach
@endsection

@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                <b> Coach Management</b>
                <small>Add Coach</small>
            </h1>
            <!-- You can dynamically generate breadcrumbs here -->
            <ol class="breadcrumb">
                <li><a href="#">Coach Management</a></li>
                <li class="active">Add Coach</li>
            </ol>
        </section>

        <!-- Main content -->
        <section class="content">
            <!-- Your Page Content Here -->
            <div class="row">
                <div class="col-md-3"></div>
                <div class="col-md-6">
                    <!-- general form elements -->
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title"><b>Add Coach</b></h3>
                        </div>
                        <!-- /.box-header -->
                        <!-- form start -->
                        <form id="add_coach_form" method="POST">
                            @csrf
                            <div class="box-body">
                                <div class="form-group">
                                    <label for="bus_number">Bus Number</label>
                                    <input type="text" class="form-control" id="bus_number" placeholder="Enter Bus Number"
                                        name="bus_number" >
                                </div>
                                <div class="form-group">
                                    <label for="bus_seat_qty">Bus Seat Quantity</label>
                                    <input type="text" class="form-control" id="bus_seat_qty"
                                        placeholder="Enter Bus Seat Quantity" name="bus_seat_quantity" >
                                </div>
                                <div class="form-group">
                                    <label for="coach_type">Coach Type</label>
                                    <select class="form-control" id="coach_type" name="coach_type" >
                                        <option>AC</option>
                                        <option>Non AC</option>
                                    </select>
                                </div>
                                <button id="add_coach_form_btn" type="submit" class="btn btn-primary">Submit</button>
                            </div>
                            <!-- /.box-body -->
                            <div class="box-footer">
                                <a href="{{ url('/bus/coach-management/coaches') }}" >Back to Coach Details</a>
                            </div>
                        </form>
                    </div>
                    <!-- /.box -->
                </div>
                <div class="col-md-3"></div>
            </div>
        </section><!-- /.content -->
    </div><!-- /.content-wrapper -->
@endsection

@section('addtional-scripts')
    <script>
        $(document).ready(function() {
            const Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000
            });
            //  const EndPoint = '@EndPoint.SupplierModuleEndpoint';
            $("#add_coach_form_btn").click(function(e) {
                e.preventDefault();
                $("#add_coach_form").validate({
                    highlight: function(element) {
                        jQuery(element).closest('.form-group').addClass('has-error');
                    },
                    unhighlight: function(element) {
                        jQuery(element).closest('.form-group').removeClass('has-error');
                        jQuery(element).closest('.form-group').addClass('has-success');
                    },
                    errorElement: 'span',
                    errorClass: 'help-block',
                    errorPlacement: function(error, element) {
                        if (element.parent('.input-group').length) {
                            $(element).siblings(".help-block").append(error);
                            error.insertAfter(element.parent());
                        } else {
                            error.insertAfter(element);
                        }
                    }
                });
                const coach = {
                    "bus_number": $("#bus_number").val(),
                    "bus_seat_quantity": $("#bus_seat_qty").val(),
                    "coach_type": $("#coach_type").val(),
                }
                const coachJson = JSON.stringify(coach);
                console.log(coachJson);
                $.ajax({
                    // url: EndPoint + 'supplier/CreateSupplier',
                    url: '{{ url('bus/coach-management/add-coach-ajax') }}',
                    type: 'POST',
                    data: JSON.stringify(coach),
                    dataType: 'json',
                    contentType: 'application/json; charset=utf-8',
                    success: function(data, textStatus, xhr) {
                        let responseCode = xhr.status;
                        if (responseCode === 201) {
                            $('#add_coach_form').trigger('reset');
                            Toast.fire({
                                icon: 'success',
                                title: "Success " + responseCode,
                                text: "Created Successfully",
                            });
                            setTimeout(redirectFunc, 2000);
                            function redirectFunc() {
                                  window.location.href = "{{ url('/bus/coach-management/coaches') }}";
                            }
                        }
                    },
                    error: function(jqXHR, exception) {
                        console.log(jqXHR);
                        Toast.fire({
                            icon: 'error',
                            title: "Error " + jqXHR.status,
                            text: jqXHR.responseJSON.message,
                        });
                        if (jqXHR.status == 422) {
                            console.log(jqXHR.responseJSON.errors);
                            var validator = $('#add_coach_form').validate();
                            var objErrors = {};
                            $.each(jqXHR.responseJSON.errors, function(key, val) {
                                objErrors[key] = val;
                            });
                            validator.showErrors(objErrors);
                            validator.focusInvalid();
                        }
                    }
                });
            });
        });

    </script>
@endsection
