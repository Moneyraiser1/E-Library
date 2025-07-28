<?php 
  define('APPURL', 'http://localhost/Library-management-system/');
  session_start();
  if (!isset($_SESSION['id']) || !isset($_SESSION['fname'])) {
      header('Location: ../../Library-management-system/auth/login');
      exit;
  }
  if (isset($_SESSION['role_as']) && $_SESSION['role_as'] === 'admin') {
  header('Location: ../../Library-management-system/admin/aDashboard');
  exit;
}
  include __DIR__.'/../../Controller/Category.php';
        require_once __DIR__ . '/../../Controller/Settings.php';
      require_once __DIR__ . '/../../Controller/Users.php';
      require_once __DIR__ . '/../../Controller/Book.php';
      $book = new Book;
      $settingsObj = new Settings();
      $users = new Users();
      $settings = $settingsObj->getSettings();
      $user = $settingsObj->getUserById($_SESSION['id']);

  $categoryController = new Category();
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (isset($_POST['add_category'])) {
          $catResult = $categoryController->InsertCat($_POST['name']);
            if($catResult === true){
                $_SESSION['msg'] = 'Category Inserted successfully';
                $_SESSION['msg_type'] = 'success';
                 header("Location: category");
            }else{
              $catResult;
            }

        }
    if (isset($_POST['update_category'])) {
        $categoryController->editCat($_POST['id'], $_POST['name']);
        $_SESSION['msg'] = 'Category Inserted successfully';
        $_SESSION['msg_type'] = 'success';
    }
    require_once __DIR__ . '/../../Controller/DownloadRecord.php';
$download = new DownloadRecord();


    
}
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Purple Admin</title>
    <!-- plugins:css -->
    <link rel="stylesheet" href="<?= APPURL ?>admin/includes/assets/vendors/mdi/css/materialdesignicons.min.css">
    <link rel="stylesheet" href="<?= APPURL ?>admin/includes/assets/vendors/ti-icons/css/themify-icons.css">
    <link rel="stylesheet" href="<?= APPURL ?>admin/includes/assets/vendors/css/vendor.bundle.base.css">
    <link rel="stylesheet" href="<?= APPURL ?>admin/includes/assets/vendors/font-awesome/css/font-awesome.min.css">
    <!-- endinject -->
    <!-- Plugin css for this page -->
    <link rel="stylesheet" href="<?= APPURL ?>admin/includes/assets/vendors/bootstrap-datepicker/bootstrap-datepicker.min.css">
    <!-- End plugin css for this page -->
    <!-- inject:css -->
    <!-- endinject -->
    <!-- Layout styles -->
    <link rel="stylesheet" href="<?= APPURL ?>admin/includes/assets/css/style.css">
    <!-- End layout styles -->
    <link rel="shortcut icon" href="<?= APPURL ?>admin/includes/assets/images/favicon.png" />
    <link rel="stylesheet" href="<?= APPURL?>assets/css/alertify.min.css"/>
    <link rel="stylesheet" href="<?= APPURL?>assets/css/default.min.css"/>
    <!-- Custom CSS -->
    <link rel="stylesheet" href="<?= APPURL?>assets/css/styles.css">
        <!-- jQuery -->
    <script src="<?= APPURL?>assets/js/jquery/jquery.min.js"></script>
    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <!-- Select2 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />


    <!-- Bootstrap JS -->
    <script src="<?= APPURL?>assets/js/bootstrap.min.js"></script>
    <!-- Alertify JS -->
    <script src="<?= APPURL?>assets/js/alertify.min.js"></script>
    <!-- Select2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script>
      $(document).ready(function() {
        $('.select2').select2({
          placeholder: "Select a category",
          allowClear: true
        });
        $('#categoryTable').DataTable();
        $('#bookTable').DataTable();
      });
    </script>
  </head>
  <body>
    <?php include __DIR__.'/navbar.php'; ?>
    <?php include __DIR__.'/../../includes/alertify.php'; ?>
