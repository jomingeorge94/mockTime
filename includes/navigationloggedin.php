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
                    <select class="form-control choose-exam" name="exam_category" onchange="run()" id="exam_category">
                      <option value="">Choose an Exam</option>
                      <?php
                      foreach (get_all_exam() as $exam) {
                        
                        echo '<option value="' . $exam["quiz_id"] . '"  >' . $exam["quiz_name"] . '</option>';
                        
                      }
                      ?>
                    </select>
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

 <script type="text/javascript">
    function run() {
        var value = document.getElementById("exam_category").value;
        alert(value);
    }
</script>