<html>
<body>
<?php

if($_SERVER["HTTPS"] != "on" || !isset($_SERVER['HTTPS']))
{
    header("Location: https://" . $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"]);
    exit();
}

/*echo "POST Variables:<br>";
var_dump($_POST);
echo "<br>GET Variables:<br>";
var_dump($_GET);
echo "<br>";*/

// include the functions file
include ('functions.php');
// include the database file
include ('dbconfig.php');

// Timelimit in seconds, keep it at 1 day unless otherwise instructed
$timelimit = 86400;

$userid = '';
$pass = "abc";

if(!isset($_GET["reset"]) && !isset($_POST["ForgotPassword"])) {
	echo "Do not access this page in this manner. Use the URL from the email sent to you.<br>";
	die();
}
else {
	if (isset($_GET["reset"])) {
		$code = $_GET["reset"];
		//echo 'reset code is '.$code.'<br>';
		$decrcode = urldecode($code);
		$decrypted = decryptYRVCeMzkni($code);
		$timeval = time();
		$pwdtimeval = (int)substr($decrypted, 0, 10);
		//echo "URL timeval is $pwdtimeval.<br>";
		$userid = substr($decrypted, 10);
		//echo "UserID is $userid.<br>";
		$timepassed = $timeval - $pwdtimeval;
		//echo "Time between URL creation and page visit is $timepassed seconds.<br>";
		if ($timepassed > $timelimit) {
			echo "The URL is no longer valid, requst another password.";
			die();
		}
		if (!(isset($_POST["ResetPasswordForm"]))) {
			reenterpassword:
			if(!isset($_GET["reset"])) {
				$code = $_POST["reset"];
			}
			if(!isset($_GET["reset"])) {
				$userid = $_POST["userid"];
			}
			echo "UserID is $userid.<br>";
			echo'
			<form action= "resetPassword.php" method="POST">
				<table>
				<tr>
					<td align="right">New Password:</td>
					<td align="left"><input type="password" name="pass" size = "20"/></td>
				</tr>
				<tr>
					<td align="right">Re-Enter New Password:</td>
					<td align="left"><input type="password" name="confirmpass" size = "20"/></td>
				</tr>
				<tr>
					<td align = "right"></td>
					<td align = "left"><input type="submit" name="ForgotPassword" value="Request Reset" /></td>
				</tr>
			</table>
			<input type = "hidden" name = "userid" value = "'.$userid.'" />
			<input type = "hidden" name = "reset" value = "'.$code.'" />
			</form>';
			die();

		}
	}
	else {
		if (!(($_POST["pass"]) == ($_POST["confirmpass"]))) {
			echo "Passwords do not match, please re-enter.<br>";
			goto reenterpassword;
		}
		$userid = $_POST["userid"];
		$pass = $_POST["pass"];
		// Update the user's password
		$query = $mysqli->prepare("UPDATE test.users SET cur_pass = ? WHERE id = ?");
		if(!$query)
		{
			echo "2 This is the error:";
			echo "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error;
		}
		echo "User: $userid<br>Password: $pass<br>";
		$query->bind_param('ss', $pass, $userid);
		$execval = $query->execute();
		if (false == $execval) {
			echo "Error setting new password, contact help desk.<br>";
		}
		else {
			echo "Your password has been successfully reset.";
		}
		$mysqli = null;
	}
}
?>
</body>
</html>