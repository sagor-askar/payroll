<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyDepartmentRequest;
use App\Http\Requests\StoreDepartmentRequest;
use App\Http\Requests\UpdateDepartmentRequest;
use App\Models\Branch;
use App\Models\Company;
use App\Models\Department;
use App\Models\SubCompany;
use App\Models\User;
use Gate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class DepartmentController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('department_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $departments = Department::with(['branch', 'sub_company', 'company', 'created_by'])->paginate(20);

        return view('admin.departments.index', compact('departments'));
    }

    public function create()
    {
        abort_if(Gate::denies('department_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $companyID = User::find(Auth::user()->id);
        $companies = Company::whereUserId($companyID->company_id)->first();

        $sub_companies = SubCompany::whereCompanyId($companies->id)->pluck('sub_company_name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $branches = Branch::whereCompanyId($companies->id)->pluck('branch_name', 'id')->prepend(trans('global.pleaseSelect'), '');



        return view('admin.departments.create', compact('branches', 'companies', 'sub_companies'));
    }

    public function store(StoreDepartmentRequest $request)
    {
        $department = Department::create($request->all());

        return redirect()->route('admin.departments.index')->with('message','Department added Successfully');
    }

    public function edit(Department $department)
    {
        abort_if(Gate::denies('department_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $companyID = User::find(Auth::user()->id);
        $companies = Company::whereUserId($companyID->company_id)->first();

        $sub_companies = SubCompany::whereCompanyId($companies->id)->pluck('sub_company_name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $branches = Branch::whereCompanyId($companies->id)->pluck('branch_name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $department->load('branch', 'sub_company', 'company', 'created_by');

        return view('admin.departments.edit', compact('branches', 'companies', 'department', 'sub_companies'));
    }

    public function update(UpdateDepartmentRequest $request, Department $department)
    {
        $department->update($request->all());

        return redirect()->route('admin.departments.index')->with('message','Department updated Successfully');;
    }

    public function show(Department $department)
    {
        abort_if(Gate::denies('department_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $department->load('branch', 'sub_company', 'company', 'created_by');

        return view('admin.departments.show', compact('department'));
    }

    public function destroy(Department $department)
    {
        abort_if(Gate::denies('department_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $department->delete();

        return back();
    }

    public function massDestroy(MassDestroyDepartmentRequest $request)
    {
        Department::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
