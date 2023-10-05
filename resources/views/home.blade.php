@extends('layouts.admin')
@section('content')
@section('styles')  
    <link href="{{ asset('css/dashboard.css') }}" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.9.0/fullcalendar.css" />
    <style>
        .fc-content{
           
            height: 55px  !important;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .fc-title{
           color: white  !important;
           display:inline-block !important;
            width: 150px !important;
            word-break: break-word !important;
            font-size: 18px;
            margin-left: 10px;
        }
        .fc-event {
            background-color: #dc3545;
            border: 1px solid #dc3545;
        }
        .fc-unthemed td.fc-today {
            background: #f7e899;
        }
    </style>

@endsection

<div class="content">
  <div class="row">
    <div class="col-lg-12">
      <div class="panel panel-default">
        @if ($role_title == 'Admin' || $role_title == 'HR')
        <div class="panel-body" style="margin-top: 2%">
          <div class="col-md-3">
            <div class="widget-small primary common"><i class="icon fa fa-users fa-3x"></i>
              <div class="info">
                <h2>Total Employee</h2>
                <p><b>{{ $totalEmpoyees }}</b></p>
              </div>
            </div>
          </div>
          <div class="col-md-3">
            <div class="widget-small info common"><i class="icon fa fa-thumbs-o-up fa-3x"></i>
              <div class="info">
                <h2>Today's Presents</h2>
                <p><b>{{ $totalPresents }}</b></p>
              </div>
            </div>
          </div>
          <div class="col-md-3">
            <div class="widget-small warning common"><i class="icon fa fa-files-o fa-3x"></i>
              <div class="info">
                <h2>Today's Absents</h2>
                <p><b>{{ $totalEmpoyees - $totalPresents }}</b></p>
              </div>
            </div>
          </div>
          <div class="col-md-3">
            <div class="widget-small danger common"><i class="icon fa fa-star fa-3x"></i>
              <div class="info">
                <h2>Today's Leave</h2>
                <p><b>{{ $totalLeaves }}</b></p>
              </div>
            </div>
          </div>
        </div>
        @else
        <div class="panel-body" style="margin-top: 2%">
          <div class="col-md-4">
            <div class="widget-small primary common"><i class="icon fa fa-users fa-3x"></i>
              <div class="info">
                <h2>Total Leave</h2>
                <p><b>{{ $employeeTotalLeave }}</b></p>
              </div>
            </div>
          </div>
          <div class="col-md-4">
            <div class="widget-small info common"><i class="icon fa fa-thumbs-o-up fa-3x"></i>
              <div class="info">
                <h2>Advance Salary</h2>
                <p><b>{{ $employeeAdvancedSalary }}</b></p>
              </div>
            </div>
          </div>
          <div class="col-md-4">
            <div class="widget-small warning common"><i class="icon fa fa-files-o fa-3x"></i>
              <div class="info">
                <h2>Loan</h2>
                <p><b>{{ $employeeLoan }}</b></p>
              </div>
            </div>
          </div>
        </div>

        @endif

      </div>
    </div>
  </div>

  <div class="row">
    @if ($role_title == 'Admin' || $role_title == 'HR')
      <div class="col-lg-6">
        <div class="panel panel-default">
          <div class="panel-heading">
              <h5>Today's Absenst List || Date: <b> <?php echo date("d/m/Y"); ?></b> </h5>
          </div>
          <div class="panel-body">
              <div class="table-responsive">
                  <table class=" table table-bordered table-striped table-hover datatable datatable-lateConsideration">
                      <thead>
                          <tr>
                              <th>Name</th>
                              <th>Status</th>
                          </tr>
                      </thead>
                      <tbody>
                        @foreach ($absent as $value)
                              <tr>
                                <td>{{ $value->first_name  }}</td>
                                <td><span class="absent-btn">Absent</span></td>
                            </tr>                        
                        @endforeach                     
                      </tbody>
                  </table>
              </div>
          </div>
        </div>
      </div>
      @endif

      @if ($role_title == 'Employee')
      <div class="col-lg-6">
        <div class="panel panel-default">
          <div class="panel-heading">
            Demo Chart
          </div>
        </div>
        <div class="panel-body">
          <div id="piechart">
          </div>
        </div>
        
      </div>
      @endif

      <div class="col-lg-6">
          <div class="panel panel-default">
            <div class="panel-heading">
                <h5>Calendar</h5>
            </div>
            <div class="panel-body" >
              <div id="calendar"></div>
            </div>
          </div>
      </div>
  </div>

</div>

@endsection
@section('scripts')
@parent
<script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.9.0/fullcalendar.js"></script>
<script src="{{asset('js/cal.js')}}"></script>

<!-- js for google chart -->
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script type="text/javascript">
// Load google charts
google.charts.load('current', {'packages':['corechart']});
google.charts.setOnLoadCallback(drawChart);

// Draw the chart and set the chart values
function drawChart() {
  var data = google.visualization.arrayToDataTable([
  ['Task', 'Hours per Day'],
  ['Task 1', 8],
  ['Task 2', 2],
  ['Task 3', 4],
  ['Task 4', 2],
  ['Task 5', 8]
]);

  // title; width & height of the chart
  var options = {'title':'My Tasks', 'width':500, 'height':300};

  // Display the chart
  var chart = new google.visualization.PieChart(document.getElementById('piechart'));
  chart.draw(data, options);
}
</script>
@endsection