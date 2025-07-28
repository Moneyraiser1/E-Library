<?php 
    include_once __DIR__ . '/includes/header.php';
    include __DIR__.'/../Controller/DownloadRecord.php';

    $DownloadRecord = new DownloadRecord;

    $downDetails = $DownloadRecord->showDownload();
?>

<div class="container-fluid mt-4">
  <div class="card shadow-sm border-0">
    <div class="card-body mt-5">

      <?php if (count($downDetails) > 0): ?>
        <div class="table-responsive">
          <table class="table table-hover table-bordered align-middle" id="bookTable">
            <thead class="table-light">
              <tr>
                <th> Book Title</th>
                <th> Category</th>
                <th> Author</th>
                <th> ISBN</th>
                <th>⬇️ Total Downloads</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($downDetails as $bk): ?>
                <tr>
                  <td class="fw-semibold"><?= htmlspecialchars($bk['title']) ?></td>
                  <td><?= htmlspecialchars($bk['category']) ?></td>
                  <td><?= htmlspecialchars($bk['author_name']) ?></td>
                  <td><?= htmlspecialchars($bk['isbn']) ?></td>
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


    </div>
  </div>
</div>

