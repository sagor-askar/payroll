<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyBranchRequest;
use App\Http\Requests\StoreBranchRequest;
use App\Http\Requests\UpdateBranchRequest;
use App\Models\Branch;
use App\Models\Company;
use App\Models\SubCompany;
use App\Models\User;
use Gate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class BranchController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('branch_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $branches = Branch::with(['company', 'sub_company', 'created_by'])->paginate(20);

        return view('admin.branches.index', compact('branches'));
    }

    public function create()
    {
        abort_if(Gate::denies('branch_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $companyID = User::find(Auth::user()->id);
        $companies = Company::whereUserId($companyID->company_id)->first();

        $sub_companies = SubCompany::whereCompanyId($companies->id)->pluck('sub_company_name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $created_bies = User::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.branches.create', compact('companies', 'created_bies', 'sub_companies'));
    }

    public function store(StoreBranchRequest $request)
    {
        $branch = Branch::create($request->all());

        return redirect()->route('admin.branches.index')->with('message','Branch added Successfully');
    }

    public function edit(Branch $branch)
    {
        abort_if(Gate::denies('branch_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $companyID = User::find(Auth::user()->id);
        $companies = Company::whereUserId($companyID->company_id)->first();

        $sub_companies = SubCompany::pluck('sub_company_name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $branch->load('company', 'sub_company', 'created_by');

        return view('admin.branches.edit', compact('branch', 'companies', 'sub_companies'));
    }

    public function update(UpdateBranchRequest $request, Branch $branch)
    {
        $branch->update($request->all());

        return redirect()->route('admin.branches.index')->with('message','Branch updated Successfully');;
    }

    public function show(Branch $branch)
    {
        abort_if(Gate::denies('branch_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $branch->load('company', 'sub_company', 'created_by');

        return view('admin.branches.show', compact('branch'));
    }

    public function destroy(Branch $branch)
    {
        abort_if(Gate::denies('branch_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $branch->delete();

        return back();
    }

    public function massDestroy(MassDestroyBranchRequest $request)
    {
        Branch::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
