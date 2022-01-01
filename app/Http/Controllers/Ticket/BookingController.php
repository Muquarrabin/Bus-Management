<?php

namespace App\Http\Controllers\Ticket;

use App\Http\Controllers\Controller;
use App\Models\Bus\CoachModel;
use App\Models\Bus\ScheduleModel;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Date;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Http\Requests\Ticket\Booking\BookingInsertRequest;
use App\Models\Ticket\BookingModel;
use App\Models\Ticket\CustomerModel;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

class BookingController extends Controller
{
    /**
     * @name addBookingView
     * @role add seat booking view
     * @param null
     * @return view('admin.pages.ticket.bookings.addBooking')
     */
    public function addBookingView()
    {
        $date=date('Y-m-d', strtotime(Carbon::now('Asia/Dhaka')));
        $time=date('H:i:s', strtotime(Carbon::now('Asia/Dhaka')));
        $schedules = ScheduleModel::query()
            ->with(['coach.seatConfig'])
            ->where('departure_date','>=',$date)
            ->whereRaw('IF(departure_date <= '.$date.', departure_time, departure_time ) >= ?',[$time])
            ->get();
        $coaches= CoachModel::all();
        $data = [
            'schedules' => $schedules,
            'coaches' => $coaches,
        ];
        return view('web.pages.ticket.bookings.addBooking',$data);
    }
    /**
     * @name getCoachInfoAjax
     * @role get Coach Info
     * @param null
     * @return mixed
     */
    public function getCoachInfoAjax(Request $request)
    {
        // dd($request->schedule_id);
        $scheduleInfo=ScheduleModel::with('coach.seatConfig','booking')->where('id',$request->schedule_id)->first();
        $coachInfo=$scheduleInfo->coach;
        $bookedSeats=[];
        foreach ($scheduleInfo->booking as $booked){
            $temp=json_decode($booked->seat_ids);
            $bookedSeats=array_merge($temp,$bookedSeats);
        }
//        dd($coachInfo);
        if($coachInfo){
            return new JsonResponse(
                [
                    'coach_info' => $coachInfo,
                    'booked_seats' => $bookedSeats,
                    'schedule_info'=>$scheduleInfo
                ], 200);
        }
        return new JsonResponse(['message' => 'Something went wrong!'], 500);

    }
    /**
     * @name entryBookingAjax
     * @role  entry booking into database
     * @param App\Http\Requests\Ticket\Booking\BookingInsertRequest $request
     * @return Symfony\Component\HttpFoundation\JsonResponse
     */
    public function entryBookingAjax(BookingInsertRequest $request)
    {
        try {
            DB::beginTransaction();
            $customer=new CustomerModel();
            $customer->customer_name=$request->customer_name;
            $customer->customer_mobile=$request->customer_mobile;
            $customer->customer_address=$request->customer_address;
            $customer->save();
            // dd($customer);
            $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
            $ticketNo = '';
            for ($i = 0; $i < 10; $i++) {
                $ticketNo .= $characters[rand(0, strlen($characters))];
            }
            $booking=new BookingModel();
            $booking->ticket_no=$ticketNo;
            $booking->customer_id=$customer->id;
            $booking->schedule_id=$request->schedule_id;
            $booking->total_price=$request->total_price;
            $booking->seat_ids=json_encode($request->seat_ids);
            $booking->payment_type=$request->payment_type;
            $booking->save();
            DB::commit();
            return new JsonResponse($booking, 201);

        } catch (\Throwable $th) {
            DB::rollBack();
            return new JsonResponse(['message' => $th], 500);
        }
    }

    /**
     * @name bookingDetailsView
     * @role load  booking details view
     * @param null
     * @return mixed
     */
    public function bookingDetailsView()
    {

        return view('admin.pages.ticket.bookings.bookingDetails');
    }
    /**
     * @name getBookingInfoForPrintByTicket
     * @role load  ticket Print view
     * @param Request $request
     * @return mixed
     */
    public function getBookingInfoForPrintByTicket(Request $request)
    {
        $booking=BookingModel::where('ticket_no','=',$request->ticket_no)
            ->with('schedule.coach','customer')
            ->firstOrFail();
        return view('web.pages.ticket.bookings.ticket_template',compact('booking'));
    }

    /**
     * @name deleteBookingAjax
     * @role  delete booking from database
     * @param Illuminate\Http\Request $request
     * @return mixed
     */
    public function deleteBookingAjax(Request $request)
    {
        $booking = BookingModel::findOrfail($request->id);
        $bookingDeleteResponse = $booking->delete();

        if ($bookingDeleteResponse) {
            return new JsonResponse([], 204);
        } else {
            return new JsonResponse(['error' => 'Something went wrong!'], 500);
        }
    }
    /**
     * @name getBookingsDataTableAjax
     * @role send datatable json for showing users
     * @param Request
     * @return  Datatable json
     *
     */
    public function getBookingsDataTableAjax(Request $request)
    {
        $bookings = BookingModel::all();

        return Datatables::of($bookings)
            ->addIndexColumn()
            ->editColumn('start_route', function ($booking) {
                return $booking->schedule->start_route;
            })
            ->editColumn('end_route', function ($booking) {
                return $booking->schedule->end_route;
            })
            ->editColumn('coach_id', function ($booking) {
                return $booking->schedule->coach->bus_number;
            })
            ->editColumn('departure_date', function ($booking) {
                $booking->schedule->departure_date=date('d/m/Y', strtotime($booking->schedule->departure_date));
                return $booking->schedule->departure_date;
            })
            ->editColumn('departure_time', function ($booking) {
                $booking->schedule->departure_time = date('h:i A', strtotime($booking->schedule->departure_time));
                return $booking->schedule->departure_time;
            })
            ->editColumn('customer_name', function ($booking) {
                return $booking->customer->customer_name;
            })
            ->editColumn('customer_address', function ($booking) {
                return $booking->customer->customer_address;
            })
            ->editColumn('customer_mobile', function ($booking) {
                return $booking->customer->customer_mobile;
            })
            ->addColumn('action', function ($booking) {

                $markup = '';

                $markup .= ' <button class="btn btn-sm btn-danger" data-toggle="tooltip" data-placement="top" title="Delete"
                onclick="deleteBooking(' . $booking->id . ')"><i
                class="fa fa-trash-o" aria-hidden="true"></i></button>';

                $printUrl = url('/ticket/book-ticket/print?ticket_no='.$booking->ticket_no);

                $markup .= ' <a href="' . $printUrl . '" class="btn btn-sm btn-info"
                data-toggle="tooltip" data-placement="top" title="Print Ticket"><i
                class="fa fa-file-pdf-o" aria-hidden="true"></i></a>';


                return $markup;
            })
            ->rawColumns(['action'])
            ->make(true);
    }

}
