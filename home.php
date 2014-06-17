<?php
	session_start();
	if (!isset($_SESSION['username'])) header("Location: index.php");
?>
<!DOCTYPE html>
<!--
	Travis Sanders			June 1, 2014
	CS494 Final Assignment
-->

<html lang="en"><head>
<title>Milestones</title>
<meta charset="UTF-8">
<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css" />
<link rel="stylesheet" type="text/css" href="css/datepicker3.css" />
<style type="text/css"></style>
<meta name="viewport" content="width=device-width, initial-scale=1">
</head>
<body>

<div class="row" style="background-image: url(https://farm5.staticflickr.com/4041/4653592122_238facaf32_b_d.jpg); background-size:100%">
<div class="container" style="width:75%; color:white; padding:5%">
	<h1>Milestones</h1>
	<h4>How long has it been?</h4>
</div>
</div>

<div class="container" style="width:75%; min-width: 335px" ><!--Begin wrapper 335px used to make it look good on iPhone-->
	<div class="row">
		<div class="col-md-4">
		</div>
	<div class="col-md-4"></div>
	<div class="col-md-4">
		<h4>User: 
<?php echo($_SESSION['username']); ?></h4>
		<a href="logout.php">Logout</a>
	</div>
</div>

<div class="date"></div>

<h4>Make a new milestone:</h4>

<form class="form-group" role="form">
  <div class="form-group emailgroup">
    <div class="input-group date">
  <input type="text" class="form-control" id="dateIn" placeholder="MM/DD/YYYY"><span class="input-group-addon"><i class="glyphicon glyphicon-th"></i></span>
</div>
  </div>

  <div class="form-group passwordgroup">
    <label class="sr-only">Milestone</label>
    <input type="text" class="form-control titleIn" id="titleIn" name="titleIn" placeholder="What is your milestone?">
    <div class="mile_errors"></div>
  </div>
	<div class="errorfield text-danger" id="errorfield"></div>
	<div class="successfield text-success" id="successfield"></div>
  <button type="button" class="btn btn-primary create" id="makemile">Mark it</button>
  <button type="button" class="btn btn-warning" id="save">Save Milestones</button>
</form>


<!-- <h4>Experimental functions:</h4>
<div>
<form class="form-inline" role="form" style:"padding:5px">
<div class="form-group">
	<button type="button" class="btn btn-primary create" id="sub1">Faster? (Resets)</button>
	<button type="button" class="btn btn-success" id="sub2">Reset</button></div>
	<div class="form-group">
	<button type="button" class="btn btn-warning" id="sub4">Clear</button>
	<button type="button" class="btn btn-danger" id="sub3">Flip it and reverse it</button></div>
</form></div> -->

<div class="test" id="test">You have no milestones! Add one!</div>
<h6>Milestones uses <a href="http://momentjs.com/" target="blank">MomentJS</a>, <a href="http://bootstrap-datepicker.readthedocs.org/" target="blank">bootstrap-datepicker</a>. Written by Travis J. Sanders for CS494 Final Project</h6>
</div> <!--End wrapper -->
<script src="js/jquery-1.11.0.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/moment.min.js"></script>
<script src="js/bootstrap-datepicker.js"></script>
<script>
var myUsername = "<?php Print($_SESSION['username']); ?>";
var milestones = [];

var teststring = '<?php echo($_SESSION['array']) ?>';
if (teststring != "") {
	milestones = JSON.parse(teststring);
	for (var i=0; i<milestones.length; i++) {
		milestones[i].date = moment(milestones[i].date); //convert date strings back into moments
		//alert(milestones[i].date);					//THIS BUG WAS THE WORST
		//alert(milestones[i].heading);
	}
}

var now = moment();
var then = moment("12 04 1985", "MM DD YYYY");

function show_date() {
	$current_date = moment().format('MMMM Do YYYY, h:mm:ss a');
	$('.date').html("Today is " + $current_date + '<br>');
	$date_diff = then.diff(now, "seconds");
	$diff = moment.duration($date_diff, 'seconds');
	$('.date').append("Time since " + then.format('LLL') + " is " + $date_diff + " seconds.<br>");
	$('.date').append("Or... " + $diff.humanize(true));
}

//random_stones();
sortByKey(milestones, 'date');
print_stones();

//http://stackoverflow.com/questions/8175093/simple-function-to-sort-an-array-of-objects
function sortByKey(array, key) {
    return array.sort(function(a, b) {
        var x = a[key]; var y = b[key];
        return ((x < y) ? 1 : ((x > y) ? -1 : 0));
    });
}

function reverseByKey(array, key) {
    return array.sort(function(a, b) {
        var x = a[key]; var y = b[key];
        return ((x > y) ? 1 : ((x < y) ? -1 : 0));
    });
}

function get_max() {
	var max = 0;
	for (var i=0; i<milestones.length; i++) {
		if (max < milestones[i].date) max = milestones[i].date;
	}
	return max;
}

