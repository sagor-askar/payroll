<!DOCTYPE html>
<html dir="ltr" lang="en-US">

<head>
    <meta charset="utf-8" />
    <title>Print Employee Information</title>
    <meta name="author" content="Harrison Weir" />
    <meta name="subject" content="" />
    <meta name="keywords" content="cats,feline" />
    <meta name="date" content="2014-12-05" />

    <style>
        table {
            border-collapse: collapse;
            width: 100%;
            font-size: 13px;
        }

        th,
        td {
            padding: 5px;
            text-align: left;
            border-bottom: 1px solid #ddd;
            margin-top: 10px;
        }

        tr {
            page-break-inside: 30px;
            margin: 2px;
        }

        th {
            background-color: #f2f2f2;
        }

        table th, td, tr {
            border: 0.01px solid black;
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
            margin: 15pt 25pt 20pt;
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
                <h4><b>Payment Information of {{ $monthName }}</b></h4>
            </div>

            <div class="panel-heading" style="float: right;margin-top:-8px;">
                <h4><b>Date : {{date('d-m-Y')}}</b></h4>
            </div>
        </div>

        <br>

        <table class="table">
            <thead>
                <tr>
                    <th scope="col">Emp. Name</th>
                    <th scope="col">Basic</th>
                    <th scope="col">Allowance</th>
                    <th scope="col">Additional</th>
                    <th scope="col">Over Time</th>
                    <th scope="col">Bonus</th>
                    <th scope="col">Gross</th>
                    <th scope="col">Loan</th>
                    <th scope="col">PF</th>
                    <th scope="col">Advance</th>
                    <th scope="col">Deduction</th>
                    <th scope="col">Late Deduction</th>
                    <th scope="col">Total Deduction</th>
                    <th scope="col">Net Salary</th>
                </tr>
            </thead>
            <tbody>
                @foreach($salaryChart as $key => $chart)
                <tr data-entry-id="{{ $chart->id }}">

                    <td>{{ $chart->employee->first_name.' '.$chart->employee->last_name }}</td>
                    <td>{{ $chart->basic_amount }}</td>
                    <td>{{ $chart->allowance_amount }}</td>
                    <td>{{ $chart->additional_amount }}</td>
                    <td>{{ $chart->ot_salary }}</td>
                    <td>{{ $chart->bonus }}</td>
                    <td>{{ $chart->gross_salary }}</td>
                    <td>{{ $chart->loan_amount }}</td>
                    <td>{{ $chart->pf_loan_amount }}</td>
                    <td>{{ $chart->advance_amount }}</td>
                    <td>{{ $chart->deduction_amount }}</td>
                    <td>{{ $chart->late_deduction_amount }}</td>
                    <td>{{ $chart->total_deduction }}</td>
                    <td>{{ $chart->net_salary }}</td>

                </tr>
                @endforeach
            </tbody>
        </table>
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