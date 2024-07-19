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
						<a href="#" class="btn-download">
							<i class='bx bxs-printer' ></i>
							<span class="text">BIB NUMBER</span>
						</a>
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

	<script>
		$(document).ready(function() {
			var table = new DataTable('#example', {
				searching: true, // Aktifkan pencarian
			});

			// Event listener untuk "Enter" pada #search-input
			$('#search-input').keypress(function(event) {
				if (event.which === 13) {
					event.preventDefault(); // Mencegah form submit (jika ada)
					var searchText = $(this).val();
					table.search(searchText).draw();
				}
			});

			// Event listener untuk klik pada tombol .search-btn
			$('.search-btn').click(function(event) {
				var searchText = $('#search-input').val();
				table.search(searchText).draw();
			});

			// Event listener untuk klik pada tombol .clear-btn
			$('.clear-btn').click(function(event) {
				$('#search-input').val(''); // Mengosongkan nilai input pencarian
				table.search('').draw(); // Mereset pencarian pada tabel
			});
			// Event listener untuk klik tombol print
			$('.print-btn').click(function() {
				var namaGeng = $(this).data('nama');
				var nomorBIB = $(this).data('bib');
				// Lakukan operasi pencetakan di sini, misalnya buka jendela baru untuk mencetak
				// Membuka jendela popup
				var popupWin = window.open('', '_blank');
				popupWin.document.write('<head>');
				popupWin.document.write('    <title>Print BIB</title>');
				popupWin.document.write('    <style>');
				popupWin.document.write('        @font-face {');
				popupWin.document.write('            font-family: \'Adumu\'; /* Nama font yang akan digunakan */');
				popupWin.document.write('            src: url(\'assets/Adumu.ttf\') format(\'truetype\'); /* Lokasi file TTF */');
				popupWin.document.write('            /* Opsional: tambahkan format lain jika diperlukan */');
				popupWin.document.write('        }');
				popupWin.document.write('        body {');
				popupWin.document.write('            width: 200mm;');
				popupWin.document.write('            height: 145mm;');
				popupWin.document.write('            margin: 0;');
				popupWin.document.write('            padding: 0;');
				popupWin.document.write('            display: flex;');
				popupWin.document.write('            justify-content: center;');
				popupWin.document.write('            align-items: center;');
				popupWin.document.write('            position: relative;');
				popupWin.document.write('            font-weight: 700;');
				popupWin.document.write('            color: white;');
				popupWin.document.write('        }');
				popupWin.document.write('        .shape {');
				popupWin.document.write('            position: absolute;');
				popupWin.document.write('            top: 70%; /* Adjust vertically */');
				popupWin.document.write('            right: 7px;');
				popupWin.document.write('            transform: translate(-5%, -50%);');
				popupWin.document.write('            width: 80px;');
				popupWin.document.write('            height: 80px;');
				popupWin.document.write('            background-color: white;');
				popupWin.document.write('        }');
				popupWin.document.write('        .container {');
				popupWin.document.write('            position: relative;');
				popupWin.document.write('            width: 100%;');
				popupWin.document.write('            height: 100%;');
				popupWin.document.write('        }');
				popupWin.document.write('        .img, .img-2, .img-3 {');
				popupWin.document.write('            max-width: 100%;');
				popupWin.document.write('            height: auto;');
				popupWin.document.write('            display: block;');
				popupWin.document.write('            position: absolute;');
				popupWin.document.write('            left: 50%;');
				popupWin.document.write('            transform: translateX(-50%);');
				popupWin.document.write('        }');
				popupWin.document.write('        .img {');
				popupWin.document.write('            z-index: -1; /* Letakkan di belakang konten utama */');
				popupWin.document.write('        }');
				popupWin.document.write('        .img-2 {');
				popupWin.document.write('            top: 12mm; /* Adjust as needed */');
				popupWin.document.write('            width: 550px;');
				popupWin.document.write('        }');
				popupWin.document.write('        .img-3 {');
				popupWin.document.write('            bottom: 0; /* Adjust as needed */');
				popupWin.document.write('        }');
				popupWin.document.write('        .NameGroup {');
				popupWin.document.write('            position: absolute;');
				popupWin.document.write('            top: 50%; /* Adjust vertically */');
				popupWin.document.write('            left: 50%;');
				popupWin.document.write('            transform: translate(-50%, -50%);');
				popupWin.document.write('            text-align: center;');
				popupWin.document.write('            font-size: 88px;');
				popupWin.document.write('            font-family: \'Adumu\';');
				popupWin.document.write('            line-height: 88px;');
				popupWin.document.write('            letter-spacing: 10px;');
				popupWin.document.write('        }');
				popupWin.document.write('        .headerTextLeft {');
				popupWin.document.write('            position: absolute;');
				popupWin.document.write('            top: 5%; /* Adjust vertically */');
				popupWin.document.write('            left: 5%;');
				popupWin.document.write('            transform: translate(-5%, -50%);');
				popupWin.document.write('            text-align: center;');
				popupWin.document.write('            font-size: 15px;');
				popupWin.document.write('            font-family: Arial, Helvetica, sans-serif;');
				popupWin.document.write('        }');
				popupWin.document.write('        .headerTextRight {');
				popupWin.document.write('            position: absolute;');
				popupWin.document.write('            top: 5%; /* Adjust vertically */');
				popupWin.document.write('            right: 5%;');
				popupWin.document.write('            transform: translate(5%, -50%);');
				popupWin.document.write('            text-align: center;');
				popupWin.document.write('            font-size: 15px;');
				popupWin.document.write('            font-family: Arial, Helvetica, sans-serif;');
				popupWin.document.write('        }');
				popupWin.document.write('        .BIBText {');
				popupWin.document.write('            position: absolute;');
				popupWin.document.write('            top: 73%; /* Adjust vertically */');
				popupWin.document.write('            left: 15px;');
				popupWin.document.write('            transform: translate(-5%, -50%);');
				popupWin.document.write('            text-align: center;');
				popupWin.document.write('            font-size: 45px;');
				popupWin.document.write('            font-family: \'Adumu\';');
				popupWin.document.write('            letter-spacing: 5px;');
				popupWin.document.write('        }');
				popupWin.document.write('    </style>');
				popupWin.document.write('</head>');
				popupWin.document.write('<body>');
				popupWin.document.write('<div class="container">');
				popupWin.document.write('    <div class="shape"></div>');
				popupWin.document.write('    <img loading="lazy" srcset="assets/bg.png" class="img"/>');
				popupWin.document.write('    <div class="headerTextLeft">28 JULI 2024<br>HOTEL DAFAM SEMARANG</div>');
				popupWin.document.write('    <div class="headerTextRight">FUN RUN 6K<br>LARI ANTAR GENG</div>');
				popupWin.document.write('    <img loading="lazy" srcset="assets/sponsor-atas.png" class="img-2"/>');
				popupWin.document.write('    <div class="NameGroup">' + namaGeng +'</div>');
				popupWin.document.write('    <div class="BIBText">' + nomorBIB +'</div>');
				popupWin.document.write('    <img loading="lazy" srcset="assets/sponsor-bawah.png" class="img-3"/>');
				popupWin.document.write('</div>');
				popupWin.document.write('</body>');
				popupWin.document.close();

				// Cetak otomatis
				popupWin.window.print();
			});
		});
	</script>

    <script src="script.js"></script>
</body>
</html>