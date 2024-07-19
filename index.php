<?php
	require_once 'fetch_data.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Tailwind CSS -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">

    <!-- DataTables CSS -->
    <link href="https://cdn.datatables.net/2.0.8/css/dataTables.tailwindcss.css" rel="stylesheet">

    <!-- Boxicons -->
    <link href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css' rel='stylesheet'>

    <!-- My CSS -->
    <link rel="stylesheet" href="style.css">

    <title>FunRun - Lari Antar Geng</title>
</head>
<body>

    <!-- SIDEBAR -->
    <section id="sidebar">
        <a href="#" class="brand">
            <i class='bx bx-medal'></i>
            <span class="text">FunRun</span>
        </a>
        <ul class="side-menu top">
            <li class="active">
                <a href="#">
                    <i class='bx bxs-dashboard' ></i>
                    <span class="text">Dashboard</span>
                </a>
            </li>
        </ul>
    </section>
    <!-- SIDEBAR -->

    <!-- CONTENT -->
    <section id="content">
        <!-- NAVBAR -->
        <nav>
            <i class='bx bx-menu' ></i>
            <form action="#">
                <div class="form-input">
                    <input type="search" id="search-input" placeholder="Search...">
                    <button type="submit" class="search-btn"><i class='bx bx-search' ></i></button>
					<!-- <button type="button" class="clear-btn"><i class='bx bx-reset' ></i></button> -->
                </div>
            </form>
            <input type="checkbox" id="switch-mode" hidden>
            <label for="switch-mode" class="switch-mode"></label>
        </nav>
        <!-- NAVBAR -->

        <!-- MAIN -->
        <main>
            <div class="head-title">
                <div class="left">
                    <h1>Dashboard</h1>
                    <ul class="breadcrumb">
                        <li>
                            <a href="#">Dashboard</a>
                        </li>
                        <li><i class='bx bx-chevron-right' ></i></li>
                        <li>
                            <a class="active" href="#">Home</a>
                        </li>
                    </ul>
                </div>
            </div>

            <ul class="box-info">
                <li>
                    <i class='bx bxs-group' ></i>
                    <span class="text">
                        <h3><?php echo $row["total_peserta"]; ?></h3>
                        <p>Peserta</p>
                    </span>
                </li>
                <li>
                    <i class='bx bxs-calendar-check' ></i>
                    <span class="text">
                        <h3><?php echo $row_check["total_check"]; ?></h3>
                        <p>Checked</p>
                    </span>
                </li>
                <li>
                    <i class='bx bx-calendar-exclamation' ></i>
                    <span class="text">
						<h3><?php echo $row_uncheck["total_uncheck"]; ?></h3>
                        <p>Unchecked</p>
                    </span>
                </li>
            </ul>


            <div class="table-data">
                <div class="order">
                    <div class="head">
                        <h3>Daftar Peserta</h3>
						<button type="button" id="printAllBtn" class="btn-download">
							<i class='bx bxs-printer' ></i>
							<span class="text">BIB NUMBER</span>
						</button>
                    </div>
                    <table id="example" class="display" style="width:100%">
                            <thead>
                                <tr>
                                    <th>Nama Geng</th>
                                    <th>Nomor BIB</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
							<?php while($row = $result_data->fetch_assoc()): ?>
                            <tr>
                                <td><?php echo $row["NAMA_GENG"]; ?></td>
                                <td>
									<?php echo $row["BIB_NUMBER"]; ?>
									<button class="print-btn" data-nama="<?php echo $row["NAMA_GENG"]; ?>" data-bib="<?php echo $row["BIB_NUMBER"]; ?>"><i class='bx bxs-printer' ></i></button>
								</td>
                                <td><?php echo $row["status"]; ?></td>
                            </tr>
                        	<?php endwhile; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </main>
        <!-- MAIN -->
    </section>
    <!-- CONTENT -->
    
    <!-- Bootstrap JS and dependencies -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/2.0.8/js/dataTables.js"></script>
    <script src="https://cdn.datatables.net/2.0.8/js/dataTables.tailwindcss.js"></script>

    <script src="script.js"></script>
	<!-- Script JavaScript -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Event listener untuk tombol Print All
        document.getElementById('printAllBtn').addEventListener('click', function() {
            var rows = document.querySelectorAll('tr'); // Ambil semua baris dari tabel

            // Buat array untuk menyimpan data nama grup dan nomor BIB dari setiap baris
            var data = [];
            rows.forEach(row => {
                var namaGeng = row.cells[0].textContent.trim(); // Kolom pertama
                var nomorBIB = row.cells[1].textContent.trim(); // Kolom kedua
                data.push({ namaGeng: namaGeng, nomorBIB: nomorBIB });
            });

            // Generate QR Code untuk setiap nomor BIB menggunakan layanan online
            var qrCodePromises = data.map(entry => {
                var qrCodeUrl = 'https://api.qrserver.com/v1/create-qr-code/?size=150x150&data=' + encodeURIComponent(entry.nomorBIB);
                return new Promise(function(resolve, reject) {
                    var qrImage = new Image();
                    qrImage.onload = function() {
                        resolve({ namaGeng: entry.namaGeng, nomorBIB: entry.nomorBIB, qrCodeUrl: qrCodeUrl });
                    };
                    qrImage.onerror = function() {
                        reject();
                    };
                    qrImage.src = qrCodeUrl;
                });
            });

            // Setelah semua QR Code selesai dimuat, lanjutkan dengan membuat iframe dan mencetak
            Promise.all(qrCodePromises).then(function(entries) {
                // Semua QR Code telah dimuat
                // Buat sebuah iframe secara dinamis
                var iframe = document.createElement('iframe');
                iframe.style.display = 'none'; // Sembunyikan iframe dari tampilan pengguna
                document.body.appendChild(iframe);

                var iframeDoc = iframe.contentWindow.document;
                iframeDoc.open();
                iframeDoc.write(`
                    <!DOCTYPE html>
                    <html lang="en">
                    <head>
                        <meta charset="UTF-8">
                        <title>Print BIB</title>
                        <style>
                            /* CSS gaya cetakan Anda di sini */
                        </style>
                    </head>
                    <body>
                        <!-- Konten untuk pencetakan -->
                        <div class="container">
                            <!-- Halaman 1 -->
                            <div style="page-break-after: always;">
                                ${generatePage(entries.slice(0, 2))}
                            </div>
                            <!-- Halaman 2 -->
                            <div>
                                ${generatePage(entries.slice(2, 4))}
                            </div>
                        </div>
                    </body>
                    </html>
                `);
                iframeDoc.close();

                // Tambahkan jeda waktu sebelum mencetak
                setTimeout(function() {
                    // Pencetakan konten di dalam iframe
                    iframe.contentWindow.focus(); // Fokuskan iframe untuk memastikan pencetakan berhasil
                    iframe.contentWindow.print();

                    // Hapus iframe setelah pencetakan selesai
                    setTimeout(function() {
                        document.body.removeChild(iframe);
                    }, 1000); // Waktu tunggu sebelum menghapus iframe (1 detik)
                }, 1000); // Waktu tunggu sebelum mencetak (1 detik)
            }).catch(function() {
                // Jika terjadi kesalahan dalam memuat QR Code
                console.log('Gagal memuat QR Code.');
            });
        });
    });

    function generatePage(entries) {
        var pageContent = '';
        entries.forEach(entry => {
            var qrCodeUrl = entry.qrCodeUrl;
            pageContent += `
                <div class="row">
                    <div class="left-column">
                        <img src="${qrCodeUrl}" alt="QR Code" style="max-width: 100%; height: auto;">
                        <div class="BIBText">${entry.nomorBIB}</div>
                    </div>
                    <div class="right-column">
                        <div class="headerTextLeft">28 JULI 2024<br>HOTEL DAFAM SEMARANG</div>
                        <div class="headerTextRight">FUN RUN 6K<br>LARI ANTAR GENG</div>
                        <img src="assets/sponsor-atas.png" class="img-2" alt="Image for printing">
                        <div class="NameGroup">${entry.namaGeng}</div>
                        <img src="assets/sponsor-bawah.png" class="img-3" alt="Image for printing">
                    </div>
                </div>
            `;
        });
        return pageContent;
    }
</script>
</body>
</html>