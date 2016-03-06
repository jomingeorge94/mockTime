<aside class="main-sidebar">
        <!-- sidebar: style can be found in sidebar.less -->
        <section class="sidebar">
          <!-- Sidebar user panel -->
          <div class="user-panel">
            <div class="pull-left image">
              <?php echo '<img src="../', $user_data['profile_picture'], '" alt="', $user_data['first_name'], '\'s Profile Picture" class="img-circle" /> '; ?>        
            </div>
            <div class="pull-left info">
              <p><?php echo $user_data['first_name'];?>&nbsp;<?php echo $user_data['last_name'];?></p>
              <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
            </div>
          </div>
          <!-- search form -->
          <form action="#" method="get" class="sidebar-form">
            <div class="input-group">
              <input type="text" name="q" class="form-control" placeholder="Search...">
              <span class="input-group-btn">
                <button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i></button>
              </span>
            </div>
          </form>
          <!-- /.search form -->
          <!-- sidebar menu: : style can be found in sidebar.less -->
          <ul class="sidebar-menu">
            <li class="header">MAIN NAVIGATION</li>
            <li class="active treeview">
              <a href="admin_dashboard.php">
                <i class="fa fa-dashboard"></i> <span>Dashboard</span> 
              </a>
            </li>


            <li class="header">Manage</li>
            <li><a href="admin_manage_category.php"><i class="fa fa-cogs"></i> <span>Category Listing</span></a></li>
            <li><a href="admin_manage_exam.php"><i class="fa fa-cog"></i> <span>Exam Listing</span></a></li>
            <li><a href="#"><i class="fa fa-puzzle-piece"></i> <span>Add Exam</span></a></li>

           
          </ul>
        </section>
        <!-- /.sidebar -->
      </aside>