<?php
  session_start();
  if (isset($_SESSION['username'])) header("Location: home.php");
?>
<!DOCTYPE html>
<!--
	Travis Sanders			May 20, 2014
	CS494 Final Project
-->
<html lang="en"><head>
<title>CS494 FINAL PROJECT</title>
<meta charset="UTF-8">
<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css" />
<style type="text/css"></style>
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="viewport" content="width=device-width, initial-scale=1">	
</head>
<body> 

<div class="row" style="background-image: url(https://farm3.staticflickr.com/2573/3690608242_9fcc638a3b_b_d.jpg); background-size:cover; background-position:bottom">
<div class="container" style="width:75%; color:white; padding:5%">
  <h1>Milestones</h1>
  <h4>How long has it been?</h4>
</div>
</div>

<div class="container" style="width:75%; padding:5%"><!--Begin wrapper -->

<h4>Create an account</h4>

<div id="errorfield" class="alert-danger"></div>

<form class="form-group" role="form">
  <div class="form-group emailgroup">
    <label class="sr-only" for="example">Email address</label>
    <input type="username" class="form-control input1" id="userIn" name="userIn" placeholder="Username">
    <div class="errors"></div>
  </div>
  <div class="form-group passwordgroup">
    <label class="sr-only" for="example">Password</label>
    <input type="password" class="form-control input2" id="passwordIn" name="passwordIn" placeholder="Password">
    <div class="errors2"></div>
  </div>
  <button type="button" class="btn btn-primary create" id="sub1" disabled="disabled" >Create Account</button>
</form>
<p><a href="index.php">Home</a></p>
</div> <!--End wrapper -->

<script src="js/jquery-1.11.0.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/bootstrap-datepicker.js"></script>
<script>

$('.input1').on('change',function () {
  if ($('#userIn').val().length < 4) {
    $('.errors').html('<label class="control-label" for="inputWarning1">Username must contain at least 4 characters.</label>');
    $('.emailgroup').removeClass("has-success");
    $('.emailgroup').addClass("has-error");
    $('.create').prop("disabled", true);
  } else {
    //alert($('#userIn').val());
    $('.errors').html('');
    $("#errorfield").empty();
    $("#errorfield").removeClass("alert");
    $('.emailgroup').removeClass("has-error");
    $('.emailgroup').addClass("has-success");  
  } 
  enablebutton(); 
});

$('.input2').on('change',function () {
  if ($('#passwordIn').val().length < 8) {
    $('.errors2').html('<label class="control-label" for="inputWarning1">Password must contain at least 8 characters.</label>');
    $('.passwordgroup').removeClass("has-success");
    $('.passwordgroup').addClass("has-error");
    $('.create').prop("disabled", true);
  } else {
    //alert($('#passwordIn').val());
    $('.errors2').html('');
    //$("#errorfield").empty();
    $('.passwordgroup').removeClass("has-error");
    $('.passwordgroup').addClass("has-success");
  }    
  enablebutton();
});

function enablebutton() {
  if (isvalid() && $('.create').prop("disabled")) {
    $('.create').prop("disabled", false);
  }
}

function isvalid() {
  if (!($('#userIn').val().length < 4) && !($('#passwordIn').val().length < 8)) {
    return true;
  } else return false;
}

$('#sub1').keydown(function(event){    
    if(event.keyCode==13){
       $('#sub1').trigger('click');
    }
});

$('#sub1').on('click', function() {
  $.ajax({
    type: "POST",
    url: "create.php",
    data: {userIn: $('#userIn').val(),
    passwordIn: $('#passwordIn').val(),
    }
}).done(function(data, info){
  if(data == "SUCCESS") {
    window.location = "home.php";
  } else {
    $("#errorfield").empty();
    //$("#errorfield").append('<button type="button" class="close" data-dismiss="alert">×</button>');
    $("#errorfield").addClass("alert alert-danger");
    $("#errorfield").append(data);
    //$("#errorfield").append(info);
    $('.emailgroup').removeClass("has-success");
    $('.emailgroup').addClass("has-error");
  }
}).fail(function(jqXHR, statusCode, errorThrown) {
  $("#errorfield").empty();
  //$("#errorfield").append('<button type="button" class="close" data-dismiss="alert">×</button>');
  $("#errorfield").addClass("alert alert-danger");
  $("#errorfield").append("The requested page was: " + "create_user.php" + "The error number returned was: " + jqXHR.status + "The error message was: " + errorThrown + "");
  }); //end of .fail
});

</script>
</body>
</html>