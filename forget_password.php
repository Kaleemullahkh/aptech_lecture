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

 if(isset($_POST['forget'])){
    
    $error = array();
    
    extract($_POST);

    if(empty($email)){
        $error['email'] = 'Email or Name is required';
    }else{ 
      $sql = "Select * from students where email = '". $email ."'";
      $data = mysqli_query($conn,$sql);
      $row_count = $data->num_rows;
      if($row_count == 0){
        $error['email_exist'] = "this email is not valid";
      }
    }

    if(empty($password)){
        $error['password'] = 'Password is required';
    }else{
        $password = md5($password);
    }

    if(empty($error)){
      
      $sql1 = "UPDATE students set password = '". $password ."' WHERE email = '". $email ."' ";
      $data1 = mysqli_query($conn, $sql1);
      if($data1){
        $msg = "Password updated successfully";
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
        <p class="h4 bg-dark text-white mt-3 text-center rounded p-2">Forget Password</p>
        <form action="" method="POST" class="bg-light rounded">
           
            Email <span>*</span><input type="text" id="email" name="email" class="form-control">
            <span id="email_err"></span><br>
            Password<span>*</span><input type="password" id="password" name="password" class="form-control">
            <span id="password_err"></span><br>
           
            <input type="submit" name="forget" id="forget" class="btn btn-success w-100 text-center mt-3">
            <a href="login.php">Login Account</a>
        </form>
        <br><br>
    </div>
</body>
</html>
<script>
    $(document).ready(function(){

        $("span").css('color','red');

        $("#forget").click(function (){
            var error = "no";
            email = $("input[name='email']").val();
            password = $("input[name='password']").val();

            if(email == ""){
                error = "yes";
                $("#email_err").html("email or name is required");
                $("#forget").prop('disabled',true);
            }

            if(password == ""){
                error = "yes";
                $("#password_err").html("password is required");
                $("#forget").prop('disabled',true);
            }

            if(error == "no"){
                $("#forget").prop('disabled',false);
                $("form").submit();
            }

            
        });

        $("#email").keyup(function (){
            $("#forget").prop('disabled',false);
            $("#email_err").html("");
        });

        $("#password").keyup(function (){
            $("#forget").prop('disabled',false);
            $("#password_err").html("");
        });

    });
</script>