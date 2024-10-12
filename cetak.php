<?php

require 'vendor/autoload.php';
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

error_reporting(E_ALL);
ini_set('display_errors', 1); // Menampilkan semua error untuk debugging

$spreadsheet = new Spreadsheet();
$activeWorksheet = $spreadsheet->getActiveSheet();

// Set header untuk spreadsheet
$activeWorksheet->setCellValue('A1', 'Data IOT');
$activeWorksheet->setCellValue('A3', 'No');
$activeWorksheet->setCellValue('B3', 'Waktu');
$activeWorksheet->setCellValue('C3', 'TDS');
$activeWorksheet->setCellValue('D3', 'pH');
$activeWorksheet->setCellValue('E3', 'Warna');

include 'koneksi.php'; // Memasukkan file koneksi
$db = new Database(); // Membuat objek Database

$query = "SELECT `time`, tds, ph, color FROM iot ORDER BY id DESC"; // Query untuk mengambil data
$cetak = $db->koneksi->query($query); // Menggunakan koneksi untuk menjalankan query

if ($cetak) {
    $no = 1;
    $baris = 4; // Mulai dari baris ke-4 untuk menampilkan data
    while ($value = $cetak->fetch_assoc()) {
        $activeWorksheet->setCellValue('A' . $baris, $no);
        $activeWorksheet->setCellValue('B' . $baris, $value['time']);
        $activeWorksheet->setCellValue('C' . $baris, $value['tds']);
        $activeWorksheet->setCellValue('D' . $baris, $value['ph']);
        $activeWorksheet->setCellValue('E' . $baris, $value['color']);

        $no++;
        $baris++;
    }
} else {
    die("Error executing query: " . $db->koneksi->error); // Menampilkan error jika query gagal
}

$writer = new Xlsx($spreadsheet);
$writer->save('data_iot.xlsx');
header('Location: data_iot.xlsx');
exit;
