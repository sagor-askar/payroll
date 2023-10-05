<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroySubCompanyRequest;
use App\Http\Requests\StoreSubCompanyRequest;
use App\Http\Requests\UpdateSubCompanyRequest;
use App\Models\Company;
use App\Models\User;
use App\Models\SubCompany;
use Gate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class SubCompanyController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('sub_company_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $subCompanies = SubCompany::with(['company', 'created_by'])->paginate(20);
        return view('admin.subCompanies.index', compact('subCompanies'));
    }



    public function create()
    {
        abort_if(Gate::denies('sub_company_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        // $companies = Company::whereUserId(Auth::user()->id)->pluck('comp_name', 'id')->prepend(trans('global.pleaseSelect'), '');
        $companyID = User::find(Auth::user()->id);
        $companies = Company::whereUserId($companyID->company_id)->first();


        return view('admin.subCompanies.create', compact('companies'));
    }

    public function store(StoreSubCompanyRequest $request)
    {
        $subCompany = SubCompany::create($request->all());

        return redirect()->route('admin.sub-companies.index')->with('message','Sub Company added Successfully');;
    }

    public function edit(SubCompany $subCompany)
    {
        abort_if(Gate::denies('sub_company_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        // $companies = Company::whereUserId(Auth::user()->id)->pluck('comp_name', 'id')->prepend(trans('global.pleaseSelect'), '');
        $companyID = User::find(Auth::user()->id);
        $companies = Company::whereUserId($companyID->company_id)->first();
        $subCompany->load('company', 'created_by');

        return view('admin.subCompanies.edit', compact('companies', 'subCompany'));
    }

    public function update(UpdateSubCompanyRequest $request, SubCompany $subCompany)
    {
        $subCompany->update($request->all());

        return redirect()->route('admin.sub-companies.index')->with('message','Sub company updated Successfully');;
    }

    public function show(SubCompany $subCompany)
    {
        abort_if(Gate::denies('sub_company_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $subCompany->load('company', 'created_by');

        return view('admin.subCompanies.show', compact('subCompany'));
    }

    public function destroy(SubCompany $subCompany)
    {
        abort_if(Gate::denies('sub_company_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $subCompany->delete();

        return back();
    }

    public function massDestroy(MassDestroySubCompanyRequest $request)
    {
        SubCompany::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
