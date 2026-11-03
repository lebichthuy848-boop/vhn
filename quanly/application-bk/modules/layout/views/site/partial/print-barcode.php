<!DOCTYPE html>
<html>
<head>
    <base href="http://bakhia.net/quanly/assets/images/">
    <meta http-equiv="Cache-control" content="public">
    <script>
        function printContent(el) {
            var restorepage = document.body.innerHTML;
            var printcontent = document.getElementById(el).innerHTML;
            document.body.innerHTML = printcontent;
            window.print();
            document.body.innerHTML = restorepage;
        }
    </script>
    <style type="text/css" media="print">
    *{
        box-sizing: border-box;
        -moz-box-sizing: border-box;
    }
    body {
        width: 100%;
        height: 100%;
        margin: 0;
        padding: 0;
    }

    @page {
        size: 8.0cm 2.2cm;
        margin: 0;
    }
    img {
        float: left;
        display: block;
        width: 50%;
    }
    </style>
</head>
<body>
    <div id="div1">
        <img src="GD-BARUOI.png" alt="" />
        <img src="GD-BARUOI.png" alt="" />
    </div>
    <button onclick="printContent('div1')">Print Content</button>
</body>

</html>