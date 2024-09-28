<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="src/output.css">
    <link rel="shortcut icon" href="img/favicon.png" type="image/x-icon">
    <title>SideBar</title>
</head>

<body class="font-mono">
<aside class="sidebar fixed top-0 bottom-0 lg:left-0 p-2 w-[300px] text-center bg-blue-500">
            <!-- sidebar start -->
            <div class="text-white-100 text-xl mt-7">
                <a href="#">
                    <div class="p-2.5 mt-1 flex items-center">
                        <img src="assets/img/water-icon.gif" alt="" class="h-8 w-8 rounded-full">
                        <h1 class="font-bold text-white text-[15px] ml-3">SI | Monitoring Air </h1>
                    </div>
                </a>
                <hr class="mt-3 mb-3">

            <!-- fitur search start -->

            <form class="max-w-md mx-auto">
                <label for="default-search" class="mb-2 text-sm font-medium text-gray-900 sr-only dark:text-white">Search</label>
                <div class="relative">
                    <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                        <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
                        </svg>
                    </div>
                    <input type="search" id="default-search" class="block w-full p-4 ps-10 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Search...." required />
                    <button type="submit" class="text-white absolute end-2.5 bottom-2.5 bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-4 py-2 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Search</button>
                </div>
            </form>

            <!-- fitur search end -->

            <!-- dashboard start-->
            <a href="dashboard.php">
                <div class="p-2.5 mt-3 flex rounded-md px-4 duration-30
                            cursor pointer text-white hover:bg-white hover:text-black shadow-lg">
                    <img src="assets/img/home.png" alt="homepage" class="h-5 w-5 mb-1 ml-4">
                    <span class="ml-7 text-xl -mt-1">Dashboard</span>
                </div>
            </a>
            <!-- dashboard end -->

            <!-- line chart start -->
            <a href="lihat-user.php">
                <div class="p-2.5 mt-3 flex rounded-md px-4 duration-30
                            cursor pointer text-white hover:bg-white hover:text-black shadow-lg">
                    <img src="assets/img/bar-chart.png" alt="user" class="h-5 w-5 mb-1 ml-4">
                    <span class="ml-7 text-xl -mt-1">Line-Chart</span>
                </div>
            </a>
            <!-- line chart end -->

            <!-- pie chart start -->
            <a href="user.php">
                <div class="p-2.5 mt-3 flex rounded-md px-4 duration-30
                            cursor pointer text-white hover:bg-white hover:text-black shadow-lg">
                    <img src="assets/img/analytics.png" alt="tambah user" class="h-5 w-5 mb-1 ml-4">
                    <span class="ml-7 text-xl -mt-1">Pie Chart</span>
                </div>
            </a>
            <!-- pie chart end -->
            
            <!-- data start -->
            <a href="monitoring.php">
                <div class="p-2.5 mt-3 flex rounded-md px-4 duration-30
                            cursor pointer text-white hover:bg-white hover:text-black shadow-lg">
                    <img src="assets/img/contract.png" alt="monitoring" class="h-5 w-5 mb-1 ml-4">
                    <span class="ml-7 text-xl -mt-1">Data</span>
                </div>
            </a>
            <!-- data end -->

            <!-- data start -->
            <a href="monitoring.php">
                <div class="p-2.5 mt-3 flex rounded-md px-4 duration-30
                            cursor pointer text-white hover:bg-white hover:text-black shadow-lg">
                    <img src="assets/img/setting.png" alt="monitoring" class="h-5 w-5 mb-1 ml-4">
                    <span class="ml-7 text-xl -mt-1">Setting</span>
                </div>
            </a>
            <!-- data end -->

            <hr class="mb-3 mt-3">

            <!-- logout start -->
            <a href="login.php">
                <div class="">
                <div class="p-2.5 mt-64 flex rounded-md px-4 duration-30
                            cursor pointer text-white hover:bg-white hover:text-red-700 hover:text-strong shadow-lg">
                    <img src="assets/img/logout.png" alt="tombol logout" class="h-5 w-5 mb-1 ml-4">
                    <span class="ml-7 text-xl -mt-1">Logout</span>
                </div>
                </div>
                
            </a>
            <!-- logout end -->
        </div>
        <!-- sidebar end -->
        </aside>
</body>

</html>