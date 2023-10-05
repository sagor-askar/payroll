<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ProvidentFund;
use App\Models\ProvidentfundSetting;
use Illuminate\Http\Request;
use Gate;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class ProvidentfundSettingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        abort_if(Gate::denies('additional_allowance_setup_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $data = ProvidentfundSetting::orderBy('id', 'DESC')->first();
        return view('admin.providentfundsetting.index',compact('data'));
    }

    public function getStatusValue($value,$id)
    {
       if($id == 'undefined'){
            if($value == 'true'){
                $data['status'] = 1;
                ProvidentfundSetting::create($data);
                return 'done';
            }
            else {
            $data['status'] = 0;
                ProvidentfundSetting::create($data);
                return 'done';
            }
       }else{
            $ProvidentfundSetting = ProvidentfundSetting::find($id);
                if($value == 'true'){
                    $data['status'] = 1;
                    $ProvidentfundSetting->update($data);
                    return 'done';
                }
                else {
                $data['status'] = 0;
                $ProvidentfundSetting->update($data);
                    return 'done';
                }
       }


    }
    public function getCompanyValue($value,$id)
    {
       if($id == 'undefined'){
            if($value == 'true'){
                $data['company_contribution_status'] = 1;
                ProvidentfundSetting::create($data);
                return 'done';
            }
            else {
            $data['company_contribution_status'] = 0;
                ProvidentfundSetting::create($data);
                return 'done';
            }
       }else{
            $ProvidentfundSetting = ProvidentfundSetting::find($id);
                if($value == 'true'){
                    $data['company_contribution_status'] = 1;
                    $ProvidentfundSetting->update($data);
                    return 'done';
                }
                else {
                $data['company_contribution_status'] = 0;
                $ProvidentfundSetting->update($data);
                    return 'done';
                }
       }


    }

    public function userProvidentFund()
    {
        $role_title =auth()->user()->roles->first()->title;
        if ($role_title == 'Employee') {
            $employee_id = Auth::user()->employee_id;
            $providents = ProvidentFund::where('employee_id',$employee_id)
                ->selectRaw("SUM(pf_amount) as total_pf_amount")
                ->selectRaw("SUM(company_amount) as total_company_amount")
                ->selectRaw("employee_id")
                ->groupBy('employee_id')
                ->get();
           }else{
            $providents = ProvidentFund::selectRaw("SUM(pf_amount) as total_pf_amount")
                                        ->selectRaw("SUM(company_amount) as total_company_amount")
                                        ->selectRaw("employee_id")
                                        ->groupBy('employee_id')
                                        ->paginate(20);
        }
        return view('admin.provident_fund.index',compact('providents'));

    }

    public function providentFundHistory($id)
    {
        $providents = ProvidentFund::where('employee_id',$id)->paginate(10);
        return view('admin.provident_fund.show',compact('providents'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

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
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
