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

// Server-Side-Event

document.addEventListener('DOMContentLoaded', function() {
    const eventSource = new EventSource('sse.php');

    eventSource.onmessage = function(event) {
        const data = JSON.parse(event.data);

        // Update statistik
        document.getElementById('totalPeserta').innerText = data.total_peserta;
        document.getElementById('totalCheck').innerText = data.total_check;
        document.getElementById('totalUncheck').innerText = data.total_uncheck;

        // Kosongkan tbody sebelum menambah data baru
        $('#example tbody').empty();

        // Iterasi data dan tambahkan ke tabel
        data.data.forEach(row => {
            const statusIcon = row.status === 'checked' 
                ? "<i class='bx bxs-badge-check bx-tada bx-md' style='color:#ffce26'></i>" 
                : "<i class='bx bxs-alarm-exclamation bx-md' style='color:#fd7237'></i>";

            $('#example tbody').append(
                "<tr>" +
                "<td><input type='checkbox' class='print-checkbox'> " + row.NAMA_GENG + "</td>" +
                "<td>" + row.BIB_NUMBER + "</td>" +
                "<td>" + statusIcon + "</td>" +
                "</tr>"
            );
        });

        // Reinitialize DataTables
        $('#example').DataTable().destroy();
        $('#example').DataTable({
            searching: true, // Aktifkan pencarian
            order: [[1, 'asc']], // Urutkan berdasarkan kolom kedua (indeks 1), urutan ascending
            columnDefs: [
                { "orderable": false, "targets": [0] } // Disable ordering for the first column (index 0)
            ]
        });
    };

    eventSource.onerror = function(event) {
        console.error('Error with SSE:', event);
    };
});

$(document).ready(function() {
    // Select All functionality
    $('#selectAllCheckbox').change(function() {
        var isChecked = $(this).prop('checked');
        $('.print-checkbox').prop('checked', isChecked);
    });

    // Handle individual checkbox change
    $(document).on('change', '.print-checkbox', function() {
        var allChecked = $('.print-checkbox:checked').length === $('.print-checkbox').length;
        $('#selectAllCheckbox').prop('checked', allChecked);
    });

    // Event listener untuk "Enter" pada #search-input
    $('#search-input').keypress(function(event) {
        if (event.which === 13) {
            event.preventDefault(); // Mencegah form submit (jika ada)
            var searchText = $(this).val();
            $('#example').DataTable().search(searchText).draw();
        }
    });

    // Event listener untuk klik pada tombol .search-btn
    $('.search-btn').click(function() {
        var searchText = $('#search-input').val();
        $('#example').DataTable().search(searchText).draw();
    });

    // Event listener untuk klik pada tombol .clear-btn
    $('.clear-btn').click(function() {
        $('#search-input').val(''); // Mengosongkan nilai input pencarian
        $('#example').DataTable().search('').draw(); // Mereset pencarian pada tabel
    });

    // Event listener untuk tombol Print Selected
    $('#printSelectedBtn').click(function() {
        var checkboxes = document.querySelectorAll('.print-checkbox:checked');
        if (checkboxes.length === 0) {
            alert('Select at least one entry to print.');
            return;
        }

        var selectedEntries = [];
        checkboxes.forEach(function(checkbox) {
            var row = checkbox.closest('tr');
            var text = row.cells[0].textContent.trim();
            var words = text.split(' ');
            var firstThreeWords = words.slice(0, 3);
            var namaGeng = firstThreeWords.join(' ');
            var nomorBIB = row.cells[1].textContent.trim();
            selectedEntries.push({ namaGeng: namaGeng, nomorBIB: nomorBIB });
        });

        printSelectedEntries(selectedEntries);
    });
});

