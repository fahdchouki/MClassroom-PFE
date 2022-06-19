<?php 
  if(auth()->isLogged()){
    $userInfo = auth()->getSessUserInfo();
  }else{
    $userInfo = array(
      'username' => '',
      'name' => '',
      'school_subject' => '',
      'photo' => '',
    );
  }
  $page = trim($_SERVER['REQUEST_URI'],"/");
?>
<div class="container-scroller">
        <nav class="navbar default-layout-navbar col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
          <div class="text-center navbar-brand-wrapper d-flex align-items-center justify-content-center">
            <a class="navbar-brand brand-logo" href="<?php url() ?>"><img style="height: auto !important;" src="<?php echo BURL . "dashboard/assets/images/logo.png" ?>" alt="logo" /></a>
            <a class="navbar-brand brand-logo-mini" href="<?php url() ?>"><span style="color: #b66dff;font-weight:bold;">M</span></a>
          </div>
          <div class="navbar-menu-wrapper d-flex align-items-stretch">
            <button class="navbar-toggler navbar-toggler align-self-center" type="button" data-toggle="minimize">
              <span class="mdi mdi-menu"></span>
            </button>
            <ul class="navbar-nav navbar-nav-right">
              <li class="nav-item d-none d-lg-block full-screen-link">
                <a class="nav-link">
                  <i class="mdi mdi-fullscreen" id="fullscreen-button"></i>
                </a>
              </li>
              <?php if(auth()->isStudent()): ?>
                            <li class="nav-item dropdown">
                              <a class="nav-link count-indicator dropdown-toggle" id="notificationDropdown" href="#" data-bs-toggle="dropdown">
                                <i class="mdi mdi-bell-outline"></i>
                                <span class="count-symbol bg-danger" id="redPill" style="display: none;"></span>
                              </a>
                              <div class="dropdown-menu dropdown-menu-right navbar-dropdown preview-list" aria-labelledby="notificationDropdown">
                                <h6 class="p-3 mb-0">Notifications</h6>
                                <div class="dropdown-divider"></div>
                                <div id="notif-area">
                                 <p class="text-center pt-2"> No notifications for now </p>
                                </div>
                              </div>
                            </li>
              <?php endif ?>
              <li class="nav-item nav-logout d-none d-lg-block">
                <a class="nav-link" href="<?php url('auth/logout') ?>">
                  <i class="mdi mdi-power"></i>
                </a>
              </li>
            </ul>
            <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button" data-toggle="offcanvas">
              <span class="mdi mdi-menu"></span>
            </button>
          </div>
        </nav>
        <!-- partial -->
        <div class="container-fluid page-body-wrapper">
          <!-- partial:partials/_sidebar.html -->
          <nav class="sidebar sidebar-offcanvas" id="sidebar">
            <ul class="nav">
              <li class="nav-item nav-profile">
                <a href="<?php url('user/profile') ?>" class="nav-link">
                  <div class="nav-profile-image">
                    <img src="<?php echo BURL . "uploads/profiles/" . $userInfo['photo'] ?>" alt="profile">
                    <span class="login-status online"></span>
                    <!--change to offline or busy as needed-->
                  </div>
                  <div class="nav-profile-text d-flex flex-column">
                    <span class="font-weight-bold mb-2"><?= $userInfo['name'] ?></span>
                    <span class="text-secondary text-small"><?= $userInfo['school_subject'] ?? '' ?></span>
                  </div>
                  <!-- <i class="mdi mdi-bookmark-check text-success nav-profile-badge"></i> -->
                </a>
              </li>
              <li class="nav-item <?= $page == "" || $page == "home" || $page == "index" ? 'active' : '' ?>">
                <a class="nav-link <?= $page == "" || $page == "home" || $page == "index" ? 'active' : '' ?>" href="<?php url() ?>">
                  <span class="menu-title">Dashboard</span>
                  <i class="mdi mdi-home menu-icon"></i>
                </a>
              </li>
              <li class="nav-item <?= strpos($page,"group") !== false ? ' active ' : '' ?>">
                <a class="nav-link<?= strpos($page,"group") !== false ? ' active ' : '' ?>" data-bs-toggle="collapse" href="#group-area" aria-expanded="false" aria-controls="group-area">
                  <span class="menu-title">Groups</span>
                  <i class="menu-arrow"></i>
                  <i class="mdi mdi-wechat menu-icon"></i>
                </a>
                <div class="collapse<?= strpos($page,"group") !== false ? ' show ' : '' ?>" id="group-area">
                  <ul class="nav flex-column sub-menu">
                    <li class="nav-item<?= $page == "group" ? ' active ' : '' ?>"> <a class="nav-link<?= $page == "group" ? ' active ' : '' ?>" href="<?php url('group') ?>">Chats</a></li>
                    <?php if(auth()->isTeacher()) : ?>
                    <li class="nav-item<?= $page == "group/settings" ? ' active ' : '' ?>"> <a class="nav-link<?= $page == "group/settings" ? ' active ' : '' ?>" href="<?php url('group/settings') ?>">Manage Groups</a></li>
                    <?php endif ?>
                    <li class="nav-item<?= $page == "group/opened" ? ' active ' : '' ?>"> <a class="nav-link<?= $page == "group/opened" ? ' active ' : '' ?>" href="<?php url('group/opened') ?>">Open Groups</a></li>
                  </ul>
                </div>
              </li>
              <li class="nav-item<?= strpos($page,"task") !== false ? ' active ' : '' ?>">
                <a class="nav-link<?= strpos($page,"task") !== false ? ' active ' : '' ?>" data-bs-toggle="collapse" href="#task-area" aria-expanded="false" aria-controls="task-area">
                  <span class="menu-title">Tasks</span>
                  <i class="menu-arrow"></i>
                  <i class="mdi mdi-marker menu-icon"></i>
                </a>
                <div class="collapse<?= strpos($page,"task") !== false ? ' show ' : '' ?>" id="task-area">
                  <ul class="nav flex-column sub-menu">
                  <?php if(auth()->isTeacher()) : ?>
                      <li class="nav-item<?= $page == "task/create" ? ' active ' : '' ?>"> <a class="nav-link<?= $page == "task/create" ? ' active ' : '' ?>" href="<?php url('task/create') ?>">Create Task</a></li>
                  <?php endif ?>
                      <li class="nav-item<?= $page == "task" ? ' active ' : '' ?>"> <a class="nav-link<?= $page == "task" ? ' active ' : '' ?>" href="<?php url('task') ?>">Manage Tasks</a></li>
                  </ul>
                </div>
              </li>
              <?php if(auth()->isTeacher()) : ?>
              <li class="nav-item<?= strpos($page,"course") !== false ? ' active ' : '' ?>">
                <a class="nav-link" data-bs-toggle="collapse" href="#course-area" aria-expanded="false" aria-controls="course-area">
                  <span class="menu-title">Courses</span>
                  <i class="menu-arrow"></i>
                  <i class="mdi mdi-book-open-page-variant menu-icon"></i>
                </a>
                <div class="collapse<?= strpos($page,"course") !== false ? ' show ' : '' ?>" id="course-area">
                  <ul class="nav flex-column sub-menu">
                      <li class="nav-item<?= $page == "course/create" ? ' active ' : '' ?>"> <a class="nav-link<?= $page == "course/create" ? ' active ' : '' ?>" href="<?php url('course/create') ?>">Create Course</a></li>
                      <li class="nav-item<?= $page == "course" ? ' active ' : '' ?>"> <a class="nav-link<?= $page == "course" ? ' active ' : '' ?>" href="<?php url('course') ?>">Manage Courses</a></li>
                    </ul>
                  </div>
                </li>
                <?php endif ?>
                <?php if(auth()->isStudent()) : ?>
                  <li class="nav-item<?= $page == "course" ? ' active ' : '' ?>">
                    <a class="nav-link" href="<?php url('course') ?>">
                      <span class="menu-title">Courses</span>
                      <i class="mdi mdi-book-open-page-variant menu-icon"></i>
                    </a>
                  </li>
                <?php endif ?>
              <li class="nav-item<?= $page == "event" ? ' active ' : '' ?>">
                <a class="nav-link" href="<?php url('event') ?>">
                  <span class="menu-title">Events</span>
                  <i class="mdi mdi-calendar-multiple menu-icon"></i>
                </a>
              </li>
              <li class="nav-item<?= $page == "livechat" ? ' active ' : '' ?>">
                <a class="nav-link" href="<?php url('livechat') ?>">
                  <span class="menu-title">Live Chat</span>
                  <i class="mdi mdi-message-video menu-icon"></i>
                </a>
              </li>
            </ul>
          </nav>
          <!-- partial -->
            <div class="main-panel">