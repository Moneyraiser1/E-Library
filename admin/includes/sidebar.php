
<div class="container-fluid page-body-wrapper mt-2">
  <nav class="sidebar sidebar-offcanvas" id="sidebar" style="position: -webkit-sticky; position: sticky; top: 0; z-index: 1000; height: 100vh; overflow-y: auto;">
    <!-- Sidebar contents here -->

    <ul class="nav">
      <li class="nav-item nav-profile">
        <a href="#" class="nav-link">

          <div class="nav-profile-text d-flex flex-column">
            <span class="font-weight-bold mb-2"><?= $_SESSION['fname'] .' '. $_SESSION['lname'] ?></span>
            <span class="text-secondary text-small">Library Admin</span>
          </div>
          <i class="mdi mdi-bookmark-check text-success nav-profile-badge"></i>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="aDashboard">
          <span class="menu-title">Dashboard</span>
          <i class="mdi mdi-view-dashboard menu-icon"></i>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="libraryManagement">
          <span class="menu-title">Books Management</span>
          <i class="mdi mdi-library menu-icon"></i>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="category">
          <span class="menu-title">Category</span>
          <i class="mdi mdi-shape menu-icon"></i>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="userManagement">
          <span class="menu-title">User Management</span>
          <i class="mdi mdi-account-multiple menu-icon"></i>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="DownloadRecord">
          <span class="menu-title">Download Records</span>
          <i class="mdi mdi-book-open-variant menu-icon"></i>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="Reports">
          <span class="menu-title">Reports</span>
          <i class="mdi mdi-file-document menu-icon"></i>
        </a>
      <li class="nav-item">
        <a class="nav-link" href="Settings">
          <span class="menu-title">Settings</span>
          <i class="fa fa-gear menu-icon"></i>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="<?= APPURL ?>auth/logout" target="_blank">
          <span class="menu-title">Logout</span>
          <i class="mdi mdi-logout menu-icon"></i>
        </a>
      </li>
    </ul>
  </nav>
