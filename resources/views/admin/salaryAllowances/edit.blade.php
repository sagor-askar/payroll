@extends('layouts.admin')
@section('content')
<div class="content">

    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    {{ trans('global.edit') }} {{ trans('cruds.salaryAllowance.title_singular') }}
                </div>
                <div class="panel-body">
                    <form method="POST" action="{{ route("admin.salary-allowances.update", [$salaryAllowance->id]) }}" enctype="multipart/form-data">
                        @method('PUT')
                        @csrf
                        <div class="col-md-6">
                            <div class="form-group {{ $errors->has('allowance_name') ? 'has-error' : '' }}">
                                <label class="required" for="allowance_name">{{ trans('cruds.salaryAllowance.fields.allowance_name') }}</label>
                                <input class="form-control" type="text" name="allowance_name" id="allowance_name" value="{{ old('allowance_name', $salaryAllowance->allowance_name) }}" required>
                                @if($errors->has('allowance_name'))
                                    <span class="help-block" role="alert">{{ $errors->first('allowance_name') }}</span>
                                @endif
                                <span class="help-block">{{ trans('cruds.salaryAllowance.fields.allowance_name_helper') }}</span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group {{ $errors->has('percentage') ? 'has-error' : '' }}">
                                <input type="hidden" name="hidden_percentage" id="hidden_percentage" value="{{$salaryAllowance->percentage}}">
                                <label class="required" for="percentage">{{ trans('cruds.salaryAllowance.fields.percentage') }}</label>
                                <input class="form-control" type="number" name="percentage" id="percentage" value="{{ old('percentage', $salaryAllowance->percentage) }}" required>
                                @if($errors->has('percentage'))
                                    <span class="help-block" role="alert">{{ $errors->first('percentage') }}</span>
                                @endif
                                <span class="help-block">{{ trans('cruds.salaryAllowance.fields.percentage_helper') }}</span>
                            </div>
                        </div>

                        <div class="form-group checkpercentagemsg" style="color: #dd4b39;">
                            <span> </span>
                        </div>

                        <div class="col-md-12">
                            <div class="form-group">
                                <button class="button check_button" type="submit">
                                    {{ trans('global.save') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>



        </div>
    </div>
</div>



@endsection
@section('scripts')
<script>
    $(document).ready(function() {
        $('input[name="percentage"]').on('input', function() {
            var percent = $(this).val();
            var hidden_percent= $('#hidden_percentage').val();
            $.get('/admin/salary-allowances/check_percentage/edit/' + percent + '/'+ hidden_percent , function(data) {
                if (data.lims_total_percentage > 100){
                    currentvaluemsg = 'Your Limitation will  not be  more than '+data.remaining_total_percent + '%'
                    statusMsg = ' Your total Percentage is over than 100 ! ' + currentvaluemsg ;
                    $(".checkpercentagemsg ").text(statusMsg );
                    document.querySelector('.check_button').disabled = true;
                }else{
                    statusMsg = '  ' ;
                    $(".checkpercentagemsg ").text(statusMsg );
                    document.querySelector('.check_button').disabled = false;
                }
            });
        });
    });
</script>  
@endsection
