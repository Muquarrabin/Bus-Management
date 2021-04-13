@extends('admin.layouts.master')

@section('Page Title')
    Edit Schedule
@endsection

@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                <b> Schedule Management</b>
                <small>Edit Schedule</small>
            </h1>
            <!-- You can dynamically generate breadcrumbs here -->
            <ol class="breadcrumb">
                <li><a href="#">Schedule Management</a></li>
                <li class="active">Edit Schedule</li>
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
                            <h3 class="box-title"><b>Edit Schedule</b></h3>
                        </div>
                        <!-- /.box-header -->
                        <!-- form start -->
                        <form id="edit_schedule_form" method="POST">
                            <input type="hidden" id="id" name="id" value="{{ $schedule->id }}" />
                            <div class="box-body">
                                <div class="form-group">
                                    <label for="coach_id">Coach Number</label>
                                    <select class="form-control" id="coach_id" name="coach_id">
                                        <option value="">--Select Coach Number--</option>
                                        @foreach ($coaches as $coach)
                                            <option {{ $coach->id == $schedule->coach_id ? 'selected' : '' }}
                                                value="{{ $coach->id }}">{{ $coach->bus_number }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="start_route">From</label>
                                    <input type="text" class="form-control" id="start_route"
                                        placeholder="Enter Your Location" name="start_route" value="{{ $schedule->start_route}}">
                                </div>
                                <div class="form-group">
                                    <label for="end_route">To</label>
                                    <input type="text" class="form-control" id="end_route"
                                        placeholder="Enter Your Destination" name="end_route" value="{{ $schedule->end_route }}">
                                </div>
                                <div class="form-group">
                                    <label for="departure_date">Departure Date</label>
                                    <div class="input-group">
                                        <div class="input-group-addon">
                                            <i class="fa fa-calendar"></i>
                                        </div>
                                        <input type="text" class="form-control datepicker" id="departure_date"
                                        placeholder="Enter Departure Date" name="departure_date" value="{{ $schedule->departure_date }}">
                                    </div>
                                    <!-- /.input group -->
                                </div>
                                <div class="form-group">
                                    <label for="departure_time">Departure Time</label>
                                    <div class="input-group">
                                        <div class="input-group-addon">
                                            <i class="fa fa-clock-o"></i>
                                        </div>
                                        <input type="text" class="form-control timepicker" id="departure_time"
                                        placeholder="Enter Departure Time" name="departure_time" value="{{ $schedule->departure_time }}">

                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="bus_driver">Bus Driver</label>
                                    <input type="text" class="form-control" id="bus_driver"
                                        placeholder="Enter Bus Driver Name" name="bus_driver" value="{{ $schedule->bus_driver }}">
                                </div>
                                <button id="edit_schedule_form_btn" type="submit" class="btn btn-primary">Submit</button>
                            </div>
                            <!-- /.box-body -->
                            <div class="box-footer">
                                <a href="{{ url('/bus/schedule-management/schedules') }}">Back to Schedule Details</a> |
                                <a href="{{ url('/bus/schedule-management/add-schedule') }}">Add Schedule</a>
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
             //Timepicker
             $('.timepicker').timepicker({
                showInputs: false
            });
            //Datepicker
            $('.datepicker').datepicker({
                showInputs: false
            });
            const Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000
            });
            //  const EndPoint = '@EndPoint.SupplierModuleEndpoint';
            $("#edit_schedule_form_btn").click(function(e) {
                e.preventDefault();
                $("#edit_schedule_form").validate({
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
                const schedule = {
                    "id": $("#id").val(),
                    "coach_id": $("#coach_id").val(),
                    "start_route": $("#start_route").val(),
                    "end_route": $("#end_route").val(),
                    "departure_date": $("#departure_date").val(),
                    "departure_time": $("#departure_time").val(),
                    "bus_driver": $("#bus_driver").val(),
                }
                const scheduleJson = JSON.stringify(schedule);
                console.log(scheduleJson);
                $.ajax({
                    // url: EndPoint + 'supplier/CreateSupplier',
                    url: '{{ url('bus/schedule-management/edit-schedule-ajax') }}',
                    type: 'POST',
                    data: JSON.stringify(schedule),
                    dataType: 'json',
                    contentType: 'application/json; charset=utf-8',
                    success: function(data, textStatus, xhr) {
                        let responseCode = xhr.status;
                        if (responseCode === 200) {
                            $('#edit_schedule_form').trigger('reset');
                            Toast.fire({
                                icon: 'success',
                                title: "Success " + responseCode,
                                text: "Edited Successfully",
                            });
                            setTimeout(redirectFunc, 2000);

                            function redirectFunc() {
                                window.location.href =
                                    "{{ url('/bus/schedule-management/schedules') }}";
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
                            var validator = $('#edit_schedule_form').validate();
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
