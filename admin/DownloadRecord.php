<?php 
    include 'includes/header.php';
    include 'includes/sidebar.php'; 
    include __DIR__.'/../Controller/DownloadRecord.php';

    $DownloadRecord = new DownloadRecord;

    // Decide what data to show
    $isSingle = isset($_GET['id']);
    $downDetails = $isSingle 
        ? $DownloadRecord->showsingleDownload($_GET['id']) 
        : $DownloadRecord->showDownload();
?>

<div class="container-fluid mt-4">
  <div class="card shadow-sm border-0">
    <div class="card-body">
      <h4 class="card-title mb-3">
        <?= $isSingle ? "📘 Download Details for Selected Book" : "📚 All Book Downloads" ?>
      </h4>

      <?php if (count($downDetails) > 0): ?>
        <div class="table-responsive">
          <table class="table table-hover table-bordered align-middle" id="bookTable">
            <thead class="table-light">
              <tr>
                <th>📖 Book Title</th>
                <th>📂 Category</th>
                <th>⬇️ Total Downloads</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($downDetails as $bk): ?>
                <tr>
                  <td class="fw-semibold"><?= htmlspecialchars($bk['title']) ?></td>
                  <td><?= htmlspecialchars($bk['category']) ?></td>
                  <td>
                    <?php
                      $bookId = isset($bk['book_id']) ? $bk['book_id'] : $bk['id'];
                      echo "<span class='badge bg-primary fs-6'>"
                            . $DownloadRecord->getDownloadCountByBook($bookId) .
                           "</span>";
                    ?>
                  </td>
                </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>
      <?php else: ?>
        <div class="alert alert-info">No download data available.</div>
      <?php endif; ?>

      <?php if ($isSingle): ?>
        <a href="DownloadRecord" class="btn btn-secondary mt-3">
          🔙 Back to All Downloads
        </a>
      <?php endif; ?>
    </div>
  </div>
</div>

