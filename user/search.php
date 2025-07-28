<?php 
include_once __DIR__.'/includes/header.php';
require_once __DIR__.'/../Controller/Book.php';

$bookObj = new Book();
$searchTerm = trim($_GET['q'] ?? '');
$searchResults = [];

if ($searchTerm !== '') {
    $searchResults = $bookObj->searchBooks($searchTerm);
}
?>

<div class="container py-5 mt-5">
    <h2 class="mb-4 text-primary">Search Results for: "<?= htmlspecialchars($searchTerm); ?>"</h2>

    <?php if (count($searchResults) > 0): ?>
        <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 g-4">
            <?php foreach ($searchResults as $book): ?>
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
    <?php else: ?>
        <p class="text-muted">No books found matching your search.</p>
    <?php endif; ?>
</div>
