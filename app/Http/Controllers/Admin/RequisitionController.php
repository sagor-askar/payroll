<?php

namespace App\Http\Controllers\Admin;

use App\Models\Employee;
use App\Models\Department;

use App\Http\Controllers\Controller;
use App\Models\Requisition;
use App\Models\RequisitionItems;
use Carbon\Carbon;
use Illuminate\Http\Request;

class RequisitionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $requisitions =   Requisition::orderBy('id','DESC')->paginate(20);
        return view('admin.requisition.index',compact('requisitions'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $employees = Employee::where('is_active',1)->get();
        $departments = Department::get();

        return view('admin.requisition.create', compact('employees', 'departments'));
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
        $data['start_date'] = Carbon::parse($request->start_date)->format('Y-m-d');
        $data['end_date'] = Carbon::parse($request->end_date)->format('Y-m-d');
        $requisition =   Requisition::create($data);
        if(isset($request->name)){
            $name =  $request->name;
            $description =  $request->description;
            $qty =  $request->qty;
            $unit_price =  $request->unit_price;
            for ( $i = 0; $i < count($name); $i++) {
                $requisition_item = new RequisitionItems();
                $requisition_item->requisition_id = $requisition->id;
                $requisition_item->name = $name[$i];
                $requisition_item->qty = $qty[$i];
                $requisition_item->description = $description[$i];
                $requisition_item->unit_price = $unit_price[$i];
                $requisition_item->save();
            }
        }
        return redirect()->route('admin.requisition.index')->with('message', 'Requisition Generated Successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $role_title =auth()->user()->roles->first()->title;
        $requisitions =   Requisition::find($id);
        $requisitionsItems =   RequisitionItems::where('requisition_id',$id)->get();
        return view('admin.requisition.show',compact('role_title','requisitions','requisitionsItems'));
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
        $departments = Department::get();
        $requisitions =   Requisition::find($id);
        $requisitionsItems =   RequisitionItems::where('requisition_id',$id)->get();
        return view('admin.requisition.edit', compact('requisitionsItems','requisitions','employees', 'departments'));
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

        $data = $request->all();

        $requisitions =   Requisition::find($id);
        $data['start_date'] = Carbon::parse($request->start_date)->format('Y-m-d');
        $data['end_date'] = Carbon::parse($request->end_date)->format('Y-m-d');
        $requisition = $requisitions->update($data);

        $requisitionsItems =   RequisitionItems::where('requisition_id',$id)->get();
        foreach ($requisitionsItems as $val) {
            $val->delete();
        }
        if(isset($request->name)){
            $name =  $request->name;
            $description =  $request->description;
            $qty =  $request->qty;
            $unit_price =  $request->unit_price;

            for ( $i = 0; $i < count($name); $i++) {
                $requisition_item = new RequisitionItems();
                $requisition_item->requisition_id = $id;
                $requisition_item->name = $name[$i];
                $requisition_item->qty = $qty[$i];
                $requisition_item->description = $description[$i];
                $requisition_item->unit_price = $unit_price[$i];
                $requisition_item->save();
            }
        }
        return redirect()->route('admin.requisition.index')->with('message', 'Requisition Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
          $requisitions = Requisition::find($id);
          $requisitionsItems =   RequisitionItems::where('requisition_id',$id)->get();
            foreach($requisitionsItems as $value){
                $value->delete();
            }
           $requisitions->delete();
       return redirect()->route('admin.requisition.index')->with('message', 'Delete Successfully');

    }

    public function requisitionApproved($id)
    {
        $requisitions = Requisition::find($id);
        $requisitions->status = 1 ;
        $requisitions->save();
        return redirect()->route('admin.requisition.index')->with('message', 'Requisition approved successfully');
    }

    public function requisitionCancel($id)
    {
        $requisitions = Requisition::find($id);
        $requisitions->delete();
        return redirect()->route('admin.requisition.index')->with('message', 'Requisition cancel successfully');
    }

    public function requisitionReject($id)
    {
        $requisitions = Requisition::find($id);
        $requisitions->status = 2 ;
        $requisitions->save();
        return redirect()->route('admin.requisition.index')->with('message', 'Requisition rejected successfully');
    }




}
