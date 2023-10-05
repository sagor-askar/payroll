<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>1TouchBD - Career</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>

<body>

    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a href="#">𝟏𝐓𝐨𝐮𝐜𝐡𝐁𝐃</a>
    </nav>

    <div class="header">
        <div class="headerInfo">
            <h4>CAREER</h4>
            <h2>Job Openings</h2>
            <br>
            <h5>Work there. Find the dream job you've always wanted</h5>
        </div>
    </div>

    <div class="jobList">
        <section class="slice slice-lg bg-section-secondary">
            <span class="tongue tongue-top"><i class="ti ti-arrow-down"></i></span>
                <div class="container">
                    <div class="mb-5 text-center">
                        <h3 style="color: #4d4d4d; font-family: Verdana, Geneva, Tahoma, sans-serif;">We help businesses grow</h3>
                        <div class="fluid-paragraph mt-3">
                            <p class="lead lh-180 ">
                                Always looking for better ways to do things, innovate and help people achieve their goals.
                            </p>
                        </div>
                    </div>
                    <div class="row justify-content-center">
                        <div class="col-lg-11">
                            <div class="table-responsive-lg">
                                <table class="table table-hover table-scale--hover table-cards align-items-center">
                                    <tbody>
                                        @foreach($jobsCreate as $key => $jobs)
                                        <tr>
                                            <th scope="row">
                                                <div class="media align-items-center">
                                                    <div>
                                                        <span class="avatar text-white mr-4" title="Job Position">0</span>
                                                    </div>
                                                    <div class="media-body">
                                                        <a name="job_title" href="" class="h5 mb-0">{{ $jobs->job_title }}</a>
                                                    </div>
                                                </div>
                                            </th>

                                            <td>
                                                @if($jobs->job_type == 0)
                                                <td>Job Type: <strong style="color: #dd4b39"> Internship</strong> </td>
                                                @elseif($jobs->job_type == 1)
                                                <td>Job Type: <strong style="color: darkgreen"> Parttime</strong> </td>
                                                @elseif($jobs->job_type == 2)
                                                <td>Job Type: <strong style="color: darkgreen"> Fulltime</strong> </td>
                                                @else
                                                <td>Job Type: <strong style="color: red"> Contactual</strong> </td>
                                                @endif
                                            </td>

                                            <td>
                                                <span name="end_date" class="badge p-2 px-3 rounded">Deadine: {{ $jobs->end_date }}</span>
                                            </td>

                                            <td>
                                                <a class="badge p-2 px-3 rounded" href="{{ route('career.show', $jobs->id) }}" style="text-decoration: none; color: white;">Job Details</a>
                                            </td>
                                            
                                        </tr>

                                        <tr class="table-divider"></tr>
                                        @endforeach
                                        
                                    </tbody>
                                </table>
                            </div>

                        </div>
                    </div>
                </div>
        </section>
    </div>

    <footer style="font-family:'Times New Roman', Times, serif; " id="footer-main">
        <div class="footer-dark">
            <div class="container">
                <div class="row align-items-center justify-content-md-between py-4 mt-4 delimiter-top">
                    <div class="col-md-6">
                        <div class="copyright text-sm font-weight-bold text-center text-md-left">
                            1TouchBD
                        </div>
                    </div>
                    <div class="col-md-6">
                        <ul class="nav justify-content-center justify-content-md-end mt-3 mt-md-0">
                            <li class="nav-item">
                                <a class="nav-link" href="#" target="_blank">
                                    <i class="fa fa-facebook"></i>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#" target="_blank">
                                    <i class="fa fa-instagram"></i>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#" target="_blank">
                                    <i class="fa fa-google"></i>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#" target="_blank">
                                    <i class="fa fa-facebook"></i>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </footer>

    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
</body>

</html>

