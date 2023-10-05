<?php

namespace App\Http\Controllers\Admin;

use App\Models\Employee;
use App\Models\Department;
use App\Models\Designation;

use App\Http\Controllers\Controller;
use App\Models\Conveyance;
use App\Models\Settings;
use App\Models\ConveyanceItem;
use Illuminate\Http\Request;
use Illuminate\Routing\RedirectController;
use \NumberFormatter;
use Carbon\Carbon;
use PDF;
use Auth;
use PhpOffice\PhpSpreadsheet\Reader\Xml\Style\NumberFormat;
use Illuminate\Support\Facades\DB;

class ConveyanceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $employee_id = Auth::user()->employee_id;
        $role_title = auth()->user()->roles->first()->title;
        if ($role_title == 'Employee') {
            $conveyances = Conveyance::with(['department', 'employee'])->where('employee_id',$employee_id)->paginate(20);
        }elseif($role_title == 'Admin'){
            $conveyances = Conveyance::with(['department', 'employee'])->where('status',3)->paginate(20);
        }else{
            $conveyances = Conveyance::with(['department', 'employee'])->paginate(20);
        }
        return view('admin.conveyance.index', compact('employee_id', 'role_title', 'conveyances'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $employee_id =   Auth::user()->employee_id;
        $role_title =auth()->user()->roles->first()->title;

        if($role_title == 'Employee'){
            $employees = Employee::where('is_active',1)->where('id',$employee_id)->first();
            $departments = Department::where('id',$employees->department_id)->first();
            $designations = Designation::where('id',$employees->designation_id)->first();
        }else{
            $employees = Employee::where('is_active',1)->get();
            $departments = Department::get();
            $designations = Designation::get();
        }
        return view('admin.conveyance.create', compact('role_title', 'employees', 'departments', 'designations'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try{
            DB::beginTransaction();

            $data = $request->all();
            $data['conveyance_date'] = Carbon::parse($request->conveyance_date)->format('Y-m-d');
            $conveyance = Conveyance::create($data);

            if(isset($request->description)){
                $description = $request->description;
                $from_place = $request->from_place;
                $to_place = $request->to_place;
                $mode_of_transport = $request->mode_of_transport;
                $cost = $request->cost;
                for($i = 0; $i < count($description); $i++){
                    $conveyance_item = new ConveyanceItem();
                    $conveyance_item->conveyance_id = $conveyance->id;
                    $conveyance_item->description = $description[$i];
                    $conveyance_item->from_place = $from_place[$i];
                    $conveyance_item->to_place = $to_place[$i];
                    $conveyance_item->mode_of_transport = $mode_of_transport[$i];
                    $conveyance_item->cost = $cost[$i];

                    $conveyance_item->save();
                }
            }
            DB::commit();
            return redirect()->route('admin.conveyance.index')->with('message', 'Conveyance List Generated');
        }catch(\Exception $e){
            DB::rollBack();
            return redirect()->route('admin.conveyance.index')->with('error', $e->getMessage());
        }
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
        $conveyances = Conveyance::find($id);
        $conveyanceItems = ConveyanceItem::where('conveyance_id', $id)->get();
        return view('admin.conveyance.show', compact('role_title','conveyances', 'conveyanceItems'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $role_title =auth()->user()->roles->first()->title;

        if($role_title == 'Employee'){
            $employee_id =   Auth::user()->employee_id;
            $employees = Employee::where('is_active',1)->where('id',$employee_id)->get();
        }else{
            $employees = Employee::where('is_active',1)->get();
        }
        $departments = Department::get();
        $designations = Designation::get();
        $conveyances = Conveyance::find($id);
        $conveyanceItems = ConveyanceItem::where('conveyance_id', $id)->get();

        return view('admin.conveyance.edit', compact('role_title', 'employees', 'departments', 'designations', 'conveyances', 'conveyanceItems'));
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
        try{
            DB::beginTransaction();
            $data = $request->all();

            $conveyances = Conveyance::find($id);
            $data['conveyance_date'] = Carbon::parse($request->conveyance_date)->format('Y-m-d');
            $conveyance = $conveyances->update($data);
            $conveyanceItems = ConveyanceItem::where('conveyance_id', $id)->get();
            foreach($conveyanceItems as $val)
            {
                $val->delete();
            }

            if(isset($request->description)){
                $description = $request->description;
                $from_place = $request->from_place;
                $to_place = $request->to_place;
                $mode_of_transport = $request->mode_of_transport;
                $cost = $request->cost;

                for($i = 0; $i < count($description); $i++){
                    $conveyance_item = new ConveyanceItem();
                    $conveyance_item->conveyance_id = $id;
                    $conveyance_item->description = $description[$i];
                    $conveyance_item->from_place = $from_place[$i];
                    $conveyance_item->to_place = $to_place[$i];
                    $conveyance_item->mode_of_transport = $mode_of_transport[$i];
                    $conveyance_item->cost = $cost[$i];

                    $conveyance_item->save();
                }
            }
            DB::commit();
            return redirect()->route('admin.conveyance.index')->with('message', 'Conveyance Updated Successfully');
        }catch(\Exception $e){
            DB::rollBack();
            return redirect()->route('admin.conveyance.index')->with('error', $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $conveyances = Conveyance::find($id);
        $conveyanceItems = ConveyanceItem::where('conveyance_id', $id)->get();
            foreach($conveyanceItems as $value){
                $value->delete();
            }
        $conveyances->delete();
        return redirect()->route('admin.requisition.index')->with('message', 'Delete Successfully');
    }

    public function conveyancePDF($id)
    {
        $setting = Settings::first();
        $conveyances = Conveyance::find($id);
        $conveyanceItems = ConveyanceItem::where('conveyance_id', $id)->get();
        $pdf = PDF::loadview('admin.conveyance.print-conveyance', compact('setting','conveyances','conveyanceItems'))->setOptions(['defaultFont' => 'sans-serif']);
        return $pdf->setPaper('a4')->stream('report.pdf');
    }


    public function conveyanceApproved($id)
    {
        $conveyance = Conveyance::find($id);
        $conveyance->status = 1 ;
        $conveyance->save();
        return redirect()->route('admin.conveyance.index')->with('message', 'Conveyance approved successfully');
    }



    public function conveyanceReject($id)
    {
        $conveyance = Conveyance::find($id);
        $conveyance->status = 2 ;
        $conveyance->save();
        return redirect()->route('admin.conveyance.index')->with('message', 'Conveyance rejected successfully');
    }

    public function conveyanceCancel($id)
    {
        $conveyance = Conveyance::find($id);
        $conveyance->delete();
        return redirect()->route('admin.conveyance.index')->with('message', 'Conveyance cancel successfully');
    }

    public function conveyanceForward($id)
    {
        $conveyance = Conveyance::find($id);
        $conveyance->status = 3 ;
        $conveyance->save();
        return redirect()->route('admin.conveyance.index')->with('message', 'Conveyance Forwarded successfully');
    }
}
