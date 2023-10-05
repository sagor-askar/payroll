<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Employee;
use App\Models\Company;
use App\Models\SubCompany;
use App\Models\AdditionalAllowanceSetup;
use Illuminate\Support\Facades\Auth;

use App\Models\User;
use Gate;
use Symfony\Component\HttpFoundation\Response;

class AdditionalAllowanceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        abort_if(Gate::denies('additional_allowance_setup_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $additionalAllowance = AdditionalAllowanceSetup::with(['company', 'sub_company'])->paginate(20);
        return view('admin.additionalAllowance.index', compact('additionalAllowance'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        abort_if(Gate::denies('additional_allowance_setup_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $employees = Employee::pluck('first_name', 'last_name')->prepend(trans('global.pleaseSelect'));
        $companyID = User::find(Auth::user()->id);
        $companies = Company::whereUserId($companyID->company_id)->first();
        $sub_companies = SubCompany::pluck('sub_company_name', 'id')->prepend(trans('global.pleaseSelect'), '');
        return view('admin.additionalAllowance.create', compact('employees', 'companies', 'sub_companies'));
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
        $data['created_by'] = Auth::user()->id;
        AdditionalAllowanceSetup::create($data);
        return redirect()->route('admin.additional-allowance.index')->with('message','Added Successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        abort_if(Gate::denies('additional_allowance_setup_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $additionalAllowanceSetup = AdditionalAllowanceSetup::find($id);
        return view('admin.additionalAllowance.show',compact('additionalAllowanceSetup'));
    }



    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        abort_if(Gate::denies('additional_allowance_setup_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $additionalAllowanceSetup = AdditionalAllowanceSetup::find($id);
        $companyID = User::find(Auth::user()->id);
        $companies = Company::whereUserId($companyID->company_id)->first();
        $sub_companies = SubCompany::where('company_id',$additionalAllowanceSetup->company_id)->pluck('sub_company_name', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.additionalAllowance.edit', compact('companies', 'sub_companies', 'additionalAllowanceSetup'));
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
        $additionalAllowanceSetup = AdditionalAllowanceSetup::find($id);
        $additionalAllowanceSetup['updated_by'] = Auth::user()->id;
        $additionalAllowanceSetup->update($request->all());
        return redirect()->route('admin.additional-allowance.index')->with('message','Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        abort_if(Gate::denies('additional_allowance_setup_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $additionalAllowanceSetup = AdditionalAllowanceSetup::find($id);
        $additionalAllowanceSetup->delete();
        return back();
    }
}
