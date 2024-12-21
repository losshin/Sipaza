<?php
if (!isset($_SESSION)) {
  session_start();
  if (!isset($_SESSION['user'])) {
    header('Location: /views/login.php');
    exit();
  }
  require_once 'database/controller.php';
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <title>SiPaZa</title>
  <meta content="width=device-width, initial-scale=1.0, shrink-to-fit=no" name="viewport" />
  <link rel="icon" href="assets/img/favicon.svg" />

  <!-- Fonts and icons -->
  <script src="assets/js/plugin/webfont/webfont.min.js"></script>
  <script>
    WebFont.load({
      google: {
        families: ["Public Sans:300,400,500,600,700"]
      },
      custom: {
        families: [
          "Font Awesome 5 Solid",
          "Font Awesome 5 Regular",
          "Font Awesome 5 Brands",
          "simple-line-icons",
        ],
        urls: ["assets/css/fonts.min.css"],
      },
      active: function() {
        sessionStorage.fonts = true;
      },
    });
  </script>

  <!-- CSS Files -->
  <link rel="stylesheet" href="assets/css/bootstrap.min.css" />
  <link rel="stylesheet" href="assets/css/plugins.min.css" />
  <link rel="stylesheet" href="assets/css/kaiadmin.min.css" />

</head>

<body>
  <div class="wrapper">
    <!-- Sidebar -->
    <div class="sidebar" data-background-color="dark">
      <div class="sidebar-logo">
        <!-- Logo Header -->
        <div class="logo-header" data-background-color="dark">
          <a href="index.php" class="logo">
            <img src="assets/img/logo_light.png" alt="navbar brand" class="navbar-brand" height="25" />
          </a>
          <div class="nav-toggle">
            <button class="btn btn-toggle toggle-sidebar">
              <i class="gg-menu-right"></i>
            </button>
            <button class="btn btn-toggle sidenav-toggler">
              <i class="gg-menu-left"></i>
            </button>
          </div>
          <button class="topbar-toggler more">
            <i class="gg-more-vertical-alt"></i>
          </button>
        </div>
        <!-- End Logo Header -->
      </div>
      <div class="sidebar-wrapper scrollbar scrollbar-inner">
        <div class="sidebar-content">
          <ul class="nav nav-secondary">
            <li class="nav-item active">
              <a href="index.php" aria-expanded="false">
                <i class="fas fa-home"></i>
                <p>Dashboard</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="#Account">
                <i class="fas fa-users"></i>
                <p>Accounts</p>
              </a>
            </li>
            <li class="nav-item">
              <a data-bs-toggle="collapse" href="#homeClient">
                <i class="fas fa-layer-group"></i>
                <p>Website</p>
                <span class="caret"></span>
              </a>
              <div class="collapse" id="homeClient">
                <ul class="nav nav-collapse">
                  <li>
                    <a href="#Home">
                      <span class="sub-item">Home</span>
                    </a>
                  </li>
                  <li>
                    <a href="#Menu">
                      <span class="sub-item">Menu</span>
                    </a>
                  </li>
                  <li>
                    <a href="#AboutUs">
                      <span class="sub-item">About Us</span>
                    </a>
                  </li>
                  <li>
                    <a href="#Promotion">
                      <span class="sub-item">Promotion</span>
                    </a>
                  </li>
                </ul>
              </div>
            </li>
          </ul>
        </div>
      </div>
    </div>
    <!-- End Sidebar -->

    <div class="main-panel">
      <div class="main-header">
        <div class="main-header-logo">
          <!-- Logo Header -->
          <div class="logo-header" data-background-color="dark">
            <a href="index.php" class="logo">
              <img src="assets/img/logo_light.svg" alt="navbar brand" class="navbar-brand" height="20" />
            </a>
            <div class="nav-toggle">
              <button class="btn btn-toggle toggle-sidebar">
                <i class="gg-menu-right"></i>
              </button>
              <button class="btn btn-toggle sidenav-toggler">
                <i class="gg-menu-left"></i>
              </button>
            </div>
            <button class="topbar-toggler more">
              <i class="gg-more-vertical-alt"></i>
            </button>
          </div>
          <!-- End Logo Header -->
        </div>
        <!-- Navbar Header -->
        <nav class="navbar navbar-header navbar-header-transparent navbar-expand-lg border-bottom">
          <div class="container-fluid">
            <nav class="navbar navbar-header-left navbar-expand-lg navbar-form nav-search p-0 d-none d-lg-flex">
              <div class="input-group">
                <div class="input-group-prepend">
                  <button type="submit" class="btn btn-search pe-1">
                    <i class="fa fa-search search-icon"></i>
                  </button>
                </div>
                <input type="text" placeholder="Pencarian ..." class="form-control" />
              </div>
            </nav>
            <!-- dropdown-toogle profile -->
            <ul class="navbar-nav topbar-nav ms-md-auto align-items-center">
              <li class="nav-item topbar-user dropdown hidden-caret">
                <a class="dropdown-toggle profile-pic" data-bs-toggle="dropdown" href="#" aria-expanded="false">
                  <div class="avatar-sm">
                    <img src="assets/img/sipaza.jpg" alt="..." class="avatar-img rounded-circle" />
                  </div>
                  <span class="profile-username">
                    <span class="op-7">Hai,</span>
                    <span class="fw-bold">
                      <?php
                      echo $_SESSION['user'];
                      ?>
                    </span>
                  </span>
                </a>
                <ul class="dropdown-menu dropdown-user animated fadeIn">
                  <div class="dropdown-user-scroll scrollbar-outer">
                    <li>
                      <a class="dropdown-item" href="#">My Profile</a>
                      <a class="dropdown-item" href="#">Account Setting</a>
                      <div class="dropdown-divider"></div>
                      <form action="/database/controller.php" method="post">
                        <input type="hidden" name="action" value="logout">
                        <button type="submit" class="btn dropdown-item" id="logout-btn">Logout</button>
                      </form>
                    </li>
                  </div>
                </ul>
              </li>
            </ul>
          </div>
        </nav>
        <!-- End Navbar -->
      </div>

      <div class="container">
        <div class="page-inner">
          <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row pt-2 pb-4">
            <div>
              <h3 class="fw-bold mb-3">Dashboard</h3>
            </div>
            <div class="ms-md-auto py-2 py-md-0">
              <button
                class="btn btn-primary btn-round ms-auto" data-bs-toggle="modal" data-bs-target="#addPeserta">
                <i class="fa fa-plus"></i>
                Tambah Peserta
              </button>
            </div>
          </div>
          <div class="row">
            <div class="col">
              <div class="card card-stats card-round">
                <div class="card-body">
                  <div class="row align-items-center">
                    <div class="col-icon">
                      <div class="icon-big text-center icon-primary bubble-shadow-small">
                        <i class="fas fa-users"></i>
                      </div>
                    </div>
                    <div class="col col-stats ms-3 ms-sm-0">
                      <div class="numbers">
                        <p class="card-category">Peserta</p>
                        <h4 class="card-title">
                          <?php
                          echo countColumnData('peserta');
                          ?>
                        </h4>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col">
              <div class="card card-stats card-round">
                <div class="card-body">
                  <div class="row align-items-center">
                    <div class="col-icon">
                      <div class="icon-big text-center icon-info bubble-shadow-small">
                        <i class="fas fa-user-check"></i>
                      </div>
                    </div>
                    <div class="col col-stats ms-3 ms-sm-0">
                      <div class="numbers">
                        <p class="card-category">Kriteria</p>
                        <h4 class="card-title">
                          <?php
                          echo countColumnData('kriteria');
                          ?>
                        </h4>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="row">
            <!-- Tabel Kriteria -->
            <div class="col-sm-7">
              <div class="card">
                <div class="card-header">
                  <div class="d-flex align-items-center">
                    <h4 class="card-title">Kriteria</h4>
                  </div>
                </div>
                <div class="card-body">
                  <div class="table-responsive">
                    <div id="add-row_wrapper" class="dataTables_wrapper container-fluid dt-bootstrap4">
                      <div class="row">
                        <div class="col-sm-9">
                          <table id="basic" class="display table table-striped table-hover dataTable" role="grid" aria-describedby="add-row_info">
                            <thead>
                              <tr role="row">
                                <th>Kriteria</th>
                                <?php
                                $resultColumns = getData('kriteria', null);
                                if ($resultColumns && mysqli_num_rows($resultColumns) > 0) {
                                  while ($col = mysqli_fetch_assoc($resultColumns)) {
                                    $id = $col['id'];
                                    $nama = $col['nama'];
                                ?>
                                    <th><?php
                                        echo ucwords(str_replace('_', ' ', $nama));
                                        ?></th>
                                <?php
                                  }
                                }
                                ?>
                              </tr>
                            </thead>
                            <tbody>
                              <?php
                              // $result = getData('kriteria', null);
                              // if ($result && mysqli_num_rows($result) > 0) {
                              //   while ($a = mysqli_fetch_array($result)) {
                              //     $id = $a['id'];
                              //     $nama = $a['nama'];

                              //     require 'components/modal.php';
                              ?>
                              <tr role="row" class="odd">
                                <!-- <td><?php
                                          // echo ucwords(str_replace('_', ' ', $nama)); 

                                          // Nilai skala AHP
                                          $RtoR = 1; // Sama
                                          $RtoSE = 3; // Rumah Sedikit Lebih Penting dari Sosial Ekonomi
                                          $RtoT = 5; // Rumah Cukup Penting dari Tanggungan
                                          $SEtoSE = 1; // Sama
                                          $SEtoT = 3; // Sosial Ekonomi Sedikit Lebih penting dari Tanggungan 
                                          $TtoT = 1; // Sama

                                          // Nilai kebalikan skala AHP 
                                          $SEtoR = 1 / $RtoSE;
                                          $TtoR = 1 / $RtoT;
                                          $TtoSE = 1 / $SEtoT;

                                          // Total
                                          $totalR = $RtoR + $SEtoR + $TtoR;
                                          $totalSE = $RtoSE + $SEtoSE + $TtoSE;
                                          $totalT = $RtoT + $SEtoT + $TtoT;

                                          ?></td> -->
                                <!-- <td>
                                      <select id="nilai" name="nilai" type="number" class="form-control" required>
                                        <option value="" disabled selected hidden>--pilih nilai kriteria</option>
                                        <option value="1">1. Sama</option>
                                        <option value="2">2. Sama, namun Sedikit Lebih penting</option>
                                        <option value="3">3. Sedikit Lebih Penting</option>
                                        <option value="4">4. Sedikit Lebih Penting, namun Cukup Penting</option>
                                        <option value="5">5. Cukup Penting</option>
                                        <option value="6">6. Cukup Penting, namun Sangat Penting</option>
                                        <option value="7">7. Sangat Penting</option>
                                        <option value="8">8. Sangat Penting, namun Mutlak Penting</option>
                                        <option value="9">9. Mutlak Penting</option>
                                      </select>
                                    </td>
                                    <td>
                                      <select id="nilai" name="nilai" type="number" class="form-control" required>
                                        <option value="" disabled selected hidden>--pilih nilai kriteria</option>
                                        <option value="1">1. Sama</option>
                                        <option value="2">2. Sama, namun Sedikit Lebih penting</option>
                                        <option value="3">3. Sedikit Lebih Penting</option>
                                        <option value="4">4. Sedikit Lebih Penting, namun Cukup Penting</option>
                                        <option value="5">5. Cukup Penting</option>
                                        <option value="6">6. Cukup Penting, namun Sangat Penting</option>
                                        <option value="7">7. Sangat Penting</option>
                                        <option value="8">8. Sangat Penting, namun Mutlak Penting</option>
                                        <option value="9">9. Mutlak Penting</option>
                                      </select>
                                    </td>
                                    <td>
                                      <select id="nilai" name="nilai" type="number" class="form-control" required>
                                        <option value="" disabled selected hidden>--pilih nilai kriteria</option>
                                        <option value="1">1. Sama</option>
                                        <option value="2">2. Sama, namun Sedikit Lebih penting</option>
                                        <option value="3">3. Sedikit Lebih Penting</option>
                                        <option value="4">4. Sedikit Lebih Penting, namun Cukup Penting</option>
                                        <option value="5">5. Cukup Penting</option>
                                        <option value="6">6. Cukup Penting, namun Sangat Penting</option>
                                        <option value="7">7. Sangat Penting</option>
                                        <option value="8">8. Sangat Penting, namun Mutlak Penting</option>
                                        <option value="9">9. Mutlak Penting</option>
                                      </select>
                                    </td> -->
                                <td>Rumah</td>
                                <td><?php echo $RtoR ?></td>
                                <td><?php echo $RtoSE ?></td>
                                <td><?php echo $RtoT ?></td>
                              </tr>
                              <tr>
                                <td>Sosial Ekonomi</td>
                                <td><?php echo number_format($SEtoR, 2) ?></td>
                                <td><?php echo $SEtoSE ?></td>
                                <td><?php echo $SEtoT ?></td>
                              </tr>
                              <tr>
                                <td>Tanggungan</td>
                                <td><?php echo number_format($TtoR, 2) ?></td>
                                <td><?php echo number_format($TtoSE, 2) ?></td>
                                <td><?php echo $TtoT ?></td>
                              </tr>
                              <?php
                              //   }
                              // } else {
                              //   echo "<p class='text-center'>Tidak ada data kriteria tersedia.</p>";
                              // }
                              ?>
                            </tbody>
                            <tfoot>
                              <tr>
                                <th>Total</th>
                                <th><?php echo number_format($totalR, 2) ?></th>
                                <th><?php echo number_format($totalSE, 2) ?></th>
                                <th><?php echo number_format($totalT, 2) ?></th>
                              </tr>
                            </tfoot>
                          </table>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <!-- End of Tabel Kriteria -->
            </div>
            <!-- Konsistensi Kriteria -->
            <div class="col-md-5">
              <div class="card card-round">
                <div class="card-body">
                  <div class="card-head-row card-tools-still-right">
                    <div class="card-title">Konsistensi Kriteria</div>
                  </div>
                  <div class="table-responsive">
                    <table id="basic" class="display table table-striped table-hover dataTable" role="grid" aria-describedby="add-row_info">
                      <thead>
                        <tr role="row" align="center">
                          <th>CI</th>
                          <th>IR</th>
                          <th>CR</th>
                          <th>Konsisten?</th>
                        </tr>
                      </thead>
                      <tbody align="center">
                        <td><?php echo number_format((3.06 - 3) / (3 - 1), 2) ?></td>
                        <td>0.58</td>
                        <td><?php echo number_format(((3.06 - 3) / (3 - 1)) / 0.58, 2) ?></td>
                        <td><?php
                            if ((((3.06 - 3) / (3 - 1)) / 0.58) <= 0.1) {
                              echo 'Konsisten';
                            } else {
                              echo 'Tidak Konsisten';
                            }
                            ?></td>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>
            <!-- End of Konsistensi Kriteria -->
            <div class="row">
              <!-- Tabel Normalisasi Kriteria -->
              <div class="col-md-12">
                <div class="card">
                  <div class="card-header">
                    <div class="d-flex align-items-center">
                      <h4 class="card-title">Normalisasi Kriteria</h4>
                    </div>
                  </div>
                  <div class="card-body">
                    <div class="table-responsive">
                      <div id="add-row_wrapper" class="dataTables_wrapper container-fluid dt-bootstrap4">
                        <div class="row">
                          <div class="col-sm-12">
                            <table id="basic" class="display table table-striped table-hover dataTable" role="grid" aria-describedby="add-row_info">
                              <thead>
                                <tr role="row">
                                  <th>Kriteria</th>
                                  <?php
                                  $resultColumns = getData('kriteria', null);
                                  if ($resultColumns && mysqli_num_rows($resultColumns) > 0) {
                                    while ($col = mysqli_fetch_assoc($resultColumns)) {
                                      $id = $col['id'];
                                      $nama = $col['nama'];
                                  ?>
                                      <th><?php
                                          echo ucwords(str_replace('_', ' ', $nama));
                                          ?></th>
                                  <?php
                                    }
                                  }
                                  ?>
                                  <th>Jumlah</th>
                                  <th>Rata-rata</th>
                                  <th>Eigen Value</th>
                                </tr>
                              </thead>
                              <tbody>
                                <tr role="row" class="odd">
                                  <?php
                                  // Normalisasi Nilai skala AHP
                                  $normalisasiRtoR = $RtoR / $totalR; // Sama
                                  $normalisasiRtoSE = $RtoSE / $totalSE; // Rumah Sedikit Lebih Penting dari Sosial Ekonomi
                                  $normalisasiRtoT = $RtoT / $totalT; // Rumah Cukup Penting dari Tanggungan
                                  $normalisasiSEtoR = $SEtoR / $totalR; // Sama
                                  $normalisasiSEtoSE = $SEtoSE / $totalSE; // Sama
                                  $normalisasiSEtoT = $SEtoT / $totalT; // Sosial Ekonomi Sedikit Lebih penting dari Tanggungan 
                                  $normalisasiTtoR = $TtoR / $totalR; // Sama
                                  $normalisasiTtoSE = $TtoSE / $totalSE; // Sama
                                  $normalisasiTtoT = $TtoT / $totalT; // Sama

                                  // Jumlah nilai normalisasis nilai kriteria 
                                  $jumlahR = $normalisasiRtoR + $normalisasiRtoSE + $normalisasiRtoT;
                                  $jumlahSE = $normalisasiSEtoR + $normalisasiSEtoSE + $normalisasiSEtoT;
                                  $jumlahT = $normalisasiTtoR + $normalisasiTtoSE + $normalisasiTtoT;
                                  $totalJumlahNormalisasi = $jumlahR + $jumlahSE + $jumlahT;

                                  // Rata-rata normalisasis nilai kriteria 
                                  $averageR = $jumlahR / $totalJumlahNormalisasi;
                                  $averageSE = $jumlahSE / $totalJumlahNormalisasi;
                                  $averageT = $jumlahT / $totalJumlahNormalisasi;

                                  // Eigen Value nilai kriteria 
                                  $evR = $averageR * $totalR;
                                  $evSE = $averageSE * $totalSE;
                                  $evT = $averageT * $totalT;

                                  // Total
                                  $totalNormalisasiR = $normalisasiRtoR + $normalisasiSEtoR + $normalisasiTtoR;
                                  $totalNormalisasiSE = $normalisasiRtoSE + $normalisasiSEtoSE + $normalisasiTtoSE;
                                  $totalNormalisasiT = $normalisasiRtoT + $normalisasiSEtoT + $normalisasiTtoT;
                                  $totalNormalisasiAverage = $averageR + $averageSE + $averageT;
                                  $totalNormalisasiEV = $evR + $evSE + $evT;

                                  ?>

                                  <td>Rumah</td>
                                  <td><?php echo number_format($normalisasiRtoR, 2) ?></td>
                                  <td><?php echo number_format($normalisasiRtoSE, 2) ?></td>
                                  <td><?php echo number_format($normalisasiRtoT, 2) ?></td>
                                  <td><?php echo number_format($jumlahR, 2) ?></td>
                                  <td><?php echo number_format($averageR, 2) ?></td>
                                  <td><?php echo number_format($evR, 2) ?></td>
                                </tr>
                                <tr>
                                  <td>Sosial Ekonomi</td>
                                  <td><?php echo number_format($normalisasiSEtoR, 2) ?></td>
                                  <td><?php echo number_format($normalisasiSEtoSE, 2) ?></td>
                                  <td><?php echo number_format($normalisasiSEtoT, 2) ?></td>
                                  <td><?php echo number_format($jumlahSE, 2) ?></td>
                                  <td><?php echo number_format($averageSE, 2) ?></td>
                                  <td><?php echo number_format($evSE, 2) ?></td>
                                </tr>
                                <tr>
                                  <td>Tanggungan</td>
                                  <td><?php echo number_format($normalisasiTtoR, 2) ?></td>
                                  <td><?php echo number_format($normalisasiTtoSE, 2) ?></td>
                                  <td><?php echo number_format($normalisasiTtoT, 2) ?></td>
                                  <td><?php echo number_format($jumlahT, 2) ?></td>
                                  <td><?php echo number_format($averageT, 2) ?></td>
                                  <td><?php echo number_format($evT, 2) ?></td>
                                </tr>
                              </tbody>
                              <tfoot>
                                <tr>
                                  <th>Total</th>
                                  <th><?php echo number_format($totalNormalisasiR, 2) ?></th>
                                  <th><?php echo number_format($totalNormalisasiSE, 2) ?></th>
                                  <th><?php echo number_format($totalNormalisasiT, 2) ?></th>
                                  <th><?php echo number_format($totalJumlahNormalisasi, 2) ?></th>
                                  <th><?php echo number_format($totalNormalisasiAverage, 2) ?></th>
                                  <th><?php echo number_format($totalNormalisasiEV, 2) ?></th>
                                </tr>
                              </tfoot>
                            </table>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <!-- End of Tabel Normalisasi Kriteria -->
            </div>
            <div class="row">
              <!-- Tabel Peserta -->
              <div class="col-md-12">
                <div class="card">
                  <div class="card-header">
                    <div class="d-flex align-items-center">
                      <h4 class="card-title">Peserta</h4>
                      <button
                        class="btn btn-primary btn-round ms-auto" data-bs-toggle="modal" data-bs-target="#addPeserta">
                        <i class="fa fa-plus"></i>
                        Tambah Peserta
                      </button>
                    </div>
                  </div>
                  <div class="card-body">
                    <div class="table-responsive">
                      <div id="add-row_wrapper" class="dataTables_wrapper container-fluid dt-bootstrap4">
                        <div class="row">
                          <div class="col-sm-12">
                            <table id="multi-filter-select" class="display table table-striped table-hover dataTable" role="grid" aria-describedby="add-row_info">
                              <thead>
                                <tr role="row">
                                  <?php
                                  $columns = [];
                                  $resultColumns = mysqli_query($mySqliCon, "SHOW COLUMNS FROM peserta");
                                  if ($resultColumns && mysqli_num_rows($resultColumns) > 0) {
                                    while ($col = mysqli_fetch_assoc($resultColumns)) {
                                      if ($col['Field'] !== 'id') { // Kecualikan kolom 'id'
                                        $columns[] = $col['Field'];
                                      }
                                    }
                                  }
                                  ?>
                                  <?php foreach ($columns as $column): ?>
                                    <th><?php echo ucwords(str_replace('_', ' ', $column)); ?></th>
                                  <?php endforeach; ?>
                                  <th>Action</th>
                                </tr>
                              </thead>
                              <tfoot>
                                <tr>
                                  <?php foreach ($columns as $column): ?>
                                    <th><?php echo ucwords(str_replace('_', ' ', $column)); ?></th>
                                  <?php endforeach; ?>
                                  <th>Action</th>
                                </tr>
                              </tfoot>
                              <tbody>
                                <?php
                                $result = getData('peserta', null);
                                if ($result && mysqli_num_rows($result) > 0) {
                                  while ($a = mysqli_fetch_array($result)) {
                                    $id = $a['id'];
                                    $nama = $a['nama'];
                                    $statusrumah = $a['status_rumah'];
                                    $luasbangunan = $a['luas_bangunan'];
                                    $jenislantai = $a['jenis_lantai'];
                                    $jenisdinding = $a['jenis_dinding'];
                                    $pendidikan = $a['pendidikan'];
                                    $pekerjaan = $a['pekerjaan'];
                                    $tanggungan = $a['tanggungan'];

                                    require 'components/modal.php';
                                ?>
                                    <tr role="row" class="odd">
                                      <td><?php echo ucwords(str_replace('_', ' ', $nama)); ?></td>
                                      <td><?php echo ucwords(str_replace('_', ' ', $statusrumah)); ?></td>
                                      <td><?php echo ucwords(str_replace('_', ' ', $luasbangunan)); ?></td>
                                      <td><?php echo ucwords(str_replace('_', ' ', $jenislantai)); ?></td>
                                      <td><?php echo ucwords(str_replace('_', ' ', $jenisdinding)); ?></td>
                                      <td><?php echo ucwords(str_replace('_', ' ', $pendidikan)); ?></td>
                                      <td><?php echo ucwords(str_replace('_', ' ', $pekerjaan)); ?></td>
                                      <td><?php echo ucwords(str_replace('_', ' ', $tanggungan)); ?></td>
                                      <td>
                                        <center>
                                          <!-- Open Edit Peserta Modal -->
                                          <button class="btn btn-icon btn-link op-8 me-1" data-bs-toggle="modal" data-bs-target="#editPeserta<?php echo $id ?>">
                                            <i class="fa fa-edit"></i>
                                          </button>
                                          <!-- End Edit Peserta Modal -->

                                          <!-- Delete Peserta -->
                                          <form action="database/controller.php" method="post" style="display: inline;">
                                            <input type="hidden" name="action" value="deletePeserta">
                                            <input type="hidden" name="id" value="<?php echo $id; ?>">
                                            <button class="btn btn-icon btn-link btn-danger op-8" type="submit" onclick="return confirm('Yakin ingin menghapus data ini?')">
                                              <i class="fa fa-times"></i>
                                            </button>
                                          </form>
                                          <!-- End Delete Peserta -->
                                        </center>
                                      </td>
                                    </tr>
                                <?php
                                  }
                                } else {
                                  echo "<p class='text-center'>Tidak ada data kriteria tersedia.</p>";
                                }
                                ?>
                              </tbody>
                            </table>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <!-- End of Tabel Peserta -->
            </div>
            <div class="row">
              <!-- Matriks Keputusan -->
              <div class="col-md-12">
                <div class="card">
                  <div class="card-header">
                    <div class="d-flex align-items-center">
                      <h4 class="card-title">Normalisasi Data</h4>
                    </div>
                  </div>
                  <div class="card-body">
                    <div class="table-responsive">
                      <div id="add-row_wrapper" class="dataTables_wrapper container-fluid dt-bootstrap4">
                        <div class="row">
                          <div class="col-sm-12">
                            <table id="basic" class="display table table-striped table-hover dataTable" role="grid" aria-describedby="add-row_info">
                              <thead>
                                <tr role="row">
                                  <?php
                                  $columns = [];
                                  $resultColumns = mysqli_query($mySqliCon, "SHOW COLUMNS FROM peserta");
                                  if ($resultColumns && mysqli_num_rows($resultColumns) > 0) {
                                    while ($col = mysqli_fetch_assoc($resultColumns)) {
                                      if ($col['Field'] !== 'id') { // Kecualikan kolom 'id'
                                        $columns[] = $col['Field'];
                                      }
                                    }
                                  }
                                  ?>
                                  <?php foreach ($columns as $column): ?>
                                    <th><?php echo ucwords(str_replace('_', ' ', $column)); ?></th>
                                  <?php endforeach; ?>
                                </tr>
                              </thead>
                              <tfoot>
                                <tr>
                                  <?php foreach ($columns as $column): ?>
                                    <th><?php echo ucwords(str_replace('_', ' ', $column)); ?></th>
                                  <?php endforeach; ?>
                                </tr>
                              </tfoot>
                              <tbody>
                                <?php
                                $result = getNormalisasiSubkriteria();
                                $countRow = $result ? mysqli_num_rows($result) : 0;

                                if ($result && $countRow > 0) {
                                  while ($a = mysqli_fetch_assoc($result)) {
                                    $idPeserta = $a['id_peserta'];
                                    $nama = $a['nama'];
                                    $statusrumah = $a['status_rumah'];
                                    $luasbangunan = $a['luas_bangunan'];
                                    $jenislantai = $a['jenis_lantai'];
                                    $jenisdinding = $a['jenis_dinding'];
                                    $pendidikan = $a['pendidikan'];
                                    $pekerjaan = $a['pekerjaan'];
                                    $tanggungan = $a['tanggungan'];

                                    require 'components/modal.php';
                                ?>
                                    <tr role="row" class="odd">
                                      <td><?php echo ucwords(str_replace('_', ' ', $nama)); ?></td>
                                      <td><?php echo ucwords(str_replace('_', ' ', $statusrumah)); ?></td>
                                      <td><?php echo ucwords(str_replace('_', ' ', $luasbangunan)); ?></td>
                                      <td><?php echo ucwords(str_replace('_', ' ', $jenislantai)); ?></td>
                                      <td><?php echo ucwords(str_replace('_', ' ', $jenisdinding)); ?></td>
                                      <td><?php echo ucwords(str_replace('_', ' ', $pendidikan)); ?></td>
                                      <td><?php echo ucwords(str_replace('_', ' ', $pekerjaan)); ?></td>
                                      <td><?php echo ucwords(str_replace('_', ' ', $tanggungan)); ?></td>
                                    </tr>
                                <?php
                                  }
                                } else {
                                  echo "<p class='text-center'>Tidak ada data kriteria tersedia.</p>";
                                }
                                ?>
                              </tbody>
                            </table>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <!-- End of Matriks Keputusan -->
            </div>
            <div class="row">
              <!-- Vektor Si dan Vi -->
              <div class="col-md-12">
                <div class="card">
                  <div class="card-header">
                    <div class="d-flex align-items-center">
                      <h4 class="card-title">Metode WP (Vektor Si dan Vi)</h4>
                    </div>
                  </div>
                  <div class="card-body">
                    <div class="table-responsive">
                      <div id="add-row_wrapper" class="dataTables_wrapper container-fluid dt-bootstrap4">
                        <div class="row">
                          <div class="col-sm-12">
                            <table id="basic-datatables" class="display table table-striped table-hover dataTable" role="grid" aria-describedby="add-row_info">
                              <thead>
                                <tr role="row">
                                  <th>No</th>
                                  <th>Nama</th>
                                  <th>Si</th>
                                  <th>Vi</th>
                                </tr>
                              </thead>
                              <tfoot>
                                <tr>
                                  <th></th>
                                  <th></th>
                                  <th></th>
                                  <th>Total Vi = <?php
                                                  global $mySqliCon;
                                                  $query = "SELECT SUM(vi) AS vektorVi FROM vektor_vi_si";
                                                  $resultCount = mysqli_query($mySqliCon, $query);
                                                  $row = mysqli_fetch_assoc($resultCount);
                                                  $totalBobot = $row['vektorVi'];
                                                  echo number_format($totalBobot, 1);
                                                  ?> </th>
                                </tr>
                              </tfoot>
                              <tbody>
                                <?php
                                // global $mySqliCon;
                                // $query = "SELECT SUM(si) AS vektorSi FROM vektor_vi_si";
                                // $resultCount = mysqli_query($mySqliCon, $query);
                                // if ($resultCount) {
                                //   $row = mysqli_fetch_assoc($resultCount);
                                //   $totalBobot = $row['vektorSi'];
                                // } else {
                                //   echo "Error: " . mysqli_error($mySqliCon);
                                // }

                                $i = 0;
                                $result = getSiVi();
                                if ($result && mysqli_num_rows($result) > 0) {
                                  while ($a = mysqli_fetch_array($result)) {
                                    $i += 1;
                                    $idPeserta = $a['id_peserta'];
                                    $namaPeserta = $a['nama'];
                                    $si = $a['si'];
                                    $vi = $si / $totalBobot;
                                    addVi($idPeserta, $vi);
                                ?>
                                    <tr role="row" class="odd">
                                      <td><?php echo ucwords(str_replace('_', ' ', $i)); ?></td>
                                      <td><?php echo ucwords(str_replace('_', ' ', $namaPeserta)); ?></td>
                                      <td><?php echo ucwords(str_replace('_', ' ', $si)); ?></td>
                                      <td><?php echo ucwords(str_replace('_', ' ', $vi)); ?></td>
                                    </tr>
                                <?php
                                  }
                                } else {
                                  echo "<p class='text-center'>Tidak ada data kriteria tersedia.</p>";
                                }
                                ?>
                              </tbody>
                            </table>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <!-- End of Vektor Si dan Vi -->
            </div>
          </div>
        </div>
        <footer class="footer">
          <div class="container-fluid d-flex justify-content-between">
            <div>
              <?php
              echo 'Logged in as ', $_SESSION['role'];
              ?>
            </div>
          </div>
        </footer>
      </div>
    </div>
    <!--   Core JS Files   -->
    <script src="assets/js/core/jquery-3.7.1.min.js"></script>
    <script src="assets/js/core/popper.min.js"></script>
    <script src="assets/js/core/bootstrap.min.js"></script>

    <!-- jQuery Scrollbar -->
    <script src="assets/js/plugin/jquery-scrollbar/jquery.scrollbar.min.js"></script>

    <!-- Chart JS -->
    <script src="assets/js/plugin/chart.js/chart.min.js"></script>

    <!-- jQuery Sparkline -->
    <script src="assets/js/plugin/jquery.sparkline/jquery.sparkline.min.js"></script>

    <!-- Chart Circle -->
    <script src="assets/js/plugin/chart-circle/circles.min.js"></script>

    <!-- Datatables -->
    <script src="assets/js/plugin/datatables/datatables.min.js"></script>

    <!-- jQuery Vector Maps -->
    <script src="assets/js/plugin/jsvectormap/jsvectormap.min.js"></script>
    <script src="assets/js/plugin/jsvectormap/world.js"></script>

    <!-- Sweet Alert -->
    <script src="assets/js/plugin/sweetalert/sweetalert.min.js"></script>

    <!-- Kaiadmin JS -->
    <script src="assets/js/kaiadmin.min.js"></script>

    <script>
      $("#lineChart").sparkline([102, 109, 120, 99, 110, 105, 115], {
        type: "line",
        height: "70",
        width: "100%",
        lineWidth: "2",
        lineColor: "#177dff",
        fillColor: "rgba(23, 125, 255, 0.14)",
      });

      $("#lineChart2").sparkline([99, 125, 122, 105, 110, 124, 115], {
        type: "line",
        height: "70",
        width: "100%",
        lineWidth: "2",
        lineColor: "#f3545d",
        fillColor: "rgba(243, 84, 93, .14)",
      });

      $("#lineChart3").sparkline([105, 103, 123, 100, 95, 105, 115], {
        type: "line",
        height: "70",
        width: "100%",
        lineWidth: "2",
        lineColor: "#ffa534",
        fillColor: "rgba(255, 165, 52, .14)",
      });
    </script>
    <script>
      $(document).ready(function() {
        $("#basic-datatables").DataTable({});

        $("#multi-filter-select").DataTable({
          pageLength: 5,
          initComplete: function() {
            this.api()
              .columns()
              .every(function() {
                var column = this;
                var select = $(
                    '<select class="form-select"><option value=""></option></select>'
                  )
                  .appendTo($(column.footer()).empty())
                  .on("change", function() {
                    var val = $.fn.dataTable.util.escapeRegex($(this).val());

                    column
                      .search(val ? "^" + val + "$" : "", true, false)
                      .draw();
                  });

                column
                  .data()
                  .unique()
                  .sort()
                  .each(function(d, j) {
                    select.append(
                      '<option value="' + d + '">' + d + "</option>"
                    );
                  });
              });
          },
        });

        // Add Row
        $("#add-row").DataTable({
          pageLength: 5,
        });

        var action =
          '<td> <div class="form-button-action"> <button type="button" data-bs-toggle="tooltip" title="" class="btn btn-link btn-primary btn-lg" data-original-title="Edit Task"> <i class="fa fa-edit"></i> </button> <button type="button" data-bs-toggle="tooltip" title="" class="btn btn-link btn-danger" data-original-title="Remove"> <i class="fa fa-times"></i> </button> </div> </td>';

        $("#addRowButton").click(function() {
          $("#add-row")
            .dataTable()
            .fnAddData([
              $("#addName").val(),
              $("#addPosition").val(),
              $("#addOffice").val(),
              action,
            ]);
          $("#addRowModal").modal("hide");
        });
      });
    </script>
</body>

</html>