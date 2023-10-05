<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyRankRequest;
use App\Http\Requests\StoreRankRequest;
use App\Http\Requests\UpdateRankRequest;
use App\Models\Department;
use App\Models\Company;
use App\Models\Rank;
use App\Models\User;
use Gate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;
use Stevebauman\Location\Facades\Location;


class RankController extends Controller
{
    public function index(Request $request)
    {
        abort_if(Gate::denies('rank_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $ranks = Rank::with(['company', 'created_by'])->paginate(20);

        return view('admin.ranks.index', compact('ranks'));
    }

    public function create()
    {
        abort_if(Gate::denies('rank_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $departments = Department::pluck('department_name', 'id')->prepend(trans('global.pleaseSelect'), '');
        $companyID = User::find(Auth::user()->id);
        $companies = Company::whereUserId($companyID->company_id)->first();
        return view('admin.ranks.create', compact('companies','departments'));

    }

    public function store(StoreRankRequest $request)
    {
        $rank = Rank::create($request->all());

        return redirect()->route('admin.ranks.index')->with('message','Rank added Successfully');;
    }

    public function edit(Rank $rank)
    {
        abort_if(Gate::denies('rank_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $departments = Department::pluck('department_name', 'id')->prepend(trans('global.pleaseSelect'), '');
        $companyID = User::find(Auth::user()->id);
        $companies = Company::whereUserId($companyID->company_id)->first();
        $rank->load('department', 'created_by');
        return view('admin.ranks.edit', compact('departments', 'rank','companies'));

    }

    public function update(UpdateRankRequest $request, Rank $rank)
    {
        $rank->update($request->all());

        return redirect()->route('admin.ranks.index')->with('message','Rank update Successfully');
    }

    public function show(Rank $rank)
    {
        abort_if(Gate::denies('rank_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $rank->load('department', 'created_by');

        return view('admin.ranks.show', compact('rank'));
    }

    public function destroy(Rank $rank)
    {
        abort_if(Gate::denies('rank_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $rank->delete();

        return back();
    }

    public function massDestroy(MassDestroyRankRequest $request)
    {
        Rank::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
