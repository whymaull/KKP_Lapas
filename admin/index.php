<?php
session_start();
include 'functions/auth-admin.php';
include 'functions/jadwal-helper.php';

if (!isset($_SESSION['id_user']) || !isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
  header("Location: /kkp-lapas/login.php");
  exit;
}
// Panggil fungsi untuk mendapatkan data pengguna
$userDetails = getUserData($conn, $_SESSION['id_user']);

$stmt = $conn->query($sql_kunjungan); 
$result_kunjungan = $stmt->fetchAll(PDO::FETCH_ASSOC); 
$jadwal_kunjungan = [];
foreach ($result_kunjungan as $row) {
    $jadwal_kunjungan[] = [
        'title' => $row['nama_pengunjung'],
        'start' => $row['tanggal_kunjungan'],
        'backgroundColor' => '#00bcd4'
    ];
}

$stmt = $conn->query($sql_pengiriman); 
$result_pengiriman = $stmt->fetchAll(PDO::FETCH_ASSOC);
$jadwal_pengiriman = [];
foreach ($result_pengiriman as $row) {
    $jadwal_pengiriman[] = [
        'title' => $row['nama_pengirim'],
        'start' => $row['tanggal_pengiriman'],
        'backgroundColor' => '#fe9701'
    ];
}

// Gabungkan data kunjungan dan pengiriman
$events = array_merge($jadwal_kunjungan, $jadwal_pengiriman);

?>
<!DOCTYPE html>
<html lang="en">


<!-- index.php -->
<head>
  <meta charset="UTF-8">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
  <title>Lapas Cipinang Jakarta</title>
  <!-- CSS -->
  <link rel="stylesheet" href="assets/css/app.min.css">
  <link rel="stylesheet" href="assets/bundles/fullcalendar/fullcalendar.min.css">
  <link rel="stylesheet" href="assets/css/style.css">
  <link rel="stylesheet" href="assets/css/components.css">
  <link rel="stylesheet" href="assets/css/toggle.css">
  <link rel='shortcut icon' type='image/x-icon' href='assets/img/logo_lapas.png' />
</head>

