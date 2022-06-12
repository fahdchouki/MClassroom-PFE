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
?>
<div class="container-scroller">
        <nav class="navbar default-layout-navbar col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
          <div class="text-center navbar-brand-wrapper d-flex align-items-center justify-content-center">
            <a class="navbar-brand brand-logo" href="<?php url() ?>"><span style="color: #b66dff ;font-weight: bold;">M</span>Classroom</a>
            <a class="navbar-brand brand-logo-mini" href="<?php url() ?>"><span style="color: #b66dff ;font-weight: bold;">M</span>Classroom</a>
          </div>
          <div class="navbar-menu-wrapper d-flex align-items-stretch">
            <button class="navbar-toggler navbar-toggler align-self-center" type="button" data-toggle="minimize">
              <span class="mdi mdi-menu"></span>
            </button>
            <div class="search-field d-none d-md-block">
              <form class="d-flex align-items-center h-100" action="#">
                <div class="input-group">
                  <div class="input-group-prepend bg-transparent">
                    <i class="input-group-text border-0 mdi mdi-magnify"></i>
                  </div>
                  <input type="text" class="form-control bg-transparent border-0" placeholder="Search anything">
                </div>
              </form>
            </div>
            <ul class="navbar-nav navbar-nav-right">
              <li class="nav-item d-none d-lg-block full-screen-link">
                <a class="nav-link">
                  <i class="mdi mdi-fullscreen" id="fullscreen-button"></i>
                </a>
              </li>
              <li class="nav-item dropdown">
                <a class="nav-link count-indicator dropdown-toggle" id="messageDropdown" href="#" data-bs-toggle="dropdown" aria-expanded="false">
                  <i class="mdi mdi-email-outline"></i>
                  <span class="count-symbol bg-warning"></span>
                </a>
                <div class="dropdown-menu dropdown-menu-right navbar-dropdown preview-list" aria-labelledby="messageDropdown">
                  <h6 class="p-3 mb-0">Messages</h6>
                  <div class="dropdown-divider"></div>
                  <a class="dropdown-item preview-item">
                    <div class="preview-thumbnail">
                      <img src="<?php echo BURL . 'dashboard/' ?>assets/images/faces/face4.jpg" alt="image" class="profile-pic">
                    </div>
                    <div class="preview-item-content d-flex align-items-start flex-column justify-content-center">
                      <h6 class="preview-subject ellipsis mb-1 font-weight-normal">Mark send you a message</h6>
                      <p class="text-gray mb-0"> 1 Minutes ago </p>
                    </div>
                  </a>
                  <div class="dropdown-divider"></div>
                  <a class="dropdown-item preview-item">
                    <div class="preview-thumbnail">
                      <img src="<?php echo BURL . 'dashboard/' ?>assets/images/faces/face2.jpg" alt="image" class="profile-pic">
                    </div>
                    <div class="preview-item-content d-flex align-items-start flex-column justify-content-center">
                      <h6 class="preview-subject ellipsis mb-1 font-weight-normal">Cregh send you a message</h6>
                      <p class="text-gray mb-0"> 15 Minutes ago </p>
                    </div>
                  </a>
                  <div class="dropdown-divider"></div>
                  <a class="dropdown-item preview-item">
                    <div class="preview-thumbnail">
                      <img src="<?php echo BURL . 'dashboard/' ?>assets/images/faces/face3.jpg" alt="image" class="profile-pic">
                    </div>
                    <div class="preview-item-content d-flex align-items-start flex-column justify-content-center">
                      <h6 class="preview-subject ellipsis mb-1 font-weight-normal">Profile picture updated</h6>
                      <p class="text-gray mb-0"> 18 Minutes ago </p>
                    </div>
                  </a>
                  <div class="dropdown-divider"></div>
                  <h6 class="p-3 mb-0 text-center">4 new messages</h6>
                </div>
              </li>
              <li class="nav-item dropdown">
                <a class="nav-link count-indicator dropdown-toggle" id="notificationDropdown" href="#" data-bs-toggle="dropdown">
                  <i class="mdi mdi-bell-outline"></i>
                  <span class="count-symbol bg-danger"></span>
                </a>
                <div class="dropdown-menu dropdown-menu-right navbar-dropdown preview-list" aria-labelledby="notificationDropdown">
                  <h6 class="p-3 mb-0">Notifications</h6>
                  <div class="dropdown-divider"></div>
                  <a class="dropdown-item preview-item">
                    <div class="preview-thumbnail">
                      <div class="preview-icon bg-success">
                        <i class="mdi mdi-calendar"></i>
                      </div>
                    </div>
                    <div class="preview-item-content d-flex align-items-start flex-column justify-content-center">
                      <h6 class="preview-subject font-weight-normal mb-1">Event today</h6>
                      <p class="text-gray ellipsis mb-0"> Just a reminder that you have an event today </p>
                    </div>
                  </a>
                  <div class="dropdown-divider"></div>
                  <a class="dropdown-item preview-item">
                    <div class="preview-thumbnail">
                      <div class="preview-icon bg-warning">
                        <i class="mdi mdi-settings"></i>
                      </div>
                    </div>
                    <div class="preview-item-content d-flex align-items-start flex-column justify-content-center">
                      <h6 class="preview-subject font-weight-normal mb-1">Settings</h6>
                      <p class="text-gray ellipsis mb-0"> Update dashboard </p>
                    </div>
                  </a>
                  <div class="dropdown-divider"></div>
                  <a class="dropdown-item preview-item">
                    <div class="preview-thumbnail">
                      <div class="preview-icon bg-info">
                        <i class="mdi mdi-link-variant"></i>
                      </div>
                    </div>
                    <div class="preview-item-content d-flex align-items-start flex-column justify-content-center">
                      <h6 class="preview-subject font-weight-normal mb-1">Launch Admin</h6>
                      <p class="text-gray ellipsis mb-0"> New admin wow! </p>
                    </div>
                  </a>
                  <div class="dropdown-divider"></div>
                  <h6 class="p-3 mb-0 text-center">See all notifications</h6>
                </div>
              </li>
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
              <li class="nav-item">
                <a class="nav-link" href="<?php url() ?>">
                  <span class="menu-title">Dashboard</span>
                  <i class="mdi mdi-home menu-icon"></i>
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link" data-bs-toggle="collapse" href="#group-area" aria-expanded="false" aria-controls="group-area">
                  <span class="menu-title">Groups</span>
                  <i class="menu-arrow"></i>
                  <i class="mdi mdi-wechat menu-icon"></i>
                </a>
                <div class="collapse" id="group-area">
                  <ul class="nav flex-column sub-menu">
                    <li class="nav-item"> <a class="nav-link" href="<?php url('group') ?>">Chats</a></li>
                    <?php if(auth()->isTeacher()) : ?>
                    <li class="nav-item"> <a class="nav-link" href="<?php url('group/settings') ?>">Manage Groups</a></li>
                    <?php endif ?>
                    <li class="nav-item"> <a class="nav-link" href="<?php url('group/opened') ?>">Open Groups</a></li>
                  </ul>
                </div>
              </li>
              <li class="nav-item">
                <a class="nav-link" data-bs-toggle="collapse" href="#course-area" aria-expanded="false" aria-controls="course-area">
                  <span class="menu-title">Courses</span>
                  <i class="menu-arrow"></i>
                  <i class="mdi mdi-book-open-page-variant menu-icon"></i>
                </a>
                <div class="collapse" id="course-area">
                  <ul class="nav flex-column sub-menu">
                  <?php if(auth()->isTeacher()) : ?>
                      <li class="nav-item"> <a class="nav-link" href="<?php url('course/create') ?>">Create Course</a></li>
                      <?php endif ?>
                      <li class="nav-item"> <a class="nav-link" href="<?php url('course/settings') ?>">Manage Courses</a></li>
                      <li class="nav-item"> <a class="nav-link" href="<?php url('course/opened') ?>">Open Courses</a></li>
                  </ul>
                </div>
              </li>
              <li class="nav-item">
                <a class="nav-link" data-bs-toggle="collapse" href="#task-area" aria-expanded="false" aria-controls="task-area">
                  <span class="menu-title">Tasks</span>
                  <i class="menu-arrow"></i>
                  <i class="mdi mdi-marker menu-icon"></i>
                </a>
                <div class="collapse" id="task-area">
                  <ul class="nav flex-column sub-menu">
                  <?php if(auth()->isTeacher()) : ?>
                      <li class="nav-item"> <a class="nav-link" href="<?php url('task/create') ?>">Create Task</a></li>
                  <?php endif ?>
                      <li class="nav-item"> <a class="nav-link" href="<?php url('task/settings') ?>">Manage Tasks</a></li>
                      <li class="nav-item"> <a class="nav-link" href="<?php url('task/opened') ?>">Open Tasks</a></li>
                  </ul>
                </div>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="<?php url('event') ?>">
                  <span class="menu-title">Events</span>
                  <i class="mdi mdi-calendar-multiple menu-icon"></i>
                </a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="<?php url('livechat') ?>">
                  <span class="menu-title">Live Chat</span>
                  <i class="mdi mdi-message-video menu-icon"></i>
                </a>
              </li>
            </ul>
          </nav>
          <!-- partial -->
            <div class="main-panel">