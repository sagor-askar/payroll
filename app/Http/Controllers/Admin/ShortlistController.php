<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Interview;
use App\Models\JobApplications;
use App\Models\Settings;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;

class ShortlistController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $candidates = JobApplications::orderBy('job_id')->where('status',1)->paginate(20);
        $role_title =auth()->user()->roles->first()->title;
        return view('admin.shortlist.index',compact('role_title','candidates'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      $data =$request->all();
      $data['interview_date'] = Carbon::parse($request->interview_date)->format('Y-m-d');
      $interview_time = strtotime($request->interview_time);
      $data['interview_time'] = date('H:i:s', $interview_time);
      Interview::create($data);
      $candidates = JobApplications::find($request->candidate_id);
      $candidates->status = 2;
      $candidates->save() ;

        // sending user credential via email
        $settings = Settings::first();
        $mail_data['name'] = $candidates->name;
        $mail_data['email'] = $candidates->email;
        $mail_data['job_title'] = $candidates->job->job_title;
        $mail_data['interview_time'] = $data['interview_time'];
        $mail_data['interview_date'] = $data['interview_date'];
        $mail_data['comment'] = strip_tags( $data['comment']);
        $mail_data['company_title'] = $settings->company_title;
        $mail_data['company_address'] = $settings->company_address;
        $mail_data['developed_by'] = $settings->developed_by;
        $mail_data['created_by'] = Auth::user()->name;
        $mail_data['role_title'] = auth()->user()->roles->first()->title;
        $message ='Candidate Interview Email Sent Successfully!';
                 try{

                     Mail::send( 'admin.emails.interviewEmail', $mail_data, function( $message ) use ($mail_data)
                     {
                         $message->to($mail_data['email'])->subject( 'Email From Polock Group' );
                     });
                 }
                 catch(\Exception $e){

                     $message = 'Mail Sending Failed!';
                 }


     return redirect()->route('admin.shortlist.index')->with('message', 'Candidate selected for Interview Successfully !');;

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function createInterview($id)
    {
        $candidates = JobApplications::find($id);
        $role_title =auth()->user()->roles->first()->title;
        return view('admin.shortlist.create',compact('candidates','role_title'));

    }

    public function createcancel($id)
    {
        $candidates = JobApplications::find($id);
        $candidates->delete();
        return redirect()->route('admin.shortlist.index')->with('message', 'Cancel successfully');
    }

}
