<?php

namespace App\Http\Controllers\Bus;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Services\Bus\CoachService;
use Symfony\Component\HttpFoundation\JsonResponse;

class CoachManagementController extends Controller
{
    private $_coachService;
    public function __construct(CoachService $coachService)
    {
        $this->_coachService=$coachService;
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
     * @param null
     * @return view('admin.pages.bus.coach.editCoach')
     */
    public function editCoachView()
    {
        return view('admin.pages.bus.coach.editCoach');
    }

    /**
     * @name addCoachAjax
     * @role  add coach into database
     * @param \Illuminate\Http\Request $request
     * @return Symfony\Component\HttpFoundation\JsonResponse
     */
    public function addCoachAjax(Request $request)
    {
        $this->_coachService->validateCoachInsert($request);

        $coachInfo=$this->_coachService->insertCoach($request);

        if($coachInfo){
            return new JsonResponse([],201);
        }
        else{
            return new JsonResponse(['error' => 'Something went wrong!'], 500);
        }
    }
}
