document.addEventListener('DOMContentLoaded', function() {
    const eventSource = new EventSource('../api/sse.php');
    const audio = document.getElementById('audio'); // Pastikan audio sudah didefinisikan di halaman HTML

    eventSource.onmessage = function(event) {
        const data = JSON.parse(event.data);

        // Update UI for top 5 fastest check-ins
        var medalList = document.getElementById('medal-list');
				// Contoh penggunaan:
				for (var i = 0; i < 5; i++) {
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

        // // Function to populate the table with checked data
        // function populateCheckinTable(data) {
        //     const tableBody = document.getElementById('checkin-table-body');
        //     tableBody.innerHTML = ''; // Clear existing rows

        //     data.checked_data.forEach(entry => {
        //         const row = document.createElement('tr');

        //         // Creating and appending cells for each data point
        //         const timestampCell = document.createElement('td');
        //         timestampCell.textContent = entry.timestamp;
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

        // // Call the function to populate the table with initial data
        // populateCheckinTable(data);

    // Function to populate the table with checked data
    function populateCheckinTable(data) {
        const tableBody = document.getElementById('checkin-table-body');
        tableBody.innerHTML = ''; // Clear existing rows

        // Limit the number of rows to display to 5
        const rowsToShow = data.checked_data.slice(0, 5);

        rowsToShow.forEach(entry => {
            const row = document.createElement('tr');

            // Creating and appending cells for each data point
            const timestampCell = document.createElement('td');
            timestampCell.textContent = entry.timestamp;
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

    // Call the function to populate the table with initial data
    populateCheckinTable(data);


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
                title: 'Fun Run - Lari Antar Geng',
                html: `Geng's ${data.max_timestamp_data.NAMA_GENG}<br>BIB Number ${data.max_timestamp_data.BIB_NUMBER} Telah Check In<br>Timestamp: ${data.max_timestamp_data.max_timestamp}`,
                icon: 'info',
                showConfirmButton: false, // Tidak ada tombol konfirmasi
                timer: 10000, // Durasi notifikasi 10 detik
                timerProgressBar: true, // Tampilkan progress bar
            });
        }
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