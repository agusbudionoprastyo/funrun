document.addEventListener('DOMContentLoaded', function() {
    const eventSource = new EventSource('../api/sse.php');
    const audio = document.getElementById('audio'); // Pastikan audio sudah didefinisikan di halaman HTML

    eventSource.onmessage = function(event) {
        const data = JSON.parse(event.data);

        // Update UI for top 5 fastest check-ins
        var medalList = document.getElementById('medal-list');
				// Contoh penggunaan:
				for (var i = 0; i < 6; i++) {
					var position = i + 1;
					var suffix = getRankSuffix(position);
					var listItem = medalList.children[i];
				
					if (data.fastest_checkin[i]) {
						listItem.innerHTML = '<p>' + position + suffix + ' ' + data.fastest_checkin[i].NAMA_GENG + '</p>' +
											 '<i class="bx bx-medal"></i>';
					} else {
						listItem.innerHTML = '<p>' + position + suffix + '</p>' +
											 '<i class="bx bx-medal"></i>';

					}
				}	

		function getRankSuffix(position) {
			// Mendapatkan angka terakhir dari posisi (misalnya 1, 2, 3, dst)
			var lastDigit = position % 10;
			var secondLastDigit = Math.floor(position / 10) % 10;
		
			// Aturan dasar:
			if (secondLastDigit === 1) {
				return "<sup>th</sup>";
			} else {
				switch (lastDigit) {
					case 1:
						return "<sup>st</sup>";
					case 2:
						return "<sup>nd</sup>";
					case 3:
						return "<sup>rd</sup>";
					default:
						return "<sup>th</sup>";
				}
			}
		}

   // Update statistik
    document.getElementById('totalPeserta').innerText = data.total_peserta;
    document.getElementById('totalCheck').innerText = data.total_check;
    document.getElementById('totalUncheck').innerText = data.total_uncheck;

    // Ambil data terakhir dari sessionStorage
    const storedData = JSON.parse(sessionStorage.getItem('lastData'));

    // Bandingkan dengan data saat ini
    if (data.max_timestamp_data &&
        (!storedData ||
        data.max_timestamp_data.max_timestamp !== storedData.max_timestamp ||
        data.max_timestamp_data.NAMA_GENG !== storedData.NAMA_GENG ||
        data.max_timestamp_data.BIB_NUMBER !== storedData.BIB_NUMBER)) {
        
        // Update data terbaru di sessionStorage
        sessionStorage.setItem('lastData', JSON.stringify(data.max_timestamp_data));

        // Memastikan tidak menampilkan SweetAlert pada inisialisasi pertama kali
        if (storedData && storedData.max_timestamp) {
            playAudio();

            // Tampilkan notifikasi menggunakan SweetAlert2
            Swal.fire({
                title: data.max_timestamp_data.NAMA_GENG + '\n' + data.max_timestamp_data.BIB_NUMBER,
                html: `Telah Check In<br>Timestamp: ${data.max_timestamp_data.max_timestamp}`,
                icon: 'info',
                showConfirmButton: false, // Tidak ada tombol konfirmasi
                timer: 10000, // Durasi notifikasi 10 detik
                timerProgressBar: true, // Tampilkan progress bar
            });
        }
        // Call the fetchData function to initiate the data fetching and table population
        fetchData();
    }
    // Simpan data terbaru di sessionStorage
    // sessionStorage.setItem('lastData', JSON.stringify(data.max_timestamp_data));
    };

    eventSource.onerror = function(event) {
        console.error('Error dengan SSE:', event);
    };

    // Function to play audio
    function playAudio() {
        audio.play().catch(function(error) {
            console.error('Error playing audio:', error);
        });
    }
});

// Function to update current time
function updateCurrentTime() {
    var currentTimeElement = document.getElementById('current-time');
    var currentTime = new Date().toLocaleTimeString();
    currentTimeElement.textContent = currentTime;
}

// Update current time initially
updateCurrentTime();

// Update current time every second (1000 milliseconds)
setInterval(updateCurrentTime, 1000);

// // Function to populate the table with checked data
// function populateCheckinTable(data) {
//     const tableBody = document.getElementById('checkin-table-body');
//     tableBody.innerHTML = ''; // Clear existing rows