<style>
    .navbar a {
        margin-left: 150px;
        font-size: 25px;
        text-decoration: none;
        color: #605CA8;
        font-weight: 640;
    }
    .header {
        width: auto;
        margin: 8%;
        font-family: Verdana, Geneva, Tahoma, sans-serif;
    }

    .headerInfo {
        text-align: center;
    }

    .headerInfo h2 {
        color: #4d4d4d;
    }

    .headerInfo h4, h5 {
        color: #b3b3b3;
    }

    .middleInfo {
        margin: 8%;
        text-align: center;
    }

    .media-body a {
        text-decoration: none;
    }

    .media-body a:hover {
        color: #605CA8;
    }

    /* job details table design */

    .table.align-items-center td, .table.align-items-center th {
        vertical-align: middle;
    }

    .table.align-items-center td, .table.align-items-center th {
        vertical-align: middle;
    }

   .td {
        display: table-cell;
   }

   .table-cards tbody tr td:last-child {
        border-radius: 0 0.375rem 0.375rem 0;
    }

    tr:hover {
        transition: all 0.2s ease;
        cursor: pointer;
        box-shadow: 0px 0px 0px 0px #e9ecef;
        transform: scale(1.1);
    }

    .avatar {
        background-color: #605CA8;
        border-radius: 0.25rem;
        position: relative;
        color: #fff;
        display: -webkit-inline-box;
        display: -ms-inline-flexbox;
        display: inline-flex;
        -webkit-box-align: center;
        -ms-flex-align: center;
        align-items: center;
        -webkit-box-pack: center;
        -ms-flex-pack: center;
        justify-content: center;
        font-size: 1rem;
        font-weight: 600;
        height: 50px;
        width: 50px;
    }

    .badge {
        background-color: #605CA8;
        color: white;
    }

    /* responsive design */
    /* Media query for screens smaller than 767px */
    @media (max-width: 767px) {
        .headerInfo h4 {
            font-size: 22px;
        }
        .headerInfo h5 {
            font-size: 18px;
        }
        .container h3 {
            font-size: 20px;
        }
        .lead {
            width: 98%;
            font-size: 20px;
        }
        .media-body a{
            font-size: 15px;
        }
        .avatar {
            background-color: #605CA8;
            border-radius: 0.25rem;
            position: relative;
            color: #fff;
            display: -webkit-inline-box;
            display: -ms-inline-flexbox;
            display: inline-flex;
            -webkit-box-align: center;
            -ms-flex-align: center;
            align-items: center;
            -webkit-box-pack: center;
            -ms-flex-pack: center;
            justify-content: center;
            font-size: 1rem;
            font-weight: 600;
            height: 20px;
            width: 20px;
        }
    }

    /* Media query for screens between 768px and 1024px */
    @media (min-width: 768px) and (max-width: 1024px) {
        .navbar a {
            margin-left: 98px;
        }
        .avatar {
            background-color: #605CA8;
            border-radius: 0.25rem;
            position: relative;
            color: #fff;
            display: -webkit-inline-box;
            display: -ms-inline-flexbox;
            display: inline-flex;
            -webkit-box-align: center;
            -ms-flex-align: center;
            align-items: center;
            -webkit-box-pack: center;
            -ms-flex-pack: center;
            justify-content: center;
            font-size: 1rem;
            font-weight: 600;
            height: 35px;
            width: 35px;
        }
    }

    /* Media query for screens larger than 1024px */
    @media (min-width: 1025px) {
        .navbar a {
            margin-left: 98px;
        }
        .avatar {
            background-color: #605CA8;
            border-radius: 0.25rem;
            position: relative;
            color: #fff;
            display: -webkit-inline-box;
            display: -ms-inline-flexbox;
            display: inline-flex;
            -webkit-box-align: center;
            -ms-flex-align: center;
            align-items: center;
            -webkit-box-pack: center;
            -ms-flex-pack: center;
            justify-content: center;
            font-size: 1rem;
            font-weight: 600;
            height: 35px;
            width: 35px;
        }
    }
</style>