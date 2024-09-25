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
        $this->koneksi = new mysqli( $this->host, $this->user, $this->password, $this->database);
        if ($this->koneksi->connect_error) {
            die("Koneksi gagal: " . $this->koneksi->connect_error);
        }
    }

    public function getIDRange(): array {
        $sql_ID = $this->koneksi->query("SELECT MAX(id) FROM iot");
        $data_Id = mysqli_fetch_array($sql_ID);
        $ID_Akhir = $data_Id['MAX(id)'];
        $ID_Awal = $ID_Akhir - 4;
        return [$ID_Awal, $ID_Akhir];
    }

    // Fungsi untuk waktu
    public function waktu() {
        list($ID_Awal, $ID_Akhir) = $this->getIDRange();
        $waktu = "SELECT `time` FROM iot WHERE ID>='$ID_Awal' AND ID<='$ID_Akhir' ORDER BY id ASC";
        $output = $this->koneksi->query($waktu);
        return $output->fetch_all(MYSQLI_ASSOC);
    }

    // Fungsi untuk TDS
    public function tds() {
        list($ID_Awal, $ID_Akhir) = $this->getIDRange();
        $tds = "SELECT tds FROM iot WHERE ID>='$ID_Awal' AND ID<='$ID_Akhir' ORDER BY id ASC";
        $output = $this->koneksi->query($tds);
        return $output->fetch_all(MYSQLI_ASSOC);
    }

    // Fungsi untuk PH
    public function ph() {
        list($ID_Awal, $ID_Akhir) = $this->getIDRange();
        $ph = "SELECT ph FROM iot WHERE ID>='$ID_Awal' AND ID<='$ID_Akhir' ORDER BY id ASC";
        $output = $this->koneksi->query($ph);
        return $output->fetch_all(MYSQLI_ASSOC);
    }

    // Fungsi untuk Warna
    public function warna() {
        list($ID_Awal, $ID_Akhir) = $this->getIDRange();
        $warna = "SELECT color FROM iot WHERE ID>='$ID_Awal' AND ID<='$ID_Akhir' ORDER BY id ASC";
        $output = $this->koneksi->query($warna);
        return $output->fetch_all(MYSQLI_ASSOC);
    }

    // Destructor untuk menutup koneksi
    public function __destruct(){
        $this->koneksi->close();
    }
}

$db = new database();
$waktu = $db->waktu();
$tds = $db->tds();
$ph = $db->ph();
$warna = $db->warna();
?>

<body>
    <!-- TAMPILAN GRAFIK TDS -->
    <div class="panel panel-primary">
        <div class="panel-heading">
            Grafik TDS (Total Dissolved Solids)
        </div>
        <div class="panel-body">
            <canvas id="mychart"></canvas>
            <script type="text/javascript">
                var canvas = document.getElementById('mychart');
                var tds = {
                    labels: [
                        <?php 
                        foreach($waktu as $data_waktu) {
                            echo '"' . $data_waktu['time'] . '",';
                        }
                        ?>
                    ],
                    datasets: [{
                        label: "TDS",
                        fill: true,
                        backgroundColor: "rgba(153,109,74,1)",
                        borderColor: "rgba(75,192,192,1)",
                        lineTension: 0.5,
                        pointRadius: 3,
                        data: [
                            <?php
                            foreach($tds as $data_tds) {
                                echo '"' . $data_tds['tds'] . '",';
                            }
                            ?>
                        ],
                    }]
                };
                var option = {
                    showLines: true,
                    animation: { duration: 0 }
                };
                var mychart = new Chart(canvas, {
                    type: 'line',
                    data: tds,
                    options: option
                });
            </script>
        </div>
    </div>

    <!-- TAMPILAN GRAFIK PH AIR -->
    <div class="panel panel-danger">
        <div class="panel-heading">
            Grafik PH AIR
        </div>
        <div class="panel-body">
            <canvas id="mychart2"></canvas>
            <script type="text/javascript">
                var canvas = document.getElementById('mychart2');
                var ph = {
                    labels: [
                        <?php 
                        foreach($waktu as $data_waktu) {
                            echo '"' . $data_waktu['time'] . '",';
                        }
                        ?>
                    ],
                    datasets: [{
                        label: "PH",
                        fill: true,
                        backgroundColor: "rgba(253,1,17,1)",
                        borderColor: "rgba(75,192,192,1)",
                        lineTension: 0.5,
                        pointRadius: 3,
                        data: [
                            <?php
                            foreach($ph as $data_ph) {
                                echo '"' . $data_ph['ph'] . '",';
                            }
                            ?>
                        ],
                    }]
                };
                var option = {
                    showLines: true,
                    animation: { duration: 0 }
                };
                var mychart = new Chart(canvas, {
                    type: 'line',
                    data: ph,
                    options: option
                });
            </script>
        </div>
    </div>

    <!-- TAMPILAN WARNA -->
    <div class="panel panel-warning">
        <div class="panel-heading">
            Warna Air
        </div>
        <div class="panel-body">
            <table align="center" border="1" cellpadding="10" cellspacing="0">
                <tr>
                    <th>Color Code</th>
                    <th>Color Display</th>
                </tr>
                <?php
          foreach ($warna as $data_warna) {
            // Pastikan kode warna hex memiliki tanda #
            $hex_color = htmlspecialchars($data_warna['color']);
            
            // Jika kode tidak memiliki tanda '#', tambahkan
            if (strpos($hex_color, '#') !== 0) {
                $hex_color = '#' . $hex_color;
            }
            
            // Tampilkan baris tabel dengan background-color sesuai dengan kode hex
            echo "<tr>";
            echo "<td>" . $hex_color . "</td>"; // Kolom yang menampilkan kode hex
            echo "<td style='background-color: $hex_color; width: 100px;'>&nbsp;</td>"; // Kolom dengan latar belakang warna
            echo "</tr>";
        }
        
                ?>
            </table>
        </div>
    </div>
</body>
</html>
