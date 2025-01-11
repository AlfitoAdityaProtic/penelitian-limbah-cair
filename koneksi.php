<?php
class Database
{
    private $host;
    private $user;
    private $password;
    private $database;
    public $koneksi;

    // Membuat koneksi
    public function __construct()
    {
        $this->host = getenv("DB_HOST") ?: "160.19.166.42";
        $this->user = getenv("DB_USER") ?: "abu";
        $this->password = getenv("DB_PASS") ?: "akmal123";
        $this->database = getenv("DB_NAME") ?: "iot";

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
        $warna = "SELECT color FROM iot WHERE ID>='$ID_Awal' AND ID<='$ID_Akhir' ORDER BY id ASC LIMIT 100";
        $output = $this->koneksi->query($warna);
        return $output->fetch_all(MYSQLI_ASSOC);
    }
    // Tambahkan fungsi untuk mendapatkan nilai terakhir

    // Fungsi berikut untuk data.php
    public function dataIot($limit, $offset) {
        $sql = "SELECT id, time, ph, tds, color FROM iot ORDER BY time DESC LIMIT ?, ?";
        $stmt = $this->koneksi->prepare($sql);
        $stmt->bind_param("ii", $offset, $limit);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    // fungsi untuk menghitung jumlah data pada tabel iot
    public function countDataIot(){
        return $this->koneksi->query("SELECT count(*) FROM iot")->fetch_row()[0];
    }

    public function __destruct()
    {
        $this->koneksi->close();
    }
}
?>
