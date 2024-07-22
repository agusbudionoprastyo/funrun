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

// // Server-Side-Event

// document.addEventListener('DOMContentLoaded', function() {
//     const eventSource = new EventSource('sse.php');

//     eventSource.onmessage = function(event) {
//         const data = JSON.parse(event.data);

//         // Update statistik
//         document.getElementById('totalPeserta').innerText = data.total_peserta;
//         document.getElementById('totalCheck').innerText = data.total_check;
//         document.getElementById('totalUncheck').innerText = data.total_uncheck;

//     };

//     eventSource.onerror = function(event) {
//         console.error('Error with SSE:', event);
//     };
// });

// document.addEventListener('DOMContentLoaded', function() {
// 	const audio = document.getElementById('audio');

// 	const eventSource = new EventSource('sse.php');
// 	// Ambil data terakhir dari sessionStorage
// 	const storedData = JSON.parse(sessionStorage.getItem('lastData')) || {
// 		total_peserta: 0,
// 		total_check: 0,
// 		total_uncheck: 0
// 	};

// 	eventSource.onmessage = function(event) {
		
// 		const data = JSON.parse(event.data);

// 		// Update statistik di halaman
// 		document.getElementById('totalPeserta').innerText = data.total_peserta;
// 		document.getElementById('totalCheck').innerText = data.total_check;
// 		document.getElementById('totalUncheck').innerText = data.total_uncheck;

// 		// Bandingkan data lama dengan data baru
// 		if (data.total_peserta !== storedData.total_peserta ||
// 			data.total_check !== storedData.total_check ||
// 			data.total_uncheck !== storedData.total_uncheck) {
// 			playAudio()
// 			// Tampilkan notifikasi menggunakan SweetAlert2
// 			Swal.fire({
// 				title: 'Fun Run - Lari Antar Geng',
// 				text: `Total Peserta: ${data.total_peserta}\nTotal Check: ${data.total_check}\nTotal Uncheck: ${data.total_uncheck}`,
// 				icon: 'info',
// 				showConfirmButton: false, // Tidak ada tombol konfirmasi
// 				timer: 5000, // Durasi notifikasi 5 detik
// 				timerProgressBar: true, // Tampilkan progress bar
// 				willClose: () => {
// 					// Simpan data terbaru di sessionStorage setelah notifikasi menghilang
// 					sessionStorage.setItem('lastData', JSON.stringify(data));
// 					window.location.reload(); // Reload halaman setelah notifikasi menghilang
// 				}
// 			});
// 		}
// 	};

// 	eventSource.onerror = function(event) {
// 		console.error('Error dengan SSE:', event);
// 	};
// });

// // Function to play audio
// function playAudio() {
// 	audio.play().catch(function(error) {
// 		console.error('Error playing audio:', error);
// 	});
// }

const eventSource = new EventSource('sse.php');  // Sesuaikan dengan URL SSE server Anda

eventSource.onmessage = function(event) {
    const data = JSON.parse(event.data);

    // Panggil fungsi untuk mengelompokkan data berdasarkan 'NAMA_GENG'
    const groupedData = groupDataByGeng(data.data);

    // Lakukan sorting untuk setiap kelompok berdasarkan 'timestamp' paling pertama
    for (let geng in groupedData) {
        groupedData[geng].sort((a, b) => new Date(a.timestamp) - new Date(b.timestamp));
    }

    // Ambil lima grup tercepat
    const fastestGroups = Object.keys(groupedData).slice(0, 5);

    // Update struktur HTML dengan urutan grup tercepat
    updateMedalList(fastestGroups);
    
    // Update statistik di halaman
    updateStatistics(data);
};

eventSource.onerror = function(event) {
    console.error('Error receiving SSE: ', event);
};

// Fungsi untuk mengelompokkan data berdasarkan 'NAMA_GENG'
function groupDataByGeng(data) {
    const groupedData = {};

    data.forEach(entry => {
        const { NAMA_GENG } = entry;
        if (!groupedData[NAMA_GENG]) {
            groupedData[NAMA_GENG] = [];
        }
        groupedData[NAMA_GENG].push(entry);
    });

    return groupedData;
}

// Fungsi untuk memperbarui struktur HTML dengan urutan grup tercepat
function updateMedalList(fastestGroups) {
    const medalList = document.getElementById('medal-list');
    const listItems = medalList.getElementsByTagName('li');

    fastestGroups.forEach((groupName, index) => {
        const listItem = listItems[index];
        listItem.classList.add(groupName);  // Tambahkan kelas 'first', 'second', 'third', dst.
        listItem.querySelector('p').innerText = `${index + 1}. ${groupName}`;  // Update teks urutan
    });
}

// Fungsi untuk memperbarui statistik di halaman
function updateStatistics(data) {
    document.getElementById('totalPeserta').innerText = data.total_peserta;
    document.getElementById('totalCheck').innerText = data.total_check;
    document.getElementById('totalUncheck').innerText = data.total_uncheck;

    // Bandingkan data lama dengan data baru jika diperlukan untuk menampilkan notifikasi
    const storedData = JSON.parse(sessionStorage.getItem('lastData')) || {
        total_peserta: 0,
        total_check: 0,
        total_uncheck: 0
    };

    if (!isEqualData(data, storedData)) {
        playNotificationSound(); // Memanggil fungsi untuk memainkan suara notifikasi
        showNotification(data); // Menampilkan notifikasi dengan data baru
    }

    // Simpan data terbaru di sessionStorage
    sessionStorage.setItem('lastData', JSON.stringify(data));
}

