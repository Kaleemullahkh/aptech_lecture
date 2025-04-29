<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="css/bootstrap.min.css" />
    <script src="js/bootstrap.min.js"></script>
    <script src="js/bootstrap.bundle.min.js"></script>
    <script src="js/jquery-3.7.1.js"></script>
</head>

<body>
<?php if(isset($_GET['msg'])){
      $msg = $_GET['msg']; ?>
    <div class="alert alert-success alert-dismissible mt-3">
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
  <strong>Success!</strong><?php echo $msg; ?>
</div>
 <?php  } ?>
    <div class="container">
        <div class="card" style="width:400px">
        <img class="card-img-top" src="img_avatar1.png" alt="Card image">
            <div class="card-body">
                <h4 class="card-title">Card title</h4>
                <p class="card-text">Some example text. Some example text.</p>
                <a href="#" class="card-link">Card link</a>
                <a href="#" class="card-link">Another link</a>
            </div>
        </div>
    </div>
    </div>
</body>

</html>