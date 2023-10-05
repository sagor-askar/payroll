<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\AppointmentChecklist;
use App\Models\InterviewResult;
use Illuminate\Http\Request;

class AppointmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $appointments =Appointment::paginate(20);
        return view('admin.appointment.index', compact('appointments'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $interview_result = InterviewResult::get();
        $checklist= AppointmentChecklist::get();
        return view('admin.appointment.create', compact('interview_result','checklist'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->all();
        $checklist_documents = $request->appointment_checklist;
        $arrCustom_question = array();
        $incI = 0;
        foreach($checklist_documents AS $arrKey => $arrData){
            $arrCustom_question[$arrKey] = $arrData;
            $incI++;
        }
        $data['appointment_checklist_id'] = json_encode($arrCustom_question);
        Appointment::create($data);
        return redirect()->route('admin.appointment.index')->with('message','Appointment documents create successfully !');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $appointment = Appointment::find($id);
        $appointment_documents =  json_decode($appointment->appointment_checklist_id);
        return view('admin.appointment.show',compact('appointment_documents','appointment'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $appointment = Appointment::find($id);
        $appointment_documents =  json_decode($appointment->appointment_checklist_id);
        $role_title =auth()->user()->roles->first()->title;
        $interview_result = InterviewResult::get();
        $checklist= AppointmentChecklist::get();
        return view('admin.appointment.edit',compact('appointment','appointment_documents','interview_result','checklist','role_title'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        $appointment = Appointment::find($id);
        $data = $request->all();
        $checklist_documents = $request->appointment_checklist;
        if ($checklist_documents) {
            $arrCustom_question = array();
            $incI = 0;
            foreach ($checklist_documents as $arrKey => $arrData) {
                $arrCustom_question[$arrKey] = $arrData;
                $incI++;
            }
            $data['confirm_appointment_checklist_id'] = json_encode($arrCustom_question);
        }

        $appointment->update($data);
        return redirect()->route('admin.appointment.index')->with('message','Appointment documents update successfully !');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $jobs = Appointment::find($id);
        $jobs->delete();
        return redirect()->route('admin.appointment.index')->with('message','Data Deleted Successfully !');
    }
}
