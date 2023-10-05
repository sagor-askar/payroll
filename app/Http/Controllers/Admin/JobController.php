<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CustomQuestion;
use App\Models\Department;
use App\Models\Employee;
use App\Models\JobApplications;
use App\Models\JobsCreate;
use App\Models\Settings;

use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Gate;

class JobController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $jobs = JobsCreate::orderBy('id','DESC')->paginate(20);
        return view('admin.jobs.index',compact('jobs'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $role_title =auth()->user()->roles->first()->title;
        $departments = Department::pluck('department_name', 'id')->prepend(trans('global.pleaseSelect'), '');
        $questions = CustomQuestion::where('question_type','jobs')->orderBy('id','ASC')->get();
        return view('admin.jobs.create',compact('questions','departments','role_title'));
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
        $data['start_date'] = Carbon::parse($request->start_date)->format('Y-m-d');
        $data['end_date'] = Carbon::parse($request->end_date)->format('Y-m-d');
        $need_to_ask = $request->need_to_ask;
        $show_option = $request->need_to_show_option;
        $custom_question = $request->custom_question;
        $arrAsk = array();
        $incI = 0;
        foreach($need_to_ask AS $arrKey => $arrData){
            $arrAsk[$arrKey]  = $arrData;
            $incI++;
        }
        $data['need_to_ask'] = json_encode($arrAsk);
        $arrShowOption = array();
        $incI = 0;
        foreach($show_option AS $arrKey => $arrData){
            $arrShowOption[$arrKey]  = $arrData;
            $incI++;
        }
        $data['need_to_show_option'] = json_encode($arrShowOption);
        $arrCustom_question = array();
        $incI = 0;
        foreach($custom_question AS $arrKey => $arrData){
            $arrCustom_question[$arrKey] = $arrData;
            $incI++;
        }
        $data['custom_question'] = json_encode($arrCustom_question);
        $data['created_by'] =   Auth::user()->employee_id;
        JobsCreate::create($data);
        return redirect()->route('admin.jobs.index')->with('message','Data Created Successfully !');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $jobs = JobsCreate::find($id);
        $askarray =  json_decode($jobs->need_to_ask);
        $showOptionArray =  json_decode($jobs->need_to_show_option);
        $customArray =  json_decode($jobs->custom_question);
        $role_title =auth()->user()->roles->first()->title;
        return view('admin.jobs.show',compact('customArray','showOptionArray','askarray','jobs','role_title'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $jobs = JobsCreate::find($id);
        $askarray =  json_decode($jobs->need_to_ask);
        $showOptionArray =  json_decode($jobs->need_to_show_option);
        $customArray =  json_decode($jobs->custom_question);
        $role_title =auth()->user()->roles->first()->title;
        $questions = CustomQuestion::where('question_type','jobs')->orderBy('id','ASC')->get();
        $departments = Department::pluck('department_name', 'id')->prepend(trans('global.pleaseSelect'), '');
        return view('admin.jobs.edit',compact('showOptionArray','questions','customArray','askarray','jobs','departments','role_title'));
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
        $jobs = JobsCreate::find($id);
        $data = $request->all();
        $data['start_date'] = Carbon::parse($request->start_date)->format('Y-m-d');
        $data['end_date'] = Carbon::parse($request->end_date)->format('Y-m-d');
        $need_to_ask = $request->need_to_ask;
        $show_option = $request->need_to_show_option;
        $custom_question = $request->custom_question;
        if ($need_to_ask) {
            $arrAsk = array();
            $incI = 0;
            foreach ($need_to_ask as $arrKey => $arrData) {
                $arrAsk[$arrKey] = $arrData;
                $incI++;
            }
            $data['need_to_ask'] = json_encode($arrAsk);
        }

        if ($show_option) {
            $arrShowOption = array();
            $incI = 0;
            foreach ($show_option as $arrKey => $arrData) {
                $arrShowOption[$arrKey] = $arrData;
                $incI++;
            }
            $data['need_to_show_option'] = json_encode($arrShowOption);
        }
        if ($custom_question) {
            $arrCustom_question = array();
            $incI = 0;
            foreach ($custom_question as $arrKey => $arrData) {
                $arrCustom_question[$arrKey] = $arrData;
                $incI++;
            }
            $data['custom_question'] = json_encode($arrCustom_question);
        }
        $data['created_by'] =   Auth::user()->employee_id;
        $jobs->update($data);

        return redirect()->route('admin.jobs.index')->with('message','Data Updated Successfully !');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $jobs = JobsCreate::find($id);
        $jobs->delete();
        return redirect()->route('admin.jobs.index')->with('message','Data Deleted Successfully !');
    }


    public function jobApproved($id)
    {
        $jobs = JobsCreate::find($id);
        $jobs->approve_status = 1 ;
        $jobs->save();
        return redirect()->route('admin.jobs.index')->with('message', 'Approved successfully');
    }

    public function jobCancel($id)
    {
        $jobs = JobsCreate::find($id);
        $jobs->delete();
        return redirect()->route('admin.jobs.index')->with('message', 'Cancel successfully');
    }

    public function jobReject($id)
    {
        $jobs = JobsCreate::find($id);
        $jobs->approve_status = 2 ;
        $jobs->save();
        return redirect()->route('admin.jobs.index')->with('message', 'Rejected successfully');
    }

    public function circularactive($id)
    {
        $jobs = JobsCreate::find($id);
        $jobs->circulate_status = 1 ;
        $jobs->save();
        return redirect()->route('admin.jobs.index')->with('message', 'Circular Active Successfully');
    }

    public function circularInactive($id)
    {
        $jobs = JobsCreate::find($id);
        $jobs->circulate_status = 0 ;
        $jobs->save();
        return redirect()->route('admin.jobs.index')->with('message', 'Circular Inactive Successfully');
    }

    public function jobApply($id)
    {
        $jobs = JobsCreate::find($id);
        $askarray =  json_decode($jobs->need_to_ask);
        $showOptionArray =  json_decode($jobs->need_to_show_option);
        $role_title =auth()->user()->roles->first()->title;
        return view('admin.jobs.apply',compact('showOptionArray','askarray','jobs','role_title'));
    }

    public function jobApplyStore(Request $request)
    {
        $email = $request->email;
        $job_id = $request->job_id;
        $check_email = JobApplications::where('job_id',$job_id)->where('email',$email)->first();

        if($check_email != NULL){
            return redirect()->back()->with('error', 'You have already applied for this position!');
        }
        $data = $request->except('image','resume','cover_letter');
        $data['apply_date'] = Carbon::parse($request->apply_date)->format('Y-m-d');

        if($request->file('image')){
            $file=$request->file('image');
            $filename=date('YmdHi').$file->getClientOriginalName();
            $file->move(public_path('images/job-application/image/'),$filename);
            $data['image'] = $filename;
        }
        if($request->file('resume')){
            $file=$request->file('resume');
            $filename=date('YmdHi').$file->getClientOriginalName();
            $file->move(public_path('images/job-application/resume/'),$filename);
            $data['resume'] = $filename;
        }
        if($request->file('cover_letter')){
            $file=$request->file('cover_letter');
            $filename=date('YmdHi').$file->getClientOriginalName();
            $file->move(public_path('images/job-application/cover-letter/'),$filename);
            $data['cover_letter'] = $filename;
        }

        $data['dob'] = Carbon::parse($request->dob)->format('Y-m-d');
        $data['apply_date'] = Carbon::parse($request->apply_date)->format('Y-m-d');
        $candidates = JobApplications::create($data);


        // sending user credential via email
        $settings = Settings::first();
        $mail_data['name'] = $candidates->name;
        $mail_data['email'] = $candidates->email;
        $mail_data['job_title'] = $candidates->job->job_title;
        $mail_data['company_title'] = $settings->company_title;
        $mail_data['company_address'] = $settings->company_address;
        $mail_data['created_by'] = Auth::user()->name;
        $mail_data['role_title'] = auth()->user()->roles->first()->title;
        $message ='Candidate Interview Email Sent Successfully!';
                 try{

                     Mail::send( 'admin.emails.application_confirmation', $mail_data, function( $message ) use ($mail_data)
                     {
                         $message->to($mail_data['email'])->subject( 'Email From Polock Group' );
                     });
                 }
                 catch(\Exception $e){

                     $message = 'Mail Sending Failed!';
                 }


        return back()->with('message','Applied Successfully! Thank You.');
    }
}
