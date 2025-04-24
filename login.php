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
<body>
  <?php

 if(isset($_POST['login'])){
    
    $error = array();
    
    extract($_POST);

    if(empty($email)){
        $error['email'] = 'Email or Name is required';
    }

    if(empty($password)){
        $error['password'] = 'Password is required';
    }

    if(empty($error)){
      $sql = "SELECT * FROM students WHERE email = '". $email ."' AND password = '". $password ."' OR name = '". $email ."' AND password = '". $password ."' ";
      
      $data = mysqli_query($conn,$sql);
      if(!$data){
        die('error'.$conn->error);
      }else{
          $count = $data->num_rows;
          if($count > 0){
            $msg = "User has been login successfully";
          }else{
            $error['match'] = "Email and Password has not matched";
          }
      }
      
    }
    
 }

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
        <p class="h4 bg-dark text-white mt-3 text-center rounded p-2">Login Form</p>
        <form action="" method="POST" class="bg-light rounded">
           
            Email or Name<span>*</span><input type="text" id="email" name="email" class="form-control">
            <span id="email_err"></span><br>
            Password<span>*</span><input type="password" id="password" name="password" class="form-control">
            <span id="password_err"></span><br>
           
            <input type="submit" name="login" id="login" class="btn btn-success w-100 text-center mt-3">
            <a href="registeration.php">Registered Account</a>
        </form>
        <br><br>
    </div>
</body>
</html>
<script>
    $(document).ready(function(){

        $("span").css('color','red');

        $("#login").click(function (){
            var error = "no";
            email = $("input[name='email']").val();
            password = $("input[name='password']").val();

            if(email == ""){
                error = "yes";
                $("#email_err").html("email or name is required");
                $("#login").prop('disabled',true);
            }

            if(password == ""){
                error = "yes";
                $("#password_err").html("password is required");
                $("#login").prop('disabled',true);
            }

            if(error == "no"){
                $("#login").prop('disabled',false);
                $("form").submit();
            }

            
        });

        $("#email").keyup(function (){
            $("#login").prop('disabled',false);
            $("#email_err").html("");
        });

        $("#password").keyup(function (){
            $("#login").prop('disabled',false);
            $("#password_err").html("");
        });

    });
</script>