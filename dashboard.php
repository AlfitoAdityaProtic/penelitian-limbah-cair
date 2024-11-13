<?php
require_once 'koneksi.php'; // Memanggil file koneksi

$db = new Database(); // Membuat objek database
$waktu = $db->waktu();
$tds = $db->tds();
$ph = $db->ph();
$warna = $db->warna();
list($tdsTerakhir, $phTerakhir, $warnaTerakhir) = $db->dataTerakhir();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Monitoring Limbah Cair</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>

<h2 class="mt-5 justify-end items-end text-3xl font-bold text-gray-800 border-b-2 border-yellow-500 pb-2 mb-4">
    Laman Dashboard
</h2>

<div class="flex flex-col items-center">
    <!-- Card TDS, PH, Warna -->
    <div class="flex flex-row md:flex-row">
        <div class="block max-w-sm p-6 bg-white border rounded-lg shadow m-10">
            <h5 class="text-2xl font-bold">TDS</h5>
            <p><?php echo $tdsTerakhir; ?> ppa</p>
        </div>
        <div class="block max-w-sm p-6 bg-white border rounded-lg shadow m-10">
            <h5 class="text-2xl font-bold">PH Air</h5>
            <p><?php echo $phTerakhir; ?></p>
        </div>
        <div class="block max-w-sm p-6 bg-white border rounded-lg shadow m-10">
            <h5 class="text-2xl font-bold">Warna</h5>
            <p><?php echo $warnaTerakhir; ?></p>
        </div>
    </div>

    <!-- Grafik TDS dan PH -->
    <div class="flex flex-col items-center md:flex-row justify-center gap-5 w-full">
        <div class="panel panel-primary m-5 w-[500px] shadow-lg">
            <div class="panel-heading font-custom">
                Grafik TDS
            </div>
            <div class="panel-body">
                <canvas id="mychart" width="500" height="250"></canvas>
                <script>
                    var canvas = document.getElementById('mychart');
                    var tds = {
                        labels: [
                            <?php foreach ($waktu as $data_waktu) {
                                echo '"' . $data_waktu['time'] . '",';
                            } ?>
                        ],
                        datasets: [{
                            label: "TDS",
                            fill: true,
                            backgroundColor: "rgba(153,109,74,0.2)",
                            borderColor: "rgba(75,192,192,1)",
                            data: [
                                <?php foreach ($tds as $data_tds) {
                                    echo '"' . $data_tds['tds'] . '",';
                                } ?>
                            ],
                        }]
                    };
                    var mychart = new Chart(canvas, {
                        type: 'line',
                        data: tds,
                    });
                </script>
            </div>
        </div>

        <div class="panel panel-danger m-5 w-[500px] shadow-lg">
            <div class="panel-heading font-custom">
                Grafik PH Air
            </div>
            <div class="panel-body">
                <canvas id="mychart2" width="500" height="250"></canvas>
                <script>
                    var canvas = document.getElementById('mychart2');
                    var ph = {
                        labels: [
                            <?php foreach ($waktu as $data_waktu) {
                                echo '"' . $data_waktu['time'] . '",';
                            } ?>
                        ],
                        datasets: [{
                            label: "PH",
                            fill: true,
                            backgroundColor: "rgba(253,1,17,0.2)",
                            borderColor: "rgba(253,1,17,1)",
                            data: [
                                <?php foreach ($ph as $data_ph) {
                                    echo '"' . $data_ph['ph'] . '",';
                                } ?>
                            ],
                        }]
                    };
                    var mychart = new Chart(canvas, {
                        type: 'line',
                        data: ph,
                    });
                </script>
            </div>
        </div>
    </div>
</div>

<!-- Warna Air -->
<div class="panel panel-warning shadow-lg rounded-lg">
    <div class="panel-heading p-4 text-xl font-bold border-b border-yellow-300 font-custom">
        Warna Air
    </div>
    <div class="panel-body p-4">
        <ul class="space-y-3">
            <?php foreach ($warna as $data_warna) {
                $hexColor = htmlspecialchars($data_warna['color']);
                if (strpos($hexColor, '#') !== 0) {
                    $hexColor = '#' . $hexColor;
                }
                echo "<li class='flex items-center justify-center gap-5 ml-10'>
                        <div class='flex items-center' style='width: 100px; height: 25px; background-color: $hexColor;'></div>
                        <span class='font-medium'>$hexColor</span>
                      </li>";
            } ?>
        </ul>
    </div>
</div>

</body>
</html>
