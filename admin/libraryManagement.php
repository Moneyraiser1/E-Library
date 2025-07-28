<?php
include 'includes/header.php';
 include 'includes/sidebar.php'; 
require_once '../Controller/Book.php';

$book = new Book();
$cat = new Category();
$books = $book->showBooks();

$categories = $cat->showCat();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['add_book'])) {
    $title = $_POST['title'];
    $isbn = $_POST['isbn'];
    $author_name = $_POST['author'];
    $category_id = $_POST['category_id'];

    $imageFile = $_FILES['cover_image'];
    $pdfFile = $_FILES['pdf_file'];

    $book->insertBook($title, $isbn, $author_name, $category_id, $_FILES['cover_image'], $_FILES['pdf_file']);
   echo '<a id="redir" href="libraryManagement" style="display:none;">Redirect</a>';
   echo '<script>document.getElementById("redir").click();</script>';
   exit;
}


    if (isset($_POST['edit_book'])) {
        $id = $_POST['book_id'];
     

        $title = $_POST['edit_title'];
        $author = $_POST['edit_author'];
        $category_id = $_POST['edit_category_id'];

        $imageName = $_POST['existing_image'];
        $pdfName = $_POST['existing_pdf'];

        if (!empty($_FILES['edit_cover_image']['name'])) {
            $image = $_FILES['edit_cover_image'];
            $imageName = time() . '_' . basename($image['name']);
            move_uploaded_file($image['tmp_name'], '../uploads/images/' . $imageName);
        }

        if (!empty($_FILES['edit_pdf_file']['name'])) {
            $pdf = $_FILES['edit_pdf_file'];
            $pdfName = time() . '_' . basename($pdf['name']);
            move_uploaded_file($pdf['tmp_name'], '../uploads/files/' . $pdfName);
        }

       if (isset($_POST['edit_book'])) {
          $id = $_POST['book_id'];
          $title = $_POST['edit_title'];
          $author_name = $_POST['edit_author'];
          $category_id = $_POST['edit_category_id'];

          $existingImage = $_POST['existing_image'];
          $existingPdf = $_POST['existing_pdf'];

          $imageFile = $_FILES['edit_cover_image'];
          $pdfFile = $_FILES['edit_pdf_file'];

          $book->updateBook($id, $title, $author_name, $category_id, $imageFile, $pdfFile, $existingImage, $existingPdf);

          echo '<a id="redir" href="libraryManagement" style="display:none;">Redirect</a>';
          echo '<script>document.getElementById("redir").click();</script>';
          exit();
        }

    }
}

if (isset($_GET['delete'])) {
    $book->removeBook($_GET['delete']);
    header("Location: libraryManagement");
    exit();
}
?>


<div class="container mt-5">
  <h2 class="mb-4 text-center">📚 Library Management</h2>

  <!-- Add Book Form -->
  <form method="post" enctype="multipart/form-data" class="card p-4 shadow-sm mb-5">
    <h5>Add New Book</h5>
    <div class="row g-3">
      <div class="col-md-4"><input type="text" name="isbn" class="form-control" placeholder="ISBN" required></div>

      <div class="col-md-4"><input type="text" name="title" class="form-control" placeholder="Book Title" required></div>
      <div class="col-md-4"><input type="text" name="author" class="form-control" placeholder="Author" required></div>
      <div class="col-md-4">
        <select name="category_id" class="form-select select2" required>
          <option value="">-- Select Category --</option>
          <?php foreach ($categories as $cat): ?>
            <option value="<?= $cat['id'] ?>"><?= $cat['category'] ?></option>
          <?php endforeach; ?>
        </select>
      </div>

      <div class="col-md-6">      <label for="">Image</label><input type="file"  name="cover_image" class="form-control" accept="image/*" required></div>
   
      <div class="col-md-6">    <label for="">Pdf</label><input type="file"   name="pdf_file" class="form-control" accept="application/pdf" required></div>
    </div>
    <button name="add_book" type="submit" class="btn btn-primary mt-3">Add Book</button>
  </form>

  <!-- Book List Table -->
  <div class="table-responsive card p-3 shadow-sm">
    <h5>All Books</h5>
    <table class="table table-bordered table-hover align-middle" id="bookTable">
      <thead class="table-light">
        <tr>
          <th>Title</th>
          <th>Author</th>
          <th>Category</th>
          <th>Cover</th>
          <th>PDF</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($books as $bk): ?>
          <tr>
            <td><?= htmlspecialchars($bk['title']) ?></td>
            <td><?= htmlspecialchars($bk['author_name']) ?></td>
            <td><?= htmlspecialchars($bk['category']) ?></td>
            <td><img src="../uploads/images/<?= $bk['image'] ?>" width="60"></td>
            <td><a href="../uploads/files/<?= $bk['pdf'] ?>" target="_blank">📄 View</a></td>
            <td>
              <button 
                class="btn btn-sm btn-warning btn-edit"
                data-id="<?= $bk['id'] ?>"
                data-title="<?= htmlspecialchars($bk['title']) ?>"
                data-author="<?= htmlspecialchars($bk['author_name']) ?>"
                data-category="<?= $bk['category_id'] ?>"
                data-image="<?= $bk['image'] ?>"
                data-pdf="<?= $bk['pdf'] ?>"
              > <i class="fa fa-pencil"></i></button>
              <a href="?delete=<?= $bk['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('Delete this book?')">🗑️</a>
            </td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
</div>

<!-- Edit Modal -->
<div class="modal fade" id="editModal" tabindex="-1">
  <div class="modal-dialog modal-lg">
    <form method="post" enctype="multipart/form-data" class="modal-content">
      <div class="modal-header"><h5>Edit Book</h5></div>
      <div class="modal-body row g-3 px-3">
        <input type="hidden" name="book_id" id="edit_book_id">
        <input type="hidden" name="existing_image" id="existing_image">
        <input type="hidden" name="existing_pdf" id="existing_pdf">

        <div class="col-md-6"><input type="text" name="edit_title" id="edit_title" class="form-control" required></div>
        <div class="col-md-6"><input type="text" name="edit_author" id="edit_author" class="form-control" required></div>

        <div class="col-md-6">
          <select name="edit_category_id" id="edit_category_id" class="form-control select2" required>
            <?php foreach ($categories as $cat): ?>
              <option value="<?= $cat['id'] ?>"><?= $cat['category'] ?></option>
            <?php endforeach; ?>
          </select>
        </div>

        <div class="col-md-6"><input type="file" name="edit_cover_image" class="form-control" accept="image/*"></div>
        <div class="col-md-6"><input type="file" name="edit_pdf_file" class="form-control" accept="application/pdf"></div>
      </div>
      <div class="modal-footer">
        <button name="edit_book" type="submit" class="btn btn-success">Update Book</button>
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
      </div>
    </form>
  </div>
</div>

</body>
</html>
<script>
  $(document).on('click', '.btn-edit', function () {
    $('#edit_book_id').val($(this).data('id'));
    $('#edit_title').val($(this).data('title'));
    $('#edit_author').val($(this).data('author'));
    $('#edit_category_id').val($(this).data('category'));
    $('#existing_image').val($(this).data('image'));
    $('#existing_pdf').val($(this).data('pdf'));
    new bootstrap.Modal(document.getElementById('editModal')).show();
  });
</script>