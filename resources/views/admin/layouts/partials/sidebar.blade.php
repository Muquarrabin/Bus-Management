<!-- Left side column. contains the logo and sidebar -->
<aside class="main-sidebar">

    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">

        <!-- Sidebar user panel (optional) -->
        <div class="user-panel">
            <div class="pull-left image">
                <img src="{{asset("bower_components/admin-lte/dist/img/user2-160x160.jpg")}}" class="img-circle"
                     alt="User Image">
            </div>
            <div class="pull-left info">
                <p>{{Auth::user()->name}}</p>
                <!-- Status -->
                <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
            </div>
        </div>

        <!-- search form (Optional) -->
    {{-- <form action="#" method="get" class="sidebar-form">
      <div class="input-group">
        <input type="text" name="q" class="form-control" placeholder="Search...">
        <span class="input-group-btn">
            <button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i>
            </button>
          </span>
      </div>
    </form> --}}
    <!-- /.search form -->

        <!-- Sidebar Menu -->
        <ul class="sidebar-menu" data-widget="tree">
            <li class="header">Menu</li>
            <!-- Optionally, you can add icons to the links -->

            {{-- <li>
                <a href="#"><i class="fa fa-link"></i> <span>Another Link</span></a>
            </li> --}}
            <li class="treeview {{ (request()->is('ticket*')) ? 'active menu-open' : '' }}">
                <a href="#"><i class="fa fa-ticket"></i> <span>Ticket Management</span>
                    <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
                </a>
                <ul class="treeview-menu">

                    <li class="{{ (request()->is('ticket/book-ticket*')) ? 'active' : '' }}">
                        <a href="{{ url('ticket/book-ticket/details') }}"><i class="fa fa-dot-circle-o"></i>Booking
                            Details</a>
                    </li>
                    <li class="{{ (request()->is('ticket/seat-configuration*')) ? 'active' : '' }}">
                        <a href="{{ url('ticket/seat-configuration/details') }}"><i class="fa fa-dot-circle-o"></i>Seat
                            Configuration</a>
                    </li>

                </ul>
            </li>
            <li class="treeview {{ (request()->is('bus*')) ? 'active menu-open' : '' }}">
                <a href="#"><i class="fa fa-bus"></i> <span>Bus Management</span>
                    <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
                </a>
                <ul class="treeview-menu">
                    <li class="{{ (request()->is('bus/coach-management*')) ? 'active' : '' }}">
                        <a href="{{ url('bus/coach-management/coaches') }}">
                            <i class="fa fa-dot-circle-o"></i>Coach Management</a>
                    </li>
                    <li class="{{ (request()->is('bus/schedule-management*')) ? 'active' : '' }}">
                        {{-- <a href="#"> --}}
                        <a href="{{ url('bus/schedule-management/schedules') }}">
                            <i class="fa fa-dot-circle-o"></i>Schedule Management </a>
                    </li>
                </ul>
            </li>

        </ul>
        <!-- /.sidebar-menu -->
    </section>
    <!-- /.sidebar -->
</aside>
