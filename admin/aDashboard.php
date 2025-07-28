 <!-- partial -->
  <?php include 'includes/header.php'; ?>
  <?php include 'includes/sidebar.php';
  require_once __DIR__ . '/../Controller/DownloadRecord.php';
  require_once __DIR__ . '/../Controller/Book.php';

$record = new DownloadRecord();
$topDownloaders = $record->getTopDownloaders();
$topBooks = $record->getTopDownloadedBooks();
$records = new Users;
$totalUsers = $records->getTotalUsers();
$bookStats = $records->getBookDownloadStats();
$totalDownloads = $record->getTotalDownloads();


  ?>
        <div class="main-panel">
          <div class="content-wrapper">
            <div class="page-header">
              <h3 class="page-title">
                <span class="page-title-icon bg-gradient-primary text-white me-2">
                  <i class="mdi mdi-home"></i>
                </span> Dashboard
              </h3>
              <nav aria-label="breadcrumb">
                <ul class="breadcrumb">
                  <li class="breadcrumb-item active" aria-current="page">
                    <span></span>Overview <i class="mdi mdi-alert-circle-outline icon-sm text-primary align-middle"></i>
                  </li>
                </ul>
              </nav>
            </div>
            <div class="row">
              <div class="col-md-4 stretch-card grid-margin">
                <div class="card bg-gradient-danger card-img-holder text-white">
                  <div class="card-body">
                    <?php
                    if (!empty($topDownloaders)):
                        $totalDownloads = 0;
                        foreach ($topDownloaders as $user) {
                            $totalDownloads += $user['total_downloads'];
                        }
                    ?>
                    <img src="includes/assets/images/dashboard/circle.svg" class="card-img-absolute" alt="circle-image" />
                    <h4 class="font-weight-normal mb-3">Total Downloads <i class="mdi mdi-chart-line mdi-24px float-end"></i>
                    </h4>
                    <h2 class="mb-5"><?= $totalDownloads ?></h2>
                  </div>
                    <?php endif; ?>
                </div>
              </div>
              <div class="col-md-4 stretch-card grid-margin">
                <div class="card bg-gradient-info card-img-holder text-white">
                  <div class="card-body">
                    <img src="includes/assets/images/dashboard/circle.svg" class="card-img-absolute" alt="circle-image" />
                    <h4 class="font-weight-normal mb-3">Books downloaded <i class="mdi mdi-bookmark-outline mdi-24px float-end"></i>
                    </h4>
                     <h2 class="mb-5"><?= $totalDownloads ?></h2>
                  </div>
                </div>
              </div>
              <div class="col-md-4 stretch-card grid-margin">
                <div class="card bg-gradient-success card-img-holder text-white">
                  <div class="card-body">
                    <img src="includes/assets/images/dashboard/circle.svg" class="card-img-absolute" alt="circle-image" />
                    <h4 class="font-weight-normal mb-3">Total Users <i class="mdi mdi-diamond mdi-24px float-end"></i>
                    </h4>
                    <h2 class="mb-5"><?= $totalUsers ?></h2>

                  </div>
                </div>
                      
              </div>
            </div>

          </div>
          <div class="card">
  <div class="card-body">
    <h4 class="card-title">Top Downloaded Books</h4>
    <canvas id="downloadsChart"></canvas>
  </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
const ctx = document.getElementById('downloadsChart').getContext('2d');
const chart = new Chart(ctx, {
    type: 'bar',
    data: {
        labels: <?= json_encode(array_column($bookStats, 'book_title')) ?>,
        datasets: [{
            label: 'Downloads',
            data: <?= json_encode(array_column($bookStats, 'total_downloads')) ?>,
            backgroundColor: 'rgba(54, 162, 235, 0.7)'
        }]
    },
    options: {
        responsive: true,
        scales: {
            y: { beginAtZero: true }
        }
    }
});
</script>
<?php if (!empty($topDownloaders)): ?>
    <ul class="list-group">
    <?php foreach ($topDownloaders as $user): ?>
        <li class="list-group-item d-flex justify-content-between align-items-center">
            <?= htmlspecialchars($user['username']) ?>
            <span class="badge bg-primary rounded-pill"><?= $user['total_downloads'] ?></span>
        </li>
    <?php endforeach; ?>
    </ul>
<?php endif; ?>
