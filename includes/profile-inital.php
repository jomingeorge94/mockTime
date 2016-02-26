

<!-- Page Content -->
    <div class="container">

        <div class="row">
            <div class="col-lg-12 text-left">
         
<div class="panel panel-default manageprofile">
        <div class="panel-heading"><span class="glyphicon glyphicon-edit"></span><strong class="profiletitle">Manage Profile</strong></div>
            <div class="panel-body">

                

                <form>

                <div class="form-group row">
                    <label for="inputEmail3" class="col-sm-3 form-control-label">First Name: </label>
                        <div class="col-sm-7">
                            <input type="text" value ="<?php echo $user_data['first_name'];?>" class="form-control" id="inputEmail3" placeholder="First Name">
                        </div>
                  </div>

                  <div class="form-group row">
                    <label for="inputEmail3" class="col-sm-3 form-control-label">Last Name: </label>
                        <div class="col-sm-7">
                            <input type="text" value ="<?php echo $user_data['last_name'];?>" class="form-control" id="inputEmail3" placeholder="Last Name">
                        </div>
                  </div>

                  <div class="form-group row">
                    <label for="inputEmail3" class="col-sm-3 form-control-label">Email: </label>
                        <div class="col-sm-7">
                            <input type="email" value ="<?php echo $user_data['email_address'];?>" class="form-control" id="inputEmail3" placeholder="Email Address">
                        </div>
                  </div>

                 
                 <div class="form-group row mutedtext">
                     <small class="text-muted">
                    Leave password blank if you don't want to update it
                     </small>
                  </div>


                  <div class="form-group row password">
                    <label for="inputPassword3" class="col-sm-3 form-control-label">Old Password: </label>
                        <div class="col-sm-7">
                            <input type="password" class="form-control" id="inputPassword3" placeholder="Password">
                        </div>
                  </div>

                  <div class="form-group row password">
                  <label for="inputPassword3" class="col-sm-3 form-control-label">New Password: </label>
                        <div class="col-sm-7">

                            <input type="password" class="form-control" id="inputPassword3" placeholder="Password">
                        </div>
                  </div>

                  <div class="form-group row password">
                    <label for="inputPassword2" class="col-sm-3 form-control-label">Confirm Password: </label>
                        <div class="col-sm-7">
                            <input type="password" class="form-control" id="inputPassword3" placeholder="Password">
                        </div>
                  </div>


                  <div class="form-group row">
                    <div class="col-sm-offset-3 col-sm-10">
                      <button type="submit" class="btn btn-secondary">Submit</button>
                    </div>
                  </div>

                </form>

            </div>
    </div>




            </div>
        </div>
    </div>