// Fungsi untuk membandingkan data lama dan baru
function isEqualData(newData, oldData) {
    return (
        newData.total_peserta === oldData.total_peserta &&
        newData.total_check === oldData.total_check &&
        newData.total_uncheck === oldData.total_uncheck
        // Tambahkan pembandingan data lain jika diperlukan
    );
}

// Fungsi untuk memainkan suara atau efek audio notifikasi
function playNotificationSound() {
    // Tambahkan logika untuk memainkan suara atau efek audio
    // Contoh:
    // const audio = new Audio('path/to/sound.mp3');
    // audio.play();
}

// Fungsi untuk menampilkan notifikasi menggunakan SweetAlert2
function showNotification(data) {
    Swal.fire({
        title: 'Fun Run - Lari Antar Geng',
        html: `
            <p>Total Peserta: ${data.total_peserta}</p>
            <p>Total Check: ${data.total_check}</p>
            <p>Total Uncheck: ${data.total_uncheck}</p>
        `,
        icon: 'info',
        showConfirmButton: false, // Tidak ada tombol konfirmasi
        timer: 5000, // Durasi notifikasi 5 detik
        timerProgressBar: true // Tampilkan progress bar
    });
}


$(document).ready(function() {
	// table initialize
	var table = new DataTable('#example', {
		searching: true, // Aktifkan pencarian
		order: [[1, 'asc']], // Urutkan berdasarkan kolom kedua (indeks 1), urutan ascending
		columnDefs: [
			{ 
				"orderable": false, 
				"targets": [3] // Disable ordering for the fourth column (index 0)
			},
			{ 
				"targets": 1,  // Kolom ke-2 (indeks mulai dari 0)
				"className": "text-center" 
			},
			{ 
				"targets": 2,  // Kolom ke-3 (indeks mulai dari 0)
				"className": "text-center" 
			},
			{ 
				"targets": 3,  // Kolom ke-3 (indeks mulai dari 0)
				"className": "text-center" 
			}
		]
	});

	// Select All functionality
	$('#selectAllCheckbox').change(function() {
		var isChecked = $(this).prop('checked');
		$('.print-checkbox').prop('checked', isChecked);
	});

	// Handle individual checkbox change
	$('.print-checkbox').change(function() {
		var allChecked = $('.print-checkbox:checked').length === $('.print-checkbox').length;
		$('#selectAllCheckbox').prop('checked', allChecked);
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
	});

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
				var text = row.cells[0].textContent.trim();
				// Potong teks menjadi array kata-kata
				var words = text.split(' ');

				// Ambil hanya 3 kata pertama
				var firstThreeWords = words.slice(0, 3);

				// Gabungkan 3 kata tersebut kembali dengan spasi di antara mereka
				var namaGeng = firstThreeWords.join(' ');

				var nomorBIB = row.cells[1].textContent.trim();
				selectedEntries.push({ namaGeng: namaGeng, nomorBIB: nomorBIB });
			});

			printSelectedEntries(selectedEntries);
		});
	});

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
			flex-direction: column; /* Tampilkan konten secara vertikal */
			justify-content: center; 
			width: 100%; /* Lebar penuh untuk memastikan konten mengisi halaman */
			height: 100%; /* Setengah tinggi halaman untuk setiap konten */
			color: white !important;
			-webkit-print-color-adjust: exact;
		  }

		  .container {
			height: 145mm; /* Ketinggian halaman */
			width: 200mm; /* Lebar halaman */
			position: relative;
			border: 1px solid #000;
    		padding: 1mm; 
			page-break-after: always; /* Force page break after each container */
		  }

		  .img{
			max-width: 100%;
			height: auto;
			display: block;
			position: absolute;
			z-index: -1; /* Letakkan di belakang konten utama */
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

		  .BIBText {
			position: absolute;
			top: 95mm; /* Adjust vertically */
			left: 2mm;
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
    // Setting style for qrCodeDiv...
	qrCodeDiv.style.position = 'absolute'; // atau 'relative' tergantung dari kebutuhan layout
	qrCodeDiv.style.top = '88mm'; // Atur posisi dari atas
	qrCodeDiv.style.right = '2mm'; // Atur posisi dari left

    new QRCode(qrCodeDiv, {
        text: entry.nomorBIB,
        width: 80,
        height: 80,
        colorDark: '#ffffff',
        colorLight: 'rgba(255, 255, 255, 0)',
        correctLevel: QRCode.CorrectLevel.H
    });

    // Membuat container untuk setiap entri
    var containerDiv = document.createElement('div');
    containerDiv.classList.add('container');
    containerDiv.innerHTML = `
        <img src="assets/bg.png" class="img">
        <div class="NameGroup">${entry.namaGeng}</div>
        <div class="BIBText">${entry.nomorBIB}</div>
    `;
    containerDiv.appendChild(qrCodeDiv);

	iframeDoc.body.appendChild(containerDiv);

    // // Tambahkan page break setelah setiap dua konten
    // if ((index + 1) % 2 === 0 && index !== entries.length - 1) {
    //     var pageBreakDiv = document.createElement('div');
    //     pageBreakDiv.style.pageBreakAfter = 'always';
    //     iframeDoc.body.appendChild(pageBreakDiv);
    // }
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