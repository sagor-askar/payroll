<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\Employee;
use App\Models\AdditionalDeductionSetup;
use App\Models\AdditionalDeductionPenalty;
use App\Models\AdditionalAllowanceSetup;
use App\Models\Department;
use App\Models\Settings;
use App\Models\SubCompany;
use Gate;
use Symfony\Component\HttpFoundation\Response;

class DeductionPenaltiesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        abort_if(Gate::denies('additional_deduction_distribution_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $deductionPenalties = AdditionalDeductionPenalty::paginate(20);

        return view('admin.deductionPenalties.index', compact('deductionPenalties'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        abort_if(Gate::denies('additional_deduction_distribution_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $employees = Employee::where('is_active',1)->get();
        $deduction = AdditionalDeductionSetup::where('status',1)->pluck('deduction_name','id');
        return view('admin.deductionPenalties.create', compact('employees','deduction'));
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
        $data['deduction_date'] = Carbon::parse($request->deduction_date)->format('Y-m-d');
        AdditionalDeductionPenalty::create($data);
        return redirect()->route('admin.deduction-penalties.index')->with('message','Distribution Successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        abort_if(Gate::denies('additional_deduction_distribution_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $deductionPenaltiesSetup = AdditionalDeductionPenalty::find($id);
        return view('admin.deductionPenalties.show', compact('deductionPenaltiesSetup'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        abort_if(Gate::denies('additional_deduction_distribution_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $deductionPenaltiesSetup = AdditionalDeductionPenalty::find($id);
        $employees = Employee::where('is_active',1)->get();
        $deduction = AdditionalDeductionSetup::pluck('deduction_name','id');
        return view('admin.deductionPenalties.edit', compact('deductionPenaltiesSetup', 'employees', 'deduction'));
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
        $data['deduction_date'] = Carbon::parse($request->deduction_date)->format('Y-m-d');
        $deductionPenaltiesSetup = AdditionalDeductionPenalty::find($id);
        $deductionPenaltiesSetup->update($data);
        return redirect()->route('admin.deduction-penalties.index')->with('message','Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        abort_if(Gate::denies('additional_deduction_distribution_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $deductionPenaltiesSetup = AdditionalDeductionPenalty::find($id);
        $deductionPenaltiesSetup->delete();
        return back();
    }

    public function deductionDistributionReport()
    {
        $employees = Employee::where('is_active',1)->get();
        $deduction = AdditionalDeductionSetup::pluck('deduction_name','id');
        $departments = Department::pluck('department_name', 'id');
        $additional_deduction_distribution = [];
        return view('admin.deductionPenalties.report', compact('additional_deduction_distribution','employees', 'deduction', 'departments'));
    }

    public function deductionDistributionReportSearch(Request $request)
    {

        $data = $request->all();
        $employee_id = $request->employee_id;
        $start = Carbon::parse($request->start_date)->format('Y-m-d');
        $end = Carbon::parse($request->end_date)->format('Y-m-d');
        $additional_deduction_setup_id = $request->additional_deduction_setup_id;
        $query = new AdditionalDeductionPenalty();
        if($employee_id)
        {
            $query =  $query->where('employee_id',$employee_id);
        }
        if($additional_deduction_setup_id)
        {
            $query =  $query->where('additional_deduction_setup_id',$additional_deduction_setup_id);
        }
        if($request->start_date != null && $request->end_date != null)
        {
            $query =  $query->where('deduction_date','>=',$start)->where('deduction_date','<=',$end);
        }
        $additional_deduction_distribution = $query->get();


        $employees = Employee::get();
        $deduction = AdditionalDeductionSetup::pluck('deduction_name','id');
        $departments = Department::pluck('department_name', 'id');
        $setting = Settings::first();
        return view('admin.deductionPenalties.report', compact('additional_deduction_distribution','employees', 'deduction', 'departments','setting'));
    }
}
