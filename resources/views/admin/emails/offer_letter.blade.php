
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

        <div class="panel-heading row">
            <div style="float: left;">
                <p>Md. Askar Ibne Saikh Sagor </p>
                <p>Address: Mohammadpur </p>
                <p>Dhaka-1207</p>
            </div>

            <div class="panel-heading" style="float: right;margin-top: 28px;">
                <img  src="data:image/png;base64,<?php echo base64_encode(file_get_contents(base_path('public/images/settings/'.$setting->company_logo))); ?>" width="80 px;">
            </div>
        </div>
        <br>

        <div style="text-align: justify;">
            Dear Md. Askar Ibne Saikh Sagor, <br>
            <br>
            We are pleased to welcome you to [Company Name] as a [Job Title]. We are confident that you will be an 
            asset to our team and we look forward to working with you.

            As discussed, your start date is [Start Date] and your salary will be [Salary Amount] per [Year/Month/Hour]. 
            Your working hours are from [Working Hours]. You will be reporting to [Manager Name].
            <br>
            <br>

            Please bring the following documents on your first day of work: <br>
            <ul>
                <li>A copy of your signed offer letter,</li>
                <li>Two passport-sized photographs,</li>
                <li>Original of all educational certificates,</li>
            </ul>

            During your first few days, you will be provided with a comprehensive orientation about our company, 
            policies, procedures, and benefits. If you have any questions or concerns, please do not hesitate to 
            ask your manager or HR representative.

            We are excited to have you join our team at [Company Name] and we look forward to a 
            long and productive working relationship. <br>
            <br>


            Sincerely, <br>
            
            [Manager Name] <br>
            [Job Title] <br>
            [Company Name] <br>
        </div>

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
