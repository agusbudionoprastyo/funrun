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
						<button type="button" id="printSelectedBtn" class="btn-download">
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
									<input type="checkbox" class="print-checkbox">
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
	<!-- <script>
        // Event listener untuk tombol Print Selected
		document.addEventListener('DOMContentLoaded', function() {
            document.getElementById('printSelectedBtn').addEventListener('click', function() {
                var checkboxes = document.querySelectorAll('.print-checkbox:checked');
                if (checkboxes.length === 0) {
                    alert('Select at least one entry to print.');
                    return;
                }

                var selectedEntries = [];
                checkboxes.forEach(function(checkbox) {
                    var row = checkbox.closest('tr');
                    var namaGeng = row.cells[0].textContent.trim();
                    var nomorBIB = row.cells[1].textContent.trim();
                    selectedEntries.push({ namaGeng: namaGeng, nomorBIB: nomorBIB });
                });

                printSelectedEntries(selectedEntries);
            });
        });

			// Fungsi untuk mencetak semua baris yang dipilih dalam dokumen HTML terpisah
			function printSelectedEntries(entries) {
				entries.forEach(function(entry) {
					// Generate QR Code URL
					var qrCodeUrl = 'https://api.qrserver.com/v1/create-qr-code/?size=150x150&data=' + encodeURIComponent(entry.nomorBIB);
					
					// Buat elemen iframe secara dinamis
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
							<title>Print Entry - ${entry.namaGeng}</title>
							<style>
								@font-face {
									font-family: 'Adumu'; /* Nama font yang akan digunakan */
									src: url('assets/Adumu.ttf') format('truetype'); /* Lokasi file TTF */
									/* Opsional: tambahkan format lain jika diperlukan */
								}
								body {
									width: 200mm;
									height: 145mm;
									margin: 0;
									padding: 0;
									display: flex;
									justify-content: center;
									align-items: center;
									position: relative;
									font-weight: 700;
									color: white;
								}
								.shape {
									position: absolute;
									top: 67%; /* Adjust vertically */
									right: 7px;
									transform: translate(-5%, -50%);
									width: 80px;
									height: 80px;
									background-color: white;
								}
								.container {
									position: relative;
									width: 100%;
									height: 100%;
								}
								.img,
								.img-2,
								.img-3 {
									max-width: 100%;
									height: auto;
									display: block;
									position: absolute;
									left: 50%;
									transform: translateX(-50%);
								}
								.img {
									z-index: -1; /* Letakkan di belakang konten utama */
								}
								.img-2 {
									top: 12mm; /* Adjust as needed */
									width: 550px;
								}
								.img-3 {
									bottom: 0; /* Adjust as needed */
								}
								.NameGroup {
									position: absolute;
									top: 50%; /* Adjust vertically */
									left: 50%;
									transform: translate(-50%, -50%);
									text-align: center;
									font-size: 88px;
									font-family: 'Adumu';
									line-height: 88px;
									letter-spacing: 10px;
								}
								.headerTextLeft {
									position: absolute;
									top: 5%; /* Adjust vertically */
									left: 5%;
									transform: translate(-5%, -50%);
									text-align: center;
									font-size: 15px;
									font-family: Arial, Helvetica, sans-serif;
								}
								.headerTextRight {
									position: absolute;
									top: 5%; /* Adjust vertically */
									right: 5%;
									transform: translate(5%, -50%);
									text-align: center;
									font-size: 15px;
									font-family: Arial, Helvetica, sans-serif;
								}
								.BIBText {
									position: absolute;
									top: 73%; /* Adjust vertically */
									left: 15px;
									transform: translate(-5%, -50%);
									text-align: center;
									font-size: 45px;
									font-family: 'Adumu';
									letter-spacing: 5px;
								}
							</style>
						</head>
						<body>
							<div class="container">
								<div class="shape">
									<img src="${qrCodeUrl}" alt="QR Code" style="max-width: 100%; height: auto;">
								</div>
								<img src="assets/bg.png" class="img" alt="Image for printing">
								<div class="headerTextLeft">28 JULI 2024<br>HOTEL DAFAM SEMARANG</div>
								<div class="headerTextRight">FUN RUN 6K<br>LARI ANTAR GENG</div>
								<img src="assets/sponsor-atas.png" class="img-2" alt="Image for printing">
								<div class="NameGroup">${entry.namaGeng}</div>
								<div class="BIBText">${entry.nomorBIB}</div>
								<img src="assets/sponsor-bawah.png" class="img-3" alt="Image for printing">
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
				});
			}