//     // Limit the number of rows to display to 5
//     const rowsToShow = data.slice(0, 6);

//     rowsToShow.forEach(entry => {
//         const row = document.createElement('tr');

//         // Creating and appending cells for each data point
//         const timestampCell = document.createElement('td');
//         // Split timestamp to separate date and time, then take time part
//         const timePart = entry.timestamp.split(' ')[1]; // Assuming timestamp format is "YYYY-MM-DD HH:MM:SS"
//         timestampCell.textContent = timePart; // Display only the time part
//         row.appendChild(timestampCell);

//         const gengCell = document.createElement('td');
//         gengCell.textContent = entry.NAMA_GENG;
//         row.appendChild(gengCell);

//         const bibCell = document.createElement('td');
//         bibCell.textContent = entry.BIB_NUMBER;
//         row.appendChild(bibCell);

//         // Append the row to the table body
//         tableBody.appendChild(row);
//     });
// }

// // AJAX request to fetch data from fetch_data.php
// function fetchData() {
//     var xhr = new XMLHttpRequest();
//     xhr.open('GET', '../api/checked_data.php', true);
//     xhr.onreadystatechange = function () {
//         if (xhr.readyState === 4 && xhr.status === 200) {
//             var data = JSON.parse(xhr.responseText);
//             populateCheckinTable(data);
//         }
//     };
//     xhr.send();
// }

// // Call the fetchData function to initiate the data fetching and table population
// fetchData();

// let data = []; // Variabel untuk menyimpan data dari server

// // Function to populate the table with checked data
// function populateCheckinTable(data) {
//     const tableBody = document.getElementById('checkin-table-body');
//     tableBody.innerHTML = ''; // Clear existing rows

//         // Limit the number of rows to display to 5
//     const rowsToShow = data.slice(0, 6);

//     rowsToShow.forEach(entry => {
//         const row = document.createElement('tr');

//         // Creating and appending cells for each data point
//         const timestampCell = document.createElement('td');
//         const timePart = entry.timestamp.split(' ')[1]; // Assuming timestamp format is "YYYY-MM-DD HH:MM:SS"
//         timestampCell.textContent = timePart; // Display only the time part
//         row.appendChild(timestampCell);

//         const gengCell = document.createElement('td');
//         gengCell.textContent = entry.NAMA_GENG;
//         row.appendChild(gengCell);

//         const bibCell = document.createElement('td');
//         bibCell.textContent = entry.BIB_NUMBER;
//         row.appendChild(bibCell);

//         // Append the row to the table body
//         tableBody.appendChild(row);
//     });
// }

// // Function to fetch data from server
// function fetchData() {
//     var xhr = new XMLHttpRequest();
//     xhr.open('GET', '../api/checked_data.php', true); // Adjust URL based on your server endpoint
//     xhr.onreadystatechange = function () {
//         if (xhr.readyState === 4 && xhr.status === 200) {
//             data = JSON.parse(xhr.responseText); // Update global variable 'data' with fetched data
//             populateCheckinTable(data); // Populate the table with fetched data
//         }
//     };
//     xhr.send();
// }

// // Call fetchData function to initiate data fetching and table population
// fetchData();

// let startIndex = 0; // Indeks dari baris pertama yang akan ditampilkan
// const rowsToShowCount = 6; // Jumlah baris yang akan ditampilkan setiap kali pembaruan

// // Fungsi untuk memperbarui tabel dengan baris dari startIndex hingga endIndex
// function updateTable() {
//     const tableBody = document.getElementById('checkin-table-body');
//     tableBody.innerHTML = ''; // Kosongkan tabel sebelum memasukkan baris baru

//     const endIndex = startIndex + rowsToShowCount - 1;
//     const rowsToShow = data.slice(startIndex, endIndex + 1);

//     rowsToShow.forEach(entry => {
//         const row = document.createElement('tr');

//         // Membuat dan menambahkan sel untuk setiap data
//         const timestampCell = document.createElement('td');
//         const timePart = entry.timestamp.split(' ')[1]; // Mengasumsikan format timestamp "YYYY-MM-DD HH:MM:SS"
//         timestampCell.textContent = timePart; // Menampilkan bagian waktu saja
//         row.appendChild(timestampCell);

