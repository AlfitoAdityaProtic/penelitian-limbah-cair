<?php
class Database
{
    private $host = "160.19.166.42";
    private $user = "abu";
    private $password = "akmal123";
    private $database = "iot";
    protected $koneksi;

    public function __construct()
    {
        $this->koneksi = new mysqli($this->host, $this->user, $this->password, $this->database);
        if ($this->koneksi->connect_error) {
            die("Koneksi gagal: " . $this->koneksi->connect_error);
        }
    }

    public function getIDRange(): array
    {
        $sql_ID = $this->koneksi->query("SELECT MAX(id) FROM iot");
        $data_Id = mysqli_fetch_array($sql_ID);
        $ID_Akhir = $data_Id['MAX(id)'];
        $ID_Awal = $ID_Akhir - 4;
        return [$ID_Awal, $ID_Akhir];
    }

    public function waktu()
    {
        $waktu = "SELECT `time` FROM iot ORDER BY id ASC";
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

    public function tds()
    {
        $tds = "SELECT tds FROM iot ORDER BY id ASC";
        $output = $this->koneksi->query($tds);
        return $output->fetch_all(MYSQLI_ASSOC);
    }

    public function ph()
    {    
        $ph = "SELECT ph FROM iot ORDER BY id ASC";
        $output = $this->koneksi->query($ph);
        return $output->fetch_all(MYSQLI_ASSOC);
    }

    public function warna()
    {
        $warna = "SELECT color FROM iot ORDER BY id ASC";
        $output = $this->koneksi->query($warna);
        return $output->fetch_all(MYSQLI_ASSOC);
    }

    public function __destruct()
    {
        $this->koneksi->close();
    }
}
?>
