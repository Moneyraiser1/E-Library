<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Start session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Capture message if available
$message = isset($_SESSION['msg']) ? $_SESSION['msg'] : '';
$type = isset($_SESSION['msg_type']) ? $_SESSION['msg_type'] : ''; // "success" or "error"

// Clear the session message so it doesn’t show again on refresh
unset($_SESSION['msg']);
unset($_SESSION['msg_type']);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Email Verification</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/alertify.min.css"/>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/themes/default.min.css"/>
</head>
<body>

<!-- Optional content -->
<h2>Verifying Email...</h2>

<!-- AlertifyJS -->
<script src="https://cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/alertify.min.js"></script>

<script>
<?php if (!empty($message) && !empty($type)): ?>
    alertify.<?= $type ?>("<?= htmlspecialchars($message, ENT_QUOTES) ?>");
<?php endif; ?>
</script>

<!-- Optional redirect -->
<script>
    setTimeout(() => {
        window.location.href = "Library-management-system/auth/login";
    }, 3000);
</script>

</body>
</html>