function get_min() {
	var min = moment();
	for (var i=0; i<milestones.length; i++) {
		if (min > milestones[i].date) min = milestones[i].date;
	}
	return moment() - min;
}

function print_stones() {
	$('#test').empty();
	var max = get_max() - moment();
	var min = get_min();
	for (var i=0; i<milestones.length; i++) {
		//$('#test').append("<p>" + milestones[i].date.format() + "</p>");
		var thisone = milestones[i].date - moment();
		var	color = ((thisone / max * 100));

		if (thisone > 0) {
			// if (milestones[i].date == get_max() && milestones[i+1].date - moment() < 0) {
			// 	color = 0;
			// }
			color += 10;
			if(color < 35) { 
				color = 35; 
			} else if (color > 90) {
				//$('#test').append('<p>Max:</p>');
				color = 90;
			}
			$('#test').append('<div class="row" style="background:rgb(100%,' + color + '%, ' + color + '%)"><div class="col-md-8"><h5 style="padding:5px">' + milestones[i].heading + " (" + milestones[i].date.format('MMMM Do YYYY') + ')</h5></div><div class="col-md-4"><h6 style="padding:5px">' + milestones[i].date.fromNow() +  "</h6></div></div>");
		} else {
			color = ((thisone / min) * -100);
			color = 130 - color;
			if(color < 35) { 
				color = 35; 
			} else if (color > 90) {
				color = 90;
			}
			$('#test').append('<div class="row" style="background:rgb(' + color + '%, 100%,' + color + '%)"><div class="col-md-8"><h5 style="padding:5px">' + milestones[i].heading + " (" + milestones[i].date.format('MMMM Do YYYY') + ')</h5></div><div class="col-md-4"><h6 style="padding:5px">' + milestones[i].date.fromNow() +  "</h6></div></div>");
		}
		$('#test').append();
	}
	setTimeout(print_stones, 60000);  //changed to 1 min update
}

function get_difference(then) {
	$now = moment();

}

function create_milestone(title, moment) {
	milestones.push({
		date: moment,
		heading: title
	});
	sortByKey(milestones,'date');
	print_stones();
}

function random_stones() {
	for (var i=0; i<10; i++) {
		var now = moment();
		now.add('minutes', i+1);
		create_milestone("This is a new milestone!", now);
	}
	for (var i=0; i<10; i++) {
		var now = moment();
		now.subtract('minutes', i);
		create_milestone("This is a past milestone!", now);
	}
}

$('#sub4').on('click', function() {
	milestones = [];
	print_stones();
});

$('#sub3').on('click', function() {
	reverseByKey(milestones, 'date');
	//print_stones();
});

$('#sub2').on('click', function() {
	milestones = [];
	random_stones();
	sortByKey(milestones, 'date');
	print_stones();
});

$('#sub1').on('click', function() {
	milestones = [];
	for (var i=0; i<10; i++) {
		var now = moment();
		now.add('seconds', i+1);
		create_milestone("This is a new milestone!", now);
	}
	for (var i=0; i<10; i++) {
		var now = moment();
		now.subtract('hours', i);
		create_milestone("This is a past milestone!", now);
	}
	sortByKey(milestones, 'date');
	print_stones();
});

//DATEPICKER AND MILESTONE CREATION FUNCTIONS

$('#makemile').on('click', function() {
	//milestones = []; //For testing
	var in_date = $('#dateIn').val();
	var in_text = $('#titleIn').val();
	if (in_text != "") {
		if (in_date != "") {
			var formatted_date = moment(new Date(in_date));
			create_milestone(in_text, formatted_date);
			sortByKey(milestones, 'date');
			$("#errorfield").empty();
			$("#successfield").empty();
			$("#successfield").append("Milestone created!");
			$('#titleIn').val("");
			$('#dateIn').val("");
		} else {
			//alert("EMPTY DATE ERROR");
			$("#errorfield").empty();
			$("#successfield").empty();
  			$("#errorfield").append("Your milestone has no date.");
		}
	} else {
		//alert("EMPTY TEXT FIELD ERROR");
		$("#errorfield").empty();
		$("#successfield").empty();
  		$("#errorfield").append("Your milestone has no text.");
	}
});

$('.input-group.date').datepicker({
    startView: 1,
    todayHighlight: true
});

//SAVE FILE FUNCTIONS
$('#save').on('click', function() {
	var jsonarray = JSON.stringify(milestones);
	//$("#errorfield").append(jsonarray);
	$.ajax({
    type: "POST",
    url: "save.php",
    data: {userIn: myUsername,
    arrayIn: jsonarray,
  }
}).done(function(data, info){
  if(data == "SUCCESS") {
    $("#errorfield").empty();
    $("#successfield").empty();
  	$("#successfield").append("Save successful!");
  } else {
  	alert("save unsuccesful...");
  	$("#errorfield").empty();
  	$("#errorfield").append(data);
  }
}).fail(function(jqXHR, statusCode, errorThrown) {
  //$("#errorfield").empty();
  $("#errorfield").append("The error message was: " + errorThrown + "");
  });
});

</script>

</body>
</html>