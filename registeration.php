<?PHP require_once("connection.php"); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="css/bootstrap.min.css"/>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/bootstrap.bundle.min.js"></script>
    <script src="js/jquery-3.7.1.js"></script>
</head>
<?php

   if(isset($_POST['submit'])){
    $error = array();
     extract($_POST);

     if(empty($username)){
      $error['name'] = "Name is Required";
     }

     if(empty($email)){
      $error['email'] = "Email is Required";
     }else{
     
      $sql = "Select * from students where email = '". $email ."'";
      $data = mysqli_query($conn,$sql);
      $row_count = $data->num_rows;
      if($row_count > 0){
        $error['email_exist'] = "this email is already exists";
      }
     }

     if(empty($password)){
      $error['password'] = "Password is Required";
     }
     if(empty($c_password)){
      $error['c_password'] = "Confirm Password is Required";
     }
     if(empty($contact)){
      $error['contact'] = "Contact is Required";
     }
     if(empty($dob)){
      $error['dob'] = "Date of Birth is Required";
     }
     if(empty($gender)){
      $error['gender'] = "Gender is Required";
     }
     if(empty($city)){
      $error['city'] = "city is Required";
     }
     if(empty($country)){
      $error['country'] = "country is Required";
     }
     if($password != $c_password){
      $error['match'] = "passowrd not matched";
     }else{
      $password = md5($password);
     }

     //echo "<pre>";print_r($_FILES['image']);die;
     $image_name = $_FILES['image']['name'];
     $image_tmp_name = $_FILES['image']['tmp_name'];
     $image_size = $_FILES['image']['size'];
     $image_type = $_FILES['image']['type'];
     
     if($image_type != "image/jpg" && $image_type != "image/jpeg" && $image_type != "image/png" && $image_type != "image/gif"){
      $error['image_type'] = "image accept jpeg,jpg, png, gif";
     }

     if($image_size > 1000000){
      $error['image_size'] = "image size must be less than 1MB";
     }


     if(empty($error)){
      $image_name = time().'-'.$image_name;
      unset($sql);
      unset($data);
      $sql = "INSERT INTO students (Name, email, password, contact, dob, gender, city, country, profile) VALUES ('". $username ."', '". $email ."', '". $password ."', '". $contact ."', '". $dob ."', '". $gender ."', '". $city ."', '". $country ."', '". $image_name ."')";
      
      $data = mysqli_query($conn,$sql);
      if(!$data){
        die('Error'. $conn->error);
      }else{
        if(!move_uploaded_file($image_tmp_name,'image/'.$image_name)){
          $error['file_upload'] = "file not uploaded"; 
        }else{
          $msg = "Profile has been registered";
        }
        
      }
     }



   }


?>

<body>
  <?php
  if(!empty($msg)){ ?>
    <div class="alert alert-success alert-dismissible">
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
  <strong>Success!</strong><?php echo $msg; ?>
</div>
 <?php  }

if(!empty($error)){ ?>
  <div class="alert alert-danger alert-dismissible">
  <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
  <h3><strong>Error!</strong></h3>
   <?php foreach($error as $data) { ?>
    <?php echo $data."<br>";  ?>
   <?php } ?> 
</div>
<?php } ?>
    <div class="container mt-3">
        <p class="h4 bg-dark text-white mt-3 text-center rounded p-2">Registeration Form</p>
        <form action="" method="POST" enctype="multipart/form-data" class="bg-light rounded">
            Name<span>*</span><input type="text" id="username" name="username" class="form-control">
            <span id="username_err"></span><br>
            Email<span>*</span><input type="email" id="email" name="email" class="form-control">
            <span id="email_err"></span><br>
            Password<span>*</span><input type="password" id="password" name="password" class="form-control">
            <span id="password_err"></span><br>
            Confirm Password<span>*</span><input type="password" id="c_password" name="c_password" class="form-control">
            <span id="c_password_err"></span><br>
            Contact<span>*</span><input type="number" id="contact" name="contact" class="form-control">
            <span id="contact_err"></span><br>
            Date of Birth<span>*</span><input type="date" id="dob" name="dob" class="form-control">
            <span id="dob_err"></span><br>
            Gender<span>*</span><input type="radio" name="gender" id="male" value="male"> Male
            <input type="radio" name="gender" id="female" value="female"> Female <br>
            <span id="gender_err"></span><br>
            City<span>*</span><select name="city" id="city" class="form-control">
                <option value="">Select</option>
                <option value="Karachi">Karachi</option>
                <option value="Lahore">Lahore</option>
                <option value="Quetta">Quetta</option>
                <option value="Islamabad">Islamabad</option>
            </select>
            <span id="city_err"></span><br>
             Country<span>*</span>  
            <select name="country" id="country" class="form-control">
                <option value="">Select</option>
                <option value="Pakistan">Pakistan</option>
                <option value="India">India</option>
                <option value="Bangladesh">Bangladesh</option>
                <option value="Afghanistan">Afghanistan</option>
                <option value="Srilanka">Srilanka</option>
                <option value="China">China</option>
                <option value="Iran">Iran</option>
            </select>
            <span id="country_err"></span><br>
            Profile<span>*</span>
            <input type="file" name="image" id="image" class="form-control">
            <span id="image_err"></span><br>
            <input type="submit" name="submit" id="submit" class="btn btn-success w-100 text-center mt-3">
            <a href="login.php">Already Registered</a>
        </form>
        <br><br>
    </div>
