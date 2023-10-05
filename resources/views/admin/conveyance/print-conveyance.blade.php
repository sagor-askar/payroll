
<!DOCTYPE html>
<html dir="ltr" lang="en-US">
  <head>
  <meta charset="utf-8" />
 
  <meta name="author" content="Harrison Weir"/>
  <meta name="subject" content="Cats. Their Varieties, Habits and Management; and for show, the Standard of Excellence and Beauty"/>
  <meta name="keywords" content="cats,feline"/>
  <meta name="date" content="2014-12-05"/>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
  <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.3/dist/jquery.slim.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
 
  </head>
  <body>
 
    <div class="contents">
        <div class="row">
            <div class="column">
                <img  src="data:image/png;base64,<?php echo base64_encode(file_get_contents(base_path('public/images/settings/'.$setting->company_logo))); ?>" width="80 px;">
            </div>
            <div class="column" style="margin-top: -15px; margin-bottom: 30px; float: left;">
                <h3>{{ $setting->company_title}}</h3>
                <p>{{ $setting->company_address}}</p>
                <p>Email : {{ $setting->company_email}}</p>
                <p>Phone : {{ $setting->company_phone}}</p>
            </div>

        </div>

        <div class="panel-heading row">
            <div style="float: left;">
                <h4><b>Conveyance Bill</b></h4>
            </div>

            <div class="panel-heading" style="float: right;margin-top:-8px;">
                <h4><b>Date : {{date('d-m-Y')}}</b></h4>
            </div>
        </div>

        <br>

        <table class="table table-bordered table-striped">
            <tbody>
                <tr>
                    <th style="text-align:left;">
                        Employee Name
                    </th>
                    <td>
                        : {{$conveyances->employee->first_name.' '.$conveyances->employee->last_name}}
                    </td>
                </tr>
                <tr>
                    <th style="text-align:left;">
                        Department
                    </th>
                    <td>
                        : {{ $conveyances->department->department_name}}
                    </td>
                </tr>
                <tr>
                    <th style="text-align:left;">
                        Designation
                    </th>
                    <td>
                        : {{ $conveyances->designation->designation_name }}
                    </td>
                </tr>

                <tr>
                    <th style="text-align:left;">
                        Date
                    </th>
                    <td>
                        : {{ \Carbon\Carbon::parse($conveyances->date)->format('d-m-Y')}}
                    </td>
                </tr>
            </tbody>
        </table>

        <br>

         
        <table style="height: auto;" class="table table-sm table-bordered table-striped table-hover">
            <thead style="background-color: #d9d9d9;">
                <tr>
                    <th scope="col"></th>
                    <th scope="col">Description</th>
                    <th scope="col">From Place</th>
                    <th scope="col">To Place</th>
                    <th scope="col">Mode of Transportation</th>
                    <th scope="col">Amount</th>
                </tr>
            </thead>
            @php 
                $total = 0;
            @endphp
            <tbody>
                @foreach($conveyanceItems as $key=>$conv_item)
                    @php
                        $total += $conv_item->cost
                    @endphp
                <tr>
                    <th scope="row">{{ $key+1 }}</th>

                    <td>{{ $conv_item->description }}</td>

                    <td>{{ $conv_item->from_place }}</td>

                    <td style="text-align:center;">{{ $conv_item->to_place }}</td>

                    <td style="text-align:center;">{{ $conv_item->mode_of_transport }}</td>

                    <td style="text-align:center;">{{ $conv_item->cost }}</td>
                </tr>
                @endforeach 

                @php
                    $f = new \NumberFormatter( locale_get_default(), \NumberFormatter::SPELLOUT );
                    $word =ucwords($f->format($total)) ;
                @endphp
                
                <br>
                <br>

                <tr>
                    <th scope="row"></th>
                    <td><b>Total Amount: </b>{{ $total }} BDT</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <th scope="row"></th>
                    <td><b>In Words: </b> {{$word}} Taka Only.</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
            </tbody>
        </table>
           
        <br>
        <br>

        <div class="row">
            <div class="row-side">
                <div class="column-side">
                    <p>Prepared By</p>
                    <p>.............</p>
                </div>
                <div class="column-side">
                    <p>Accounts</p>
                    <p>.............</p>
                </div>
                <div class="column-side">
                    <p>Approved By</p>
                    <p>.............</p>
                </div>
            </div>
        </div>

        <footer style="bottom: 0; text-align:center; font-size: 15px;">
            <p class="text-center">Generated By - <a> Polock Group</a></p>
            <a href="mailto:info@polockgroup.com.bd">info@polockgroup.com.bd</a></p>
        </footer>

    </div>


  </body>
</html>


<style>

    .column-side {
    float: left;
    width: 30%;
    padding: 10px;
    text-align: center;
    }

    .row-side:after {
    content: "";
    display: table;
    clear: both;
    }

    table { font-size: 15px; }
    td    { margin-top: 10px;  }
    tr    { page-break-inside:30px; margin: 5px; }

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

</style>
