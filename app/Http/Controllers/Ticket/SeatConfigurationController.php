<?php

namespace App\Http\Controllers\Ticket;

use App\Http\Controllers\Controller;
use App\Http\Requests\Ticket\SeatConfig\SeatConfigInsertRequest;
use App\Http\Requests\Ticket\SeatConfig\SeatConfigUpdateRequest;
use Illuminate\Http\Request;
use App\Models\Bus\CoachModel;
use App\Http\Services\Ticket\SeatConfigService;
use App\Models\Ticket\SeatConfigModel;
use Symfony\Component\HttpFoundation\JsonResponse;
use Yajra\DataTables\DataTables;


class SeatConfigurationController extends Controller
{
    private $_seatConfigService;

    public function __construct(SeatConfigService $seatConfigService)
    {
        $this->_seatConfigService = $seatConfigService;
    }

    /**
     * @name addSeatConfigView
     * @role add seat config view
     * @param null
     * @return view('admin.pages.ticket.seatConfiguration.addSeatConfiguration')
     */
    public function addSeatConfigView()
    {
        $coaches = CoachModel::all();
        $data = [
            'coaches' => $coaches
        ];
        return view('admin.pages.ticket.seatConfiguration.addSeatConfiguration',$data);
    }

    /**
     * @name editSeatConfigView
     * @role load edit schedule view
     * @param Illuminate\Http\Request $request
     * @return view('admin.pages.ticket.seatConfiguration.editSeatConfiguration')
     */
    public function editSeatConfigView(Request $request)
    {
        $coaches = CoachModel::all();
        $seat_config = SeatConfigModel::findOrFail($request->id);

        $data=[
            'coaches'=>$coaches,
            'seat_config'=>$seat_config
        ];
        // dd($data);
        return view('admin.pages.ticket.seatConfiguration.editSeatConfiguration', $data);
    }
    /**
     * @name seatConfigDetailsView
     * @role load  seat config details view
     * @param null
     * @return view('admin.pages.ticket.seatConfiguration.seatConfigurationDetails')
     */
    public function seatConfigDetailsView()
    {

        return view('admin.pages.ticket.seatConfiguration.seatConfigurationDetails');
    }

    /**
     * @name addSeatConfigAjax
     * @role  add seat config into database
     * @param App\Http\Requests\Ticket\SeatConfig\SeatConfigInsertRequest $request
     * @return Symfony\Component\HttpFoundation\JsonResponse
     */
    public function addSeatConfigAjax(SeatConfigInsertRequest $request)
    {
        $status_code = $this->_seatConfigService->insertSeatConfig($request);

        if ($status_code==201) {
            return new JsonResponse([], $status_code);
        }else {
            return new JsonResponse(['message' => 'Something went wrong!'], 500);
        }
    }
     /**
     * @name editSeatConfigAjax
     * @role  edit seat config into database
     * @param App\Http\Requests\Ticket\SeatConfig\SeatConfigUpdateRequest $request
     * @return Symfony\Component\HttpFoundation\JsonResponse
     */
    public function editSeatConfigAjax(SeatConfigUpdateRequest $request)
    {
        $seatConfigInfo = SeatConfigModel::findOrfail($request->id);
        $seatConfigUpdateResponseCode = $this->_seatConfigService->updateSeatConfig($request, $seatConfigInfo);

        if ($seatConfigUpdateResponseCode == 200) {
            return new JsonResponse([], $seatConfigUpdateResponseCode);
        }
        return new JsonResponse(['error' => 'Something went wrong!'], 500);
    }

    /**
     * @name getSeatConfigDatatableAjax
     * @role send datatable json for showing users
     * @param Request
     * @return  Datatable json
     *
     */
    public function getSeatConfigDatatableAjax(Request $request)
    {
        $seat_cofigs = SeatConfigModel::all();

        return Datatables::of($seat_cofigs)
            ->addIndexColumn()
            ->editColumn('coach_id', function ($seat_cofig) {
                $bus_details=$seat_cofig->coach->bus_number.' ('.$seat_cofig->coach->coach_type.')';
                return $bus_details;
            })
            ->editColumn('seat_type', function ($seat_cofig) {
                $seat_type="";
                if($seat_cofig->seat_type==1){
                    $seat_type="Economy Class(2 by 2)";
                }
                if($seat_cofig->seat_type==2){
                    $seat_type="Business Class(1 by 2)";
                }

                return $seat_type;
            })
            ->addColumn('action', function ($seat_cofig) {
                $updateUrl = url('/ticket/seat-configuration/edit-seat-configuration', [$seat_cofig->id]);

                $markup = '';

                $markup .= ' <a href="' . $updateUrl . '" class="btn btn-sm btn-info"
                data-toggle="tooltip" data-placement="top" title="Edit Coaches"><i
                class="fa fa-pencil" aria-hidden="true"></i></a>';

                $markup .= ' <button class="btn btn-sm btn-danger" data-toggle="tooltip" data-placement="top" title="Delete"
                onclick="deleteSeatConfig(' . $seat_cofig->id . ')"><i
                class="fa fa-trash-o" aria-hidden="true"></i></button>';


                return $markup;
            })
            ->rawColumns(['action'])
            ->make(true);
    }
    /**
     * @name deleteSeatConfigAjax
     * @role  delete seat config from database
     * @param Illuminate\Http\Request $request
     * @return Symfony\Component\HttpFoundation\JsonResponse
     */
    public function deleteSeatConfigAjax(Request $request)
    {
        $seat_cofig = SeatConfigModel::findOrfail($request->id);
        $seatConfigDeleteResponse = $seat_cofig->delete();

        if ($seatConfigDeleteResponse) {
            return new JsonResponse([], 204);
        } else {
            return new JsonResponse(['error' => 'Something went wrong!'], 500);
        }
    }
}
