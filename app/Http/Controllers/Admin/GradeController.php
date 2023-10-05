<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyGradeRequest;
use App\Http\Requests\StoreGradeRequest;
use App\Http\Requests\UpdateGradeRequest;
use App\Models\Company;
use App\Models\Department;
use App\Models\Grade;
use App\Models\User;
use Gate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class GradeController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('grade_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $grades = Grade::with(['department', 'created_by'])->paginate(20);

        return view('admin.grades.index', compact('grades'));
    }

    public function create()
    {
        abort_if(Gate::denies('grade_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $companyID = User::find(Auth::user()->id);
        $companies = Company::whereUserId($companyID->company_id)->first();

        $departments = Department::pluck('department_name', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.grades.create', compact('departments','companies'));
    }

    public function store(StoreGradeRequest $request)
    {
        $grade = Grade::create($request->all());

        return redirect()->route('admin.grades.index')->with('message','Grade added Successfully');;
    }

    public function edit(Grade $grade)
    {
        abort_if(Gate::denies('grade_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $companyID = User::find(Auth::user()->id);
        $companies = Company::whereUserId($companyID->company_id)->first();

        $departments = Department::pluck('department_name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $grade->load('department', 'created_by');

        return view('admin.grades.edit', compact('departments', 'grade','companies'));
    }

    public function update(UpdateGradeRequest $request, Grade $grade)
    {
        $grade->update($request->all());

        return redirect()->route('admin.grades.index')->with('message','Grade update Successfully');;
    }

    public function show(Grade $grade)
    {
        abort_if(Gate::denies('grade_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $grade->load('department', 'created_by');

        return view('admin.grades.show', compact('grade'));
    }

    public function destroy(Grade $grade)
    {
        abort_if(Gate::denies('grade_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $grade->delete();

        return back();
    }

    public function massDestroy(MassDestroyGradeRequest $request)
    {
        Grade::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
