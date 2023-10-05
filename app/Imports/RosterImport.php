<?php

namespace App\Imports;

use App\Models\Employee;
use App\Models\Roster;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

class RosterImport implements ToCollection, WithHeadingRow
{

    public function startRow(): int
    {
        return 2;
    }
    public function collection(Collection  $rows)
    {

        Validator:: make($rows->toArray(), [
            '*.employee_manual_id' => 'required',
            '*.name'               => 'required',
            '*.duty_date'          => 'required',
            '*.start_time'         => 'required',
            '*.end_time'           => 'required',
        ])->validate();

            foreach($rows as $row){
                $duplicatCheck = Roster::where('employee_manual_id',$row['employee_manual_id'])->where('duty_date',\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row['duty_date'])->format('Y-m-d'))->count();
                if($duplicatCheck){
                    return redirect()->route('admin.rosters.index')->with('error','Duplicate Entry');
                }else{
                    $employee = Employee::where('employee_manual_id',$row['employee_manual_id'])->first();
                    Roster::create([
                        "employee_id" => $employee->id,
                        "employee_manual_id"  => $row['employee_manual_id'],
                        "name"                => $row['name'],
                        "duty_date"           => \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row['duty_date'])->format('Y-m-d'),
                        "start_time"          => $row['start_time'],
                        "end_time"            => $row['end_time']
                    ]);
                }
                
            } 
            return redirect()->route('admin.rosters.index')->with('message','Data Imported successfully');

    }
}
