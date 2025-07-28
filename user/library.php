<?php 
include_once __DIR__.'/includes/header.php';
$bookData = $book->showBooks(); 
 ?>
 <style>
    .card:hover {
    transform: scale(1.02);
    transition: all 0.3s ease-in-out;
}

.badge {
    font-size: 0.75rem;
}

 </style>
<div class="container mt-5">
    <div class="row">
        <?php foreach($bookData as $data):  ?>
             <div class="col-md-4">
                <div class="card" >
                    <img class="img-top" style="height: 400px;" src="<?= APPURL ?>uploads/images/<?= $data['image'] ?>" alt="">
                    <div class="card-body">
                        <h4 class="card-title"><?= $data['title']; ?></h4>
                        <p class="card-text"><?= $data['category']; ?></p>
                        <a href="single?id=<?= $data['id']; ?>" class="btn btn-primary">See Profile</a>
                    </div>
                </div>

            </div>
                    <?php endforeach; ?>
        
    </div>
</div>