<body>
  <div class="loader"></div>
  <div id="app">
    <div class="main-wrapper main-wrapper-1">
      <!-- navbar -->
      <?php include 'assets/components/navbar.php'; ?>

      <!-- sidebar -->
      <?php include 'assets/components/sidebar.php'; ?>
      <!-- Main Content -->
      <div class="main-content">
        <section class="section">
            <!-- chart start -->
            <div class="row">
              <div class="col-12 col-sm-12 col-lg-6">
              <div class="card">
                  <div class="card-header">
                    <h4>Statistik Pengunjung</h4>
                    <div class="card-header-action">
                      <a href="#" class="btn active">Week</a>
                      <a href="#" class="btn">Month</a>
                      <a href="#" class="btn">Year</a>
                    </div>
                  </div>
                  <div class="card-body">
                    <canvas id="myChart2" height="180"></canvas>
                    <div class="statistic-details mt-1">
                      <div class="statistic-details-item">
                        <div class="text-small text-muted"><span class="text-primary"><i
                              class="fas fa-caret-up"></i></span> 12%</div>
                        <div class="detail-value">$125</div>
                        <div class="detail-name">Today</div>
                      </div>
                      <div class="statistic-details-item">
                        <div class="text-small text-muted"><span class="text-danger"><i
                              class="fas fa-caret-down"></i></span> 33%</div>
                        <div class="detail-value">$3,564</div>
                        <div class="detail-name">This Week</div>
                      </div>
                      <div class="statistic-details-item">
                        <div class="text-small text-muted"><span class="text-primary"><i
                              class="fas fa-caret-up"></i></span>19%</div>
                        <div class="detail-value">$14,687</div>
                        <div class="detail-name">This Month</div>
                      </div>
                      <div class="statistic-details-item">
                        <div class="text-small text-muted"><span class="text-primary"><i
                              class="fas fa-caret-up"></i></span>29%</div>
                        <div class="detail-value">$88,568</div>
                        <div class="detail-name">This Year</div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-xl-6 col-md-14 col-lg-6">
                <div class="card l-bg-orange">
                  <div class="card-body">
                    <div class="text-white">
                      <div class="row">
                        <div class="col-md-6 col-lg-5">
                          <h4 class="mb-0 font-26">$1,235</h4>
                          <p class="mb-2">Avg Sales Per Month</p>
                          <p class="mb-0">
                            <span class="font-20">+11.25% </span>Increase
                          </p>
                        </div>
                        <div class="col-md-6 col-lg-7">
                          <div class="sparkline-bar p-t-50"></div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="card l-bg-cyan">
                  <div class="card-body">
                    <div class="text-white">
                      <div class="row">
                        <div class="col-md-6 col-lg-5">
                          <h4 class="mb-0 font-26">758</h4>
                          <p class="mb-2">Avg new Cust Per Month</p>
                          <p class="mb-0">
                            <span class="font-20">+25.11%</span> Increase
                          </p>
                        </div>
                        <div class="col-md-6 col-lg-7">
                          <div class="sparkline-line-chart2 p-t-50"></div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <!-- chart end -->
            <!-- feature start -->
            <div class="row ">
              <!-- feature 1 -->
              <div class="col-12 col-md-6">
                <div class="card">
                  <div class="card-statistic-4">
                    <div class="align-items-center justify-content-between">
                      <div class="row ">
                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 pr-0 pt-3">
                          <div class="card-content">
                            <h5 class="font-19">Kunjungan</h5>
                            <h2 class="mb-3 font-22">18</h2>
                            <p class="mb-0"><span class="col-green">7 Selesai</span></p>
                          </div>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 pl-0">
                          <div class="banner-img">
                            <img src="assets/img/banner/1.png" alt="">
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>

              <!-- feature 2 -->
              <div class="col-12 col-md-6">
                <div class="card">
                  <div class="card-statistic-4">
                    <div class="align-items-center justify-content-between">
                      <div class="row ">
                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 pr-0 pt-3">
                          <div class="card-content">
                            <h5 class="font-19">Kiriman</h5>
                            <h2 class="mb-3 font-22">121</h2>
                            <p class="mb-0"><span class="col-green">26 Selesai</span></p>
                          </div>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 pl-0">
                          <div class="banner-img">
                            <img src="assets/img/banner/notif.png" alt="">
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            <!-- feature end -->
            
            <!-- jadwal kunjungan start -->
            <div class="col-12">
                <div class="card">
                  <div class="card-header">
                    <h4>Jadwal Kunjungan</h4>
                  </div>
                  <div class="card-body">
                    <div class="fc-overflow">
                      <div id="myEvent"></div>
                    </div>
                  </div>
                </div>
              </div>
            <!-- jadwal kunjungan end -->
        </section>
      </div>
      <!-- footer -->
      <?php include 'assets/components/footer.php'; ?>
    </div>
  </div>
  <!-- General JS Scripts -->
  <script src="assets/js/app.min.js"></script>
  <!-- JS Libraies -->
  <script src="assets/bundles/chartjs/chart.min.js"></script>
  <script src="assets/bundles/fullcalendar/fullcalendar.min.js"></script>
  <script src="assets/bundles/jquery.sparkline.min.js"></script>
  <script src="assets/bundles/apexcharts/apexcharts.min.js"></script>
  <script src="assets/js/page/widget-chart.js"></script>
  <!-- Page Specific JS File -->
  <script src="assets/js/page/index.js"></script>
  <!-- <script src="assets/js/page/calendar.js"></script> -->
  <!-- Template JS File -->
  <script src="assets/js/scripts.js"></script>
  <script>
var events = <?php echo json_encode($events); ?>;
var calendar = $('#myEvent').fullCalendar({
    height: 'auto',
    defaultView: 'month',
    editable: true,
    selectable: true,
    header: {
        left: 'prev,next today',
        center: 'title',
        right: 'month,agendaWeek,agendaDay,listMonth'
    },
    events: events
});
</script>

  
</body>

</html>