</script> -->
<script>
        // Event listener untuk tombol Print Selected
		document.addEventListener('DOMContentLoaded', function() {
            document.getElementById('printSelectedBtn').addEventListener('click', function() {
                var checkboxes = document.querySelectorAll('.print-checkbox:checked');
                if (checkboxes.length === 0) {
                    alert('Select at least one entry to print.');
                    return;
                }

                var selectedEntries = [];
                checkboxes.forEach(function(checkbox) {
                    var row = checkbox.closest('tr');
                    var namaGeng = row.cells[0].textContent.trim();
                    var nomorBIB = row.cells[1].textContent.trim();
                    selectedEntries.push({ namaGeng: namaGeng, nomorBIB: nomorBIB });
                });

                printSelectedEntries(selectedEntries);
            });
        });

		// Membuat iframe element
		var iframe = document.createElement('iframe');

			// Menetapkan beberapa gaya untuk iframe
			iframe.style.position = 'absolute';
			iframe.style.left = '-9999px'; // Mengatur posisi di luar layar
			iframe.style.width = '200mm'; // Menetapkan lebar iframe sesuai gaya label
			iframe.style.height = '145mm'; // Menetapkan tinggi iframe sesuai gaya label
			iframe.style.border = 'none'; // Menghapus border iframe

			// Menambahkan iframe ke dalam body dokumen
			document.body.appendChild(iframe);

	function printSelectedEntries(entries) {
    // Buat elemen iframe secara dinamis
    var iframe = document.createElement('iframe');
    // Tetapkan beberapa gaya untuk iframe
    iframe.style.position = 'absolute';
    iframe.style.left = '-9999px'; // Mengatur posisi di luar layar
    iframe.style.width = '200mm'; // Menetapkan lebar iframe sesuai gaya label
    iframe.style.height = '145mm'; // Menetapkan tinggi iframe sesuai gaya label
    iframe.style.border = 'none'; // Menghapus border iframe
    iframe.style.display = 'none'; // Sembunyikan iframe dari tampilan pengguna
    document.body.appendChild(iframe);

    var iframeDoc = iframe.contentWindow.document;
    iframeDoc.open();
    iframeDoc.write(`
        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <title>Cetak Entri - ${entries[0].namaGeng}</title>
            <style>
			@font-face {
						font-family: 'Adumu'; /* Nama font yang akan digunakan */
						src: url('assets/Adumu.ttf') format('truetype'); /* Lokasi file TTF */
						/* Opsional: tambahkan format lain jika diperlukan */
					}
					body {
						width: 200mm;
						height: 145mm;
						margin: 0;
						padding: 0;
						display: flex;
						justify-content: center;
						align-items: center;
						position: relative;
						font-weight: 700;
						color: white;
					}
					.shape {
						position: absolute;
						top: 67%; /* Adjust vertically */
						right: 7px;
						transform: translate(-5%, -50%);
						width: 80px;
						height: 80px;
						background-color: white;
					}
					.container {
						position: relative;
						width: 100%;
						height: 100%;
					}
					.img,
					.img-2,
					.img-3 {
						max-width: 100%;
						height: auto;
						display: block;
						position: absolute;
						left: 50%;
						transform: translateX(-50%);
					}
					.img {
						z-index: -1; /* Letakkan di belakang konten utama */
					}
					.img-2 {
						top: 12mm; /* Adjust as needed */
						width: 550px;
					}
					.img-3 {
						bottom: 0; /* Adjust as needed */
					}
					.NameGroup {
						position: absolute;
						top: 50%; /* Adjust vertically */
						left: 50%;
						transform: translate(-50%, -50%);
						text-align: center;
						font-size: 88px;
						font-family: 'Adumu';
						line-height: 88px;
						letter-spacing: 10px;
					}
					.headerTextLeft {
						position: absolute;
						top: 5%; /* Adjust vertically */
						left: 5%;
						transform: translate(-5%, -50%);
						text-align: center;
						font-size: 15px;
						font-family: Arial, Helvetica, sans-serif;
					}
					.headerTextRight {
						position: absolute;
						top: 5%; /* Adjust vertically */
						right: 5%;
						transform: translate(5%, -50%);
						text-align: center;
						font-size: 15px;
						font-family: Arial, Helvetica, sans-serif;
					}
					.BIBText {
						position: absolute;
						top: 73%; /* Adjust vertically */
						left: 15px;
						transform: translate(-5%, -50%);
						text-align: center;
						font-size: 45px;
						font-family: 'Adumu';
						letter-spacing: 5px;
					}
            </style>
        </head>
        <body>
    `);

    entries.forEach(function(entry) {
        // Membuat URL QR Code
        var qrCodeUrl = 'https://api.qrserver.com/v1/create-qr-code/?size=150x150&data=' + encodeURIComponent(entry.nomorBIB);

        iframeDoc.write(`
            <div class="container">
			<div class="shape">
					<img src="${qrCodeUrl}" alt="QR Code" style="max-width: 100%; height: auto;">
				</div>
				<img src="assets/bg.png" class="img" alt="Image for printing">
				<div class="headerTextLeft">28 JULI 2024<br>HOTEL DAFAM SEMARANG</div>
				<div class="headerTextRight">FUN RUN 6K<br>LARI ANTAR GENG</div>
				<img src="assets/sponsor-atas.png" class="img-2" alt="Image for printing">
				<div class="NameGroup">${entry.namaGeng}</div>
				<div class="BIBText">${entry.nomorBIB}</div>
				<img src="assets/sponsor-bawah.png" class="img-3" alt="Image for printing">
            </div>
        `);
    });

    iframeDoc.write(`
        </body>
        </html>
    `);

    iframeDoc.close();

    iframe.onload = function() {
        iframe.contentWindow.print();
        setTimeout(function() {
            document.body.removeChild(iframe);
        }, 100);
    };
}


</script>

</body>
</html>