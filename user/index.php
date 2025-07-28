<?php include_once __DIR__.'/includes/header.php'; ?>
<?php
include_once __DIR__.'/includes/header.php';
require_once __DIR__.'/../Controller/Book.php';
require_once __DIR__.'/../Controller/Category.php';

$bookObj = new Book();
$categoryObj = new Category();

$categories = $categoryObj->showCat();
$featuredBooks = $categoryObj->getFeaturedBooks();

?>

<div class="container py-5">
    <!-- Hero Section -->
    <div class="text-center mb-5">
        <h1 class="display-5 fw-bold text-primary">Welcome to the Digital Library</h1>
        <p class="lead">Explore, read and download thousands of books for free.</p>
        <form class="d-flex justify-content-center mt-4" action="search" method="GET" style="max-width: 600px; margin: 0 auto;">
            <input type="text" name="q" class="form-control form-control-lg me-2" placeholder="Search for books or authors...">
            <button type="submit" class="btn btn-primary btn-lg">Search</button>
        </form>
    </div>

    <!-- Category Filters -->
    <div class="mb-4 text-center">
        <h4 class="fw-semibold">Browse by Category</h4>
        <div class="d-flex flex-wrap justify-content-center mt-3 gap-2">
            <?php foreach ($categories as $cat): ?>
                <a href="category?id=<?= $cat['id']; ?>" class="btn btn-outline-dark btn-sm rounded-pill">
                    <?= htmlspecialchars($cat['category']); ?>
                </a>
            <?php endforeach; ?>
        </div>
    </div>

    <!-- Featured Books Grid -->
    <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 g-4">
        <?php foreach ($featuredBooks as $book): ?>
            <div class="col">
                <div class="card h-100 shadow-sm border-0">
                    <img src="<?= APPURL ?>uploads/images/<?= $book['image']; ?>" class="card-img-top" style="height: 250px; object-fit: contain;" alt="<?= $book['title']; ?>">
                    <div class="card-body">
                        <h5 class="card-title text-truncate"><?= htmlspecialchars($book['title']); ?></h5>
                        <p class="card-text small"><strong>Author:</strong> <?= htmlspecialchars($book['author_name']); ?></p>
                        <span class="badge bg-light text-muted"><?= $book['category']; ?></span>
                    </div>
                    <div class="card-footer bg-white border-0">
                        <a href="single?id=<?= $book['id']; ?>" class="btn btn-sm btn-outline-primary w-100">View Details</a>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>


