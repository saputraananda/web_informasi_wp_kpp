<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Wajib Pajak</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- DataTables CSS -->
    <link href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2 class="mb-4">Daftar Wajib Pajak</h2>
        <table id="wajibPajakTable" class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Wajib Pajak</th>
                    <th>NPWP</th>
                    <th>Kecamatan</th>
                    <th>Kelurahan</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php
                include 'koneksi.php';

                $sql = "SELECT id, nama, npwp, kecamatan, kelurahan FROM wajib_pajak";
                $result = $conn->query($sql);

                if ($result === FALSE) {
                    echo "<tr><td colspan='5'>Error: " . $conn->error . "</td></tr>";
                } else {
                    if ($result->num_rows > 0) {
                        $no = 1;
                        while($row = $result->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td>" . $no++ . "</td>";
                            echo "<td>" . $row["nama"] . "</td>";
                            echo "<td>" . $row["npwp"] . "</td>";
                            echo "<td>" . $row["kecamatan"] . "</td>";
                            echo "<td>" . $row["kelurahan"] . "</td>";
                            echo "<td class='action-icons'> <center>
                                    <a href='lihat.php?id=".$row["id"]."' class='btn btn-warning btn-sm'>Lihat</a>
                                    <a href='print.php?id=".$row["id"]."' class='btn btn-primary btn-sm'>Print</a>
                                    <a href='delete.php?id=".$row["id"]."' class='btn btn-danger btn-sm'>Hapus</a>
                                    <a href='complete.php?id=".$row["id"]."' class='btn btn-success btn-sm'>Selesai</a> </center>
                                  </td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='4'>No results found</td></tr>";
                    }
                }
                $conn->close();
                ?>
            </tbody>
        </table>
    </div>

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <!-- Initialize DataTables -->
    <script>
        $(document).ready(function() {
            $('#wajibPajakTable').DataTable();
        });
    </script>
</body>
</html>
