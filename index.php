<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/output.css">
    <title>Grafik Sensor</title>
</head>

<body class="font-custom">
    <!-- sidebar start -->
    <div x-data="setup()" x-init>
        <div class="flex h-screen antialiased text-gray-900 dark:bg-dark dark:text-light">
            <?php include('sidebar.php') ?>

            <main class="flex flex-col items-center justify-center flex-1">
                <!-- Grafik -->
                <div class="container max-w-3xl w-full h-full text-center mt-5" id="responsecontainer">
                    <div
                        class="fixed inset-0 z-50 flex items-center justify-center text-2xl font-semibold text-white bg-blue-600">
                        Loading.....
                    </div>
                <!-- Grafik data dari tds.php akan dimuat di sini -->
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
        setInterval(function() {
            $('#responsecontainer').load('tds.php');
        }, 1000);
    </script>
</body>

</html>