<?php
// bikin koneksi duls
class database
{
    private $host = "160.19.166.42";
    private $user = "abu";
    private $password = "akmal123";
    private $database = "iot";
    protected $koneksi;

    // Membuat koneksi
    public function __construct()
    {
        $this->koneksi = new mysqli($this->host, $this->user, $this->password, $this->database);
        if ($this->koneksi->connect_error) {
            die("Koneksi gagal: " . $this->koneksi->connect_error);
        }
    }
    public function getIDRange(): array
    {
        $sql_ID = $this->koneksi->query(query: "SELECT MAX(id) FROM iot");
        $data_Id = mysqli_fetch_array(result: $sql_ID);
        $ID_Akhir = $data_Id['MAX(id)'];
        $ID_Awal = $ID_Akhir - 4;
        return [$ID_Awal, $ID_Akhir];
    }

    // Fungsi untuk waktu
    public function waktu()
    {
        list($ID_Awal, $ID_Akhir) = $this->getIDRange();
        $waktu = "SELECT `time` FROM iot WHERE ID>='$ID_Awal' AND ID<='$ID_Akhir' ORDER BY id ASC";
        $output = $this->koneksi->query($waktu);
        return $output->fetch_all(MYSQLI_ASSOC);
    }

    public function dataTerakhir()
    {
        $tdsTerakhir = $this->koneksi->query("SELECT tds FROM iot ORDER BY id DESC LIMIT 1")->fetch_assoc()['tds'];
        $phTerakhir = $this->koneksi->query("SELECT ph FROM iot ORDER BY id DESC LIMIT 1")->fetch_assoc()['ph'];
        $warnaTerakhir = $this->koneksi->query("SELECT color FROM iot ORDER BY id DESC LIMIT 1")->fetch_assoc()['color'];

        return [$tdsTerakhir, $phTerakhir, $warnaTerakhir];
    }
    // ini sumbu y nya tds
    public function tds()
    {
        list($ID_Awal, $ID_Akhir) = $this->getIDRange();
        $tds = "SELECT tds FROM iot WHERE ID>='$ID_Awal' AND ID<='$ID_Akhir' ORDER BY id ASC";
        $output = $this->koneksi->query($tds);
        return $output->fetch_all(MYSQLI_ASSOC);
    }

    // Fungsi untuk PH
    public function ph()
    {
        list($ID_Awal, $ID_Akhir) = $this->getIDRange();
        $ph = "SELECT ph FROM iot WHERE ID>='$ID_Awal' AND ID<='$ID_Akhir' ORDER BY id ASC";
        $output = $this->koneksi->query($ph);
        return $output->fetch_all(MYSQLI_ASSOC);
    }

    // Fungsi untuk Warna
    public function warna()
    {
        list($ID_Awal, $ID_Akhir) = $this->getIDRange();
        $warna = "SELECT color FROM iot WHERE ID>='$ID_Awal' AND ID<='$ID_Akhir' ORDER BY id ASC";
        $output = $this->koneksi->query($warna);
        return $output->fetch_all(MYSQLI_ASSOC);
    }
    // Tambahkan fungsi untuk mendapatkan nilai terakhir


    public function __destruct()
    {
        $this->koneksi->close();
    }
}

$db = new database();
$waktu = $db->waktu();
$tds = $db->tds();
$ph = $db->ph();
$warna = $db->warna();
list($tdsTerakhir, $phTerakhir, $warnaTerakhir) = $db->dataTerakhir();
?>

<body>
    <div class="container mt-26 text-center">
        <h3>Grafik TDS</h3>
        <p>(Data yang ditampilkan adalah 5 data terakhir)</p>
    </div>
    <div class="flex flex-col items-center">
        <!-- Card start -->
        <div class="flex flex-row md:flex-row">
            <!-- Card TDS -->
            <div class="block max-w-sm p-6 bg-white border border-gray-200 rounded-lg shadow hover:bg-gray-100 dark:bg-gray-800 dark:border-gray-700 dark:hover:bg-gray-700 m-10">
                <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">TDS</h5>
                <p class="font-normal text-gray-700 dark:text-gray-400">
                    <?php echo $tdsTerakhir; ?> ppa
                </p>
            </div>
            <!-- Card PH -->
            <div class="block max-w-sm p-6 bg-white border border-gray-200 rounded-lg shadow hover:bg-gray-100 dark:bg-gray-800 dark:border-gray-700 dark:hover:bg-gray-700 m-10">
                <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">PH Air</h5>
                <p class="font-normal text-gray-700 dark:text-gray-400"><?php echo $phTerakhir; ?></p>
            </div>
            <!-- Card Warna -->
            <div class="block max-w-sm p-6 bg-white border border-gray-200 rounded-lg shadow hover:bg-gray-100 dark:bg-gray-800 dark:border-gray-700 dark:hover:bg-gray-700 m-10">
                <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">Warna</h5>
                <p class="font-normal text-gray-700 dark:text-gray-400"><?php echo $warnaTerakhir; ?></p>
            </div>
        </div>
    </div>

    <div class="flex flex-col items-center">
        <!-- Container untuk Grafik -->
        <div class="flex flex-col items-center md:flex-row justify-center gap-5 w-full">
            <!-- Grafik TDS -->
            <div class="panel panel-primary m-5 w-[500px]">
                <div class="panel-heading font-custom">
                    Grafik TDS (Total Dissolved Solids)
                </div>
                <div class="panel-body">
                    <canvas id="mychart" width="500" height="250"></canvas>
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
            <div class="panel panel-danger m-5 w-[500px]">
                <div class="panel-heading">
                    Grafik PH AIR
                </div>
                <div class="panel-body">
                    <canvas id="mychart2" width="500" height="250"></canvas>
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
    <div class="panel panel-warning bg-yellow-100 shadow-lg rounded-lg">
        <div class="panel-heading p-4 text-xl font-bold border-b border-yellow-300">
            Warna Air
        </div>
        <div class="panel-body p-4">
            <ul class="space-y-3">
                <?php
                foreach ($warna as $data_warna) {
                    $hexColor = htmlspecialchars($data_warna['color']);
                    // pake kondisi buat nambahin # karena akmal ga masukin ke database # nya 
                    if (strpos($hexColor, '#') !== 0) {
                        $hexColor = '#' . $hexColor;
                    }
                    echo "<li style='list-style:none;' class='flex items-center justify-center gap-5 ml-10'>
                        <div class='flex items-center' style='width: 100px; height: 25px;  background-color: $hexColor; border: 1px solid #000;'>
                        </div>
                        <span class='font-medium text-md'>$hexColor</span> <!-- Menampilkan kode warna untuk referensi -->
                      </li>";
                }
                ?>
            </ul>
        </div>
    </div>
</body>

</html>