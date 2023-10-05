
<!DOCTYPE html>
<html dir="ltr" lang="en-US">
  <head>
  <meta charset="utf-8" />
  <title>Print Employee Information</title>
  <meta name="author" content="Harrison Weir"/>
  <meta name="subject" content=""/>
  <meta name="keywords" content="cats,feline"/>
  <meta name="date" content="2014-12-05"/>

  <style>
    table {
        border-collapse: collapse;
        width: 100%;
        font-size: 15px;
    }

    th, td {
        padding: 8px;
        text-align: left;
        border-bottom: 1px solid #ddd;
        margin-top: 10px;
    }

    tr {
        page-break-inside:30px; margin: 5px;
    }

    th {
        background-color: #f2f2f2;
    }

    .column {
        margin-top: 20px;
        float: left;
        width: 50%;
        padding: 5px;
    }

    .column p{
        margin: 1px;
        font-size: 14px;
    }

    .row:after {
        content: "";
        display: table;
        clear: both;
    }

    @page {
        size: A4;
        margin: 20pt 40pt 40pt;
    }

    @page:first {
    size: 5.5in 8.5in;
    margin: 0;
    }

    footer {
        position: fixed;
        bottom: 0;
        width: 100%;
        padding: 10px;
        text-align: center;
        font-size: 13px;
    }
  </style>



  </head>
  <body>
    <div class="frontcover">
    </div>
    <div class="contents">
        <div class="row">
            <div class="column">
                <img  src="data:image/png;base64,<?php echo base64_encode(file_get_contents(base_path('public/images/settings/'.$setting->company_logo))); ?>" width="80 px;">
            </div>
            <div class="column" style="margin-top: -15px; margin-bottom: 30px;">
                <h3>{{ $setting->company_title}}</h3>
                <p>{{ $setting->company_address}}</p>
                <p>Email : {{ $setting->company_email}}</p>
                <p>Phone : {{ $setting->company_phone}}</p>
            </div>

        </div>

        <div class="panel-heading row">
            <div style="float: left;">
                <h4><b>Employee Information</b></h4>
            </div>

            <div class="panel-heading" style="float: right;margin-top:-8px;">
                <h4><b>Date : {{date('d-m-Y')}}</b></h4>
            </div>
        </div>

        <br>

        <table class="table">
            <thead>
                <tr>
                    <th scope="col">SL.</th>
                    <th scope="col">Employee Name</th>
                    <th scope="col">Employee Manual ID</th>
                    <th scope="col">Department</th>
                    <th scope="col">Contact No</th>
                </tr>
            </thead>
            <tbody>
                @foreach($employees as $employee)
                <tr>
                    <td>{{ $employee->id ?? '' }}</td>
                    <td>{{ $employee->first_name ?? '' }} {{ $employee->last_name ?? '' }}</td>
                    <td>{{ $employee->employee_manual_id ?? '' }}</td>
                    <td>{{ $employee->department->department_name ?? '' }}</td>
                    <td>{{ $employee->contact_no ?? '' }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <footer>
        <p>All Right Reserved. @ Polock Group</p>
    </footer>

  </body>
</html>

