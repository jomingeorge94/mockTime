<?php include '../../core/session.php'; ?>
<?php admin_protect (); ?>

<aside class="main-sidebar">
    <section class="sidebar">
        <form action="#" method="get" class="sidebar-form">
            <div class="input-group">
                <input type="text" name="q" class="form-control" placeholder="Search...">
                    <span class="input-group-btn">
                        <button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i></button>
                    </span>
            </div>
        </form>
        <ul class="sidebar-menu">
            <li class="header">Admin Panel</li>
            <!-- Optionally, you can add icons to the links -->
            <li class="treeview">
            <a href="#"><i class="fa fa-briefcase"></i> <span>Products</span> <i class="fa fa-angle-left pull-right"></i></a>
                <ul class="treeview-menu">
                    <li><a href="#"><i class="fa fa-question-circle"></i> Quizzes</a></li>
                    <li><a href="#"><i class="fa fa-bug"></i> Reports</a></li>
                    <li><a href="#"> <i class="fa fa-compress"></i>Polls</a></li>
                </ul>
            </li>
            <li><a href="#"><i class="fa fa-question"></i> <span>FAQ</span></a></li>
            <li><a href="#"><i class="fa fa-info"></i> <span>About Us</span></a></li>
            <li><a href="..#contact"><i class="fa fa-phone-square"></i> <span>Contact Us</span></a></li>
        </ul>

    </section>
</aside>