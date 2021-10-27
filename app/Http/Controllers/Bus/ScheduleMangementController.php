<?php

namespace App\Http\Controllers\Bus;

use App\Http\Controllers\Controller;
use App\Http\Requests\Bus\Schedule\ScheduleInsertRequest;
use App\Http\Requests\Bus\Schedule\ScheduleUpdateRequest;
use App\Http\Services\Bus\ScheduleService;
use App\Models\Bus\CoachModel;
use App\Models\Bus\ScheduleModel;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Illuminate\Support\Carbon;
use Yajra\DataTables\DataTables;

class ScheduleMangementController extends Controller
{
    private $_scheduleService;

    public function __construct(ScheduleService $scheduleService)
    {
        $this->_scheduleService = $scheduleService;
    }

    /**
     * @name addScheduleView
     * @role load add schedule view
     * @param null
     * @return view('admin.pages.bus.schedule.addSchedule')
     */
    public function addScheduleView()
    {
        $coaches = CoachModel::all();
        $data = [
            'coaches' => $coaches
        ];
        return view('admin.pages.bus.schedule.addSchedule', $data);
    }

     /**
     * @name editScheduleView
     * @role load edit schedule view
     * @param Illuminate\Http\Request $request
     * @return view('admin.pages.bus.schedule.editSchedule')
     */
    public function editScheduleView(Request $request)
    {
        $coaches = CoachModel::all();
        $schedule = ScheduleModel::findOrFail($request->id);
        $schedule->departure_date=date('m/d/Y', strtotime($schedule->departure_date));
        $schedule->departure_time = date('h:i A', strtotime($schedule->departure_time));

        $data=[
            'coaches'=>$coaches,
            'schedule'=>$schedule
        ];
        // dd($data);
        return view('admin.pages.bus.schedule.editSchedule', $data);
    }
    /**
     * @name scheduleDetalisView
     * @role load  schedule details view
     * @param null
     * @return view('admin.pages.bus.schedule.scheduleDetails')
     */
    public function scheduleDetalisView()
    {

        return view('admin.pages.bus.schedule.scheduleDetails');
    }

    /**
     * @name addScheduleAjax
     * @role  add schedule into database
     * @param App\Http\Requests\Bus\Schedule\ScheduleInsertRequest $request
     * @return Symfony\Component\HttpFoundation\JsonResponse
     */
    public function addScheduleAjax(ScheduleInsertRequest $request)
    {
        $status_code = $this->_scheduleService->insertSchedule($request);

        if ($status_code==201) {
            return new JsonResponse([], $status_code);
        }else if($status_code==409){
            return new JsonResponse(['message' => "Coach can't be rescheduled wihtin 3 hrs!"], $status_code);
        }else {
            return new JsonResponse(['message' => 'Something went wrong!'], 500);
        }
    }
    /**
     * @name editScheduleAjax
     * @role  edit schedule into database
     * @param App\Http\Requests\Bus\Schedule\ScheduleUpdateRequest $request
     * @return Symfony\Component\HttpFoundation\JsonResponse
     */
    public function editScheduleAjax(ScheduleUpdateRequest $request)
    {
        $scheduleInfo = ScheduleModel::findOrfail($request->id);
        $status_code = $this->_scheduleService->updateSchedule($request,$scheduleInfo);

        if ($status_code==200) {
            return new JsonResponse([], $status_code);
        }else if($status_code==409){
            return new JsonResponse(['message' => "Coach can't be rescheduled wihtin 3 hrs!"], $status_code);
        }else {
            return new JsonResponse(['message' => 'Something went wrong!'], 500);
        }
    }

    /**
     * @name deleteScheduleAjax
     * @role  delete schedule from database
     * @param Illuminate\Http\Request $request
     * @return Symfony\Component\HttpFoundation\JsonResponse
     */
    public function deleteScheduleAjax(Request $request)
    {
        $schedule = ScheduleModel::findOrfail($request->id);
        $scheduleDeleteResponse = $schedule->delete();

        if ($scheduleDeleteResponse) {
            return new JsonResponse([], 204);
        } else {
            return new JsonResponse(['error' => 'Something went wrong!'], 500);
        }
    }

    /**
     * @name getSchedulesDataTableAjax
     * @role send datatable json for showing users
     * @param Request
     * @return  Datatable json
     *
     */
    public function getSchedulesDataTableAjax(Request $request)
    {
        $schedules = ScheduleModel::all();

        return Datatables::of($schedules)
            ->addIndexColumn()
            ->editColumn('coach_id', function ($schedule) {
                return $schedule->coach->bus_number;
            })
            ->editColumn('departure_date', function ($schedule) {
            $schedule->departure_date=date('d/m/Y', strtotime($schedule->departure_date));
                return $schedule->departure_date;
            })
            ->editColumn('departure_time', function ($schedule) {
                $schedule->departure_time = date('h:i A', strtotime($schedule->departure_time));
                return $schedule->departure_time;
            })
            ->addColumn('action', function ($schedule) {
                $updateUrl = url('bus/schedule-management/edit-schedule', [$schedule->id]);

                $markup = '';

                $markup .= ' <a href="' . $updateUrl . '" class="btn btn-sm btn-info"
                data-toggle="tooltip" data-placement="top" title="Edit Coaches"><i
                class="fa fa-pencil" aria-hidden="true"></i></a>';

                $markup .= ' <button class="btn btn-sm btn-danger" data-toggle="tooltip" data-placement="top" title="Delete"
                onclick="deleteSchedule(' . $schedule->id . ')"><i
                class="fa fa-trash-o" aria-hidden="true"></i></button>';


                return $markup;
            })
            ->rawColumns(['action'])
            ->make(true);
    }
}
