<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\JobController;
use App\Models\Asset;
use App\Models\Conveyance;
use App\Models\ConveyanceItem;
use App\Models\Interview;
use App\Models\InterviewResult;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class InterviewController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $interview_result = InterviewResult::paginate(20);
        //dd($interview_result);

        return view('admin.interview.index', compact('interview_result'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $interview_result = InterviewResult::get();
        if (count($interview_result) > 0 ){
            foreach ($interview_result as $val){
                $cadidate_id[] = $val->candidate_id;
            }
            $candidates = Interview::whereNotIn('candidate_id',$cadidate_id)->get();
        }else{
            $candidates = Interview::get();
        }


        return view('admin.interview.create', compact('candidates'));
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
        $data['interview_date'] = Carbon::parse($request->interview_date)->format('Y-m-d');
        $interview_result = InterviewResult::create($data);
        return redirect()->route('admin.interview.index')->with('message', 'Successfully Data Generated !');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $interview_result = InterviewResult::find($id);
        return view('admin.interview.show', compact('interview_result'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $candidates = Interview::get();
        $interview_result = InterviewResult::with('candidate')->find($id);
        return view('admin.interview.edit', compact('interview_result', 'candidates'));
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
        $interview_result = InterviewResult::find($id);
        $data = $request->all();
        $interview_result->update($data);

        return redirect()->route('admin.interview.index')->with('message','Result Updated Successfully');;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $interview_result = InterviewResult::find($id);

        $interview_result->delete();
        return redirect()->route('admin.requisition.index')->with('message', 'Information Deleted Successfully');
    }
}
