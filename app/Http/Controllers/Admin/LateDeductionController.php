<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AdditionalAllowanceSetup;
use Illuminate\Http\Request;
use App\Models\Employee;
use App\Models\Company;
use App\Models\SalaryAllowance;
use App\Models\LateDeductionRules;
use App\Models\SubCompany;
use App\Models\User;
use Gate;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;


class LateDeductionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $lateDeductionRules = LateDeductionRules::paginate(20);

        return view('admin.lateDeduction.index', compact('lateDeductionRules'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $companyID = User::find(Auth::user()->id);
        $companies = Company::whereUserId($companyID->company_id)->first();
        $sub_companies = SubCompany::pluck('sub_company_name', 'id')->prepend(trans('global.pleaseSelect'), '');
        $allowance = SalaryAllowance::pluck('allowance_name','id');
        return view('admin.lateDeduction.create', compact('companies', 'sub_companies', 'allowance'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        DB::beginTransaction();
        try{
            if($request->late_days < 0 || $request->deduction_days < 0){
                return redirect()->route('admin.late-deduction.index')->with('error','Ops! Must be positive value.');
            }
            $data = $request->all();
            LateDeductionRules::create($data);
            DB::commit();
            return redirect()->route('admin.late-deduction.index')->with('message','Late deduction added Successfully');
        }catch(\Exception $e){
            DB::rollBack();
            return redirect()->route('admin.late-deduction.index')->with('error',$e->getMessage());
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
        $lateDeductionRules = LateDeductionRules::find($id);

        return view('admin.lateDeduction.show',compact('lateDeductionRules'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $lateDeductionRules = LateDeductionRules::find($id);
        $companyID = User::find(Auth::user()->id);
        $companies = Company::whereUserId($companyID->company_id)->pluck('comp_name', 'id')->prepend(trans('global.pleaseSelect'), '');
        $sub_companies = SubCompany::pluck('sub_company_name', 'id')->prepend(trans('global.pleaseSelect'), '');
        $allowance = SalaryAllowance::pluck('allowance_name','id');

        return view('admin.lateDeduction.edit', compact('companies','sub_companies','lateDeductionRules','allowance'));
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
        if($request->late_days < 0 || $request->deduction_days < 0){
            return redirect()->route('admin.late-deduction.index')->with('error','Ops! Must be positive value.');
        }
        $lateDeductionRules = LateDeductionRules::find($id);
        $lateDeductionRules->update($request->all());

        return redirect()->route('admin.late-deduction.index')->with('message','Late deduction update Successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $lateDeductionRules = LateDeductionRules::find($id);
        $lateDeductionRules->delete();
        return back();
    }
}
