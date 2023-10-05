<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroySalaryAllowanceRequest;
use App\Http\Requests\StoreSalaryAllowanceRequest;
use App\Http\Requests\UpdateSalaryAllowanceRequest;
use App\Models\Department;
use App\Models\Employee;
use App\Models\SalaryAllowance;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Auth;
use DB;

class SalaryAllowanceController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('salary_allowance_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $salaryAllowances = SalaryAllowance::with(['employee'])->paginate(20);
        $company_id =   Auth::user()->company_id;
        $total = \App\Models\SalaryAllowance::where('company_id',$company_id)->select(DB::raw("SUM(percentage) as total_percentage"))
            ->groupBy('company_id')
            ->get();
       if (count($total) > 0){
           $lims_total_percentage = $total[0]->total_percentage;
       }else{
           $lims_total_percentage = 0;
       }

        return view('admin.salaryAllowances.index', compact('lims_total_percentage','salaryAllowances'));
    }

    public function create()
    {
        abort_if(Gate::denies('salary_allowance_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $employees = Employee::pluck('first_name', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.salaryAllowances.create', compact('employees'));
    }



    public function store(StoreSalaryAllowanceRequest $request)
    {
         if($request->percentage < 0){
             return redirect()->route('admin.salary-allowances.index')->with('error','Oops ! Must Be Positive Value');
         }
        $percentage = SalaryAllowance::get()->sum('percentage');
        if ($percentage > 100 || $request->percentage > 100){
           return redirect()->route('admin.salary-allowances.index')->with('error','Salary allowance Percentage not more than 100 !');
        }
        $data = $request->all();
        $company_id =   Auth::user()->company_id;
        $data['company_id'] = $company_id;
         $salaryAllowance = SalaryAllowance::create($data);

        return redirect()->route('admin.salary-allowances.index')->with('message','Salary allowance added Successfully');
    }

    public function edit(SalaryAllowance $salaryAllowance)
    {
        abort_if(Gate::denies('salary_allowance_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $employees = Employee::pluck('first_name', 'id')->prepend(trans('global.pleaseSelect'), '');
        $salaryAllowance->load('employee');
        return view('admin.salaryAllowances.edit', compact('employees', 'salaryAllowance'));
    }

    public function update(UpdateSalaryAllowanceRequest $request, SalaryAllowance $salaryAllowance)
    {
        if($request->percentage < 0){
            return redirect()->route('admin.salary-allowances.index')->with('error','Oops ! Must Be Positive Value');
        }
        $salaryAllowance->update($request->all());
        return redirect()->route('admin.salary-allowances.index')->with('message','Salary allowance updated Successfully');
    }

    public function show(SalaryAllowance $salaryAllowance)
    {
        abort_if(Gate::denies('salary_allowance_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $salaryAllowance->load('employee');
        return view('admin.salaryAllowances.show', compact('salaryAllowance'));
    }

    public function destroy(SalaryAllowance $salaryAllowance)
    {
        abort_if(Gate::denies('salary_allowance_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $salaryAllowance->delete();

        return back();
    }

    public function massDestroy(MassDestroySalaryAllowanceRequest $request)
    {
        SalaryAllowance::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function checkPercentage($percent)
    {
        $company_id =   Auth::user()->company_id;
        $total = SalaryAllowance::where('company_id',$company_id)->select(DB::raw("SUM(percentage) as total_percentage"))
            ->groupBy('company_id')
            ->get();
        $data['remaining_total_percent']= 100 - $total[0]->total_percentage;
        $data['lims_total_percentage']  = $total[0]->total_percentage +$percent;
        return $data;

    }


    public function editCheckPercentage($percent ,$hidden_percent)
    {
        $company_id =   Auth::user()->company_id;
        $total = SalaryAllowance::where('company_id',$company_id)->select(DB::raw("SUM(percentage) as total_percentage"))
            ->groupBy('company_id')
            ->get();
        $data['remaining_total_percent']= 100 - $total[0]->total_percentage ;
        $data['lims_total_percentage']  = $total[0]->total_percentage +$percent - $hidden_percent ;
        return $data;

    }

}
