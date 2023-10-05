<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\MassDestroyEmployeeRequest;
use App\Http\Requests\StoreEmployeeRequest;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateEmployeeRequest;
use App\Models\Interview;
use App\Models\JobsCreate;
use App\Models\LoanApplication;
use App\Models\SalaryAdvance;
use App\Models\Shift;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use App\Models\Department;
use App\Models\Designation;
use App\Models\Education;
use App\Models\Employee;
use App\Models\EmployeeSalary;
use App\Models\Grade;
use App\Models\Role;
use App\Models\SalaryAllowance;
use App\Models\Settings;
use App\Models\SubCompany;
use App\Models\User;
use Gate;
use PDF;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Symfony\Component\HttpFoundation\Response;


class EmployeeController extends Controller
{
    use MediaUploadingTrait;

    public function index()
    {


        abort_if(Gate::denies('employee_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $employees = Employee::with(['department', 'designation', 'grade', 'created_by', 'media'])->where('is_active',1)->paginate(20);

        return view('admin.employees.index', compact('employees'));
    }

    public function create()
    {

        abort_if(Gate::denies('employee_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $sub_companies = SubCompany::where('company_id',Auth::user()->company_id)->get();
        // $sub_companies = SubCompany::pluck('sub_company_name', 'id');
        $departments = Department::pluck('department_name', 'id')->prepend(trans('global.pleaseSelect'), '');
        $designations = Designation::pluck('designation_name', 'id')->prepend(trans('global.pleaseSelect'), '');
        $employees = Employee::where('is_active',1)->pluck('first_name','last_name','id')->prepend(trans('global.pleaseSelect'), '');
        $grades = Grade::pluck('grade', 'id')->prepend(trans('global.pleaseSelect'), '');
        $roles = Role::get();
        $shifts = Shift::get();

        return view('admin.employees.create', compact('shifts','employees','sub_companies','roles','departments', 'designations', 'grades'));
    }


    public function getSalaryDisbersments($salary)
    {
        $salary = $salary;
        $company_id =   Auth::user()->company_id;
        $salary_allowances = SalaryAllowance::where('company_id',$company_id)->get();
        $data['tsalary']= $salary;
        $data['salary_allowances']  = $salary_allowances;
        $data['salary_allowances_count']  = count($salary_allowances);
        return $data  ;

    }

    public function store(StoreEmployeeRequest $request)
    {

        DB::beginTransaction();
        try{
            $data = $request->all();
            $settings= Settings::orderBy('id','DESC')->first();
            $prefix = $settings->prefix;
            $employee_details = Employee::orderBy('id','DESC')->first();
            $employee_details = Employee::orderBy('id','DESC')->first();
            if ($employee_details == null){
                $employee_id = 0 ;
            }else{
                $employee_id = $employee_details->id;
            }
            $emp_manual_id = $prefix.'-'.str_pad($employee_id + 1, 8, "0", STR_PAD_LEFT);
            $data['employee_manual_id'] = $emp_manual_id;
            $data['company_id'] = Auth::user()->company_id;
            $salary = $request->salary;
            $employee = Employee::create($data);
            $company_id =   Auth::user()->company_id;
            $salary_allowances = SalaryAllowance::where('company_id',$company_id)->get();
            if (count($salary_allowances) > 0 ){
                foreach ($salary_allowances as $salary_allowance){
                    $percent = $salary_allowance->percentage;
                    $percentage_salary = ($percent /100) * $salary ;
                    $employee_salary = new EmployeeSalary;
                    $employee_salary->employee_id = $employee->id;
                    $employee_salary->salary_allowance_id = $salary_allowance->id;
                    $employee_salary->salary = $percentage_salary;
                    $employee_salary->save();
                }

            }
            if(isset($request->user_show)){
                $userdata['name'] = $employee->first_name;
                $userdata['email'] = $request->user_email;
                $userdata['password'] = $request->password;
                $userdata['company_id'] = $company_id;
                $userdata['employee_id'] = $employee->id;
                $userdata['role_id'] = $request->roles[0];
                $user = User::create($userdata);
                $user->roles()->sync($request->input('roles', []));
            }
            // education info store
            if(isset($request->examination)){
                $examination =  $request->examination;
                $institute =  $request->institute;
                $result =  $request->result;
                $passing_year =  $request->passing_year;


                for ( $i = 0; $i < count($examination); $i++) {
                    $education = new Education();
                    $education->employee_id = $employee->id;
                    $education->examination = $examination[$i];
                    $education->institue = $institute[$i];
                    $education->result = $result[$i];
                    $education->passing_year = $passing_year[$i];
                    $education->save();
                }
            }


            foreach ($request->input('certificates', []) as $file) {
                $employee->addMedia(storage_path('tmp/uploads/' . basename($file)))->toMediaCollection('certificates');
            }

            if ($request->input('noc', false)) {
                $employee->addMedia(storage_path('tmp/uploads/' . basename($request->input('noc'))))->toMediaCollection('noc');
            }

            if ($request->input('resume', false)) {
                $employee->addMedia(storage_path('tmp/uploads/' . basename($request->input('resume'))))->toMediaCollection('resume');
            }

            if ($request->input('photo', false)) {
                $employee->addMedia(storage_path('tmp/uploads/' . basename($request->input('photo'))))->toMediaCollection('photo');
            }

            if ($media = $request->input('ck-media', false)) {
                Media::whereIn('id', $media)->update(['model_id' => $employee->id]);
            }

            // sending user credential via email
            $mail_data['email'] = $user->email;
            $mail_data['password'] = $userdata['password'];
            $mail_data['name'] = $user->name;

            $message ='User Credentials Sent Successfully!';
            //         try{

            //             Mail::send( 'admin.emails.emailSent', $mail_data, function( $message ) use ($mail_data)
            //             {
            //                 $message->to($mail_data['email'])->subject( 'Email From Polock Group' );
            //             });
            //         }
            //         catch(\Exception $e){

            //             $message = 'Mail Sending Failed!';
            //         }
             DB::commit();
            return redirect()->route('admin.employees.index')->with('message', $message);

        }catch(\Exception $e){
            DB::rollback();
            return redirect()->route('admin.employees.index')->with('error', $e->getMessage());
        }


    }



    public function edit(Employee $employee)
    {
        abort_if(Gate::denies('employee_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $departments = Department::pluck('department_name', 'id')->prepend(trans('global.pleaseSelect'), '');
        $sub_companies = SubCompany::where('company_id',Auth::user()->company_id)->get();

        $designations = Designation::pluck('designation_name', 'id')->prepend(trans('global.pleaseSelect'), '');
        $employees = Employee::where('is_active',1)->get();
        $grades = Grade::pluck('grade', 'id')->prepend(trans('global.pleaseSelect'), '');

        $employee->load('subcompany','department', 'designation', 'grade', 'created_by');
        $education = Education::where('employee_id',$employee->id)->get();
        $shifts = Shift::get();
        return view('admin.employees.edit', compact('shifts','employees','sub_companies','education','departments', 'designations', 'employee', 'grades'));
    }

    public function update(UpdateEmployeeRequest $request, Employee $employee)
    {
        DB::beginTransaction();
        try{
            $emp_data = $request->all();
            if($request->attendance_type != 'Shift'){
                $emp_data['shift_id'] = null;
            }



            $salary = $request->salary;
            $ex_salaray = $employee->salary;
            $check_employee_salary = EmployeeSalary::where('employee_id', $employee->id)->get();
            if ($ex_salaray != $salary) {
                $employee_salary = EmployeeSalary::where('employee_id', $employee->id)->get();
                foreach ($employee_salary as $val) {
                    $val->delete();
                }
                $company_id = Auth::user()->company_id;
                $salary_allowances = SalaryAllowance::where('company_id', $company_id)->get();
                if (count($salary_allowances) > 0) {
                    foreach ($salary_allowances as $salary_allowance) {
                        $percent = $salary_allowance->percentage;
                        $percentage_salary = ($percent / 100) * $salary;

                        $employee_salary = new EmployeeSalary;
                        $employee_salary->employee_id = $employee->id;
                        $employee_salary->salary_allowance_id = $salary_allowance->id;
                        $employee_salary->salary = $percentage_salary;
                        $employee_salary->save();
                    }

                }
            }else{
                if ( ! count($check_employee_salary) > 0){
                    $company_id = Auth::user()->company_id;
                    $salary_allowances = SalaryAllowance::where('company_id', $company_id)->get();
                    if (count($salary_allowances) > 0) {
                        foreach ($salary_allowances as $salary_allowance) {
                            $percent = $salary_allowance->percentage;
                            $percentage_salary = ($percent / 100) * $salary;

                            $employee_salary = new EmployeeSalary;
                            $employee_salary->employee_id = $employee->id;
                            $employee_salary->salary_allowance_id = $salary_allowance->id;
                            $employee_salary->salary = $percentage_salary;
                            $employee_salary->save();
                        }

                    }
                }

            }

         $employee->update($request->all());

           // education info update
            $educations_info  = Education::where('employee_id',$employee->id)->get();
            foreach($educations_info  as $val){
                $val->delete();
            }
            $examination =  $request->examination;
            $institute =  $request->institute;
            $result =  $request->result;
            $passing_year =  $request->passing_year;

            for ( $i = 0; $i < count($examination); $i++) {
              $education = new Education();
              $education->employee_id = $employee->id;
              $education->examination = $examination[$i];
              $education->institue = $institute[$i];
              $education->result = $result[$i];
              $education->passing_year = $passing_year[$i];
              $education->save();
          }
          //education info update ends



            if (count($employee->certificates) > 0) {
                foreach ($employee->certificates as $media) {
                    if (!in_array($media->file_name, $request->input('certificates', []))) {
                        $media->delete();
                    }
                }
            }else{
                if ( ! count($check_employee_salary) > 0){
                    $company_id = Auth::user()->company_id;
                    $salary_allowances = SalaryAllowance::where('company_id', $company_id)->get();
                    if (count($salary_allowances) > 0) {
                        foreach ($salary_allowances as $salary_allowance) {
                            $percent = $salary_allowance->percentage;
                            $percentage_salary = ($percent / 100) * $salary;

                            $employee_salary = new EmployeeSalary;
                            $employee_salary->employee_id = $employee->id;
                            $employee_salary->salary_allowance_id = $salary_allowance->id;
                            $employee_salary->salary = $percentage_salary;
                            $employee_salary->save();
                        }

                    }
                }

            }
            $media = $employee->certificates->pluck('file_name')->toArray();
            foreach ($request->input('certificates', []) as $file) {
                if (count($media) === 0 || !in_array($file, $media)) {
                    $employee->addMedia(storage_path('tmp/uploads/' . basename($file)))->toMediaCollection('certificates');
                }
            }

            if ($request->input('noc', false)) {
                if (!$employee->noc || $request->input('noc') !== $employee->noc->file_name) {
                    if ($employee->noc) {
                        $employee->noc->delete();
                    }
                    $employee->addMedia(storage_path('tmp/uploads/' . basename($request->input('noc'))))->toMediaCollection('noc');
                }
            } elseif ($employee->noc) {
                $employee->noc->delete();
            }

            if ($request->input('resume', false)) {
                if (!$employee->resume || $request->input('resume') !== $employee->resume->file_name) {
                    if ($employee->resume) {
                        $employee->resume->delete();
                    }
                    $employee->addMedia(storage_path('tmp/uploads/' . basename($request->input('resume'))))->toMediaCollection('resume');
                }
            } elseif ($employee->resume) {
                $employee->resume->delete();
            }

            if ($request->input('photo', false)) {
                if (!$employee->photo || $request->input('photo') !== $employee->photo->file_name) {
                    if ($employee->photo) {
                        $employee->photo->delete();
                    }
                    $employee->addMedia(storage_path('tmp/uploads/' . basename($request->input('photo'))))->toMediaCollection('photo');
                }
            } elseif ($employee->photo) {
                $employee->photo->delete();
            }
            DB::commit();
            return redirect()->route('admin.employees.index')->with('message', 'Employee updated successfully');

        }catch(\Exception $e){
            DB::rollback();
            return redirect()->route('admin.employees.index')->with('error', $e->getMessage());
        }

    }

    public function show(Employee $employee)
    {
        abort_if(Gate::denies('employee_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $employee->load('department', 'designation', 'grade', 'created_by');
        $education = Education::where('employee_id',$employee->id)->get();
        $employee_salaries = EmployeeSalary::where('employee_id',$employee->id)->get();

        return view('admin.employees.show', compact('employee_salaries','employee','education'));
    }

    public function destroy(Employee $employee)
    {
        abort_if(Gate::denies('employee_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        DB::beginTransaction();
        try{
            $employee_salaries_table = EmployeeSalary::where('employee_id',$employee->id)->get();

            foreach($employee_salaries_table as $value){
                $employee_salary = EmployeeSalary::findOrFail($value->id);
                $employee_salary->delete();
            }
            $employeeOnUser = User::findOrFail($employee->id);
            $employeeOnUser->delete();

            $employee->delete();
            DB::commit();
            return redirect()->route('admin.employees.index')->with('message', 'Delete Successfully');

        }catch(\Exception $e){
            DB::rollBack();
            return redirect()->route('admin.employees.index')->with('error', $e->getMessage());
        }


        return back();
    }

    public function massDestroy(MassDestroyEmployeeRequest $request)
    {
        Employee::where('is_active',1)->whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function storeCKEditorImages(Request $request)
    {
        abort_if(Gate::denies('employee_create') && Gate::denies('employee_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $model         = new Employee();
        $model->id     = $request->input('crud_id', 0);
        $model->exists = true;
        $media         = $model->addMediaFromRequest('upload')->toMediaCollection('ck-media');

        return response()->json(['id' => $media->id, 'url' => $media->getUrl()], Response::HTTP_CREATED);
    }


    public function getSubCompanyDepartment(Request $request){


      $data  = Department::where('sub_company_id',$request->id)->get();

        return response()->json($data);
    }

    public function getSubCompanyEmployee(Request $request){


         $departments  = Department::where('sub_company_id',$request->id)->get();
        foreach ($departments as $val){
            $dep_id[] = $val->id;
        }
        $data = Employee::where('is_active',1)->whereIn('department_id',$dep_id)->get();
        return response()->json($data);
    }

    public function getReportingEmployee(Request $request){

        $data  = Employee::where('is_active',1)->where('department_id',$request->id)->get();
        return response()->json($data);
    }

    public function getIncrementEmployee(Request $request){
        $oneYearAgoDate = Carbon::parse(Carbon::now()->subYear())->format('Y-m-d');
        $data = Employee::where('is_active',1)->where('department_id',$request->id)->where('joining_date','<=',$oneYearAgoDate)->get();
        return response()->json($data);
    }

    public function getSubCompanyDepartmentUpdate(Request $request){
        $data  = Department::where('sub_company_id',$request->id)->get();
        return response()->json($data);
    }

    public function getEmployeeSalary(Request $request){
        $oneYearAgoDate = Carbon::parse(Carbon::now()->subYear())->format('Y-m-d');
        $data  = Employee::where('is_active',1)->where('id',$request->id)->where('joining_date','<=',$oneYearAgoDate)->first();
        return response()->json($data);
    }

    public function getAdvanceHistory(Request $request)
    {
        $advanceAmount= SalaryAdvance::where('employee_id',$request->id)->where('paid_status',0)->first();
         if ($advanceAmount !=null){
           $data['advance_amount']  =  $advanceAmount->amount;
         }else{
             $data['advance_amount']  =  0;
         }
        return response()->json($data);
    }

    public function getLoanHistory(Request $request)
    {

        $advanceAmount= LoanApplication::where('employee_id',$request->id)->whereNot('paid_status',1)->first();
        if ($advanceAmount !=null){
            $data['loan_amount']  =  $advanceAmount->due_amount;
        }else{
            $data['loan_amount']  = 0;
        }
        return response()->json($data);
    }

    public function getCandidateJob(Request $request)
    {

        $interviewDetails= Interview::where('candidate_id',$request->id)->first();
        if($interviewDetails)
        {
            $data['job']= JobsCreate::find($interviewDetails->job_id);
            $data['interview_date']= Carbon::parse( $interviewDetails->interview_date )->format('d-m-Y');

        }else{
            $data['job'] = NULL;
            $data['interview_date'] = NULL;
        }
        return response()->json($data);
    }

    public function employeeInformationPDF() 
    {
        $setting = Settings::first();
        $employees = Employee::get();
        $pdf = PDF::loadview('admin.employees.employee_info', compact('setting','employees'))->setOptions(['defaultFont' => 'sans-serif']);
        return $pdf->setPaper('a4')->stream('report.pdf');
    }
}
