<?php

namespace App\Http\Controllers\Admin;

use App\Models\Bonus;
use App\Models\Employee;
use App\Models\Department;
use App\Models\Rule;
use App\Models\SubCompany;
use Carbon\Carbon;
use Auth;
use Gate;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth as FacadesAuth;
use Illuminate\Support\Facades\DB;

class BonusController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        abort_if(Gate::denies('bonus_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $bonusSalaryList  = Bonus::with(['employee','user'])->orderBy('id','DESC')->paginate(20);

        return view('admin.bonus.index',compact('bonusSalaryList'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $sub_companies = SubCompany::get();
        $departments = Department::get();
        $oneYearAgoDate = Carbon::parse(Carbon::now()->subYear())->format('Y-m-d');
        $employees = Employee::where('is_active',1)->where('joining_date','<=',$oneYearAgoDate)->get();
        $employeeData = [];
        return view('admin.bonus.create', compact('employeeData','employees', 'departments', 'sub_companies'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try{
            DB::beginTransaction();
            foreach($request->employee_id as $key => $value){
                 $bonus                            =  new Bonus();
                 $bonus->bonus_date               =  Carbon::parse($request->bonus_date[$key])->format('Y-m-d');
                 $bonus->employee_id              =  $request->employee_id[$key];
                 $bonus->bonus_name               =  $request->bonus_name[$key];
                 $bonus->bonus_percentage         =  $request->bonus_percentage[$key];
                 $bonus->amount                   =  $request->amount[$key];
                 $bonus->created_by               =  Auth::user()->id;
                 $bonus->save();
            }
            DB::commit();
            return redirect()->route('admin.bonus.index')->with('message', 'Bonus Generated successfully');
        }catch(\Exception $e){
            DB::rollBack();
            return redirect()->route('admin.bonus.index')->with('error', $e->getMessage());
        }

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

    public function bonusSearch(Request $request)
    {

        $bonus_name = $request->bonus_name;
        $percentage = $request->percentage;
        $bonus_date = $request->date;
        $employee_id =$request->employee_id;
        $sub_company_id =$request->sub_company_id;
        $department_id =$request->department_id;
        $date = Carbon::parse($request->date)->format('Y-m');
        $start_date = $date.'-01';
        $end_date = $date.'-31';
        $promotion_rules = Rule::where('type','like','%'.'bonus'.'%')->first();
        if ($promotion_rules == null){
            return redirect()->route('admin.bonus.index')->with('error','Oops ! Please Setup a Rule First !.');
        }
        $bonusPeriod_month = $promotion_rules->period;
        $oneYearAgoDate = Carbon::parse(Carbon::now()->subMonths($bonusPeriod_month))->format('Y-m-d');
        $query = new Employee();
        if($employee_id)
        {
            $query =  $query->where('id',$employee_id);
        }
        if($department_id)
        {
            $query =  $query->where('department_id',$department_id);
        }
        if($sub_company_id)
        {
            $query =  $query->where('sub_company_id',$sub_company_id);
        }
        $searchData = $query->where('is_active',1)->where('joining_date','<=',$oneYearAgoDate)->get();

         if (count($searchData) > 0 ) {
             foreach ($searchData as $val) {
                 $emp_id[] = $val->id;
             }
             $bonus_employeeData = Bonus::whereIn('employee_id', $emp_id)->where('bonus_date','>=', $start_date)->where('bonus_date','<=', $end_date)->get();

             if (count($bonus_employeeData) > 0) {
                 foreach ($bonus_employeeData as $val) {
                     $employee_id[] = $val->employee_id;
                 }
                 $employeeData = $query->where('is_active',1)->whereNotIn('id', $employee_id)->where('joining_date', '<=', $oneYearAgoDate)->get();
             } else {
                 $employeeData = $query->where('is_active',1)->where('joining_date', '<=', $oneYearAgoDate)->get();
             }
         }else{
             $employeeData=[];
         }
         if (count($employeeData) < 1){
             return redirect()->route('admin.bonus.index')->with('error', 'Oops ! Already Exits Or No Data Found.');
         }
        $sub_companies = SubCompany::get();
        $departments = Department::get();
        $oneYearAgoDate = Carbon::parse(Carbon::now()->subYear())->format('Y-m-d');
        $employees = Employee::where('is_active',1)->where('joining_date','<=',$oneYearAgoDate)->get();
        return view('admin.bonus.create', compact(  'bonus_name','bonus_date','percentage','employeeData','employees', 'departments', 'sub_companies'));
    }


}
