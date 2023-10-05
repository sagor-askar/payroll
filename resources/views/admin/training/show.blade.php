@extends('layouts.admin')
@section('content')
    <div class="content">

        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        {{ trans('global.show') }} Training Employee
                    </div>
                    <div class="panel-body col-md-5">
                        <table class="table table-bordered table-striped">
                            <tbody>
                                @php
                                    if($training->employee_id != null){
                                        $employee_id = json_decode($training->employee_id);
                                    }
                                @endphp
                            <tr>
                                <th>
                                     Employees
                                </th>
                                <td>
                                    @if($training->employee_id != null)
                                        <ul> @foreach($employee_id as $key=> $val)
                                                @php 
                                                $employee =   App\Models\Employee::find($val);
                                                @endphp

                                            <li>{{$employee->first_name .' '.$employee->last_name}}</li>
                                            @endforeach
                                        </ul>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <th>
                                    Trainer
                                </th>
                                <td>
                                    {{ $training->trainer->name ?? '' }}
                                </td>
                            </tr>
                            <tr>
                                <th>
                                    Training Type
                                </th>
                                <td>
                                    {{ $training->training_type->name ?? '' }}
                                </td>
                            </tr>
                            <tr>
                                <th>
                                    Training Skill
                                </th>
                                <td>
                                    {{ $training->trainingSkill->name ?? '' }}
                                </td>
                            </tr>

                            <tr>
                                <th>
                                    Training Cost
                                </th>
                                <td>
                                    {{ $training->cost ?? '' }}
                                </td>
                            </tr>
                            <tr>
                                <th>
                                  Start Date
                                </th>
                                <td>
                                    {{ \Carbon\Carbon::parse($training->start_date)->format('d-m-Y') }}
                                </td>
                            </tr>
                            <tr>
                                <th>
                                    End Date
                                </th>
                                <td>
                                    {{ \Carbon\Carbon::parse($training->end_date)->format('d-m-Y') }}
                                </td>
                            </tr>

                            <tr>
                                <th>
                                    Remarks
                                </th>
                                <td>
                                  <strong>{{ $training->remarks }}</strong>
                                </td>
                            </tr>

                            <tr>
                                <th>
                                    Performance
                                </th>
                                @if($training->performance == null)
                                    <td><strong style="color: #dd4b39"> Not Yet</strong> </td>
                                @elseif($training->performance == 1)
                                    <td><strong style="color: darkgreen"> Excellent</strong> </td>
                                @elseif($training->performance == 2)
                                    <td><strong style="color: green"> Satisfactory</strong> </td>
                                @elseif($training->performance == 3)
                                    <td><strong style="color: #DA9922FF"> Average</strong> </td>
                                @elseif($training->performance == 4)
                                    <td><strong style="color: #DA5922FF"> Poor</strong> </td>
                                @else
                                    <td><strong style="color: red"> Not Concluded</strong> </td>
                                @endif
                            </tr>

                            <tr>
                                <th>
                                    Status
                                </th>
                                @if($training->status == 0)
                                    <td><strong style="color: #dd4b39"> Pending</strong> </td>
                                @elseif($training->status == 1)
                                    <td><strong style="color: green;"> Approved</strong> </td>
                                @elseif($training->status == 2)
                                    <td><strong style="color: darkgreen"> Started</strong> </td>
                                @elseif($training->status == 3)
                                    <td><strong style="color: darkgreen"> Completed</strong> </td>
                                @else
                                    <td><strong style="color: red"> Terminated</strong> </td>
                                @endif
                            </tr>

                            <tr>
                                <th>
                                    Description
                                </th>
                                <td>
                                    {{ $training->description }}
                                </td>
                            </tr>
                            </tbody>
                        </table>
                        <div>
                        </div>
                        <div class="form-group">
                            <a class="btn btn-default" href="{{ route('admin.training.index') }}">
                                {{ trans('global.back_to_list') }}
                            </a>
                        </div>
                    </div>

                    <div class="panel-body" col-md-7 >

                        <div class="panel-heading">
                            <h3> Update Status</h3>
                        </div>

                        <form method="POST" action="{{ route("admin.training.updateStatus", [$training->id]) }}" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group {{ $errors->has('performance	') ? 'has-error' : '' }}">
                                        <label  for="performance">Performance</label>
                                        <select  class="form-control select2" name="performance" id="performance" >
                                             <option  value="">Select One</option>
                                             <option  value="1" @if($training->performance ==1) selected @endif>Excellent</option>
                                             <option  value="2" @if($training->performance ==2) selected @endif>Satisfactory</option>
                                             <option  value="3" @if($training->performance ==3) selected @endif>Average</option>
                                             <option  value="4" @if($training->performance ==4) selected @endif>Poor</option>
                                             <option  value="5" @if($training->performance ==5) selected @endif>Not Concluded</option>
                                        </select>
                                        @if($errors->has('performance'))
                                            <span class="help-block" role="alert">{{ $errors->first('performance') }}</span>
                                        @endif
                                    </div>
                                    <div class="form-group {{ $errors->has('status') ? 'has-error' : '' }}">
                                        <label  for="status">Status</label>
                                        <select class="form-control select2" name="status" id="status" >
                                            <option  value="0" @if($training->status ==0) selected @endif>Pending</option>
                                            <option  value="1" @if($training->status ==1) selected @endif>Approved</option>
                                            <option  value="2" @if($training->status ==2) selected @endif>Started</option>
                                            <option  value="3" @if($training->status ==3) selected @endif>Completed</option>
                                            <option  value="4" @if($training->status ==4) selected @endif>Terminated</option>
                                        </select>
                                        @if($errors->has('status'))
                                            <span class="help-block" role="alert">{{ $errors->first('status') }}</span>
                                        @endif
                                    </div>
                                    <div class="form-group {{ $errors->has('remarks') ? 'has-error' : '' }}">
                                        <label for="remarks">Remarks</label>
                                        <textarea class="form-control" name="remarks" id="remarks" cols="30" rows="2">{!! $training->remarks  !!}</textarea>
                                        @if($errors->has('remarks'))
                                            <span class="help-block" role="alert">{{ $errors->first('remarks') }}</span>
                                        @endif
                                    </div>
                                    <div class="form-group">
                                        <button class="button" type="submit">
                                            {{ trans('global.save') }}
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

        </div>
    </div>
    </div>
@endsection
