<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\Employee;
use App\Models\AdditionalAllowanceSetup;
use App\Models\AdditionalAllowanceDistribution;
use App\Models\Department;
use App\Models\Settings;
use App\Models\SubCompany;
use Gate;
use Symfony\Component\HttpFoundation\Response;
class AllowanceDistributionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        abort_if(Gate::denies('additional_allowance_distribution_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $allowanceDistribution = AdditionalAllowanceDistribution::paginate(20);
        return view('admin.allowanceDistribution.index', compact('allowanceDistribution'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        abort_if(Gate::denies('additional_allowance_distribution_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $employees = Employee::where('is_active',1)->get();
        $allowanceDistribution = AdditionalAllowanceDistribution::pluck('allowance', 'id');
        $allowance = AdditionalAllowanceSetup::where('status',1)->pluck('allowance_name','id');

        return view('admin.allowanceDistribution.create', compact('allowanceDistribution', 'employees', 'allowance'));
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
        $data['allowance_date'] = Carbon::parse($request->allowance_date)->format('Y-m-d');
        AdditionalAllowanceDistribution::create($data);
        return redirect()->route('admin.allowance-distribution.index')->with('message','Distribution Successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        abort_if(Gate::denies('additional_allowance_distribution_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $allowanceDistributionSetup = AdditionalAllowanceDistribution::find($id);
        return view('admin.allowanceDistribution.show',compact('allowanceDistributionSetup'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        abort_if(Gate::denies('additional_allowance_distribution_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $allowanceDistributionSetup = AdditionalAllowanceDistribution::find($id);
        $employees = Employee::where('is_active',1)->get();
        $allowance = AdditionalAllowanceSetup::pluck('allowance_name','id');
        return view('admin.allowanceDistribution.edit', compact('allowanceDistributionSetup', 'employees', 'allowance'));
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
        $data = $request->all();
        $data['allowance_date'] = Carbon::parse($request->allowance_date)->format('Y-m-d');
        $allowanceDistributionSetup = AdditionalAllowanceDistribution::find($id);
        $allowanceDistributionSetup->update($data);
        return redirect()->route('admin.allowance-distribution.index')->with('message','Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        abort_if(Gate::denies('additional_allowance_distribution_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $allowanceDistributionSetup = AdditionalAllowanceDistribution::find($id);
        $allowanceDistributionSetup->delete();
        return back();
    }

    public function allowanceDistirbutionReport()
    {
        $employees = Employee::where('is_active',1)->get();
        $allowance = AdditionalAllowanceSetup::pluck('allowance_name','id');
        $departments = Department::pluck('department_name', 'id');
        $sub_companies = SubCompany::pluck('sub_company_name', 'id');
        $additional_allowance_distribution = [];

        return view('admin.allowanceDistribution.report', compact('additional_allowance_distribution','employees', 'allowance', 'departments', 'sub_companies'));
    }

    public function allowanceDistributionSearch(Request $request)
    {
        $data = $request->all();
        $employee_id = $request->employee_id;
        $start = Carbon::parse($request->start_date)->format('Y-m-d');
        $end = Carbon::parse($request->end_date)->format('Y-m-d');
        $additional_allowance_setup_id = $request->additional_allowance_setup_id;

        $query = new AdditionalAllowanceDistribution();
        if($employee_id)
        {
            $query =  $query->where('employee_id',$employee_id);
        }
        if($additional_allowance_setup_id)
        {
            $query =  $query->where('additional_allowance_setup_id',$additional_allowance_setup_id);
        }
        if($request->start_date != null && $request->end_date != null)
        {
            $query =  $query->where('allowance_date','>=',$start)->where('allowance_date','<=',$end);
        }
        $additional_allowance_distribution = $query->get();
        $employees = Employee::where('is_active',1)->get();
        $allowance = AdditionalAllowanceSetup::pluck('allowance_name','id');
        $departments = Department::pluck('department_name', 'id');
        $sub_companies = SubCompany::pluck('sub_company_name', 'id');
        $setting = Settings::first();
        return view('admin.allowanceDistribution.report', compact('additional_allowance_distribution','employees', 'allowance', 'departments', 'sub_companies','setting'));

    }

}
