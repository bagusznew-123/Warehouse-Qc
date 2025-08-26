<?php

session_start();
if (!isset($_SESSION['username'])) {
    header("Location: ../Login%20Warehouse/index.php");
    exit;
}



// Aktifkan debug
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Koneksi Database
$koneksi = mysqli_connect("localhost", "root", "", "dbcrud2025");
if (!$koneksi) {
    die("Koneksi gagal: " . mysqli_connect_error());
}

// Variabel form
$vTanggal = $vSerial = $vRedamanModem = $vRedamanOPM = $vSelisih = $vSettingan = $vValidator = "";
$id_edit = "";
$mode_edit = false;

// === Simpan / Update ===
if (isset($_POST['bsimpan'])) {
    $selisih = round($_POST['tredamanmodem'] - $_POST['tredamanopm'], 2);

    if (isset($_GET['hal']) && $_GET['hal'] == "edit") {
        // Update
        $ubah = mysqli_query($koneksi, "UPDATE tbarang SET
                                        Tanggal='$_POST[ttanggal]',
                                        SerialModem='$_POST[tserial]',
                                        RedamanModem='$_POST[tredamanmodem]',
                                        RedamanOPM='$_POST[tredamanopm]',
                                        SelisihRedaman='$selisih',
                                        Settingan='$_POST[tsettingan]',
                                        Validator='$_POST[tvalidator]'
                                        WHERE id_barang='$_GET[id]' ");
        if ($ubah) {
            echo "<script>alert('Data berhasil diubah!');document.location='indexmenu.php';</script>";
        }
    } else {
        // Insert
        $simpan = mysqli_query($koneksi, "INSERT INTO tbarang 
            (Tanggal, SerialModem, RedamanModem, RedamanOPM, SelisihRedaman, Settingan, Validator)
            VALUES (
                '$_POST[ttanggal]',
                '$_POST[tserial]',
                '$_POST[tredamanmodem]',
                '$_POST[tredamanopm]',
                '$selisih',
                '$_POST[tsettingan]',
                '$_POST[tvalidator]'
            )");

        if ($simpan) {
            // Kirim ke Spreadsheet via SheetDB
            $url = "https://sheetdb.io/api/v1/ft4yy9kguasfx";
            $data = array(
                "data" => array(
                    array(
                        "Tanggal"       => $_POST['ttanggal'],
                        "Serial"        => $_POST['tserial'],
                        "RedamanModem"  => $_POST['tredamanmodem'],
                        "RedamanOPM"    => $_POST['tredamanopm'],
                        "Selisih"       => $selisih,
                        "Settingan"     => $_POST['tsettingan'],
                        "Validator"     => $_POST['tvalidator']
                    )
                )
            );

            $options = array(
                'http' => array(
                    'header'  => "Content-type: application/json\r\n",
                    'method'  => 'POST',
                    'content' => json_encode($data),
                ),
            );

            $context  = stream_context_create($options);
            $result = @file_get_contents($url, false, $context);

            if ($result === FALSE) {
                echo "<script>alert('Data masuk DB, tapi gagal sync ke Spreadsheet');document.location='index.php';</script>";
            } else {
                echo "<script>alert('Input sukses. Cek data');document.location='index.php';</script>";
            }
        }
    }
}

// === Edit ===
if (isset($_GET['hal']) && $_GET['hal'] == "edit") {
    $tampil = mysqli_query($koneksi, "SELECT * FROM tbarang WHERE id_barang='$_GET[id]' ");
    $data = mysqli_fetch_array($tampil);
    if ($data) {
        $vTanggal      = $data['Tanggal'];
        $vSerial       = $data['SerialModem'];
        $vRedamanModem = $data['RedamanModem'];
        $vRedamanOPM   = $data['RedamanOPM'];
        $vSelisih      = $data['SelisihRedaman'];
        $vSettingan    = $data['Settingan'];
        $vValidator    = $data['Validator'];
        $id_edit       = $data['id_barang'];
        $mode_edit     = true;
    }
}

// === Hapus ===
if (isset($_GET['hal']) && $_GET['hal'] == "hapus") {
    $hapus = mysqli_query($koneksi, "DELETE FROM tbarang WHERE id_barang='$_GET[id]' ");
    if ($hapus) {
        echo "<script>alert('Data berhasil dihapus!');document.location='GriyaNet.php';</script>";
    }
}
?>

<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Warehouse Modem</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background: url('logo.png') no-repeat center center fixed;
      background-size: 700px;
      background-position: center 280px;
    }
    .form-box {
      max-width: 300px;   /* Form lebih pendek */
      background-color: rgba(255, 255, 255, 0.85); /* transparan putih */
    }
    .card {
      background-color: rgba(255, 255, 255, 0.7); /* tabel transparan */
    }
    .left-col {
      flex: 0 0 auto;
      margin-right: 20px;
    }
    .right-col {
      flex: 1;
    }
  </style>
</head>
<body>



<div class="container-fluid py-4">
  <h3 class="text-center mb-4">Welcome Tim QC</h3>

  <div class="d-flex">
    <!-- Form di kiri -->
    <div class="left-col">
      <form method="post" id="formInput" class="p-3 rounded shadow-sm form-box">
        <div class="mb-2">
          <label>Tanggal</label>
          <input type="date" name="ttanggal" 
                 value="<?= $vTanggal ?: date('Y-m-d') ?>" 
                 class="form-control" required>
        </div>
        <div class="mb-2">
          <label>Serial Modem</label>
          <input type="text" name="tserial" value="<?= $vSerial ?>" class="form-control" required>
        </div>
        <div class="mb-2">
          <label>Redaman Modem</label>
          <input type="number" step="0.01" name="tredamanmodem" value="<?= $vRedamanModem ?>" class="form-control" required>
        </div>
        <div class="mb-2">
          <label>Redaman OPM</label>
          <input type="number" step="0.01" name="tredamanopm" value="<?= $vRedamanOPM ?>" class="form-control" required>
        </div>
        <div class="mb-2">
          <label>Settingan</label>
          <input type="text" name="tsettingan" value="<?= $vSettingan ?>" class="form-control">
        </div>
        <div class="mb-2">
          <label>Validator</label>
          <input type="text" name="tvalidator" value="<?= $vValidator ?>" class="form-control">
        </div>
        <div class="mt-3 d-grid gap-2">
          <button type="submit" class="btn btn-success" name="bsimpan">Simpan</button>
          <button type="button" class="btn btn-secondary" onclick="resetForm()">Batalkan</button>
          <a href="indexmenu.php" class="btn btn-danger">Kembali</a>
        </div>
      </form>
    </div>

    <!-- Tabel database di kanan, full lebar -->
    <div class="right-col">
      <div class="card">
        <div class="card-header bg-secondary text-white">Data Tersimpan</div>
        <div class="card-body table-responsive">
          <table class="table table-bordered table-striped table-sm">
            <tr class="text-center">
              <th>No</th>
              <th>Tanggal</th>
              <th>Serial</th>
              <th>Redaman Modem</th>
              <th>Redaman OPM</th>
              <th>Selisih</th>
              <th>Settingan</th>
              <th>Validator</th>
              <th>Aksi</th>
            </tr>
            <?php
            $no = 1;
            $tampil = mysqli_query($koneksi, "SELECT * FROM tbarang ORDER BY id_barang DESC");
            while ($data = mysqli_fetch_array($tampil)) :
            ?>
            <tr>
              <td><?= $no++ ?></td>
              <td><?= $data['Tanggal'] ?></td>
              <td><?= $data['SerialModem'] ?></td>
              <td><?= $data['RedamanModem'] ?></td>
              <td><?= $data['RedamanOPM'] ?></td>
              <td><?= $data['SelisihRedaman'] ?></td>
              <td><?= $data['Settingan'] ?></td>
              <td><?= $data['Validator'] ?></td>
              <td class="text-center">
                <a href="index.php?hal=edit&id=<?= $data['id_barang'] ?>" class="btn btn-warning btn-sm">Edit</a>
                <a href="index.php?hal=hapus&id=<?= $data['id_barang'] ?>" 
                   onclick="return confirm('Yakin mau hapus?')" 
                   class="btn btn-danger btn-sm">Hapus</a>
              </td>
            </tr>
            <?php endwhile; ?>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>

<script>
function resetForm() {
  <?php if ($mode_edit): ?>
    window.location.href = "index.php";
  <?php else: ?>
    document.getElementById("formInput").reset();
  <?php endif; ?>
}
</script>

</body>
</html>
