<?php include '../../core/session.php'; ?>
<?php admin_protect (); ?>

<?php if(isset($_SESSION['error']) AND ! empty($_SESSION['error'])): ?>
    <div class="col-sm-5 form-box">
        <div class ="alert alert-danger alert-dismissable">
            <button type="button" class="close" data-dismiss="alert"> <i class="fa fa-times-circle-o"></i> </button>  

            <?php
                foreach ($_SESSION['error'] as $e){
                    echo $e;
                }
                unset($_SESSION['error']);
            ?>   
        </div>
    </div> 
<?php endif; ?>




<div class="content-wrapper">
    <section class="content">
        <div class="login-box">
            <div class="login-logo">
                <a href="#"><b>Admin</b> Panel</a>
            </div><!-- /.login-logo -->
        


 <div class="lockscreen-wrapper">

      <!-- User name -->
      <div class="lockscreen-name"><?php echo $user_data['first_name'];?>&nbsp;<?php echo $user_data['last_name'];?></div>

      <!-- START LOCK SCREEN ITEM -->
      <div class="lockscreen-item">
        <!-- lockscreen image -->

        <div class="lockscreen-image">
          <?php echo '<img src="../', $user_data['profile_picture'], '" alt="', $user_data['first_name'], '\'s Profile Picture" /> '; ?>
        </div>

        <!-- lockscreen credentials (contains the form) -->
        <form method="post" action="admin_login.php" class="lockscreen-credentials">
            <input type="hidden" name="username" value="<?php echo $user_data['email_address'];?>">
          <div class="input-group">
            <input type="password" class="form-control" name="admin_password" placeholder="password">
            <div class="input-group-btn">
              <button class="btn"><i class="fa fa-arrow-right text-muted"></i></button>
            </div>
          </div>
        </form><!-- /.lockscreen credentials -->

      </div><!-- /.lockscreen-item -->
      <div class="help-block text-center">
        Enter your password to retrieve your session
      </div>

    </div><!-- /.center -->



        </div><!-- /.login-box -->
    </section><!-- /.content -->
</div><!-- /.content-wrapper -->