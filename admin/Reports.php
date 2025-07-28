 <!-- partial -->
  <?php include 'includes/header.php'; ?>
  <?php include 'includes/sidebar.php'; ?>

  <?php

require_once __DIR__ . '/../Controller/DownloadRecord.php';

$record = new DownloadRecord();
$topDownloaders = $record->getTopDownloaders();
$topBooks = $record->getTopDownloadedBooks();
?>

<div class="container mt-4">
    <h4 class="mb-3">📊 Reports</h4>

    <div class="row">
        <div class="col-md-6">
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-primary text-white">Top Downloaders</div>
                <div class="card-body p-2">
                    <table class="table table-sm table-bordered">
                        <thead class="table-light">
                            <tr>
                                <th>#</th>
                                <th>Username</th>
                                <th>Total Downloads</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($topDownloaders)): 
                                $i = 1;
                                foreach ($topDownloaders as $user): ?>
                                    <tr>
                                        <td><?= $i++ ?></td>
                                        <td><?= htmlspecialchars($user['username']) ?></td>
                                        <td><?= $user['total_downloads'] ?></td>
                                    </tr>
                                <?php endforeach; else: ?>
                                <tr><td colspan="3">No data found.</td></tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-success text-white">Top Downloaded Books</div>
                <div class="card-body p-2">
                    <table class="table table-sm table-bordered">
                        <thead class="table-light">
                            <tr>
                                <th>#</th>
                                <th>Book Title</th>
                                <th>Total Downloads</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($topBooks)): 
                                $i = 1;
                                foreach ($topBooks as $book): ?>
                                    <tr>
                                        <td><?= $i++ ?></td>
                                        <td><?= htmlspecialchars($book['title']) ?></td>
                                        <td><?= $book['total_downloads'] ?></td>
                                    </tr>
                                <?php endforeach; else: ?>
                                <tr><td colspan="3">No data found.</td></tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    
<?php include 'includes/footer.php'; ?>
</div>

