<?php
// bikin koneksi duls
class database
{
    private $host = "160.19.166.42";
    private $user = "abu";
    private $password = "akmal123";
    private $database = "iot";
    protected $koneksi;
    // baca id tertinggi
    public function __construct()
    {
        $this->koneksi = new mysqli( $this->host, $this->user, $this->password, $this->database);
        if ($this->koneksi->connect_error) {
            die("Koneksi gagal: " . $this->koneksi->connect_error);
        }
    }
    public function getIDRange(): array{
        $sql_ID = $this->koneksi->query(query: "SELECT MAX(id) FROM iot");
        $data_Id = mysqli_fetch_array(result: $sql_ID);
        $ID_Akhir = $data_Id['MAX(id)'];
        $ID_Awal = $ID_Akhir - 4;
        return [$ID_Awal, $ID_Akhir];

    }
    // ini sumbu x nya
    public function waktu()
    {
        list($ID_Awal, $ID_Akhir) = $this->getIDRange();
        $waktu = "SELECT `time` FROM iot WHERE ID>='$ID_Awal' AND ID<='$ID_Akhir' ORDER BY id ASC";
        $output = $this->koneksi->query(query: $waktu);
        return $output->fetch_all(mode: MYSQLI_ASSOC);
    }
    // ini sumbu y nya tds
    public function tds()
    {
        list($ID_Awal, $ID_Akhir) = $this->getIDRange();
        $tds = "SELECT tds FROM iot WHERE ID>='$ID_Awal' AND ID<='$ID_Akhir' ORDER BY id ASC";
        $output = $this->koneksi->query(query: $tds);
        return $output->fetch_all(mode: MYSQLI_ASSOC);
    }
    public function ph()
    {
        list($ID_Awal, $ID_Akhir) = $this->getIDRange();
        $ph = "SELECT ph FROM iot WHERE ID>='$ID_Awal' AND ID<='$ID_Akhir' ORDER BY id ASC";
        $output = $this->koneksi->query(query: $ph);
        return $output->fetch_all(mode: MYSQLI_ASSOC);
    }
    public function warna()
    {
        list($ID_Awal, $ID_Akhir) = $this->getIDRange();
        $warna = "SELECT color FROM iot WHERE ID>='$ID_Awal' AND ID<='$ID_Akhir' ORDER BY id ASC";
        $output = $this->koneksi->query($warna);
        return $output->fetch_all(MYSQLI_ASSOC);
    }
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
    <!-- tampilan grafik TDS-->
    <div class="panel panel-primary">
        <div class ="panel-heading">
            Grafik TDS (Total Dissolved Solids)
        </div>

        <div class="panel-body">
            <!-- canvas untuk grafik -->

             <canvas id="mychart"></canvas>

             <!-- gambar grafik -->
              <script type="text/javascript">
                // baca id canvas tempat grafik akan di letakan
                var canvas = document.getElementById('mychart');
                // letakan data tanggal dan tds untuk grafik
                var tds = {
                    labels : [
                        <?php 
                            // while($data_tanggal = mysqli_fetch_array($tanggal)){
                            //     echo '"' . $data_tanggal['tanggal'] . '",';
                            // }
                            foreach($waktu as $data_waktu){
                                echo '"' . $data_waktu['time'] . '",';
                            }
                        ?>
                    ],
                    datasets : [
                    {
                        label : "TDS",
                        fill: true,
                        backgroundColor: "rgba(153,109,74,1)",
                        borderColor: "rgba(75,192,192,1)",
                        lineTension: 0.5,
                        pointRadius: 3,
                        data : [
                            <?php
                            foreach($tds as $data_tds){
                                echo '"' . $data_tds['tds'] . '",';
                            }
                            ?>
                        ],
                    }
                ]
                }
                // option grafik 
                var option = {
                    showLines : true,
                    animation : {
                        duration : 0
                    }
                };
                // cetak grafik kedalam canvas
                var mychart = new Chart(canvas, {
                    type: 'line',
                    data : tds,
                    options : option
                });
              </script>
        </div>
    </div>


<!-- TAMPILAN GRAFIK PH AIR -->
    <div class="panel panel-danger">
        <div class ="panel-heading">
            Grafik PH AIR
        </div>

        <div class="panel-body">
            <!-- canvas untuk grafik -->

             <canvas id="mychart2"></canvas>

             <!-- gambar grafik -->
              <script type="text/javascript">
                // baca id canvas tempat grafik akan di letakan
                var canvas = document.getElementById('mychart2');
                // letakan data tanggal dan tds untuk grafik
                var ph = {
                    labels : [
                        <?php 
                            foreach($waktu as $data_waktu){
                                echo '"' . $data_waktu['time'] . '",';
                            }
                        ?>
                    ],
                    datasets : [
                    {
                        label : "ph",
                        fill: true,
                        backgroundColor: "rgba(253,1,17,1)",
                        borderColor: "rgba(75,192,192,1)",
                        lineTension: 0.5,
                        pointRadius: 3,
                        data : [
                            <?php
                            foreach($ph as $data_ph){
                                echo '"' . $data_ph['ph'] . '",';
                            }
                            ?>
                        ],
                    },
                
                ]
                }
                // option grafik 
                var option = {
                    showLines : true,
                    animation : {
                        duration : 0
                    }
                };
                // cetak grafik kedalam canvas
                var mychart = new Chart(canvas, {
                    type: 'line',
                    data : ph,
                    options : option
                });
              </script>
        </div>
    </div>
    <!-- Tampilan warna -->
    <div class="panel panel-warning">
    <div class="panel-heading">
        Warna Air
    </div>
    <div class="panel-body">
        <ul>
            <?php
            foreach ($warna as $data_warna) {
                echo "<li>" . htmlspecialchars($data_warna['color']) . "</li>";
            }
            ?>
        </ul>
    </div>
</div>


</body>
</html>