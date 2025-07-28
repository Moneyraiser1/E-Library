<?php
include_once __DIR__ . '/includes/header.php';
require_once __DIR__ . '/../Controller/Users.php';
require_once __DIR__ . '/../Controller/Settings.php';
$users = new Users();
// Initialize $user to avoid undefined variable warnings

$settingsObj = new Settings();
$user = $settingsObj->getUserById($_SESSION['id']);
    if(isset($_POST['update_profile'])){
    $users->changePassword($_SESSION['id'], $_POST['fname'],  $_POST['lname'],  $_POST['username'], $_POST['email'], $_POST['phone'],  $_POST['Oldpassword'],  $_POST['Newpass'],  $_POST['rpassword']);
    if($users === true){
        $_SESSION['msg'] = 'Details changed successfully';
        $_SESSION['msg_type'] = 'error';
        exit();
    }else{
        $_SESSION['msg'] = ''.$users.'';
        $_SESSION['msg_type'] = 'error';
        exit();
    }
}   
?>
<div class="container mt-5 p-4">
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
</div>
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
