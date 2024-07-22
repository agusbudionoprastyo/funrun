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

        // Update statistik
        document.getElementById('totalPeserta').innerText = data.total_peserta;
        document.getElementById('totalCheck').innerText = data.total_check;
        document.getElementById('totalUncheck').innerText = data.total_uncheck;

        // // Bandingkan data lama dengan data baru untuk menampilkan notifikasi
        // const storedData = JSON.parse(sessionStorage.getItem('lastData')) || {
        //     total_peserta: 0,
        //     total_check: 0,
        //     total_uncheck: 0
        // };

        // if (data.total_peserta !== storedData.total_peserta ||
        //     data.total_check !== storedData.total_check ||
        //     data.total_uncheck !== storedData.total_uncheck) {
        //     playAudio();

        //     // Tampilkan notifikasi menggunakan SweetAlert2
        //     Swal.fire({
        //         title: 'Fun Run - Lari Antar Geng',
        //         html: `Total Peserta: ${data.total_peserta}<br>Total Check: ${data.total_check}<br>Total Uncheck: ${data.total_uncheck}`,
        //         icon: 'info',
        //         showConfirmButton: false, // Tidak ada tombol konfirmasi
        //         timer: 5000, // Durasi notifikasi 5 detik
        //         timerProgressBar: true, // Tampilkan progress bar
        //         willClose: () => {
        //             // Simpan data terbaru di sessionStorage setelah notifikasi menghilang
        //             sessionStorage.setItem('lastData', JSON.stringify(data));
        //             window.location.reload(); // Reload halaman setelah notifikasi menghilang
        //         }
        //     });
        // }
        // Bandingkan data lama dengan data baru untuk menampilkan notifikasi
        const storedData = JSON.parse(sessionStorage.getItem('lastData')) || {};

        if (data.max_timestamp_data && data.max_timestamp_data.max_timestamp !== storedData.max_timestamp ||
            data.max_timestamp_data.nama_geng !== storedData.nama_geng ||
            data.max_timestamp_data.BIB_NUMBER !== storedData.bib_number) {
            playAudio();
        
            // Tampilkan notifikasi menggunakan SweetAlert2
            Swal.fire({
                title: 'Fun Run - Lari Antar Geng',
                html: `Geng's ${data.max_timestamp_data.nama_geng}<br>BIB Number ${data.max_timestamp_data.BIB_NUMBER} Telah Check In<br>Timestamp: ${data.max_timestamp_data.max_timestamp}`,
                icon: 'info',
                showConfirmButton: false, // Tidak ada tombol konfirmasi
                timer: 5000, // Durasi notifikasi 5 detik
                timerProgressBar: true, // Tampilkan progress bar
                willClose: () => {
                    // Simpan data terbaru di sessionStorage setelah notifikasi menghilang
                    sessionStorage.setItem('lastData', JSON.stringify(data.max_timestamp_data));
                }
            });
        }        
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