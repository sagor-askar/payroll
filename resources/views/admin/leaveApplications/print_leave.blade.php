<!DOCTYPE html>
<html dir="ltr" lang="en-US">

<head>
    <meta charset="utf-8" />
    <title>Leave Application</title>
    <meta name="author" content="Harrison Weir" />
    <meta name="subject" content="" />
    <meta name="keywords" content="cats,feline" />
    <meta name="date" content="2014-12-05" />

    <style>
        table {
            border-collapse: collapse;
            width: 100%;
            font-size: 15px;
            background-color: white;
        }

        th,
        td {
            padding: 5px;
            text-align: left;
            margin-top: 10px;
            border: 0.1px solid grey;
        }

        tr {
            page-break-inside: 30px;
            margin: 2px;
        }

        .column {
            margin-top: 20px;
            float: left;
            width: 50%;
            padding: 5px;
        }

        .column p {
            margin: 3px;
            font-size: 10px;
        }

        .row:after {
            content: "";
            display: table;
            clear: both;
        }

        @page {
            size: A4;
            margin: 20pt 30pt 30pt;
        }

        @page: first {
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

        .column p {
            font-size: 14px;
        }

    </style>
</head>

<body>
    <div class="frontcover">
    </div>
    <div class="contents">
        <div class="row">
            <div class="column">
                <img src="data:image/png;base64,<?php echo base64_encode(file_get_contents(base_path('public/images/settings/' . $setting->company_logo))); ?>" width="80 px;">
            </div>
            <div class="column" style="text-align: right; margin-top: -15px; margin-bottom: 30px;">
                <h3>{{ $setting->company_title}}</h3>
                <p>{{ $setting->company_address}}</p>
                <p>Email : {{ $setting->company_email}}</p>
                <p>Phone : {{ $setting->company_phone}}</p>
            </div>

        </div>

        <div class="panel-heading row">
            <div style="float: left;">
                <h4><b>Leave Application</b></h4>
            </div>

            <div class="panel-heading" style="float: right;margin-top:-8px;">
                <h4><b>Date : {{date('d-m-Y')}}</b></h4>
            </div>
        </div>

        <br>

        <table>
            <tr>
                <th>Employee Name</th>
                <td>{{$leave_application->employee->first_name.' '.$leave_application->employee->last_name}}</td>
            </tr>
            <tr>
                <th>Employee ID</th>
                <td>{{$leave_application->employee->employee_manual_id}}</td>
            </tr>
            <tr>
                <th>Designation</th>
                <td>{{$leave_application->employee->designation->designation_name}}</td>
            </tr>
            <tr>
                <th>Department</th>
                <td>{{$leave_application->employee->department->department_name}}</td>
            </tr>
            <tr>
                <th>Leave From</th>
                <td>{{ \Carbon\Carbon::parse($leave_application->start_date)->format('d-m-Y')}}</td>
            </tr>
            <tr>
                <th>To</th>
                <td>{{ \Carbon\Carbon::parse($leave_application->end_date)->format('d-m-Y')}}</td>
            </tr>
            <tr>
                <th>Leave Type</th>
                <td>{{$leave_application->leave_type->leave_name}}</td>
            </tr>
            <tr>
                <th>No. of Days</th>
                <td>{{$leave_application->no_of_days}}</td>
            </tr>
        </table>

        <br>

        <div class="col-8 col-md-4" style="height: 200px; width: auto; font-size: 15px;">
            <b>Reason:</b> <br>
            <p style="text-align: justify;">
                {!! $leave_application->reason !!}
            </p>

        </div>

    </div>

    <div class="justify-content-end">
        <br>
        <p>.....................</p>
        <p>Authorized Signature</p>
    </div>

    <footer>
        <p>All Right Reserved. @ Polock Group</p>
    </footer>

</body>

</html>