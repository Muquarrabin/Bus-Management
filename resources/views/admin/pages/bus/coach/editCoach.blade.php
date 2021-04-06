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
            <small>Edit Coach</small>
        </h1>
        <!-- You can dynamically generate breadcrumbs here -->
        <ol class="breadcrumb">
            <li><a href="#">Coach Management</a></li>
            <li class="active">Edit Coach</li>
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
                  <h3 class="box-title"><b>Edit Coach</b></h3>
                </div>
                <!-- /.box-header -->
                <!-- form start -->
                <form>
                    @csrf
                    <input type="hidden" name="Id" />
                  <div class="box-body">
                    <div class="form-group">
                      <label for="bus_number">Bus Number</label>
                      <input type="text" class="form-control" id="bus_number" placeholder="Enter Bus Number" name="bus_number">
                    </div>
                    <div class="form-group">
                      <label for="bus_seat_qty">Bus Seat Quantity</label>
                      <input type="text" class="form-control" id="bus_seat_qty" placeholder="Enter Bus Seat Quantity" name="bus_seat_qty">
                    </div>
                    <div class="form-group">
                      <label for="coach_type">Coach Type</label>
                      <select class="form-control" id="coach_type" name="coach_type" >
                        <option>AC</option>
                        <option>Non AC</option>
                      </select>
                    </div>
                  </div>
                  <!-- /.box-body -->
                  <div class="box-footer">
                    <button type="submit" class="btn btn-primary">Submit</button>
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
