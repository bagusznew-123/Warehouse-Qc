<?php
session_start();
if(!isset($_SESSION['username'])){
    header("Location: ../Login Warehouse/index.php");
    exit();
}

// Ambil username dari session
$user = $_SESSION['username'];

// Mapping username ke sapaan
$welcome_text = "Selamat Datang Warehouse"; // default
if ($user == "222") {
    $welcome_text = "Selamat Datang Mas Bagus";
} elseif ($user == "333") {
    $welcome_text = "Selamat Datang Mas Dion";
} elseif ($user == "444") {
    $welcome_text = "Selamat Datang Magang Warehouse";
} elseif($user == "111"){
    $welcome_text = "Selamat datang Mas Ryann";
}
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Dashboard Modem</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
  <style>
    body { font-family: Arial, sans-serif; }
    .sidebar {
      height: 100vh;
      background-color: #2c3e50;
      padding-top: 20px;
      color: #fff;
    }
    .sidebar h4 { text-align: center; margin-bottom: 30px; }
    .sidebar a {
      color: #fff;
      text-decoration: none;
      display: block;
      padding: 10px 15px;
      margin: 5px 0;
      border-radius: 8px;
    }
    .sidebar a:hover { background-color: #34495e; }
    .content { padding: 20px; }
  </style>
</head>
<body>
<div class="container-fluid">
  <div class="row">
    <!-- Sidebar -->
    <div class="col-md-2 sidebar">
      <h4><img src="Logo.png" width="120"></h4>
      <a href="GriyaNet.php"><i class="bi bi-hdd-network"></i> QC Modem GriyaNet</a>
      <a href="Dasarata.php"><i class="bi bi-hdd-rack"></i> QC Modem Dasarata</a>
      <hr style="border-color: #7f8c8d;">
      <a href="logout.php"><i class="bi bi-box-arrow-right"></i> Logout</a>
    </div>

    <!-- Main Content -->
    <div class="col-md-10 content">
      <h3><?php echo $welcome_text; ?></h3>
      <p>Pilih Settingan Untuk QC</p>
    </div>
  </div>
</div>
</body>
</html>
