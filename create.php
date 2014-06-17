<?php
/**
 * Travis Sanders			June 1, 2014
 * CS494 Final Assignment
 */
ini_set('display_errors', 'On');
include 'storedInfo.php';
require("phpass-0.3/PasswordHash.php");

session_start();
if ($_POST) {
	if (array_key_exists("userIn", $_REQUEST) && array_key_exists("passwordIn", $_REQUEST)) {

		// Following code modified heavily from http://web.engr.oregonstate.edu/~debruynm/tutorial/
		$hasher = new PasswordHash(8, false);

		$username = htmlspecialchars($_REQUEST["userIn"]);
		$password = htmlspecialchars($_REQUEST["passwordIn"]);

		//revalidate username and password sizes.
		if (strlen($password) > 72) {
		    die("Password must be 72 characters or less");
		} else if (strlen($password) < 8) {
			die("You spoony bard! Password must be greater than 8 characters.");
		} else if (strlen($username) < 4) {
			die("Username must be at least 4 characters.");
		} else if (strlen($username) > 72) {
			die("That username is WAY too big.");
		}
		//creating the hash variable which stores the hash
		$hash = $hasher->HashPassword($password);

		//if hash is created we connect to the database
		if (strlen($hash) >= 20) {
		    $con = mysqli_connect("oniddb.cws.oregonstate.edu", "sandetra-db", $mypassword, "sandetra-db"); 
		    if (mysqli_connect_errno()) {
		        echo "Failed to connect to MySQL: " . mysqli_connect_error();
		    } else {
		    	$res = $con->query("SELECT username, password FROM members WHERE username='$username'");
	    		if($res->num_rows == 0) {
					//if connection is made, we insert the values(password is now hash) into the database
					$foo = "NULL";
			        $result = mysqli_query($con, "INSERT INTO members (username, password, email) VALUES 
			        ('{$username}', '{$hash}', '{$foo}')");

			        //Start a session with the new username.
			        $_SESSION['username'] = $username;
			        echo "SUCCESS";
			        //return true;
			        //header("Location: index.php");
			    } else {
			    	echo "Sorry, that username already exists.";
			    	//return false;
			    }
		    }
		} else {
		    echo "ERROR!: Something went very wrong";
		    //return false;
		}
	}
} else {
	header("Location: account.php");	//return user to account.php if no post
	//return false;
}

?>