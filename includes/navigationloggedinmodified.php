<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
        <div class="container">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand page-scroll" href="index.php">mockTime</a>
            </div>
            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                
            <ul class="nav navbar-right navbar-nav user-settings">
            <li class="dropdown">
              <a data-toggle="dropdown" class="dropdown-toggle" href="#"><span class="glyphicon glyphicon-user"></span> <?php echo $user_data['first_name'];?> <?php echo $user_data['last_name'];?> <b class="caret"></b></a>
              <ul class="dropdown-menu">
                <li><a href="userprofile.php">User Profile</a></li>
                <li class="divider"></li>
                <li><a href="profile.php">Change Password</a></li>
                <li class="divider"></li>
                <li><a href="logout.php"><span class="glyphicon glyphicon-off"></span> Logout</a></li>
              </ul>
            </li>
          </ul>
                    

              
                

              

                



            </div>

            <!-- /.navbar-collapse -->
        </div>
        <!-- /.container -->
    </nav>



    