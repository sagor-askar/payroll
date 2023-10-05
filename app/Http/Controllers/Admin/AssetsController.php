<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Asset;
use App\Models\AssetGroup;
use App\Models\Employee;
use Illuminate\Http\Request;
use Gate;
use Symfony\Component\HttpFoundation\Response;

class AssetsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        abort_if(Gate::denies('assets_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $assets  = Asset::orderBy('id','DESC')->paginate(20);
        return view('admin.assets.index',compact('assets'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        abort_if(Gate::denies('assets_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $assetGroups =  AssetGroup::orderBy('id','ASC')->get();
        $employees = Employee::where('is_active',1)->get();
        return view('admin.assets.create',compact('assetGroups', 'employees'));
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
        $code_name = substr($request->name, 0, 3);
        $data['asset_code'] = $code_name.'-'. date("Ymd") . '-'. date("his");
        Asset::create($data);

        return redirect()->route('admin.assets.index')->with('message', 'Asset Generated successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $asset = Asset::find($id);
        return view('admin.assets.show',compact('asset'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $employees = Employee::where('is_active',1)->get();
        $assetGroups =  AssetGroup::orderBy('id','ASC')->get();
        $asset = Asset::find($id);
        return view('admin.assets.edit',compact('asset','assetGroups','employees'));
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
        $asset = Asset::find($id);
        $data = $request->all();
        $asset->update($data);
        return redirect()->route('admin.assets.index')->with('message','Asset Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $asset = Asset::find($id);
        $asset->delete();
        return back();
    }

    public function assetGroupStore(Request $request)
    {
        $data = $request->all();
        AssetGroup::create($data);
        return back();
    }




}
