<?php
  session_start();
  if (isset($_SESSION['username'])) header("Location: home.php");
?>
<!DOCTYPE html>
<!--
  Travis Sanders      May 20, 2014
  CS494 Final Project
-->
<html lang="en"><head>
<title>Milestones</title>
<meta charset="UTF-8">
<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css" />
<style type="text/css"></style>
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="viewport" content="width=device-width, initial-scale=1">  
</head>
<body>
<div class="row" style="background-image: url(https://farm4.staticflickr.com/3805/11680780535_5dfb05ee51_b_d.jpg); background-size:cover">
<div class="container" style="width:75%; color:white; padding:5%">
  <h1>Milestones</h1>
  <h4>How long has it been?</h4>
</div>
</div>
<div class="container" style="width:75%; padding:5%"><!--Begin wrapper -->

<div id="errorfield" class="text-danger"></div>
<form class="form-inline" role="form" method="POST" action="validate.php">
  <div class="form-group">
    <label class="sr-only">Username</label>
    <input type="text" class="form-control" id="userIn" name="userIn" placeholder="Username">
  </div>
  <div class="form-group">
    <label class="sr-only">Password</label>
    <input type="password" class="form-control" id="passwordIn" name="passwordIn" placeholder="Password">
  </div>
  <button type="button" class="btn btn-default" id="sub1">Sign in</button><br><br>
  
  <p>Don't have an account? <a href="account.php">Create one!</a></p>
  <p><a href="demo.html">Try the demo!</a></p>
<div>
  <blockquote class="blockquote-reverse">
  <p>The safest road to hell is the gradual one - the gentle slope, soft underfoot, without sudden turnings, without milestones...</p>
  <footer>C.S. Lewis</footer>
</blockquote>
</div>
</form>
</div> <!--End wrapper -->

<script src="js/jquery-1.11.0.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<script type="text/javascript">

$('#sub1').keydown(function(event){    
    if(event.keyCode==13){
       $('#sub1').trigger('click');
    }
});
  
$('#sub1').on('click', function() {
  $.ajax({
    type: "POST",
    url: "validate.php",
    data: {userIn: $('#userIn').val(),
    passwordIn: $('#passwordIn').val(),
  }
}).done(function(data, info){
  if(data == "SUCCESS") {
    window.location = "home.php";
  } else {
    $("#errorfield").empty();
    $("#errorfield").append(data);
    //$("#errorfield").append(info);
    $('.emailgroup').removeClass("has-success");
    $('.emailgroup').addClass("has-error");
  }
}).fail(function(jqXHR, statusCode, errorThrown) {
  $("#errorfield").empty();
  $("#errorfield").append("The error message was: " + errorThrown + "");
  });
});
</script>
</body>
</html>