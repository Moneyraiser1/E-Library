<?php
include_once __DIR__ . '/includes/header.php';
$bookData = $book->showSingleBook($_GET['id']);

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_SESSION['id'])) {
    $userId = $_SESSION['id'];
    $bookId = $_POST['book_id'] ?? null;
    $categoryId = $_POST['category_id'] ?? null;
    $action = $_POST['action'] ?? '';

    if ($bookId && $categoryId) {
        $download->insertDownload($userId, $bookId, $categoryId);

        $fileUrl = APPURL . "uploads/files/" . $bookData['pdf'];
        $filePath = __DIR__ . '/../uploads/files/' . $bookData['pdf'];

        if ($action === 'download') {
            // Fallback for file not found
            if (!file_exists($filePath)) {
                echo "<script>alert('File not found!');</script>";
            } else {
                echo "<script>
                    const a = document.createElement('a');
                    a.href = '$fileUrl';
                    a.download = '" . basename($bookData['pdf']) . "';
                    document.body.appendChild(a);
                    a.click();
                    document.body.removeChild(a);
                </script>";
            }
        } elseif ($action === 'read') {
            echo "<script>window.open('$fileUrl', '_blank');</script>";
        }
    }
}
?>

<div class="container my-5">
    <div class="card shadow-lg border-0 rounded-4 overflow-hidden">
        <div class="row g-0">
            <!-- Book Cover Image -->
            <div class="col-lg-5 bg-light d-flex justify-content-center align-items-center p-4">
                <img 
                    src="<?= APPURL ?>uploads/images/<?= $bookData['image']; ?>" 
                    alt="Book Cover" 
                    class="img-fluid rounded-3 shadow-sm" 
                    style="max-height: 450px; object-fit: contain;"
                >
            </div>

            <!-- Book Details -->
            <div class="col-lg-7 p-5">
                <h1 class="mb-3 fw-bold text-primary"><?= $bookData['title']; ?></h1>

                <div class="mb-3">
                    <span class="badge bg-secondary text-uppercase py-2 px-3 fs-6">
                        <?= $bookData['category']; ?>
                    </span>
                </div>

                <ul class="list-unstyled fs-5 lh-lg">
                    <li><strong>Author:</strong> <?= $bookData['author_name']; ?></li>
                    <li><strong>ISBN:</strong> <?= $bookData['isbn']; ?></li>
                </ul>

                <!-- Action Buttons -->
                <div class="mt-4">
                    <div class="d-flex flex-wrap align-items-center gap-3">
                        <form method="post">
                            <input type="hidden" name="action" value="download">
                            <input type="hidden" name="book_id" value="<?= $bookData['id'] ?>">
                            <input type="hidden" name="category_id" value="<?= $bookData['category_id'] ?>">
                            <button type="submit" class="btn btn-outline-primary btn-lg" name="download_btn">
                                <i class="mdi mdi-download"></i> Download Book (PDF)
                            </button>
                        </form>

                        <a href="<?= APPURL ?>uploads/files/<?= $bookData['pdf'] ?>" target="blank" type="submit" class="btn btn-primary btn-lg" name="read_btn">
                                <i class="mdi mdi-eye"></i> Read Online
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php $allBooks = $book->showBooks(); ?>

<!-- Explore More Books Carousel -->
<div class="container my-5">
    <h3 class="mb-4 fw-bold">Explore More Books</h3>

    <div id="otherBooksCarousel" class="carousel slide" data-bs-ride="carousel">
        <div class="carousel-inner">
            <?php
            $chunks = array_chunk($allBooks, 4); // 4 books per slide
            foreach ($chunks as $index => $chunk):
            ?>
                <div class="carousel-item <?= $index === 0 ? 'active' : '' ?>">
                    <div class="row g-4">
                        <?php foreach ($chunk as $b): ?>
                            <div class="col-md-3">
                                <div class="card h-100 border-0 shadow-sm">
                                    <img src="<?= APPURL ?>uploads/images/<?= $b['image'] ?>" class="card-img-top" style="height: 200px; object-fit: cover;">
                                    <div class="card-body">
                                        <h5 class="card-title"><?= $b['title'] ?></h5>
                                        <p class="text-muted small"><?= $b['author_name'] ?></p>
                                        <a href="single?id=<?= $b['id'] ?>" class="stretched-link"></a>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <!-- Controls -->
        <button class="carousel-control-prev" type="button" data-bs-target="#otherBooksCarousel" data-bs-slide="prev">
            <span class="carousel-control-prev-icon bg-dark rounded-circle p-2" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#otherBooksCarousel" data-bs-slide="next">
            <span class="carousel-control-next-icon bg-dark rounded-circle p-2" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>
    </div>
</div>