</body>
</html>
<script>
    $(document).ready(function (){
      $("span").addClass("text-danger");
      //$("span").css('color','red');
      $("#submit").click(function (){
        var error = "no";
          //var username = $("#username").val();
          $(this).prop('disabled',true);
          var username = $("input[name='username']").val();
          var username_length = $("input[name='username']").val().length;
         
          var email = $("input[name='email']").val();
          var password = $("input[name='password']").val();
          var c_password = $("input[name='c_password']").val();
          var contact = $("input[name='contact']").val();
          var dob = $("input[name='dob']").val();
          var gender = $("input[name='gender']:checked").val();
          
          var city = $("select[name='city']").val();
          var country = $("select[name='country']").val();
          var image = $("input[name='image']").val();
           
          if(username == ""){
            $("#username_err").html("Username is Required");
            error = "yes";
          }else{
            if(username_length < 3){
                $("#username_err").html("Name is too short");
                error = "yes"; 
            }    
          }

          if(email == ""){
            $("#email_err").html("Email is Required");
            error = "yes";
          }

          if(password == ""){
            $("#password_err").html("Password is Required");
            error = "yes";
          }

          if(c_password == ""){
            $("#c_password_err").html("Confirm Password is Required");
            error = "yes";
          }

          if(password != "" && c_password != ""){
            if(password != c_password){
                $("#c_password_err").html("password and confirm password not matched");
                error = "yes";
            }else{
                $("#c_password_err").html("");
            }
          }

          if(contact == ""){
            $("#contact_err").html("Contact is Required");
            error = "yes";
          }
          if(dob == ""){
            $("#dob_err").html("Date of Birth is Required");
            error = "yes";
          }

          if(gender == undefined){
            $("#gender_err").html("Gender is Required");
            error = "yes";
          }
          if(city == ""){
            $("#city_err").html("city is Required");
            error = "yes";
          }
          if(country == ""){
            $("#country_err").html("country is Required");
            error = "yes";
          }
          if(image == ""){
            $("#image_err").html("image is Required");
            error = "yes";
          }

          if(error == "no"){
            $("#submit").prop('disabled',false);
            $("#submit").submit();
          }

      });

      $("#username").keyup(function (){
        $("#submit").prop('disabled',false);
        $("#username_err").html("");
      });

      $("#email").keyup(function (){
        $("#submit").prop('disabled',false);
        $("#email_err").html("");
      });

      $("#password").keyup(function (){
        $("#submit").prop('disabled',false);
        $("#password_err").html("");
      });

      $("#c_password").keyup(function (){
        $("#submit").prop('disabled',false);
        $("#password_err").html("");
      });

      $("#contact").keyup(function (){
        $("#submit").prop('disabled',false);
        $("#contact_err").html("");
      });

      $("#dob").change(function (){
        $("#submit").prop('disabled',false);
        $("#dob_err").html("");
      });

      $("input[name='gender']").click(function (){
        $("#submit").prop('disabled',false);
        $("#gender_err").html("");
      });

      $("#city").change(function (){
        $("#submit").prop('disabled',false);
        $("#city_err").html("");
      });

      $("#country").change(function (){
        $("#submit").prop('disabled',false);
        $("#country_err").html("");
      });

      $("#image").change(function (){
        $("#submit").prop('disabled',false);
        $("#image_err").html("");
      });



    });
</script>