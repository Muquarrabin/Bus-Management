<?php

namespace App\Http\Controllers\Bus;

use App\Http\Controllers\Controller;
use App\Http\Requests\Bus\Coach\CoachInsertRequest;
use App\Http\Requests\Bus\Coach\CoachUpdateRequest;
use Illuminate\Http\Request;
use App\Http\Services\Bus\CoachService;
use App\Models\Bus\CoachModel;
use Symfony\Component\HttpFoundation\JsonResponse;
use Yajra\DataTables\DataTables;

class CoachManagementController extends Controller
{
    private $_coachService;

    public function __construct(CoachService $coachService)
    {
        $this->_coachService = $coachService;
    }

    /**
     * @name addCoachView
     * @role load add coach view
     * @param null
     * @return view('admin.pages.bus.coach.addCoach')
     */
    public function addCoachView()
    {
        return view('admin.pages.bus.coach.addCoach');
    }

    /**
     * @name editCoachView
     * @role load edit coach view
     * @param Illuminate\Http\Request $request
     * @return view('admin.pages.bus.coach.editCoach')
     */
    public function editCoachView(Request $request)
    {
        $coach = CoachModel::findOrFail($request->id);
        $data = [
            'coach' => $coach
        ];
        // dd($data);
        return view('admin.pages.bus.coach.editCoach', $data);
    }

    /**
     * @name coachDetalisView
     * @role load  coach details view
     * @param null
     * @return view('admin.pages.bus.coach.coachDetails')
     */
    public function coachDetalisView()
    {

        return view('admin.pages.bus.coach.coachDetails');
    }

    /**
     * @name addCoachAjax
     * @role  add coach into database
     * @param App\Http\Requests\Bus\Coach\CoachInsertRequest $request
     * @return Symfony\Component\HttpFoundation\JsonResponse
     */
    public function addCoachAjax(CoachInsertRequest $request)
    {
        $status_code = $this->_coachService->insertCoach($request);

        if ($status_code == 201) {
            return new JsonResponse([], $status_code);
        }
        return new JsonResponse(['error' => 'Something went wrong!'], 500);
    }

    /**
     * @name editCoachAjax
     * @role  edit coach into database
     * @param App\Http\Requests\Bus\Coach\CoachUpdateRequest $request
     * @return Symfony\Component\HttpFoundation\JsonResponse
     */
    public function editCoachAjax(CoachUpdateRequest $request)
    {
        $coachInfo = CoachModel::findOrfail($request->id);
        $coachUpdateResponseCode = $this->_coachService->updateCoach($request, $coachInfo);

        if ($coachUpdateResponseCode == 200) {
            return new JsonResponse([], $coachUpdateResponseCode);
        }
        return new JsonResponse(['error' => 'Something went wrong!'], 500);
    }

    /**
     * @name deleteCoachAjax
     * @role  delete coach from database
     * @param Illuminate\Http\Request $request
     * @return Symfony\Component\HttpFoundation\JsonResponse
     */
    public function deleteCoachAjax(Request $request)
    {
        $coachInfo = CoachModel::findOrfail($request->id);
        $coachDeleteResponse = $coachInfo->delete();

        if ($coachDeleteResponse) {
            return new JsonResponse([], 204);
        } else {
            return new JsonResponse(['error' => 'Something went wrong!'], 500);
        }
    }

    /**
     * @name getCoachesDataTableAjax
     * @role send datatable json for showing users
     * @param Request
     * @return  Datatable json
     *
     */
    public function getCoachesDataTableAjax(Request $request)
    {
        $coaches = CoachModel::all();

        return Datatables::of($coaches)
            ->addIndexColumn()

            ->addColumn('action', function ($coach) {
                $updateUrl = url('bus/coach-management/edit-coach', [$coach->id]);

                $markup = '';

                $markup .= ' <a href="' . $updateUrl . '" class="btn btn-sm btn-info"
                data-toggle="tooltip" data-placement="top" title="Edit Coaches"><i
                class="fa fa-pencil" aria-hidden="true"></i></a>';

                $markup .= ' <button class="btn btn-sm btn-danger" data-toggle="tooltip" data-placement="top" title="Delete"
                onclick="deleteCoach(' . $coach->id . ')"><i
                class="fa fa-trash-o" aria-hidden="true"></i></button>';


                return $markup;
            })
            ->rawColumns(['action'])
            ->make(true);
    }
}
