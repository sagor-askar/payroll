<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Imports\RosterImport;
use App\Models\Roster;

use App\Models\Employee;
use App\Models\SubCompany;
use App\Models\Department;
use App\Models\Branch;

use Illuminate\Http\Request;
use Gate;
use Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth as FacadesAuth;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class RosterController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        abort_if(Gate::denies('roster_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $rosters = Roster::paginate(20);

        return view('admin.roster.index', compact('rosters'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        abort_if(Gate::denies('roster_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $employees = Employee::where('is_active',1)->where('attendance_type','roster')->get();
        $sub_companies = SubCompany::get();
        $branch = Branch::get();

        $start = Carbon::parse(Carbon::now()->startOfMonth())->format('Y-m-d');
        $end = Carbon::parse(Carbon::now()->endOfMonth())->format('Y-m-d');
        $start_date = Carbon::parse($start);
        $end_date = Carbon::parse($end);
        $dates = [];
        while ($start_date->lte($end_date)) {
            $dates[] = $start_date->copy();
            $start_date->addDay();
        }

        $employeeData = [];

        return view('admin.roster.create', compact('dates','employees', 'sub_companies', 'branch', 'employeeData'));
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
          $start_times = $request->start_time;
          foreach($start_times as $key=> $val){
               if($val != null){
                 $validTimes[] = $val;
               }
          }
          if(count($validTimes)> 0){
          for ( $i = 0; $i < count($validTimes); $i++) {
            $start_time = strtotime($validTimes[$i]);
            $start_time = date('H:i:s', $start_time);

            $end_time = strtotime($request->end_time[$i]);
            $end_time = date('H:i:s', $end_time);

            $roster = new Roster();
            $roster->employee_id = $request->employee_id;
            $roster->duty_date = Carbon::parse($request->date[$i])->format('Y-m-d');
            $roster->start_time = $start_time;
            $roster->end_time = $end_time;
            $roster->save();
        }
    }

        // try{
        //     DB::beginTransaction();

        //     $request->validate([
        //         'csv_file'=> 'required|mimes:xlsx, csv, xls'
        //      ]);

        //      Excel::import(new RosterImport, $request->csv_file);
        //     DB::commit();
        //     return redirect()->route('admin.rosters.index');
        // }catch(\Exception $e){
        //     DB::rollBack();
        //     return redirect()->route('admin.rosters.index', compact('employees', 'departments'))->with('error',$e->getMessage());
        // }

        return redirect()->route('admin.rosters.index');


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
    public function download()
    {
        $file= public_path(). "/download/sample.xlsx";

        return response()->download($file);
    }

    public function search(Request $request)
    {
        $employee_id = $request->employee_id;
        $department_id = $request->department_id;
        $branch_id = $request->branch_id;
        $date = $request->date;
        $start = Carbon::parse($date)->format('Y-m');
        $start_date  = $start.'-01';
        $end_date  = $start.'-31';
        $query = new Employee();

        if($employee_id){
           $query = $query->where('is_active',1)->where('id', $employee_id);
        }
        if($department_id){
            $query = $query->where('is_active',1)->where('department_id', $department_id);
        }
        if($branch_id){
            $branch = Branch::find($branch_id);
             $company_id = $branch->company_id;
             $sub_company_id  = $branch->sub_company_id;
            $query = $query->where('is_active',1)->where('company_id',$company_id)->where('sub_company_id', $sub_company_id);
        }

        $searchData =  $query->where('attendance_type','Roster')->get();

          if (count($searchData) > 0 ) {
            foreach ($searchData as $val) {
                $emp_id[] = $val->id;
            }

            $roster_employeeData = Roster::whereIn('employee_id', $emp_id)->where('duty_date','>=', $start_date)->where('duty_date','<=', $end_date)->get();


            if (count($roster_employeeData) > 0) {

                foreach ($roster_employeeData as $val) {

                    $em_id[] = $val->employee_id;
                }
                $employeeData = $query->where('is_active',1)->whereNotIn('id', $em_id)->where('attendance_type','Roster')->get();

            } else {
                $employeeData = $query->where('is_active',1)->where('attendance_type','Roster')->get();
            }
        }else{
            $employeeData=[];
        }


         if(count($employeeData) < 1 ){
            return redirect()->route('admin.rosters.index')->with('message', 'Oops ! Already Exits Or No Data Found .');
         }



        $employees = Employee::where('is_active',1)->where('attendance_type','roster')->get();
        $sub_companies = SubCompany::get();
        $branch = Branch::get();

        $start = Carbon::parse(Carbon::now()->startOfMonth())->format('Y-m-d');
        $end = Carbon::parse(Carbon::now()->endOfMonth())->format('Y-m-d');
        $start_date = Carbon::parse($start);
        $end_date = Carbon::parse($end);
        $dates = [];
        while ($start_date->lte($end_date)) {
            $dates[] = $start_date->copy();
            $start_date->addDay();
        }

        return view('admin.roster.create', compact('dates','employees', 'sub_companies', 'branch', 'employeeData'));

    }
}
