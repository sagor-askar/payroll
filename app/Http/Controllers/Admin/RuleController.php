<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\Rule;
use Illuminate\Http\Request;
use Gate;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;


class RuleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        abort_if(Gate::denies('rules_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $rules = Rule::paginate(20);

        return view('admin.rules.index', compact('rules'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        abort_if(Gate::denies('rules_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.rules.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rule = Rule::create(array_merge($request->all(), ['company_id' => Auth::user()->company_id]));
        return redirect()->route('admin.rules.index')->with('message','Rules create successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Rule $rule)
    {
        abort_if(Gate::denies('rule_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $rule->load('company');

        return view('admin.rules.show', compact('rule'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        abort_if(Gate::denies('rule_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $rule = Rule::find($id);
        return view('admin.rules.edit', compact('rule'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,Rule $rule)
    {
        $rule->update($request->all());

        return redirect()->route('admin.rules.index')->with('message','Rules update successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Rule $rule)
    {
        abort_if(Gate::denies('rule_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $rule->delete();

        return redirect()->route('admin.rules.index')->with('message','Rules Delete successfully');
    }
}
