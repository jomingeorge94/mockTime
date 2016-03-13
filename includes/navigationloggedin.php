<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand page-scroll" href="#page-top">mockTime</a>
        </div>
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav">
                <li class="hidden">
                    <a class="page-scroll" href="#page-top"></a>
                </li>
                <li>
                    <a class="page-scroll" href="#about">About</a>
                </li>
                <li>
                    <a class="page-scroll" href="#services">FAQ</a>
                </li>
                <li>
                    <a class="page-scroll" href="#contact">Contact</a>
                </li>
                <li>
                    <a data-toggle="dropdown" href="#">Choose an Exam <b class="caret"></b></a>
                        <ul class="dropdown-menu">
                            <?php 
                              $sub = get_all_exam_status();

                                if ($sub!= null) {
                                    foreach($sub as $s ) {
                                        ?>  
                                            <li><a href="<?php echo generate_admin_link("start_exam", "id=" . ($s["quiz_id"]) . "&" . get_all_get_params(array("id"))); ?>"> <?php echo safe_output($s["quiz_name"]); ?></a></li>
                                        <?php 
                                    } 
                                } else {
                                    echo '<li><strong>Exams not available</strong></li>';
                                }
                            ?>
                        </ul>
                </li> 
            </ul>
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
    </div>
</nav>