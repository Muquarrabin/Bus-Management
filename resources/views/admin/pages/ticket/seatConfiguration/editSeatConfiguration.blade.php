@extends('admin.layouts.master')

@section('Page Title')
    Edit Seat Configuration
@endsection

@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                <b> Seat Configuration</b>
                <small>Edit Seat Configuration</small>
            </h1>
            <!-- You can dynamically generate breadcrumbs here -->
            <ol class="breadcrumb">
                <li><a href="#">Seat Configuration</a></li>
                <li class="active">Edit Seat Configuration</li>
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
                            <h3 class="box-title"><b>Edit Seat Configuration</b></h3>
                        </div>
                        <!-- /.box-header -->
                        <!-- form start -->
                        <form id="edit_seat_config_form" method="POST">
                            <input type="hidden" id="id" name="id" value="{{ $seat_config->id }}" />
                            <div class="box-body">
                                <div class="form-group">
                                    <label for="coach_id">Coach Number</label>
                                    <select class="form-control" id="coach_id" name="coach_id">
                                        <option value="">--Select Coach Number--</option>
                                        @foreach ($coaches as $coach)
                                            <option {{ $coach->id == $seat_config->coach_id ? 'selected' : '' }}
                                                value="{{ $coach->id }}">{{ $coach->bus_number . '(' . $coach->coach_type . '; QTY: '.$coach->bus_seat_quantity.')'}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="seat_type">Seat Type</label>
                                    <select class="form-control" id="seat_type" name="seat_type">
                                        <option value="">--Select Seat Type--</option>
                                        <option value="1"  {{ $seat_config->seat_type == 1 ? 'selected' : '' }}>Economy Class(2 by 2)</option>
                                        <option value="2"  {{ $seat_config->seat_type == 2 ? 'selected' : '' }}>Business Class(1 by 2)</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="price">Price</label>
                                    <input type="text" class="form-control" id="price"
                                        placeholder="Enter Price" name="price" value="{{ $seat_config->price }}">
                                </div>

                                <button id="edit_seat_config_form_btn" type="submit" class="btn btn-primary">Submit</button>
                            </div>
                            <!-- /.box-body -->
                            <div class="box-footer">
                                <a href="{{ url('/ticket/seat-configuration/details') }}">Back to Seat Configuration Details</a> |
                                <a href="{{ url('/ticket/seat-configuration/add-seat-configuration') }}">Add Seat Configuration</a>
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
            $("#edit_seat_config_form_btn").click(function(e) {
                e.preventDefault();
                $("#edit_seat_config_form").validate({
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
                const seat_config = {
                    "id": $("#id").val(),
                    "coach_id": $("#coach_id").val(),
                    "seat_type": $("#seat_type").val(),
                    "price": $("#price").val(),
                }
                const seatConfigJson = JSON.stringify(seat_config);
                console.log(seatConfigJson);
                $.ajax({
                    // url: EndPoint + 'supplier/CreateSupplier',
                    url: '{{ url('ticket/seat-configuration/edit-seat-configuration-ajax') }}',
                    type: 'POST',
                    data: JSON.stringify(seat_config),
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
                                    "{{ url('/ticket/seat-configuration/details') }}";
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
