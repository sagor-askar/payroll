<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyDesignationRequest;
use App\Http\Requests\StoreDesignationRequest;
use App\Http\Requests\UpdateDesignationRequest;
use App\Models\Company;
use App\Models\Department;
use App\Models\Designation;
use App\Models\User;
use Gate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class DesignationController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('designation_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $designations = Designation::with(['department', 'created_by'])->paginate(20);

        return view('admin.designations.index', compact('designations'));
    }

    public function create()
    {
        abort_if(Gate::denies('designation_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $companyID = User::find(Auth::user()->id);
        $companies = Company::whereUserId($companyID->company_id)->first();
        $departments = Department::pluck('department_name', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.designations.create', compact('departments','companies'));
    }

    public function store(StoreDesignationRequest $request)
    {
        $designation = Designation::create($request->all());

        return redirect()->route('admin.designations.index')->with('message','Designation added Successfully');;
    }

    public function edit(Designation $designation)
    {
        abort_if(Gate::denies('designation_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $departments = Department::pluck('department_name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $companyID = User::find(Auth::user()->id);
        $companies = Company::whereUserId($companyID->company_id)->first();

        $designation->load('department', 'created_by');

        return view('admin.designations.edit', compact('departments', 'designation','companies'));
    }

    public function update(UpdateDesignationRequest $request, Designation $designation)
    {
        $designation->update($request->all());

        return redirect()->route('admin.designations.index')->with('message','Designation updated Successfully');;
    }

    public function show(Designation $designation)
    {
        abort_if(Gate::denies('designation_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $designation->load('department', 'created_by');

        return view('admin.designations.show', compact('designation'));
    }

    public function destroy(Designation $designation)
    {
        abort_if(Gate::denies('designation_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $designation->delete();

        return back();
    }

    public function massDestroy(MassDestroyDesignationRequest $request)
    {
        Designation::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
