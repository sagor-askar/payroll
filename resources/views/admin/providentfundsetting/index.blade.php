@extends('layouts.admin')

@section('content')
<style>
    .switch {
  position: relative;
  display: inline-block;
  width: 60px;
  height: 34px;
}

.switch input { 
  opacity: 0;
  width: 0;
  height: 0;
}

.slider {
  position: absolute;
  cursor: pointer;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background-color: #ccc;
  -webkit-transition: .4s;
  transition: .4s;
}

.slider:before {
  position: absolute;
  content: "";
  height: 26px;
  width: 26px;
  left: 4px;
  bottom: 4px;
  background-color: white;
  -webkit-transition: .4s;
  transition: .4s;
}

input:checked + .slider {
  background-color: #2196F3;
}

input:focus + .slider {
  box-shadow: 0 0 1px #2196F3;
}

input:checked + .slider:before {
  -webkit-transform: translateX(26px);
  -ms-transform: translateX(26px);
  transform: translateX(26px);
}

/* Rounded sliders */
.slider.round {
  border-radius: 34px;
}

.slider.round:before {
  border-radius: 50%;
}
</style>

    <div class="content">
        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        Provident Fund Setting
                    </div>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="card">
                                    <div class="card-body">
                                        <h5 class="card-title">Provident Fund</h5>
                                        <div class="text-center">
                                            @isset($data)
                                                @if ($data->status == 0)
                                                    <span> Inactive</span>
                                                        <label class="switch">
                                                            <input type="checkbox" id="status" class="dataID" name="dataID" value="{{ $data->id }}">
                                                            
                                                            <span class="slider round"></span>
                                                        </label>
                                                    <span class="text-primary"> Active</span>
                                                @else
                                                <span> Inactive</span>
                                                    <label class="switch">
                                                        <input type="checkbox" id="status"  class="dataID2" name="dataID2" checked value="{{ $data->id }}">
                                                       
                                                        <span class="slider round"></span>
                                                    </label>
                                                <span class="text-primary"> Active</span>
                                                    
                                                @endif
                                            
                                            @endisset                                            
                                            @empty($data)
                                                    <span> Inactive</span>
                                                        <label class="switch">
                                                            <input type="checkbox" id="status" name="graduate">
                                                            <span class="slider round"></span>
                                                        </label>
                                                    <span class="text-primary"> Active</span>                                              
                                            
                                            @endempty                                            
                                          </div>
                                    </div>
                                </div>                             
                            </div>
                            <div class="col-lg-6">
                                <div class="card">
                                    <div class="card-body">
                                        <h5 class="card-title">Company Contribution</h5>
                                        <div class="text-center">
                                            @isset($data)
                                                @if ($data->company_contribution_status == 0)
                                                    <span> NO</span>
                                                        <label class="switch">
                                                            <input type="checkbox" id="company_contribution_status" class="dataID" name="dataID" value="{{ $data->id }}">
                                                            
                                                            <span class="slider round"></span>
                                                        </label>
                                                    <span class="text-primary"> YES</span>
                                                @else
                                                <span> NO</span>
                                                    <label class="switch">
                                                        <input type="checkbox" id="company_contribution_status"  class="dataID2" name="dataID2" checked value="{{ $data->id }}">
                                                       
                                                        <span class="slider round"></span>
                                                    </label>
                                                <span class="text-primary"> YES</span>
                                                    
                                                @endif
                                            
                                            @endisset                                            
                                            @empty($data)
                                                    <span> NO</span>
                                                        <label class="switch">
                                                            <input type="checkbox" id="company_contribution_status" name="graduate">
                                                            <span class="slider round"></span>
                                                        </label>
                                                    <span class="text-primary"> YES</span>                                              
                                            
                                            @endempty   
                                          </div>
                                    </div>
                                </div>                             
                            </div>
                        </div>                       
                       
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    @parent

    <script>
        $(document).ready(function(){
            $('#status').click(function() {
                var statusValue = $('#status').is(':checked');
                var dataID = $('.dataID').val();
                if(dataID == undefined){
                   dataID = 'undefined';
                }
               
                if(statusValue == true){
                    $.ajax({
                        url: 'providentfundstatus/'+statusValue+'/'+dataID,
                        data: status,
                        type: 'GET',
                        dataType: 'json',
                        success: function(response){
                            console.log(response);
                        },
                        error: function(xhr){
                            // Handle error
                            
                        }
                    });
                }
                else if(statusValue == false){
                    var dataID2 = $('.dataID2').val();
                    $.ajax({                       
                        url: 'providentfundstatus/'+statusValue+'/'+dataID2,
                        data: status,
                        type: 'GET',
                        dataType: 'json',
                        success: function(response){
                            console.log(response);
                        },
                        error: function(xhr){
                            // Handle error
                            
                        }
                    });

                }
            });
            $('#company_contribution_status').click(function() {
                var statusValue = $('#company_contribution_status').is(':checked');
                var dataID = $('.dataID').val();
                if(dataID == undefined){
                   dataID = 'undefined';
                }
               
                if(statusValue == true){
                    $.ajax({
                        url: 'providentfundcompany/'+statusValue+'/'+dataID,
                        data: status,
                        type: 'GET',
                        dataType: 'json',
                        success: function(response){
                            console.log(response);
                        },
                        error: function(xhr){
                            // Handle error
                            
                        }
                    });
                }
                else if(statusValue == false){
                    var dataID2 = $('.dataID2').val();
                    $.ajax({                       
                        url: 'providentfundcompany/'+statusValue+'/'+dataID2,
                        data: status,
                        type: 'GET',
                        dataType: 'json',
                        success: function(response){
                            console.log(response);
                        },
                        error: function(xhr){
                            // Handle error
                            
                        }
                    });

                }
            });
          
        });
    </script>
 

   
@endsection



