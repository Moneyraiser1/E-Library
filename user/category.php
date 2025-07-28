<?php 
include_once __DIR__.'/includes/header.php';
require_once __DIR__.'/../Controller/Book.php';
require_once __DIR__.'/../Controller/Category.php';

$bookObj = new Book();
$categoryObj = new Category();

$categoryId = $_GET['id'] ?? null;
$categoryName = $categoryObj->getCategoryNameById($categoryId);
$books = $bookObj->getBooksByCategory($categoryId);
?>

<div class="container py-5 mt-5">
    <h2 class="mb-4 text-primary">Books in Category: <?= htmlspecialchars($categoryName); ?></h2>

    <?php if (count($books) > 0): ?>
        <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 g-4">
            <?php foreach ($books as $book): ?>
                <div class="col">
                    <div class="card h-100 shadow-sm border-0">
                        <img src="<?= APPURL ?>uploads/images/<?= $book['image']; ?>" class="card-img-top" style="height: 250px; object-fit: contain;" alt="<?= $book['title']; ?>">
                        <div class="card-body">
                            <h5 class="card-title text-truncate"><?= htmlspecialchars($book['title']); ?></h5>
                            <p class="card-text small"><strong>Author:</strong> <?= htmlspecialchars($book['author_name']); ?></p>
                        </div>
                        <div class="card-footer bg-white border-0">
                            <a href="single?id=<?= $book['id']; ?>" class="btn btn-sm btn-outline-primary w-100">View Details</a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <p class="text-muted">No books found in this category.</p>
    <?php endif; ?>
</div>
