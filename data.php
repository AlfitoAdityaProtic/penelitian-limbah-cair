<?php

use PhpOffice\PhpSpreadsheet\Calculation\LookupRef\Offset;

require_once 'koneksi.php'; // Memanggil file koneksi

$db = new Database(); // Membuat objek database
$perPage = 15;
$totalData = $db->countDataIot();
$totalPages = ceil($totalData / $perPage);

if (isset($_GET['page']) && is_numeric($_GET['page'])) {
    $current_page = $_GET['page'];
} else {
    $current_page = 1;
}
$offset = ($current_page - 1) * $perPage;
$data = $db->dataIot($perPage, $offset);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/output.css">
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <title>Data IOT</title>
</head>

<body class="bg-gray-100 font-custom">

    <!-- sidebar start -->
    <div x-data="setup()" x-init>
        <div class="flex h-screen antialiased text-gray-900 dark:bg-dark dark:text-light">

            <?php include('sidebar.php') ?>
            <main class="flex flex-col items-center flex-1">
                <h2 class="text-3xl font-bold mb-6 text-center text-gray-800">Data IOT</h2>

                <a class="btn btn-success flex" href="cetak.php" target="_blank">Print Data</a>

                <div class="mt-5 max-w-[80%] w-full text-center shadow-lg rounded-lg overflow-auto relative border-solid">
                    <table class="min-w-full text-center bg-white border-solid border-black">
                        <!-- Header tabel -->
                        <thead class="bg-[#337AB7] text-white text-center sticky top-0">
                            <tr class="text-center">
                                <th class="py-3 px-6 font-semibold uppercase tracking-wider text-center" scope="col">No</th>
                                <th class="py-3 px-6 font-semibold uppercase tracking-wider text-center" scope="col">Waktu</th>
                                <th class="py-3 px-6 font-semibold uppercase tracking-wider text-center" scope="col">TDS (ppa)</th>
                                <th class="py-3 px-6 font-semibold uppercase tracking-wider text-center" scope="col">pH</th>
                                <th class="py-3 px-6 font-semibold uppercase tracking-wider text-center" scope="col">Warna</th>
                            </tr>
                        </thead>

                        <!-- Isi tabel -->
                        <tbody class="text-center">
                            <?php
                            foreach ($data as $index => $d) {
                                // Cek apakah warna ada dan valid, jika tidak gunakan warna default
                                $warnaHex = isset($d['color']) && !empty($d['color']) ? htmlspecialchars($d['color']) : '#FFFFFF';
                                $backgroundColor = (strpos($warnaHex, '#') === 0) ? $warnaHex : "#$warnaHex";

                                echo "<tr class='border-b hover:bg-gray-100 transition duration-200 ease-in-out bg-white text-center'>";
                                echo "<td class='py-3 px-4 text-center'>" . ($current_page - 1) * $perPage + $index + 1  . "</td>";
                                echo "<td class='py-3 px-4 text-center'>" . htmlspecialchars($d['time']) . "</td>";
                                echo "<td class='py-3 px-4 text-center'>" . htmlspecialchars($d['tds']) . " ppa</td>";
                                echo "<td class='py-3 px-4 text-center'>" . htmlspecialchars($d['ph']) . "</td>";

                                // Tampilkan sel dengan latar belakang warna dan warna teks yang sesuai
                                echo "<td class='py-3 px-6 rounded-full text-center' style='background-color: {$backgroundColor};'>" . $backgroundColor . "</td>";
                                echo "</tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
                <div class="flex items-center border-t border-gray-200 bg-white px-4 py-3 sm:px-6 rounded-lg">
                    <!-- PAGINATION START -->
                    <div class=" flex flex-col items-center">
                        <div>
                            <p class="text-lg text-gray-700">
                                Showing
                                <span class="font-medium"><?= ($current_page - 1) * $perPage + 1 ?></span>
                                to
                                <span class="font-medium"><?= min([$current_page * $perPage, $totalData]) ?></span>
                                of
                                <span class="font-medium"><?= $totalData ?></span>
                                entries
                            </p><br>
                        </div>
                        <div>
                            <nav class="pagination-container" aria-label="Pagination">
                                <?php if ($current_page > 1) : ?>
                                    <a href="?page=<?= $current_page - 1 ?>" class="pagination-prev">
                                        <span class="sr-only">Previous</span>
                                        <svg class="pagination-icon" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                            <path fill-rule="evenodd" d="M11.78 5.22a.75.75 0 0 1 0 1.06L8.06 10l3.72 3.72a.75.75 0 1 1-1.06 1.06l-4.25-4.25a.75.75 0 0 1 0-1.06l4.25-4.25a.75.75 0 0 1 1.06 0Z" clip-rule="evenodd" />
                                        </svg>
                                    </a>
                                <?php endif; ?>

                                <?php if ($totalPages > 7) : ?>
                                    <?php if ($current_page == 1) : ?>
                                        <a href="?page=1" aria-current="page" class="pagination-number-current">1</a>
                                    <?php else : ?>
                                        <a href="?page=1" class="pagination-number">1</a>
                                    <?php endif; ?>

                                    <?php if ($totalPages - $current_page > 3) : ?>
                                        <?php if ($current_page > 4) : ?>
                                            <span class="pagination-dots">...</span>
                                            <a href="?page=<?= $current_page - 1 ?>" class="pagination-number"><?= $current_page - 1 ?></a>
                                            <a href="?page=<?= $current_page ?>" aria-current="page" class="pagination-number-current"><?= $current_page ?></a>
                                            <a href="?page=<?= $current_page + 1 ?>" class="pagination-number"><?= $current_page + 1 ?></a>
                                        <?php else : ?>
                                            <?php for ($page_no = 2; $page_no <= 5; $page_no++) : ?>
                                                <?php if ($current_page == $page_no) : ?>
                                                    <a href="?page=<?= $page_no ?>" aria-current="page" class="pagination-number-current"><?= $page_no ?></a>
                                                <?php else : ?>
                                                    <a href="?page=<?= $page_no ?>" class="pagination-number"><?= $page_no ?></a>
                                                <?php endif; ?>
                                            <?php endfor; ?>
                                        <?php endif; ?>
                                    <?php endif; ?>

                                    <?php if ($totalPages - $current_page < 4) : ?>
                                        <span class="pagination-dots">...</span>
                                        <?php for ($page_no = $totalPages - 4; $page_no <= $totalPages - 1; $page_no++) : ?>
                                            <?php if ($current_page == $page_no) : ?>
                                                <a href="?page=<?= $page_no ?>" aria-current="page" class="pagination-number-current"><?= $page_no ?></a>
                                            <?php else : ?>
                                                <a href="?page=<?= $page_no ?>" class="pagination-number"><?= $page_no ?></a>
                                            <?php endif; ?>
                                        <?php endfor; ?>
                                    <?php else : ?>
                                        <span class="pagination-dots">...</span>
                                    <?php endif; ?>

                                    <?php if ($current_page == $totalPages) : ?>
                                        <a href="?page=<?= $totalPages ?>" aria-current="page" class="pagination-number-current"><?= $totalPages ?></a>
                                    <?php else : ?>
                                        <a href="?page=<?= $totalPages ?>" class="pagination-number"><?= $totalPages ?></a>
                                    <?php endif; ?>
                                <?php else : ?>
                                    <?php for ($page = 1; $page <= $totalPages; $page++) : ?>
                                        <?php if ($page === $current_page) : ?>
                                            <a href="?page=<?= $page ?>" aria-current="page" class="pagination-number-current"><?= $page ?></a>
                                        <?php else : ?>
                                            <a href="?page=<?= $page ?>" class="pagination-number"><?= $page ?></a>
                                        <?php endif; ?>
                                    <?php endfor; ?>
                                <?php endif; ?>

                                <?php if ($current_page < $totalPages) : ?>
                                    <a href="?page=<?= $current_page + 1 ?>" class="pagination-next">
                                        <span class="sr-only">Next</span>
                                        <svg class="pagination-icon" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                            <path fill-rule="evenodd" d="M8.22 5.22a.75.75 0 0 1 1.06 0l4.25 4.25a.75.75 0 0 1 0 1.06l-4.25 4.25a.75.75 0 0 1-1.06-1.06L11.94 10 8.22 6.28a.75.75 0 0 1 0-1.06Z" clip-rule="evenodd" />
                                        </svg>
                                    </a>
                                <?php endif; ?>
                            </nav>
                        </div>
                    </div>
                    <!-- PAGINATION END -->
                </div>
            </main>
        </div>
    </div>


    <script type="text/javascript" src="assets/js/jquery-3.4.0.min.js"></script>
    <script type="text/javascript" src="assets/js/mdb.min.js"></script>
    <script src="assets/js/alpine.min.js" defer></script>
    <script>
        const setup = () => {
            return {
                isSidebarOpen: false,
            }
        }
    </script>
</body>

</html>