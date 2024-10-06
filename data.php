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
    <link rel="stylesheet" href="src/output.css">
    <title>Data IOT</title>
</head>

<body class="bg-gray-100 p-8">
    <h2 class="text-3xl font-bold mb-6 text-center text-gray-800">Data IOT</h2>
    <table class="flex flex-col w-full justify-center items-center text-center bg-white border border-gray-200 rounded-lg shadow-lg">
        <thead class="bg-blue-600 text-gray-700 text-center">
            <tr class="border-b text-center">
                <th class="py-3 px-6">No</th>
                <th class="py-3 px-6">Waktu</th>
                <th class="py-3 px-6">TDS (ppa)</th>
                <th class="py-3 px-6">pH</th>
                <th class="py-3 px-6">Warna</th>
            </tr>
        </thead>
        <tbody>
            <?php
            // Looping data untuk ditampilkan ke dalam tabel
            for ($i = 0; $i < count($waktu); $i++) {
                echo "<tr class='border-b hover:bg-gray-50 transition duration-200'>";
                echo "<td class='py-3 px-6'>" . ($i + 1) . "</td>";
                echo "<td class='py-3 px-6'>" . htmlspecialchars($waktu[$i]['time']) . "</td>";
                echo "<td class='py-3 px-6'>" . htmlspecialchars($tds[$i]['tds']) . " ppa</td>";
                echo "<td class='py-3 px-6'>" . htmlspecialchars($ph[$i]['ph']) . "</td>";
                echo "<td class='py-3 px-6' style='background-color:" . htmlspecialchars($warna[$i]['color']) . ";'>" . htmlspecialchars($warna[$i]['color']) . "</td>";
                echo "</tr>";
            }
            ?>
        </tbody>
    </table>
</body>

</html>