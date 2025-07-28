<?php 
 include 'includes/header.php';
 include 'includes/sidebar.php'; 
require_once __DIR__.'/../Controller/Users.php';
$users = new Users();

 $userDetails = $users->showUsers();
?>
<div class="container mt-5">
 <!-- view registered users
 delete users
 user book downloading history -->
  <!-- Category Table -->
    <div class="card">
        <div class="row">
            <div class="col-md-8">
            <table class="table table-bordered table-hover" id="categoryTable">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Full name</th>
                        <th>UserName</th>
                        <th>Email</th>
                        <th>Phone Number</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if($userDetails): 
                    foreach ($userDetails as $index => $singleUser): ?>
                        <tr>
                            <td><?= $index + 1 ?></td>
                            <td><?= htmlspecialchars($singleUser['fname']) . ' ' .htmlspecialchars($singleUser['lname']) ?></td>
                            <td><?= htmlspecialchars($singleUser['username']) ?></td>
                            <td><?= htmlspecialchars($singleUser['email']) ?></td>
                            <td><?= htmlspecialchars($singleUser['phone']) ?></td>

                            <td>
                                <button class="btn btn-sm btn-primary edit-btn" 
                                    data-id="<?= $singleUser['id'] ?>" 
                                    data-name="<?= htmlspecialchars($singleUser['username']) ?>"
                                    data-email="<?= htmlspecialchars($singleUser['email']) ?>"
                                    data-phone="<?= htmlspecialchars($singleUser['phone']) ?>"
                                    data-address="<?= htmlspecialchars($singleUser['address']) ?>">
                                    <span><i class="fa fa-eye"></i></span>
                                </button>
                                <a class="btn btn-sm btn-success edit-btn"  href="DownloadRecord?id=<?= $singleUser['id'] ?>">Download Record</a>
                                <a href="?delete=<?= $singleUser['id'] ?>" 
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
    </div>

<!-- View User Details Modal -->
<div class="modal fade" id="editCategoryModal" tabindex="-1" aria-labelledby="editCategoryModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content bg-dark text-white">
      <div class="modal-header border-0">
        <h5 class="modal-title" id="editCategoryModalLabel">👤 User Details</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <div class="modal-body">
        <form>
          <input type="hidden" name="id" id="editId">

          <div class="mb-3">
            <label for="editName" class="form-label">Full Name</label>
            <input type="text" class="form-control" name="name" id="editName" readonly>
          </div>

          <div class="mb-3">
            <label for="editemail" class="form-label">Email</label>
            <input type="text" class="form-control" name="email" id="editemail" readonly>
          </div>

          <div class="mb-3">
            <label for="editphone" class="form-label">Phone</label>
            <input type="text" class="form-control" name="phone" id="editphone" readonly>
          </div>

          <div class="mb-3">
            <label for="editaddress" class="form-label">Address</label>
            <textarea class="form-control" name="address" id="editaddress" rows="2" readonly></textarea>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<script>
$(document).ready(function(){
    $('#categoryTable').DataTable();

    $('.edit-btn').click(function(){
        const id = $(this).data('id');
        const name = $(this).data('name');
        const email = $(this).data('email');
        const phone = $(this).data('phone');
        const address = $(this).data('address');

        $('#editId').val(id);
        $('#editName').val(name);
        $('#editemail').val(email);
        $('#editphone').val(phone);
        $('#editaddress').val(address);

        $('#editCategoryModal').modal('show');
    });
});
</script>


</div>