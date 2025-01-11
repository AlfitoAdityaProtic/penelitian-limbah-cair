<?php
require_once('koneksi.php');

$db = new Database();
$waktu = $db->waktu();
$tds = $db->tds();
$ph = $db->ph();
$warna = $db->warna();
list($tdsTerakhir, $phTerakhir, $warnaTerakhir) = $db->dataTerakhir();
?>

<body>
    <!-- <div class="flex container justify-end items-end mt-4 pr-4"></div> -->
    <h2 class="mt-32 md:mt-5 justify-end items-end text-3xl font-bold text-gray-800 border-b-2 border-yellow-500 pb-2 mb-4">
        Laman Dashboard Monitoring Limbah Cair
    </h2>

    <div class="flex flex-col items-center">
        <!-- Card start -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <!-- Card TDS -->
            <div class="p-6 bg-white border border-gray-200 rounded-lg shadow hover:bg-gray-100 dark:bg-gray-800 dark:border-gray-700 dark:hover:bg-gray-700">
                <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">TDS</h5>
                <p class="font-normal text-gray-700 dark:text-gray-400">
                    <?php echo $tdsTerakhir; ?> ppa
                </p>
            </div>
            <!-- Card PH -->
            <div class="p-6 bg-white border border-gray-200 rounded-lg shadow hover:bg-gray-100 dark:bg-gray-800 dark:border-gray-700 dark:hover:bg-gray-700">
                <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">PH Air</h5>
                <p class="font-normal text-gray-700 dark:text-gray-400"><?php echo $phTerakhir; ?></p>
            </div>
            <!-- Card Warna -->
            <div class="p-6 bg-white border border-gray-200 rounded-lg shadow hover:bg-gray-100 dark:bg-gray-800 dark:border-gray-700 dark:hover:bg-gray-700">
                <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">Warna</h5>
                <p class="font-normal text-gray-700 dark:text-gray-400"><?php echo $warnaTerakhir; ?></p>
            </div>
        </div>
    </div>

    <div class="flex flex-col items-center">
        <!-- Container untuk Grafik -->
        <div class="flex flex-col items-center md:flex-row justify-center gap-5 w-full">
            <!-- Grafik TDS -->
            <div class="panel panel-primary m-5 shadow-lg">
                <div class="panel-heading font-custom">
                    Grafik TDS (Total Dissolved Solids)
                </div>
                <div class="panel-body">
                    <canvas id="mychart" width="500"></canvas>
                    <script type="text/javascript">
                        var canvas = document.getElementById('mychart');
                        var tds = {
                            labels: [
                                <?php
                                foreach ($waktu as $data_waktu) {
                                    echo '"' . $data_waktu['time'] . '",';
                                }
                                ?>
                            ],
                            datasets: [{
                                label: "TDS",
                                fill: true,
                                backgroundColor: "rgba(153,109,74,0.2)",
                                borderColor: "rgba(75,192,192,1)",
                                lineTension: 0.5,
                                pointRadius: 5,
                                pointHoverRadius: 7,
                                borderWidth: 2,
                                data: [
                                    <?php
                                    foreach ($tds as $data_tds) {
                                        echo '"' . $data_tds['tds'] . '",';
                                    }
                                    ?>
                                ],
                            }]
                        };
                        var option = {
                            responsive: true,
                            maintainAspectRatio: false,
                            showLines: true,
                            animation: {
                                duration: 0
                            }
                        };

                        var mychart = new Chart(canvas, {
                            type: 'line',
                            data: tds,
                            options: option
                        });
                    </script>
                </div>
            </div>

            <!-- Grafik PH -->
            <div class="panel panel-danger m-5 shadow-lg">
                <div class="panel-heading font-custom">
                    Grafik PH AIR
                </div>
                <div class="panel-body">
                    <canvas id="mychart2" width="500"></canvas>
                    <script type="text/javascript">
                        var canvas = document.getElementById('mychart2');
                        var ph = {
                            labels: [
                                <?php
                                foreach ($waktu as $data_waktu) {
                                    echo '"' . $data_waktu['time'] . '",';
                                }
                                ?>
                            ],
                            datasets: [{
                                label: "ph",
                                fill: true,
                                backgroundColor: "rgba(253,1,17,0.2)",
                                borderColor: "rgba(253,1,17,1)",
                                lineTension: 0.5,
                                pointRadius: 5,
                                pointHoverRadius: 7,
                                borderWidth: 2,
                                data: [
                                    <?php
                                    foreach ($ph as $data_ph) {
                                        echo '"' . $data_ph['ph'] . '",';
                                    }
                                    ?>
                                ],
                            }]
                        };
                        var option = {
                            showLines: true,
                            animation: {
                                duration: 0
                            }
                        };
                        var mychart = new Chart(canvas, {
                            type: 'line',
                            data: ph,
                            options: option
                        });
                    </script>
                </div>
            </div>
        </div>
    </div>

    <!-- Tampilan warna -->
    <div class="panel panel-warning shadow-lg rounded-lg">
        <div class="panel-heading p-4 text-xl font-bold border-b border-yellow-300 font-custom text-center">
            Warna Air
        </div>
        <div class="panel-body p-4">
            <ul class="space-y-3 flex flex-col items-center">
                <?php
                foreach ($warna as $data_warna) {
                    $hexColor = htmlspecialchars($data_warna['color']);
                    if (strpos($hexColor, '#') !== 0) {
                        $hexColor = '#' . $hexColor;
                    }
                    echo "<li style='list-style:none;' class='flex items-center justify-center gap-5'>
                        <div class='flex items-center justify-center' style='width: 200px; height: 32px; background-color: $hexColor; border: 1px solid #000;'>
                        <span class='font-medium text-md'>$hexColor</span>
                        </div>
                      </li>";
                }
                ?>
            </ul>
        </div>
    </div>
</body>

</html>