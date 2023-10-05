<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Panel;
use App\Models\Employee;
use Illuminate\Http\Request;


class PanelController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $panel = Panel::get();
        return view('admin.panels.index', compact('panel'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $employees = Employee::where('is_active',1)->get();
        return view('admin.panels.create', compact('employees'));
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
        $data['members'] = json_encode($data['members']);
        Panel::create($data);

        return redirect()->route('admin.panels.index')->with('message', 'Panel Created Successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $panels = Panel::find($id);
        $members = json_decode($panels->members);
        $employees = Employee::get();
        
        return view('admin.panels.edit', compact('panels', 'employees','members'));
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
        $panels = Panel::find($id);
        $data = $request->all();
        $panels->update($data);
        return redirect()->route('admin.panels.index')->with('message','Panel Info Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $panels = Panel::find($id);
        $panels->delete();
        return redirect()->route('admin.panels.index')->with('message','Panel Deleted Successfully !');
    }
}
