<?php

namespace App\Console;

use App\Helpers\Helper;
use App\Models\Attendance;
use App\Models\AttLog;
use App\Models\Employee;
use App\Models\Roster;
use App\Models\Rule;
use App\Models\Shift;
use Carbon\Carbon;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Illuminate\Support\Facades\DB;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // $schedule->command('backup:clean')->everyHour();
        $schedule->command('backup:run --only-db')->daily()->at('01:00');
        // $schedule->call(function () {
        //     $employeesAll =  Employee::where('is_attendence',1)->get();
        //     $today = Carbon::now();
        //     $dayOfWeek = $today->format('l');
        //     if($dayOfWeek == 'Thursday'){
        //             foreach($employeesAll as $key => $item){
        //                 $inTime = AttLog::where('employeeID',$item->id)->where('authDate',Carbon::now()->format('Y-m-d'))->first();
        //                 if($inTime != null){
        //                     // start
        //                     $checkAttendance = Attendance::where('employee_id',$inTime->employeeID)->where('date',Carbon::now()->format('Y-m-d'))->first();
        //                     if ($checkAttendance){
        //                         continue;
        //                     }else{
        //                         $data['date']        = $inTime->authDate;
        //                         $data['clock_in']    = $inTime->authTime;
        //                         $data['employee_id'] = $inTime->employeeID;
        //                         $data['device_name'] = "Machine";
        //                         $checkEmployee = Employee::where('id',$inTime->employeeID)->first();
        //                         if ($checkEmployee->attendance_type == 'Branch') {
        //                             $rules = Rule::first();
        //                             $system_start = $rules->start_time;
        //                             $enter_time = strtotime($inTime->authTime);
        //                             $start_time = strtotime($system_start);
        //                             if($enter_time > $start_time ){
        //                                 $data['late'] = Helper::getTime($inTime->authTime,$system_start);
        //                             }
        //                             $attendance = Attendance::create($data);
        //                         }elseif ($checkEmployee->attendance_type == 'Roster'){
        //                             $roster = Roster::where('employee_id',$checkEmployee->id)->where('duty_date',Carbon::now()->format('Y-m-d'))->first();
        //                             if ($roster) {
        //                                 $system_start = $roster->start_time;
        //                                 $enter_time = strtotime($inTime->authTime);
        //                                 $start_time = strtotime($system_start);
        //                                 if($enter_time > $start_time ){ 
        //                                     $data['late'] =  $data['late'] = Helper::getTime($inTime->authTime,$system_start);
        //                                 }
        //                                 $attendance = Attendance::create($data);
                                    
        //                             }
                        
        //                         }else{
        //                             $shift = Shift::findOrFail($checkEmployee->shift_id);
        //                             $system_start = $shift->start_time;
        //                             $enter_time = strtotime($inTime->authTime);
        //                             $start_time = strtotime($system_start);
        //                             if($enter_time > $start_time ){
        //                                 $data['late'] = Helper::getTime($inTime->authTime,$system_start);
        //                             }
        //                             $attendance = Attendance::create($data);
                                    
        //                         }
        //                     }
                            
        //                     // end
                                
        //                 }
        //         }
    
        //     }

        // })->daily()->at('12:21');
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
