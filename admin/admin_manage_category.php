<!DOCTYPE html>
<html>

  <?php include '../core/session.php'; ?>
  <?php admin_protect (); ?>
  <?php

    if(($user_data['admin_password_check']) == 1){
    } else {
      header('Location: /mocktime/admin');
    }

  ?>
  
  <?php include '/includes/admin_dashboard_usersregisteres_header.php'; ?>
  <?php include '/includes/admin_dashboard_header.php'; ?>

<body class="hold-transition skin-blue sidebar-mini">
  <div class="wrapper">

    <?php include '/includes/admin_header_profile.php';?>
      <!-- Left side column. contains the logo and sidebar -->
    <?php include '/includes/admin_side_navigation.php';?>

    <div class="content-wrapper">
      <section class="content-header">
        <h1>
          Manage
          <small>Category Listing</small>
        </h1>
        <ol class="breadcrumb">
          <li><a href="admin_dashboard.php"><i class="fa fa-home"></i> Home</a></li>
          <li><a href="admin_dashboard.php"><i class="fa fa-dashboard"></i> Dashboard</a></li>
          <li class="active">Category Listing</li>
        </ol>
      </section>

        <?php
        
          $counterboy = 0;

          if (isset($_POST['freezechecked'])) {
            foreach ($_POST['freezechecked'] as $freeze){
              if($freeze == "On")
                set_category_active($_POST['id'][$counterboy]);
              else
                unset_category_active($_POST['id'][$counterboy]); 

              $counterboy++;
            }
          }


        ?>

        <section class="content">

          <form method="post" action="">




              <table class="table table-hover table-datatable table-striped table-bordered">

                  <thead>
                      <tr>
                          <th style="text-align: left;">Category Name</th>
                          <th style="text-align: left;">Active</th>
                          <th style="text-align: left;">Action</th>
                          
                      </tr>
                  </thead>


                  <tbody>
                    <?php foreach (get_all_categories() as $r) { ?>
                      
                      <tr>
                          <td style="text-align: left;"><?php echo $r['category_name'] ?></td> 

                          
                          <td style="text-align: left;">

                              <?php 
                                if ($r['status'] == 0) { 
                                    echo '<div class="example">
                                     <input id="freezechecked" type="hidden" value="Off" name="freezechecked[]">
                                    <input type="checkbox" id="toggle-event" class="freeze" name="freezerchecked[]" value="Off" unchecked data-toggle="toggle">
                                    <input type="hidden" value="'. $r['category_id'] .'" name="id[]">
                                  </div>';
                                } 
                                else {
                                    echo '<div class="example">
                                    <input id="freezechecked" type="hidden" value="On" name="freezechecked[]">
                                    <input type="checkbox" id="toggle-event" class="freeze" name="freezerchecked[]" value="On" checked data-toggle="toggle">
                                    <input type="hidden" value="'. $r['category_id'] .'" name="id[]">

                                  </div>';
                                }
                              ?>
                          </td>

                          <td style="text-align: left;">

                              <?php

                                 echo '<button type="button" class="btn btn-warning  edit-category"><i class="fa fa-pencil-square-o"></i> Edit</a></button> 
                                        <input type="hidden" value="'. $r['category_id'] .'"  name="delete[]">&nbsp';

                                 echo '<button type="button" class="btn btn-danger  delete delete-category"><i class="fa fa-trash-o fa-lg"></i> Delete</a></button> 
                                        <input type="hidden" value="'. $r['category_id'] .'"  name="delete[]">'; 
                              ?>

                          </td>
                      </tr>
                    <?php } ?>

                  </tbody>
              </table>   
              <button type="button" class="btn btn-success  add-category"> <i class="fa fa-plus-circle"></i> Add Category</a></button>
              <input type="submit" class="btn btn-success update-button" name="formSubmit" id="formSubmit" value="Update" />


          </form> 

          <?php if (get_all_categories() == null) {
            echo '<h3>No records found in the database.</h3>';
          } ?>


        </section><!-- /.content -->
    </div><!-- /.content-wrapper -->
  

  <?php include '/includes/footer.php'; ?> 

  <script src="dist/js/bootstrap-toggle.js"></script>

  <script>

  //checkbox toggle on and off
  $(document).ready(function(){
     $(document).on('click.bs.toggle', 'div[data-toggle^=toggle]', function(e) {
      var $checkbox = $(this).find('input[type=checkbox]').parent().parent();

      if($checkbox[0].childNodes[1].value == "On")
        $checkbox[0].childNodes[1].value = "Off";
      else
        $checkbox[0].childNodes[1].value = "On";
    })
  });

  //delete button
  var id;
  $('button.delete-category').click(function(e) {
    id = $(this).parent()[0].childNodes[3].value;
      swal({
    title: "Are you sure?",
    text: " You will not be able to undo this action !",
    type: "warning",
    showCancelButton: true,
    confirmButtonColor: "#DD6B55",
    confirmButtonText: "Yes, delete it!",
    closeOnConfirm: false,
    html: false
  }, function(){
    $.post( "delete_category.php", { deletecategoryfunction: id}, function( data ) {
    location.reload();
  });
  });
    });


  //edit button
  var id;
  var userInput;

  $('button.edit-category').click(function(e) {
    id = $(this).parent()[0].childNodes[3].value;
      swal({   title: "Modify category name",   
        text: "Change the category name :",   
        type: "input",   
        showCancelButton: true,   
        closeOnConfirm: false,   
        animation: "slide-from-top",   
        inputPlaceholder: "Category name"
      }, 
        function(inputValue){   
          if (inputValue === false) return false;      
          if (inputValue === "") {     
            swal.showInputError("You need to write something!");     
            return false   }      
            swal("Successfully Changed!", "Category name : " + inputValue, "success"); 
            userInput = inputValue;
            $.post( "edit_category_name.php", { editcategory: id, edituservalue: userInput}, function( data ) {
              setTimeout(function () { location.reload(1); }, 1000);
            });

          }
      );
  });



//add category button
  var id;
  var userInput;

  $('button.add-category').click(function(e) {
    id = $(this).parent()[0].childNodes[3].value;
      swal({   title: "Add category",   
        text: "Category name : ",   
        type: "input",    
        showCancelButton: true,   
        closeOnConfirm: false,   
        animation: "slide-from-top",   
        inputPlaceholder: "Category name"
      }, 
        function(inputValue){   
          if (inputValue === false) return false;      
          if (inputValue === "") {     
            swal.showInputError("You need to write something!");     
            return false   }      
            swal("Successfully Added!", "Category name : " + inputValue, "success"); 
            userInput = inputValue;

            $.post( "add_category.php", { editcategory: id, edituservalue: userInput}, function( data ) {
              setTimeout(function () { location.reload(1); }, 1000);
            });

          }
      );
  });





  </script>

  <?php include '/includes/admin_dashboard_scripts.php'; ?>

</body>
</html>