<?php 
    include_once __DIR__ . '/includes/header.php';
    include __DIR__.'/../Controller/DownloadRecord.php';

    $DownloadRecord = new DownloadRecord;


    $downDetails = $DownloadRecord->showsingleDownload($_SESSION['id']);

?>

<div class="container-fluid mt-5">
  <div class="card shadow-sm  border-0">
    <div class="card-header mt-5">
      <h3>Recent Downloads</h3>
    </div>
    <div class="card-body">
      <h4 class="card-title mb-3">
      </h4>

      <?php if (count($downDetails) > 0): ?>
        <div class="table-responsive">
          <table class="table table-hover table-bordered align-middle" id="bookTable">
            <thead class="table-light">
              <tr>
                <th>📖 Book Title</th>
                <th>📂 Category</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($downDetails as $bk): ?>
                <tr>
                  <td class="fw-semibold"><?= htmlspecialchars($bk['title']) ?></td>
                  <td><?= htmlspecialchars($bk['category']) ?></td>
                
                </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>
      <?php else: ?>
        <div class="alert alert-info">No download data available.</div>
      <?php endif; ?>


    </div>
  </div>
</div>

