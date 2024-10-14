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
    <script type="text/javascript" src="assets/js/jquery-3.4.0.min.js"></script>
    <script type="text/javascript" src="assets/js/mdb.min.js"></script>
    <script type="text/javascript" src="jquery-latest.js"></script>
    <link rel="stylesheet" href="src/output.css">
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <title>Data IOT</title>
</head>

<body class="bg-gray-100 font-custom">

    <!-- sidebar start -->
    <div x-data="setup()" x-init="$refs.loading.classList.add('hidden');">
        <div class="flex h-screen antialiased text-gray-900 dark:bg-dark dark:text-light">
            <!-- Loading screen -->
            <div x-ref="loading" class="fixed inset-0 z-50 flex items-center justify-center text-2xl font-semibold text-white bg-blue-600">
                Loading.....
            </div>

            <!-- Sidebar -->
            <div
                x-transition:enter="transform transition-transform duration-300"
                x-transition:enter-start="-translate-x-full"
                x-transition:enter-end="translate-x-0"
                x-transition:leave="transform transition-transform duration-300"
                x-transition:leave-start="translate-x-0"
                x-transition:leave-end="-translate-x-full"
                x-show="isSidebarOpen"
                class="fixed inset-y-0 z-10 flex w-96">
                <!-- Curvy shape -->
                <svg
                    class="absolute inset-0 w-full h-full text-white"
                    style="filter: drop-shadow(10px 0 10px #00000030)"
                    preserveAspectRatio="none"
                    viewBox="0 0 309 800"
                    fill="currentColor"
                    xmlns="">
                    <path
                        d="M268.487 0H0V800H247.32C207.957 725 207.975 492.294 268.487 367.647C329 243 314.906 53.4314 268.487 0Z"
                        fill="rgba(20, 205, 200, 1)" />
                </svg>
                <!-- Sidebar content -->
                <div class="z-10 flex flex-col flex-1 p-4">
                    <div class="flex items-center flex-shrink-0 w-auto">
                        <!-- Logo -->
                        <a href="#">
                            <div class="p-1 mt-1 flex items-center">
                                <img src="assets/img/water-icon.gif" alt="" class="h-8 w-8 rounded-full">
                                <h1 class="font-bold text-white text-[15px] ml-3 pr-8">Monitoring Air </h1>
                            </div>
                        </a>
                        <!-- Close btn -->
                        <button @click="isSidebarOpen = false" class="rounded-lg focus:outline-none focus:ring">
                            <svg
                                class="w-6 h-6"
                                aria-hidden="true"
                                xmlns="http://www.w3.org/2000/svg"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                            <span class="sr-only">Close sidebar</span>
                        </button>
                    </div>

                    <nav class="flex flex-col flex-1 w-80 p-4 mt-4">
                        <a href="index.php" class="flex items-center space-x-2 mt-5 pt-2 duration-30
                            cursor pointer text-white hover:bg-white rounded-lg hover:text-black shadow-lg">
                            <img src="assets/img/home.png" alt="homepage" class="h-6 w-6 mb-1 ml-4">
                            <span>Dashboard</span>
                        </a>
                        <!-- <a href="#" class="flex items-center space-x-2 mt-5  duration-30
                            cursor pointer text-white hover:bg-white hover:text-black shadow-lg">
                            <img src="assets/img/bar-chart.png" alt="user" class="h-5 w-5 mb-1 ml-4">
                            <span>Line Chart</span>
                        </a> -->
                        <a href="data.php" class="flex items-center space-x-2 mt-5  duration-30
                            cursor pointer text-white hover:bg-white rounded-lg hover:text-black shadow-lg">
                            <img src="assets/img/contract.png" alt="monitoring" class="h-6 w-6 mb-1 ml-4">
                            <span>Data</span>
                        </a>
                        <!-- <a href="#" class="flex items-center space-x-2 mt-5  duration-30
                            cursor pointer text-white hover:bg-white hover:text-black shadow-lg">
                            <img src="assets/img/setting.png" alt="monitoring" class="h-5 w-5 mb-1 ml-4">
                            <span>Setting</span>
                        </a> -->
                    </nav>
                    <!-- <div class="flex-shrink-0 p-4 w-80">
                        <button class="flex items-center space-x-2 duration-30
                            cursor pointer text-white hover:bg-red-500 hover:text-red-500 shadow-lg w-40">
                            <img src="assets/img/logout.png" alt="tombol logout" class="h-5 w-5 mb-1 ml-4">
                            <span>Logout</span>
                        </button>
                    </div> -->
                </div>
            </div>

            <main class="flex flex-col items-center flex-1">
                <!-- Page content -->
                <button @click="isSidebarOpen = true" class="fixed p-2 text-white bg-black rounded-lg top-5 left-5">
                    <svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                    <span class="sr-only">Open menu</span>
                </button>

                <h2 class="text-3xl font-bold mb-6 text-center text-gray-800">Data IOT</h2>

                <a class="btn btn-success flex" href="cetak.php" target="_blank">Print Data</a>

                <div class="mt-5 w-[80%] max-h-[500px] text-center shadow-lg rounded-lg overflow-y-scroll overflow-x-auto relative border-solid">
                    <table class="min-w-full text-center bg-white border-solid border-black">
                        <!-- Header tabel -->
                        <thead class="bg-blue-600 text-white text-center sticky top-0">
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
                            for ($i = 0; $i < count($waktu); $i++) {
                                // Ambil warna dari data
                                $warnaHex = htmlspecialchars($warna[$i]['color']);
                                $backgroundColor = $warnaHex;

                                // Tambahkan tanda '#' di depan nilai warna jika tidak ada
                                if ($warnaHex[0] !== '#') {
                                    $backgroundColor = '#' . $warnaHex;
                                }

                                echo "<tr class='border-b hover:bg-gray-100 transition duration-200 ease-in-out bg-white text-center'>";
                                echo "<td class='py-3 px-4 text-center'>" . ($i + 1) . "</td>";
                                echo "<td class='py-3 px-4 text-center'>" . htmlspecialchars($waktu[$i]['time']) . "</td>";
                                echo "<td class='py-3 px-4 text-center'>" . htmlspecialchars($tds[$i]['tds']) . " ppa</td>";
                                echo "<td class='py-3 px-4 text-center'>" . htmlspecialchars($ph[$i]['ph']) . "</td>";

                                // Tentukan warna teks berdasarkan kecerahan latar belakang
                                $textColor = (hexdec(substr($backgroundColor, 1, 2)) * 0.299 + hexdec(substr($backgroundColor, 3, 2)) * 0.587 + hexdec(substr($backgroundColor, 5, 2)) * 0.114) > 186 ? '#000000' : '#ffffff';

                                // Tampilkan sel dengan latar belakang warna dan warna teks yang sesuai
                                echo "<td class='py-3 px-6 rounded-full text-center' style='background-color: {$backgroundColor}; color: {$textColor};'>" . $backgroundColor . "</td>";
                                echo "</tr>";
                            }
                            ?>
                        </tbody>

                    </table>
                </div>

            </main>
        </div>
    </div>
    <!-- sidebar end -->

    <script src="./node_modules/alpinejs/dist/cdn.min.js" defer></script>
    <script>
        const setup = () => {
            return {
                isSidebarOpen: false,
            }
        }
    </script>

</body>

</html>