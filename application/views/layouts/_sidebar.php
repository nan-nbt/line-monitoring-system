<!-- Session login check -->
<?php if($this->session->userdata('factory') == null && $this->session->userdata('username') == null){ redirect(base_url('users/Log')); } ?>

<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
  <!-- Brand Logo -->
  <a href="#" class="brand-link">
    <img src="<?php echo base_url(); ?>assets/dist/img/tl-logo.png" alt="TLS Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
    <span class="brand-text font-weight-light">Traffic Light System</span>
  </a>

  <!-- Sidebar -->
  <div class="sidebar">
    <!-- Sidebar user (optional) -->
    <!-- <div class="user-panel mt-3 pb-3 mb-3 d-flex">
      <div class="image">
        <img src="<?php echo base_url(); ?>assets/dist/img/avatar8.png" class="img-circle elevation-2" alt="User Image">
      </div>
      <div class="info">
        <a href="#" class="d-block"><?php echo $this->session->userdata('username'); ?></a>
      </div>
    </div> -->

    <!-- Sidebar Menu -->
    <nav class="mt-2">
      <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
        <!-- Add icons to the links using the .nav-icon class
              with font-awesome or any other icon font library -->
        <?php if($this->session->userdata('level') == 'S'): ?>
        <li class="nav-header">BASIC DATA SETTING</li>
        <li class="nav-item 
                  <?php 
                    if(base_url(uri_string()) == base_url('users/Section') || base_url(uri_string()) == base_url('users/Process'))
                      {
                        echo 'menu-open';
                      }
                  ?>">
          <a  href="#" 
              class="nav-link 
                    <?php 
                      if(base_url(uri_string()) == base_url('users/Section') || base_url(uri_string()) == base_url('users/Process'))
                        {
                          echo 'active';
                        }
                    ?>">
            <i class="nav-icon fas fa-cog"></i>
            <p>
              Basic Data
              <i class="fas fa-angle-left right"></i>
              <!-- <span class="badge badge-info right">5</span> -->
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a  href="<?php echo base_url('users/Section'); ?>" 
                  class="nav-link 
                        <?php 
                          if(base_url(uri_string()) == base_url('users/Section'))   
                            {
                              echo 'active';
                            }
                        ?>">
                <i class="far fa-circle nav-icon"></i>
                <p>Section/Line Data</p>
              </a>
            </li>
            <li class="nav-item">
              <a  href="<?php echo base_url('users/Process'); ?>" 
                  class="nav-link
                        <?php 
                          if(base_url(uri_string()) == base_url('users/Process'))   
                            {
                              echo 'active';
                            }
                        ?>">
                <i class="far fa-circle nav-icon"></i>
                <p>Step Process Data</p>
              </a>
            </li>
            <li class="nav-item">
              <a  href="<?php echo base_url('users/Defect'); ?>" 
                  class="nav-link
                        <?php 
                          if(base_url(uri_string()) == base_url('users/Defect'))   
                            {
                              echo 'active';
                            }
                        ?>">
                <i class="far fa-circle nav-icon"></i>
                <p>Defect List Data</p>
              </a>
            </li>
            <li class="nav-item">
              <a  href="<?php echo base_url('users/Suggest'); ?>" 
                  class="nav-link
                        <?php 
                          if(base_url(uri_string()) == base_url('users/Suggest'))   
                            {
                              echo 'active';
                            }
                        ?>">
                <i class="far fa-circle nav-icon"></i>
                <p>Suggestion List Data</p>
              </a>
            </li>
          </ul>
        </li>
        <?php endif; ?>
        <li class="nav-header">TRAFFIC LIGHT PROCESS</li>
        <?php if($this->session->userdata('level') == 'S' | $this->session->userdata('level') == 'U'): ?>
        <li class="nav-item">
          <a  href="<?php echo base_url('users/Collection'); ?>" 
              class="nav-link
                    <?php 
                      if(base_url(uri_string()) == base_url('users/Collection'))   
                        {
                          echo 'active';
                        }
                    ?>">
            <i class="nav-icon fas fa-database"></i>
            <p>Data Collection</p>
          </a>
        </li>
        <?php endif; ?>
        <li class="nav-item">
          <a  href="<?php echo base_url('users/Collection/visual'); ?>" 
              class="nav-link
              <?php 
                if(base_url(uri_string()) == base_url('users/Collection/visual') || 
                    base_url(uri_string()) == base_url('users/Collection/detail'))   
                  {
                    echo 'active';
                  }
              ?>">
            <i class="nav-icon fas fa-eye"></i>
            <p>Data Visualization</p>
          </a>
        </li>
        <li class="nav-header">REPORT</li>
        <li class="nav-item">
          <a  href="<?php echo base_url('users/Collection/report'); ?>" 
              class="nav-link
                    <?php 
                      if(base_url(uri_string()) == base_url('users/Collection/report'))   
                        {
                          echo 'active';
                        }
                    ?>">
            <i class="nav-icon fas fa-book"></i>
            <p>Data Collection Report</p>
          </a>
        </li>
        <li class="nav-item">
          <a  href="<?php echo base_url('users/Collection/hourly'); ?>" 
              class="nav-link
                    <?php 
                      if(base_url(uri_string()) == base_url('users/Collection/hourly'))   
                        {
                          echo 'active';
                        }
                    ?>">
            <i class="nav-icon fas fa-clock"></i>
            <p>Hourly Defect Report</p>
          </a>
        </li>
        <!-- <li class="nav-header">USER ACCOUNT</li>
        <li class="nav-item">
          <a href="<?php echo base_url('users/Log/logout'); ?>" class="nav-link" id="logout">
            <i class="nav-icon fas fa-user"></i>
            <p>Logout</p>
          </a>
        </li> -->
      </ul>
    </nav>
    <!-- /.sidebar-menu -->
  </div>
  <!-- /.sidebar -->
</aside>