//         const gengCell = document.createElement('td');
//         gengCell.textContent = entry.NAMA_GENG;
//         row.appendChild(gengCell);

//         const bibCell = document.createElement('td');
//         bibCell.textContent = entry.BIB_NUMBER;
//         row.appendChild(bibCell);

//         // Menambahkan baris ke dalam badan tabel
//         tableBody.appendChild(row);
//     });

//     // Menggeser indeks untuk baris pertama yang akan ditampilkan berikutnya
//     startIndex += rowsToShowCount;
//     if (startIndex >= data.length) {
//         startIndex = 0; // Kembali ke awal jika sudah mencapai akhir data
//     }
// }

// // Panggil fungsi updateTable untuk pertama kali
// updateTable();


// // Panggil updateTable setiap 5 detik
// setInterval(updateTable, 1000); // 5000 milliseconds = 5 detik


let data = []; // Variabel untuk menyimpan data dari server

// Function to populate the table with checked data
function populateCheckinTable(data) {
    const tableBody = document.getElementById('checkin-table-body');
    tableBody.innerHTML = ''; // Clear existing rows

    const rowsToShow = data.slice(startIndex, startIndex + rowsToShowCount);

    rowsToShow.forEach(entry => {
        const row = document.createElement('tr');

        // Creating and appending cells for each data point
        const timestampCell = document.createElement('td');
        const timePart = entry.timestamp.split(' ')[1]; // Assuming timestamp format is "YYYY-MM-DD HH:MM:SS"
        timestampCell.textContent = timePart; // Display only the time part
        row.appendChild(timestampCell);

        const gengCell = document.createElement('td');
        gengCell.textContent = entry.NAMA_GENG;
        row.appendChild(gengCell);

        const bibCell = document.createElement('td');
        bibCell.textContent = entry.BIB_NUMBER;
        row.appendChild(bibCell);

        // Append the row to the table body
        tableBody.appendChild(row);
    });
}

// Function to fetch data from server and update table
function updateTable() {
    fetchData(); // Fetch updated data from server

    const tableBody = document.getElementById('checkin-table-body');
    tableBody.innerHTML = ''; // Clear existing rows

    const rowsToShow = data.slice(startIndex, startIndex + rowsToShowCount);

    rowsToShow.forEach(entry => {
        const row = document.createElement('tr');

        // Creating and appending cells for each data point
        const timestampCell = document.createElement('td');
        const timePart = entry.timestamp.split(' ')[1]; // Assuming timestamp format is "YYYY-MM-DD HH:MM:SS"
        timestampCell.textContent = timePart; // Display only the time part
        row.appendChild(timestampCell);

        const gengCell = document.createElement('td');
        gengCell.textContent = entry.NAMA_GENG;
        row.appendChild(gengCell);

        const bibCell = document.createElement('td');
        bibCell.textContent = entry.BIB_NUMBER;
        row.appendChild(bibCell);

        // Append the row to the table body
        tableBody.appendChild(row);

        // Add 'added' class to apply transition effect
        row.classList.add('added');

        // Append the row to the table body
        tableBody.appendChild(row);

        // Remove 'added' class after transition completes
        setTimeout(() => {
            row.classList.remove('added');
        }, 300); // Adjust timing to match transition duration (0.3s)
    });

    // Move startIndex to the next set of rows
    startIndex += rowsToShowCount;
    if (startIndex >= data.length) {
        startIndex = 0; // Reset startIndex if end of data is reached
    }
}

// Function to fetch data from server
function fetchData() {
    var xhr = new XMLHttpRequest();
    xhr.open('GET', '../api/checked_data.php', true); // Adjust URL based on your server endpoint
    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4 && xhr.status === 200) {
            data = JSON.parse(xhr.responseText); // Update global variable 'data' with fetched data
            populateCheckinTable(data); // Populate the table with fetched data
        }
    };
    xhr.send();
}

// Call fetchData function to initiate data fetching and table population
fetchData();

let startIndex = 0; // Index of the first row to display
const rowsToShowCount = 6; // Number of rows to display each time

// Call updateTable function initially
updateTable();

// Call updateTable every 5 seconds
setInterval(updateTable, 5000); // 5000 milliseconds = 5 seconds