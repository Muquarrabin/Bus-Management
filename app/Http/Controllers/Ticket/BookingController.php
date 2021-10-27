<?php

namespace App\Http\Controllers\Ticket;

use App\Http\Controllers\Controller;
use App\Models\Bus\CoachModel;
use App\Models\Bus\ScheduleModel;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Http\Requests\Ticket\Booking\BookingInsertRequest;
use App\Models\Ticket\BookingModel;
use App\Models\Ticket\CustomerModel;
use Illuminate\Support\Facades\DB;

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
        $schedules = ScheduleModel::with('coach.seatConfig')->get();
        $coaches= CoachModel::all();
        $data = [
            'schedules' => $schedules,
            'coaches' => $coaches,
        ];
        return view('admin.pages.ticket.bookings.addBooking',$data);
    }
    /**
     * @name getCoachInfoAjax
     * @role get Coach Info
     * @param null
     * @return Symfony\Component\HttpFoundation\JsonResponse
     */
    public function getCoachInfoAjax(Request $request)
    {
        // dd($request->schedule_id);
        $scheduleInfo=ScheduleModel::with('coach.seatConfig')->where('id',$request->schedule_id)->first();

        $coachInfo=$scheduleInfo->coach;
        if($coachInfo){
            return new JsonResponse(['data' => $coachInfo], 200);
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
            $booking=new BookingModel();
            $booking->customer_id=$customer->id;
            $booking->schedule_id=$request->schedule_id;
            $booking->total_price=$request->total_price;
            $booking->seat_ids=json_encode($request->seat_ids);
            $booking->payment_type=$request->payment_type;
            $booking->save();
            DB::commit();
            return new JsonResponse([], 201);

        } catch (\Throwable $th) {
            DB::rollBack();
            return new JsonResponse(['message' => $th], 500);
        }
    }

}
