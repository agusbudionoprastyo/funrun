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

	<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.3.2/html2canvas.min.js"></script>

    <!-- sweetalert2 -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

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
            <li>
                <a href="index.php">
                    <i class='bx bxs-dashboard' ></i>
                    <span class="text">Dashboard</span>
                </a>
            </li>
            <li class="active">
            <a href="#">
                    <i class='bx bxs-group' ></i>
                    <span class="text">Daftar Peserta</span>
                </a>
            </li>
        </ul>
        <!-- <ul class="side-menu">
			<li>
				<a href="#">
					<i class='bx bxs-cog' ></i>
					<span class="text">Settings</span>
				</a>
			</li>
			<li>
				<a href="#" class="logout">
					<i class='bx bxs-log-out-circle' ></i>
					<span class="text">Logout</span>
				</a>
			</li>
		</ul> -->
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
            <!-- <label for="switch-mode" class="switch-mode"></label> -->
        </nav>
        <!-- NAVBAR -->

        <!-- MAIN -->
        <main>
            <div class="head-title">
                <div class="left">
                    <h1>Fun Run - Lari Antar Geng</h1>
                    <ul class="breadcrumb">
                        <li>
                            <a href="#">Daftar Peserta</a>
                        </li>
                        <li><i class='bx bx-chevron-right' ></i></li>
                        <li>
                            <a class="active" href="index.php">Home</a>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="table-data">
                <div class="order">
                    <div class="head">
                        <h3>Daftar Peserta</h3>
						<button type="button" id="printSelectedBtn" class="btn-download">
							<i class='bx bxs-printer' style="font-size:24px"></i>
						</button>
                    </div>
                    <table id="example" class="display" style="width:100%">
                            <thead>
                                <tr>
                                    <th style="text-align: left;">
                                        Nama Geng
                                    </th>
                                    <th style="text-align: center;">
										Nomor BIB
									</th>
                                    <th style="text-align: center;">
                                    <input type="checkbox" id="selectAllCheckbox" style="display:none">
										<label for="selectAllCheckbox"  style="font-size:24px"><i class='bx bx-check-double'></i></label>
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
							<?php while($row = $result_data->fetch_assoc()): ?>
                            <tr>
                                <td>
                                    <?php echo $row["NAMA_GENG"]; ?>
                                </td>
                                <td>
									<?php echo $row["BIB_NUMBER"]; ?>
								</td>
                                <td>
                                    <input type="checkbox" class="print-checkbox">    
                                </td>
                            </tr>
                        	<?php endwhile; ?>
                            </tbody>
                    </table>
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
	<script src="qrcode.min.js"></script>

</body>
</html>