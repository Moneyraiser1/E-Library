<?php
include 'includes/header.php';
include 'includes/sidebar.php';
require_once __DIR__ . '/../Controller/Settings.php';
require_once __DIR__ . '/../Controller/Users.php';

$settingsObj = new Settings();
$users = new Users();
$settings = $settingsObj->getSettings();

// Initialize $user to avoid undefined variable warnings
$user = $settingsObj->getUserById($_SESSION['id']);

if(isset($_POST['update_profile'])){
    $users->changePassword($_SESSION['id'], $_POST['fname'],  $_POST['lname'],  $_POST['username'], $_POST['email'], $_POST['phone'],  $_POST['Oldpassword'],  $_POST['Newpass'],  $_POST['rpassword']);
    if($users === true){
        $_SESSION['msg'] = 'Admin details changed successfully';
        $_SESSION['msg_type'] = 'error';
        exit();
    }else{
          
    }
}   

if (isset($_POST['update_settings'])) {
    $library_name = trim($_POST['library_name']);
    $download_limit = 0;
    $logoName = null;

    if (isset($_FILES['logo']) && $_FILES['logo']['error'] === UPLOAD_ERR_OK) {
        $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
        $fileType = mime_content_type($_FILES['logo']['tmp_name']);
        $fileSize = $_FILES['logo']['size'];

        if (!in_array($fileType, $allowedTypes)) {
            $_SESSION['msg'] = 'Only JPG, PNG, and GIF files are allowed.';
            $_SESSION['msg_type'] = 'danger';
            header("Location: settings");
            exit;
        }

        if ($fileSize > 2 * 1024 * 1024) {
            $_SESSION['msg'] = 'File size must be under 2MB.';
            $_SESSION['msg_type'] = 'danger';
            header("Location: settings");
            exit;
        }

        $logoName = uniqid() . '_' . basename($_FILES['logo']['name']);
        $targetPath = __DIR__ . '/../uploads/' . $logoName;
        move_uploaded_file($_FILES['logo']['tmp_name'], $targetPath);
    }

    $settingsObj->updateSettings($library_name, $download_limit, $logoName);
    $settings = $settingsObj->getSettings();

    $_SESSION['msg'] = "Settings updated successfully.";
    $_SESSION['msg_type'] = "success";
     echo '<a id="redir" href="settings" style="display:none;">Redirect</a>';
            echo '<script>document.getElementById("redir").click();</script>';
    exit;
}

?>

<div class="container mt-4">
    <h4>👤 Admin Profile</h4>

    <?php if (isset($_SESSION['msg'])): ?>
        <div class="alert alert-<?= $_SESSION['msg_type'] ?>">
            <?= $_SESSION['msg'] ?>
        </div>
        <?php unset($_SESSION['msg'], $_SESSION['msg_type']); ?>
    <?php endif; ?>

    <!-- Admin Profile Form -->
    <form method="post" class="row g-3 mt-3">
        <div class="col-md-6">
            <label class="form-label">First Name</label>
            <input type="text" name="fname" class="form-control" value="<?= $user['fname'] ?>" required>
        </div>

        <div class="col-md-6">
            <label class="form-label">Last Name</label>
            <input type="text" name="lname" class="form-control" value="<?= $user['lname'] ?>" required>
        </div>

        <div class="col-md-6">
            <label class="form-label">Username</label>
            <input type="text" name="username" class="form-control" value="<?= $user['username'] ?>" required>
        </div>

        <div class="col-md-6">
            <label class="form-label">Email Address</label>
            <input type="email" name="email" class="form-control" value="<?= $user['email'] ?>" required>
        </div>

        <div class="col-md-6">
            <label class="form-label">Phone Number</label>
            <input type="number" name="phone" class="form-control" value="<?= $user['phone'] ?>" required>
        </div>

        <div class="col-md-6">
            <label class="form-label">Old Password</label>
            <div class="input-group">
                <input type="password" id="password" name="Oldpassword" class="form-control">
                <span class="input-group-text" onclick="togglePassword()" style="cursor: pointer;">
                    <img id="toggleIcon" src="../assets/images/eye-open.png" alt="Toggle Password" style="height: 18px;">
                </span>
            </div>
        </div>

        <div class="col-md-6">
            <label class="form-label">New Password</label>
            <div class="input-group">
                <input type="password" id="newPassword" name="Newpass" class="form-control">
                <span class="input-group-text" onclick="togglePassword2()" style="cursor: pointer;">
                    <img id="toggleIcon2" src="../assets/images/eye-open.png" alt="Toggle Password" style="height: 18px;">
                </span>
            </div>
        </div>

        <div class="col-md-6">
            <label class="form-label">Repeat Password</label>
            <div class="input-group">
                <input type="password" id="rpassword" name="rpassword" class="form-control">
                <span class="input-group-text" onclick="togglePassword3()" style="cursor: pointer;">
                    <img id="toggleIcon3" src="../assets/images/eye-open.png" alt="Toggle Password" style="height: 18px;">
                </span>
            </div>
        </div>

        <div class="col-12">
            <button type="submit" name="update_profile" class="btn btn-primary">Update Profile</button>
        </div>
    </form>

    <hr class="my-5">

    <!-- Library Settings Form -->
    <h4>📚 Library Settings</h4>

    <form method="post" enctype="multipart/form-data" class="row g-3 mt-3">
        <div class="col-md-6">
            <label class="form-label">Library Name</label>
            <input type="text" name="library_name" class="form-control" value="<?= $settings['library_name'] ?>" required>
        </div>

        <div class="col-md-6">
            <label class="form-label">Library Logo</label>
            <input type="file" name="logo" class="form-control">
            <?php if (!empty($settings['logo'])): ?>
                <img src="../uploads/<?= $settings['logo'] ?>" class="mt-2" style="height: 50px;" alt="Current Logo">
            <?php endif; ?>
        </div>

        <div class="col-12">
            <button type="submit" name="update_settings" class="btn btn-success">Update Library Settings</button>
        </div>
    </form>
</div>

<!-- Toggle Password Script -->
<script>
function togglePassword() {
    const input = document.getElementById("password");
    const icon = document.getElementById("toggleIcon");
    input.type = input.type === "password" ? "text" : "password";
    icon.src = input.type === "text" ? "../assets/images/eye-close.png" : "../assets/images/eye-open.png";
}

function togglePassword2() {
    const input = document.getElementById("newPassword");
    const icon = document.getElementById("toggleIcon2");
    input.type = input.type === "password" ? "text" : "password";
    icon.src = input.type === "text" ? "../assets/images/eye-close.png" : "../assets/images/eye-open.png";
}

function togglePassword3() {
    const input = document.getElementById("rpassword");
    const icon = document.getElementById("toggleIcon3");
    input.type = input.type === "password" ? "text" : "password";
    icon.src = input.type === "text" ? "../assets/images/eye-close.png" : "../assets/images/eye-open.png";
}
</script>
