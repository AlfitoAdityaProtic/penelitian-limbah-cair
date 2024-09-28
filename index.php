<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <script type="text/javascript" src="assets/js/jquery-3.4.0.min.js"></script>
    <script type="text/javascript" src="assets/js/mdb.min.js"></script>
    <script type="text/javascript" src="jquery-latest.js"></script>
    <link rel="stylesheet" href="src/output.css">

    <!-- memanggil data grafik -->
    <script type="text/javascript">
        var refreshid = setInterval(function() {
            $('#responsecontainer').load('tds.php');
        }, 1000);
    </script>

    <title>Grafik Sensor</title>
</head>

<body>
    <!-- Main content -->
            <!-- Card end -->
            </div>
            <!-- Grafik TDS -->
            <div class="container mt-10 text-center">
                <h3>Grafik TDS</h3>
                <p>(Data yang ditampilkan adalah 5 data terakhir)</p>
            </div>

            <div class="container w-1/3 text-center mt-5" id="responsecontainer">
                <!-- Grafik data dari tds.php akan dimuat di sini -->
            </div>
       
   

</body>

</html>