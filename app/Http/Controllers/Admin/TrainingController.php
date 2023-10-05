<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use App\Models\Settings;
use App\Models\Trainer;
use App\Models\Training;
use App\Models\TrainingSkill;
use App\Models\TrainingType;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Mail;

class TrainingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $employees = Employee::where('is_active',1)->get();
        $trainings = Training::with(['trainer', 'training_type', 'employee', 'trainingSkill'])->paginate(20);

        return view('admin.training.index', compact('trainings','employees'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $trainers = Trainer::where('status',1)->get();
        $trainer_skills = TrainingSkill::where('status',1)->get();
        $trainer_types = TrainingType::where('status',1)->get();
        return view('admin.training.create', compact('trainers','trainer_skills','trainer_types'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data =  $request->all();
        $data['start_date'] = Carbon::parse($request->start_date)->format('Y-m-d');
        $data['end_date'] = Carbon::parse($request->end_date)->format('Y-m-d');
        Training::create($data);

        return redirect()->route('admin.training.index')->with('message', 'Training Data Store successfully ');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $training = Training::with(['trainer', 'training_type', 'employee', 'trainingSkill'])->where('id',$id)->first();
        return view('admin.training.show', compact('training'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $training = Training::with(['trainer', 'training_type', 'employee', 'trainingSkill'])->where('id',$id)->first();
        
        $employees = Employee::where('is_active',1)->get();
        $trainers = Trainer::where('status',1)->get();
        $trainer_skills = TrainingSkill::where('status',1)->get();
        $trainer_types = TrainingType::where('status',1)->get();
        

        return view('admin.training.edit', compact('training','employees','trainers','trainer_skills','trainer_types'));
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
        $training = Training::where('id',$id)->first();
        $data =  $request->all();
        $data['employee_id'] = json_encode($data['employee_id']);
        $data['start_date'] = Carbon::parse($request->start_date)->format('Y-m-d');
        $data['end_date'] = Carbon::parse($request->end_date)->format('Y-m-d');
        $training->update($data);

        $employees = json_decode($data['employee_id']);

        foreach($employees as $val){
            $employees = Employee::find($val);
            $data = ['name' => "Payroll Email", 'data' => "Email From Payroll"];
            $user['to'] = $employees->email;
           // Mail::send('admin.training.mail', $data, function($messages) use ($user) {
               // $messages->to($user['to']);
               // $messages->subject('Confirmation Email');
           // });

        }


        return redirect()->route('admin.training.index')->with('message', 'Training Data Update successfully ');
    }


    public function employeeStore(Request $request)
    {
        $training = Training::where('id',$request->training_id)->first();
        $data =  $request->all();
        $data['employee_id'] = json_encode($data['employee_id']);
        $training->update($data);
        return redirect()->route('admin.training.index')->with('message','Employee Added Successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        $training = Training::find($id);
        $training->delete();
        return redirect()->route('admin.training.index')->with('message','Training Data Deleted Successfully');
    }

    public function massDestroy(Request $request)
    {
        Training::whereIn('id', request('ids'))->delete();
        return response(null, Response::HTTP_NO_CONTENT);
    }



    public function updateStatus(Request $request, $id)
    {

        $training = Training::where('id',$id)->first();
        $data =  $request->all();
        $training->update($data);
        return redirect()->route('admin.training.index')->with('message', 'Training Data Update successfully ');
    }


    public function trainingReport()
    {
        $trainers = Trainer::where('status',1)->get();
        $employees = Employee::where('is_active',1)->get();
        $trainingReportsHistory = [];
        return view('admin.reports.training_report', compact('trainers', 'employees', 'trainingReportsHistory'));
    }


    public function trainingReportSearch(Request $request)
    {

        $employee_id  = $request->employee_id;
        $trainer_id  = $request->trainer_id;
        $status  = $request->status;
        $start_date = Carbon::parse($request->start_date)->format('Y-m-d');
        $end_date = Carbon::parse($request->end_date)->format('Y-m-d');

        $trainings = Training::query();
        if($employee_id != null){
            $trainings = $trainings->where('employee_id',$employee_id);
        }

        if($trainer_id != null){
            $trainings = $trainings->where('trainer_id',$trainer_id);
        }

        if($request->start_date != null){
            $trainings =  $trainings->where('start_date','>=',$start_date);
        }
        if($request->end_date != null){
            $trainings = $trainings->where('end_date','<=',$end_date);
        }
        if($status != null){
            $trainings =$trainings->where('status',$status);
        }
        $trainingReportsHistory = $trainings->get();
        $setting = Settings::first();
        return view ('admin.reports.training_table',[
            'trainingReportsHistory' => $trainingReportsHistory,
            'setting'          => $setting,
        ]);
    }


}
