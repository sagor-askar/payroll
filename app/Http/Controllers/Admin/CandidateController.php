<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\Models\JobApplications;
use Illuminate\Http\Request;
use DB;
use Illuminate\Support\Facades\Response;


class CandidateController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $candidates = JobApplications::orderBy('job_id')->where('status',0)->paginate(20);
        return view('admin.candidates.index',compact('candidates'));
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $candidates = JobApplications::find($id);
        $role_title =auth()->user()->roles->first()->title;
        return view('admin.candidates.show',compact('candidates','role_title'));
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
        $candidates = JobApplications::find($id);

        $candidates->delete();

        return redirect()->route('admin.candidate.index')->with('message','Data Deleted Successfully !');
    }

    public function resumeDownload($id)
    {
        $candidates = JobApplications::find($id);
        $file= public_path()."/images/job-application/resume/$candidates->resume" ;
        $headers = array(
            'Content-Type: application/pdf',
        );
      return Response::download($file, 'resume.pdf', $headers);
    }

    public function resumeOpen($id)
    {
        $candidates = JobApplications::find($id);
        $file= public_path()."/images/job-application/resume/$candidates->resume" ;
        $headers = array(
            'Content-Type: application/pdf',
        );
        return response()->file($file, $headers);
    }


    public function coverLatterDownload($id)
    {
        $candidates = JobApplications::find($id);
        $file= public_path()."/images/job-application/cover-letter/$candidates->cover_letter" ;
        $headers = array(
            'Content-Type: application/pdf',
        );
        return Response::download($file, 'cover_letter.pdf', $headers);
    }

    public function coverLatterOpen($id)
    {
        $candidates = JobApplications::find($id);
        $file= public_path()."/images/job-application/cover-letter/$candidates->cover_letter" ;
        $headers = array(
            'Content-Type: application/pdf',
        );
        return response()->file($file, $headers);
    }

    public function createShortlist($id)
    {
        $candidates = JobApplications::find($id);
        $candidates->status = 1 ;
        $candidates->save();
        return redirect()->route('admin.candidate.index')->with('message', 'Candidate Shortlisted !');
    }
    public function candidateCancel($id)
    {
        $candidates = JobApplications::find($id);
        $candidates->delete();
        return redirect()->route('admin.candidate.index')->with('message', 'Cancel successfully');
    }





}
