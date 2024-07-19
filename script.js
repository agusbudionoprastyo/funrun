const allSideMenu = document.querySelectorAll('#sidebar .side-menu.top li a');

allSideMenu.forEach(item=> {
	const li = item.parentElement;

	item.addEventListener('click', function () {
		allSideMenu.forEach(i=> {
			i.parentElement.classList.remove('active');
		})
		li.classList.add('active');
	})
});

// TOGGLE SIDEBAR
const menuBar = document.querySelector('#content nav .bx.bx-menu');
const sidebar = document.getElementById('sidebar');

menuBar.addEventListener('click', function () {
	sidebar.classList.toggle('hide');
})

const searchButton = document.querySelector('#content nav form .form-input button');
const searchButtonIcon = document.querySelector('#content nav form .form-input button .bx');
const searchForm = document.querySelector('#content nav form');

searchButton.addEventListener('click', function (e) {
	if(window.innerWidth < 576) {
		e.preventDefault();
		searchForm.classList.toggle('show');
		if(searchForm.classList.contains('show')) {
			searchButtonIcon.classList.replace('bx-search', 'bx-x');
		} else {
			searchButtonIcon.classList.replace('bx-x', 'bx-search');
		}
	}
})

if(window.innerWidth < 768) {
	sidebar.classList.add('hide');
} else if(window.innerWidth > 576) {
	searchButtonIcon.classList.replace('bx-x', 'bx-search');
	searchForm.classList.remove('show');
}

window.addEventListener('resize', function () {
	if(this.innerWidth > 576) {
		searchButtonIcon.classList.replace('bx-x', 'bx-search');
		searchForm.classList.remove('show');
	}
})

const switchMode = document.getElementById('switch-mode');

switchMode.addEventListener('change', function () {
	if(this.checked) {
		document.body.classList.add('dark');
	} else {
		document.body.classList.remove('dark');
	}
})

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

    // Event listener untuk klik pada tombol .print-btn
    $('.print-btn').click(function() {
        var row = this.closest('tr'); // Temukan baris terdekat dari tombol yang diklik

        // Ambil nilai dari kolom "Nama Group" dan "Nomor BIB" di dalam baris
        var namaGeng = row.cells[0].textContent; // Kolom pertama
        var nomorBIB = row.cells[1].textContent; // Kolom kedua

        // Buat sebuah iframe secara dinamis
        var iframe = document.createElement('iframe');
        iframe.style.display = 'none'; // Sembunyikan iframe dari tampilan pengguna
        document.body.appendChild(iframe);

        // Tulis konten HTML ke dalam iframe setelah dokumen HTML di dalam iframe dimuat sepenuhnya
        iframe.onload = function() {
            var iframeDoc = iframe.contentWindow.document;
            iframeDoc.open();
            iframeDoc.write(`
                <!DOCTYPE html>
                <html lang="en">
                <head>
                    <meta charset="UTF-8">
                    <title>Print BIB</title>
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
					top: 70%; /* Adjust vertically */
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
                        <!-- Konten yang akan dicetak -->
                        <div class="shape"></div>
                        <img loading="lazy" src="assets/bg.png" class="img"/>
                        <div class="headerTextLeft">28 JULI 2024<br>HOTEL DAFAM SEMARANG</div>
                        <div class="headerTextRight">FUN RUN 6K<br>LARI ANTAR GENG</div>
                        <img loading="lazy" src="assets/sponsor-atas.png" class="img-2"/>
                        <div class="NameGroup">${namaGeng}</div>
                        <div class="BIBText">${nomorBIB}</div>
                        <img loading="lazy" src="assets/sponsor-bawah.png" class="img-3"/>
                    </div>
                </body>
                </html>
            `);
            iframeDoc.close();

            // Pencetakan konten di dalam iframe
            iframe.contentWindow.focus(); // Fokuskan iframe untuk memastikan pencetakan berhasil
            iframe.contentWindow.print();

            // Hapus iframe setelah pencetakan selesai
            setTimeout(function() {
                document.body.removeChild(iframe);
            }, 1000); // Waktu tunggu sebelum menghapus iframe (1 detik)
        };
    });
});