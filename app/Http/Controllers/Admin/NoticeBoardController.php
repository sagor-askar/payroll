<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\AttLog;
use App\Models\Department;
use App\Models\Employee;
use App\Models\NoticeBoard;
use App\Models\Roster;
use App\Models\Rule;
use App\Models\Shift;
use App\Models\User;
use App\Notifications\NoticeNotification;
use Illuminate\Http\Request;
use Gate;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;
use Notification;
use Carbon\Carbon;

class NoticeBoardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        abort_if(Gate::denies('notice_board_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $noticeBoards = NoticeBoard::paginate(10);

        return view('admin.noticeBoard.index', compact('noticeBoards'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        abort_if(Gate::denies('notice_board_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $departments = Department::get();
        $employees = Employee::all();

        return view('admin.noticeBoard.create',compact('departments','employees'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
            $noticeBoard = NoticeBoard::create($request->all());
            if($request->department_id == null){
                Notification::send(User::all(), new NoticeNotification($noticeBoard));
                $users = User::where('is_active',1)->get();
                foreach($users as $user){
                    $user->update(['fcm_token'=>$request->token]);
                }
            }
            else if($request->department_id != null && $request->employee_id != null){
                $user = User::where('employee_id',$request->employee_id)->first();                
                $fUser = User::find($user->id);               
                $fUser->update(['fcm_token'=>$request->token]);
                $user->notify(new NoticeNotification($noticeBoard));
                
            }
            else{
                $employees = Employee::where('department_id',$request->department_id)->get();
                foreach($employees as $key=>$item){
                   $users[]= User::where('employee_id',$item->id)->first();
                }
        
                Notification::send($users, new NoticeNotification($noticeBoard));
            }  
            
            $url = 'https://fcm.googleapis.com/fcm/send';

      $FcmToken = User::whereNotNull('fcm_token')->pluck('fcm_token')->all();
      
        $serverKey = 'AAAAqUhongA:APA91bGzCMkDDcmMJoMOZZblo7fYeW1mlg7g68Wc3ttUO3JnIeYG8OJN5nExs2GbXhk-Z_3JkM5xkTocC5bCie7e13oY0VpefgGcBHzRyg-uMeTc9TCccZzvO-Imrb47MT6Zk7KT_ojw'; // ADD SERVER KEY HERE PROVIDED BY FCM
          $data = [
            "registration_ids" => $FcmToken,
            "notification" => [
                "title" => $request->notice_title,
                "body" => $request->description,  
            ]
        ];
        $encodedData = json_encode($data);
       
        $headers = [
            'Authorization:key=' . $serverKey,
            'Content-Type: application/json',
        ];
       
        $ch = curl_init();
        
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
        // Disabling SSL Certificate support temporarly
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $encodedData);
        // Execute post
        $result = curl_exec($ch);
        if ($result === FALSE) {
            die('Curl failed: ' . curl_error($ch));
        }        
        // Close connection
        curl_close($ch);
        // FCM response

           
         
            return redirect()->route('admin.noticeboards.index')->with('message','Notice create successfully!');
        
   
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        abort_if(Gate::denies('notice_board_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');
      
        $noticeBoard = NoticeBoard::findOrFail($id);
        $noticeBoard->load('department', 'employee');
        $seen_user = [];
        if($noticeBoard->seen_users != NULL){
            foreach($noticeBoard->seen_users as $itemKey => $item){
              if($item == Auth::user()->employee_id){
                    $seen_user[]=$item;
                    break;
              }else{
                $seen_user[]=$item;
                $seen_user[] = Auth::user()->employee_id;
              }
            }
            
        }else{
            $seen_user[] = Auth::user()->employee_id;
        }
         $noticeBoard->update([
            'seen_users' => $seen_user,
            'is_seen' => 1
        ]);

        return view('admin.noticeBoard.show', compact('noticeBoard'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        abort_if(Gate::denies('notice_board_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $departments = Department::get();
        $employees = Employee::all();
        $noticeBoard = NoticeBoard::findOrFail($id);
        $noticeBoard->load('department','employee');

        return view('admin.noticeBoard.edit', compact('noticeBoard', 'departments', 'employees'));
    }
    public function getSeenUsers($notice_id)
    {
        $data = NoticeBoard::with('employee')->where('id', $notice_id)->get();
        return json_encode($data);
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
        $noticeBoard = NoticeBoard::find($id);
        $noticeBoard->update($request->all());

        return redirect()->route('admin.noticeboards.index')->with('message', 'Updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
       
        abort_if(Gate::denies('notice_board_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');
        $noticeBoard = NoticeBoard::findOrFail($id);
        $noticeBoard->delete();

        return redirect()->route('admin.noticeboards.index')->with('message', 'Delete successfully');
    }
}