// Fungsi untuk mencetak entri yang dipilih
function printSelectedEntries(entries) {
    var iframe = document.createElement('iframe');
    iframe.style.position = 'absolute';
    iframe.style.left = '-9999px';
    iframe.style.width = '200mm';
    iframe.style.height = '145mm';
    iframe.style.border = 'none';
    iframe.style.display = 'none';
    document.body.appendChild(iframe);

    var iframeDoc = iframe.contentWindow.document;
    iframeDoc.open();
    iframeDoc.write(`
        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Print BIB</title>
            <style>
                @font-face {
                    font-family: 'Adumu'; /* Nama font yang akan digunakan */
                    src: url('assets/Adumu.ttf') format('truetype'); /* Lokasi file TTF */
                }

                @page { 
                    size: A4;
                    margin:3.5mm;
                }

                body {
                    padding: 0;
                    flex-direction: column;
                    justify-content: center; 
                    width: 100%;
                    height: 100%;
                    color: white !important;
                    -webkit-print-color-adjust: exact;
                }

                .container {
                    height: 145mm;
                    width: 200mm;
                    position: relative;
                }

                .img {
                    max-width: 100%;
                    height: auto;
                    display: block;
                    position: absolute;
                    z-index: -1;
                }

                .NameGroup {
                    position: absolute;
                    top: 50%;
                    left: 50%;
                    transform: translate(-50%, -50%);
                    text-align: center;
                    font-size: 88px;
                    font-family: 'Adumu';
                    line-height: 88px;
                    letter-spacing: 10px;
                }

                .BIBText {
                    position: absolute;
                    top: 95mm;
                    left: 5mm;
                    text-align: center;
                    font-size: 45px;
                    font-family: 'Adumu';
                    letter-spacing: 5px;
                }
            </style>
        </head>
        <body>
    `);

    entries.forEach(function(entry, index) {
        var qrCodeDiv = document.createElement('div');
        qrCodeDiv.style.position = 'absolute';
        qrCodeDiv.style.top = '88mm';
        qrCodeDiv.style.right = '5mm';

        new QRCode(qrCodeDiv, {
            text: entry.nomorBIB,
            width: 80,
            height: 80,
            colorDark: '#ffffff',
            colorLight: 'rgba(255, 255, 255, 0)',
            correctLevel: QRCode.CorrectLevel.H
        });

        var containerDiv = document.createElement('div');
        containerDiv.classList.add('container');
        containerDiv.innerHTML = `
            <img src="assets/bg.png" class="img">
            <div class="NameGroup">${entry.namaGeng}</div>
            <div class="BIBText">${entry.nomorBIB}</div>
        `;
        containerDiv.appendChild(qrCodeDiv);

        iframeDoc.body.appendChild(containerDiv);

        if ((index + 1) % 2 === 0 && index !== entries.length - 1) {
            var pageBreakDiv = document.createElement('div');
            pageBreakDiv.style.pageBreakAfter = 'always';
            iframeDoc.body.appendChild(pageBreakDiv);
        }
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


// $(document).ready(function() {
// 	// Select All functionality
// 	$('#selectAllCheckbox').change(function() {
// 		var isChecked = $(this).prop('checked');
// 		$('.print-checkbox').prop('checked', isChecked);
// 	});

// 	// Handle individual checkbox change
// 	$('.print-checkbox').change(function() {
// 		var allChecked = $('.print-checkbox:checked').length === $('.print-checkbox').length;
// 		$('#selectAllCheckbox').prop('checked', allChecked);
// 	});

// 	var table = new DataTable('#example', {
// 		searching: true, // Aktifkan pencarian
// 		order: [[1, 'asc']], // Urutkan berdasarkan kolom kedua (indeks 1), urutan ascending
// 		columnDefs: [
// 			{ "orderable": false, "targets": [0] } // Disable ordering for the first column (index 0)
// 		]
// 	});

//     // Event listener untuk "Enter" pada #search-input
//     $('#search-input').keypress(function(event) {
//         if (event.which === 13) {
//             event.preventDefault(); // Mencegah form submit (jika ada)
//             var searchText = $(this).val();
//             table.search(searchText).draw();
//         }
//     });

//     // Event listener untuk klik pada tombol .search-btn
//     $('.search-btn').click(function(event) {
//         var searchText = $('#search-input').val();
//         table.search(searchText).draw();
//     });

//     // Event listener untuk klik pada tombol .clear-btn
//     $('.clear-btn').click(function(event) {
//         $('#search-input').val(''); // Mengosongkan nilai input pencarian
//         table.search('').draw(); // Mereset pencarian pada tabel
// 		});
// 	});

// 	 // Event listener untuk tombol Print Selected
// 	 document.addEventListener('DOMContentLoaded', function() {
// 		document.getElementById('printSelectedBtn').addEventListener('click', function() {
// 			var checkboxes = document.querySelectorAll('.print-checkbox:checked');
// 			if (checkboxes.length === 0) {
// 				alert('Select at least one entry to print.');
// 				return;
// 			}

// 			var selectedEntries = [];
// 			checkboxes.forEach(function(checkbox) {
// 				var row = checkbox.closest('tr');
// 				var text = row.cells[0].textContent.trim();
// 				// Potong teks menjadi array kata-kata
// 				var words = text.split(' ');

// 				// Ambil hanya 3 kata pertama
// 				var firstThreeWords = words.slice(0, 3);

// 				// Gabungkan 3 kata tersebut kembali dengan spasi di antara mereka
// 				var namaGeng = firstThreeWords.join(' ');

// 				var nomorBIB = row.cells[1].textContent.trim();
// 				selectedEntries.push({ namaGeng: namaGeng, nomorBIB: nomorBIB });
// 			});

// 			printSelectedEntries(selectedEntries);
// 		});
// 	});

// 		function printSelectedEntries(entries) {
// 		// Buat elemen iframe secara dinamis
// 		var iframe = document.createElement('iframe');
// 		// Tetapkan beberapa gaya untuk iframe
// 		iframe.style.position = 'absolute';
// 		iframe.style.left = '-9999px'; // Mengatur posisi di luar layar
// 		iframe.style.width = '200mm'; // Menetapkan lebar iframe sesuai gaya label
// 		iframe.style.height = '145mm'; // Menetapkan tinggi iframe sesuai gaya label
// 		iframe.style.border = 'none'; // Menghapus border iframe
// 		iframe.style.display = 'none'; // Sembunyikan iframe dari tampilan pengguna
// 		document.body.appendChild(iframe);

// 		var iframeDoc = iframe.contentWindow.document;
// 		iframeDoc.open();
// 		iframeDoc.write(`
// 		<!DOCTYPE html>
// 		<html lang="en">
// 		<head>
// 			<meta charset="UTF-8">
// 			<meta name="viewport" content="width=device-width, initial-scale=1.0">
// 			<title>Print BIB</title>
// 		<style>
// 		@font-face {
// 						font-family: 'Adumu'; /* Nama font yang akan digunakan */
// 						src: url('assets/Adumu.ttf') format('truetype'); /* Lokasi file TTF */
// 					}

// 		  @page { 
// 			size: A4;
// 			margin:3.5mm;
// 		  }

// 		  body {
// 			padding: 0;
// 			flex-direction: column; /* Tampilkan konten secara vertikal */
// 			justify-content: center; 
// 			width: 100%; /* Lebar penuh untuk memastikan konten mengisi halaman */
// 			height: 100%; /* Setengah tinggi halaman untuk setiap konten */
// 			color: white !important;
// 			-webkit-print-color-adjust: exact;
// 		  }

// 		  .container {
// 			height: 145mm; /* Ketinggian halaman */
// 			width: 200mm; /* Lebar halaman */
// 			position: relative;
// 		  }

// 		  .img{
// 			max-width: 100%;
// 			height: auto;
// 			display: block;
// 			position: absolute;
// 			z-index: -1; /* Letakkan di belakang konten utama */
// 		  }

// 		  .NameGroup {
// 			position: absolute;
// 			top: 50%; /* Adjust vertically */
// 			left: 50%;
// 			transform: translate(-50%, -50%);
// 			text-align: center;
// 			font-size: 88px;
// 			font-family: 'Adumu';
// 			line-height: 88px;
// 			letter-spacing: 10px;
// 		  }

// 		  .BIBText {
// 			position: absolute;
// 			top: 95mm; /* Adjust vertically */
// 			left: 5mm;
// 			text-align: center;
// 			font-size: 45px;
// 			font-family: 'Adumu';
// 			letter-spacing: 5px;
// 		  }
// 		</style>
// 	</head>
// 	<body>
// `);

// entries.forEach(function(entry, index) {
//     var qrCodeDiv = document.createElement('div');
//     // Setting style for qrCodeDiv...
// 	qrCodeDiv.style.position = 'absolute'; // atau 'relative' tergantung dari kebutuhan layout
// 	qrCodeDiv.style.top = '88mm'; // Atur posisi dari atas
// 	qrCodeDiv.style.right = '5mm'; // Atur posisi dari left

//     new QRCode(qrCodeDiv, {
//         text: entry.nomorBIB,
//         width: 80,
//         height: 80,
//         colorDark: '#ffffff',
//         colorLight: 'rgba(255, 255, 255, 0)',
//         correctLevel: QRCode.CorrectLevel.H
//     });

//     // Membuat container untuk setiap entri
//     var containerDiv = document.createElement('div');
//     containerDiv.classList.add('container');
//     containerDiv.innerHTML = `
//         <img src="assets/bg.png" class="img">
//         <div class="NameGroup">${entry.namaGeng}</div>
//         <div class="BIBText">${entry.nomorBIB}</div>
//     `;
//     containerDiv.appendChild(qrCodeDiv);

// 	iframeDoc.body.appendChild(containerDiv);

//     // Tambahkan page break setelah setiap dua konten
//     if ((index + 1) % 2 === 0 && index !== entries.length - 1) {
//         var pageBreakDiv = document.createElement('div');
//         pageBreakDiv.style.pageBreakAfter = 'always';
//         iframeDoc.body.appendChild(pageBreakDiv);
//     }
// });


// iframeDoc.write(`
// 	</body>
// 	</html>
// `);

// iframeDoc.close();

// iframe.onload = function() {
// 	iframe.contentWindow.print();
// 	setTimeout(function() {
// 		document.body.removeChild(iframe);
// 	}, 100);
// };
// }