<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lihat Wajib Pajak</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- DataTables CSS -->
    <link href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css" rel="stylesheet">
    <style>
        th {
            text-align: center;
        }

        .judul {
            text-align: center;
        }

        .dataTables_paginate,.dataTables_info {
            display: none;
        }

        div.tabelwajibpajak_length{
            display: none;
        }
    </style>
</head>
<body>
    <!-- JUDUL DARI HALAMAN -->
    <div class="container mt-5 mb-3">
        <h2 class="judul"><b>DATA DAN INFORMASI YANG DIPRODUKSI</b></h2>
    </div>

    <!-- DATA KENDARAAN WAJIB PAJAK -->
    <div class="container mt-0  mb-5">
        <?php
        include 'koneksi.php';

        // Ambil ID dari URL
        $id = $_GET['id'];

        // Ambil detail wajib pajak
        $sql = "SELECT nama, npwp, kelurahan FROM wajib_pajak WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $taxpayer = $result->fetch_assoc();

        // Tampilkan detail wajib pajak
        echo "<h6 class='subjudul mb-4'>Nama : " . htmlspecialchars($taxpayer['nama']) . "</h6>";
        echo "<h6 class='subjudul mb-4'>NPWP : " . htmlspecialchars($taxpayer['npwp']) . "</h6>";
        echo "<h6 class='subjudul mb-4'>Kelurahan : " . htmlspecialchars($taxpayer['kelurahan']) . "</h6>";
        echo "<h4 class='pointsubjudul mb-3'><b>1. Daftar Harta dan Kekayaan Wajib</b></h4>";
        echo "<h5 class='subjudul mb-4'>A. Kendaraan</h5>";

        // Ambil data kendaraan
        $sql = "SELECT jenis_kendaraan, no_stnk, nilai_perolehan, tahun_pembuatan, keterangan FROM kendaraan WHERE npwp = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $taxpayer['npwp']);
        $stmt->execute();
        $result = $stmt->get_result();

        echo '<table id="tabelwajibpajak" class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Jenis Kendaraan</th>
                        <th>No.STNK</th>
                        <th>Nilai Perolehan</th>
                        <th>Tahun Pembuatan</th>
                        <th>Keterangan/Sumber Data</th>
                    </tr>
                </thead>
                <tbody>';
                
        if ($result->num_rows > 0) {
            $no = 1;
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $no++ . "</td>";
                echo "<td>" . htmlspecialchars($row["jenis_kendaraan"]) . "</td>";
                echo "<td>" . htmlspecialchars($row["no_stnk"]) . "</td>";
                echo "<td>" . htmlspecialchars($row["nilai_perolehan"]) . "</td>";
                echo "<td>" . htmlspecialchars($row["tahun_pembuatan"]) . "</td>";
                echo "<td>" . htmlspecialchars($row["keterangan"]) . "</td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='6'>Tidak ada hasil yang ditemukan</td></tr>";
        }

        echo '</tbody></table>';

        $conn->close();
        ?>
    </div>
    <!-- DATA KENDARAAN SELESAI -->
    
    <!-- DATA REKENING WAJIB PAJAK -->
    <div class="rekening container mt-5 mb-5">
        <h5 class='subjudul mt-4 mb-4'>B. Rekening Koran/Deposito/Tabungan</h5>
        <?php
        // Ambil data rekening koran/deposito/tabungan
        include 'koneksi.php';

        // Ambil data kendaraan
        $sql = "SELECT nama_bank, nomor_rekening, alamat_bank,nilai_nominal,keterangan FROM rekening WHERE npwp = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $taxpayer['npwp']);
        $stmt->execute();
        $result = $stmt->get_result();

        echo '<table id="tabelrekening" class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Bank</th>
                        <th>Nomor Rekening</th>
                        <th>Nama dan Alamat Bank</th>
                        <th>Nilai Nominal (Rp)</th>
                        <th>Keterangan/Sumber Data</th>
                    </tr>
                </thead>
                <tbody>';
                
        if ($result->num_rows > 0) {
            $no = 1;
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $no++ . "</td>";
                echo "<td>" . htmlspecialchars($row["nama_bank"]) . "</td>";
                echo "<td>" . htmlspecialchars($row["nomor_rekening"]) . "</td>";
                echo "<td>" . htmlspecialchars($row["alamat_bank"]) . "</td>";
                echo "<td>" . htmlspecialchars($row["nilai_nominal"]) . "</td>";
                echo "<td>" . htmlspecialchars($row["keterangan"]) . "</td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='6'>Tidak ada hasil yang ditemukan</td></tr>";
        }

        echo '</tbody></table>';

        $conn->close();
        ?>
    </div>
    <!-- DATA REKENING SELESAI -->
    
    <!-- DATA KEPEMILIKAN TANAH DAN BANGUNAN WAJIB PAJAK -->
    <div class="tanah container mt-5 mb-5">
        <h5 class='subjudul mt-4 mb-4'>C. Tanah dan/atau Bangunan </h5>
        <?php
        // Ambil data rekening koran/deposito/tabungan
        include 'koneksi.php';

        // Ambil data kendaraan
        $sql = "SELECT * FROM tanah WHERE npwp = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $taxpayer['npwp']);
        $stmt->execute();
        $result = $stmt->get_result();

        echo '<table id="tabeltanah" class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Jenis</th>
                        <th>Alamat Lokasi</th>
                        <th>Bukti Kepemilikan</th>
                        <th>Nilai NJOP</th>
                        <th>Keterangan/Sumber Data</th>
                    </tr>
                </thead>
                <tbody>';
                
        if ($result->num_rows > 0) {
            $no = 1;
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $no++ . "</td>";
                echo "<td>" . htmlspecialchars($row["jenis"]) . "</td>";
                echo "<td>" . htmlspecialchars($row["alamat_lokasi"]) . "</td>";
                echo "<td>" . htmlspecialchars($row["bukti_kepemilikan"]) . "</td>";
                echo "<td>" . htmlspecialchars($row["nilai_njop"]) . "</td>";
                echo "<td>" . htmlspecialchars($row["keterangan"]) . "</td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='6'>Tidak ada hasil yang ditemukan</td></tr>";
        }

        echo '</tbody></table>';

        $conn->close();
        ?>
    </div>

    <!-- DATA YANG BELUM ATAU KURANG DIUNGKAP -->
    <div class="hartappajak container mt-5 mb-5">
        <h4 class='pointsubjudul mb-3'><b>2. Harta Yang Belum atau Kurang diungkap / dilaporkan</b></h4>
        <h5 class='subjudul mt-4 mb-4'>A. Harta Yang Belum atau Kurang Diungkapkan Dalam Surat Pernyataan (Dalam Hal Wajib Pajak Mengikuti Pengampunan Pajak)</h5>
        
        <?php
        // Ambil data rekening koran/deposito/tabungan
        include 'koneksi.php';

        // Ambil data kendaraan
        $sql = "SELECT * FROM harta_p_pajak WHERE npwp = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $taxpayer['npwp']);
        $stmt->execute();
        $result = $stmt->get_result();

        echo '<table id="tabelhartappajak" class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Jenis Harta</th>
                        <th>Bukti Kepemilikan</th>
                        <th>Atas Nama</th>
                        <th>Lokasi</th>
                        <th>Nilai Harta</th>
                        <th>Keterangan</th>
                    </tr>
                </thead>
                <tbody>';
                
        if ($result->num_rows > 0) {
            $no = 1;
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $no++ . "</td>";
                echo "<td>" . htmlspecialchars($row["jenis_harta_p_pajak"]) . "</td>";
                echo "<td>" . htmlspecialchars($row["bukti_kepemilikan_p_pajak"]) . "</td>";
                echo "<td>" . htmlspecialchars($row["atas_nama"]) . "</td>";
                echo "<td>" . htmlspecialchars($row["lokasi"]) . "</td>";
                echo "<td>" . htmlspecialchars($row["nilai_harta"]) . "</td>";
                echo "<td>" . htmlspecialchars($row["keterangan"]) . "</td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='7'>Tidak ada hasil yang ditemukan</td></tr>";
        }

        echo '</tbody></table>';

        $conn->close();
        ?>
    </div>

    <!-- DATA YANG BELUM DILAPORKAN -->
    <div class="hartatpajak container mt-5 mb-5">
        <h5 class='subjudul mt-4 mb-4'>A. Harta Yang Belum Dilaporkan Dalam Surat Pemberitahuan Tahunan Pajak Penghasilan (Dalam Hal Wajib Pajak Tidak Mengikuti Pengampunan Pajak)</h5>
        
        <?php
        // Ambil data rekening koran/deposito/tabungan
        include 'koneksi.php';

        // Ambil data kendaraan
        $sql = "SELECT * FROM harta_t_pajak WHERE npwp = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $taxpayer['npwp']);
        $stmt->execute();
        $result = $stmt->get_result();

        echo '<table id="tabelhartatpajak" class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Jenis Harta</th>
                        <th>Tahun Perolehan</th>
                        <th>Bukti Kepemilikan</th>
                        <th>Atas Nama</th>
                        <th>Lokasi</th>
                        <th>Nilai Harta</th>
                        <th>Keterangan</th>
                    </tr>
                </thead>
                <tbody>';
                
        if ($result->num_rows > 0) {
            $no = 1;
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $no++ . "</td>";
                echo "<td>" . htmlspecialchars($row["jenis_harta_t_pajak"]) . "</td>";
                echo "<td>" . htmlspecialchars($row["tahun_perolehan"]) . "</td>";
                echo "<td>" . htmlspecialchars($row["bukti_kepemilikan_t_pajak"]) . "</td>";
                echo "<td>" . htmlspecialchars($row["atas_nama"]) . "</td>";
                echo "<td>" . htmlspecialchars($row["lokasi"]) . "</td>";
                echo "<td>" . htmlspecialchars($row["nilai_harta"]) . "</td>";
                echo "<td>" . htmlspecialchars($row["keterangan"]) . "</td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='8'>Tidak ada hasil yang ditemukan</td></tr>";
        }

        echo '</tbody></table>';

        $conn->close();
        ?>
    </div>


    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <!-- Inisialisasi DataTables -->
    <script>
        $(document).ready(function() {
            $('#tabelwajibpajak').DataTable();
            $('#tabelrekening').DataTable();
            $('#tabeltanah').DataTable();
            $('#tabelhartappajak').DataTable();
            $('#tabelhartatpajak').DataTable();
        });
    </script>   
</body>
</html>
