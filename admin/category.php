<?php
include 'includes/Header.php';
 include 'includes/sidebar.php'; 

$categories = $categoryController->showCat();
    if (isset($_GET['delete'])) {
      $catResult = $categoryController->removeCat($_GET['delete']);
      if($catResult === true){
           echo '<a id="redir" href="category" style="display:none;">Redirect</a>';
            echo '<script>document.getElementById("redir").click();</script>';
            exit;

      }else{
          $catResult;
      }
 
  }
?>

<div class="container mt-5">
    <h4 class="mb-4">Manage Categories</h4>
    
    <!-- Add Category Form -->
    <form method="POST" class="row g-3 mb-4">
        <div class="col-md-6">
            <input type="text" class="form-control" name="name" placeholder="Enter Category Name" required>
        </div>
        <div class="col-md-2">
            <button type="submit" name="add_category" class="btn btn-primary w-100">Add Category</button>
        </div>
    </form>

    <!-- Category Table -->
    <div class="card">

            <table class="table table-bordered table-hover" id="categoryTable">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Category Name</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if($categories): 
                    foreach ($categories as $index => $cat): ?>
                        <tr>
                            <td><?= $index + 1 ?></td>
                            <td><?= htmlspecialchars($cat['category']) ?></td>
                            <td>
                                <button class="btn btn-sm btn-warning edit-btn" 
                                    data-id="<?= $cat['id'] ?>" 
                                    data-name="<?= htmlspecialchars($cat['category']) ?>">
                                    Edit
                                </button>
                                <a href="?delete=<?= $cat['id'] ?>" 
                                   onclick="return confirm('Are you sure?')" 
                                   class="btn btn-sm btn-danger">
                                    Delete
                                </a>
                            </td>
                        </tr>
                    <?php endforeach;
                            endif;
                    ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Edit Modal -->
    <div class="modal fade" id="editCategoryModal" tabindex="-1">
      <div class="modal-dialog">
        <form method="POST" class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Edit Category</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
          </div>
          <div class="modal-body">
              <input type="hidden" name="id" id="editId">
              <input type="text" class="form-control" name="name" id="editName" required>
          </div>
          <div class="modal-footer">
            <button type="submit" name="update_category" class="btn btn-primary">Update</button>
          </div>
        </form>
      </div>
    </div>


<script>
    $(document).ready(function(){
        $('#categoryTable').DataTable();

        $('.edit-btn').click(function(){
            const id = $(this).data('id');
            const name = $(this).data('name');
            $('#editId').val(id);
            $('#editName').val(name);
            $('#editCategoryModal').modal('show');
        });
    });
</script>
