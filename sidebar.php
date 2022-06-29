  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
      <!-- Brand Logo -->
      <a href="index3.html" class="brand-link">
          <img src="dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
          <span class="brand-text font-weight-light">Creative</span>
      </a>

      <!-- Sidebar -->
      <div class="sidebar">
          <!-- Sidebar user panel (optional) -->
          <div class="user-panel mt-3 pb-3 mb-3 d-flex">
              <div class="image">
                  <img src="dimg/admins/<?php echo $_SESSION['admins']['admins_file'] ?>" class="img-circle elevation-2" alt="User Image">
              </div>
              <div class="info">
                  <a href="#" class="d-block"><?php echo $_SESSION['admins']['admins_namesurname'] ?></a>
              </div>
          </div>

          <!-- Sidebar Menu -->
          <nav class="mt-2">
              <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                  <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
                  <li class="nav-header">Menüler</li>
                  <li class="nav-item ">
                      <a href="#" class="nav-link ">
                          <i class="nav-icon fa fa-key"></i>
                          <p>
                              Yönetim
                              <i class="right fas fa-angle-left "></i>
                          </p>
                      </a>
                      <ul class="nav nav-treeview">
                          <li class="nav-item">
                              <a href="users.php" class="nav-link">
                                  <i class="nav-icon fa fa-user"></i>
                                  <p>Kullanıcılar</p>
                              </a>
                          </li>
                          <li class="nav-item">
                              <a href="admins.php" class="nav-link">
                                  <i class="nav-icon fa fa-user"></i>
                                  <p>Yöneticiler</p>
                              </a>
                          </li>

                      </ul>
                  </li>

                  <li class="nav-header">EXAMPLES</li>
                  <li class="nav-item">
                      <a href="../calendar.html" class="nav-link">
                          <i class="nav-icon fa fa-key"></i>
                          <p>
                              Yönetim
                              <span class="badge badge-info right">2</span>
                          </p>
                      </a>
                  </li>


              </ul>
          </nav>
          <!-- /.sidebar-menu -->
      </div>
      <!-- /.sidebar -->
  </aside>