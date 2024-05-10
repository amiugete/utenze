<?php
/*
Script Name: ldapLogin.php
Author: Roberto Marzochhi modifying a file of Riontino Raffaele
Author URI: https://www.lelezapp.it/
Description: example script for ldap authentication in PHP
Version: 1.0
*/

session_start();


if(!isset($_COOKIE['origine'])) {
	//echo "Cookie named origine is not set!";
	$_COOKIE['origine']=$_SESSION['origine'];
	$origine=$_COOKIE["origine"];
} else {
	//echo "Cookie un is set!<br>";
	//echo "Value is: " . $_COOKIE['origine'];
}
//echo $origine;
//exit;


require_once("conn.php");
require_once("req.php");

$successMessage = "";
$errorMessage = "";

// connect to ldap server
$ldapConnection = ldap_connect($ldapHost, $ldapPort) 
	or die("Could not connect to Ldap server.");

if (isset($_POST["ldapLogin"])){

	if ($ldapConnection) {
		
		if (isset($_POST["user"]) && $_POST["user"] != "") 
			$ldapUser = addslashes(trim($_POST["user"]));
		else 
			$errorMessage = "Invalid User value!!";
		
		if (isset($_POST["password"]) && $_POST["password"] != "") 
			$ldapPassword = addslashes(trim($_POST["password"]));
		else 
			$errorMessage = "Invalid Password value!!";
		
		if ($errorMessage == ""){
			// binding to ldap server
			ldap_set_option($ldapConnection, LDAP_OPT_PROTOCOL_VERSION, 3) or die('Unable to set LDAP protocol version');
			ldap_set_option($ldapConnection, LDAP_OPT_REFERRALS, 0);
			$ldapbind = @ldap_bind($ldapConnection, $ldapUser . $ldapDomain, $ldapPassword);

			// verify binding
			if ($ldapbind){
				ldap_close($ldapConnection);	// close ldap connection
				$successMessage = "Login done correctly with user ".$ldapUser."!!";
				$_SESSION['username']=$ldapUser;
				setcookie('un', $ldapUser, time() + (86400 * 7), "/"); // 86400 = 1 day
                header("Location: ./$origine");
			} 
			else 
				$errorMessage = "Invalid credentials!";
		}
	}
}
?>
<!DOCTYPE html>
<html>
	<head>
		<title>Login</title>
	</head>
	<body data-rsssl=1 data-rsssl=1>
    <div class="banner"> <div id="banner-image"></div> </div>

      <div class="container">
		<?php		
			if ($errorMessage != "") echo "<h3 style='color:red;'>$errorMessage</h3>";
			//if ($successMessage != "") echo "<h3 style='color:blue;'>$successMessage</h3>";
		?>
		<h3 style="color:orange">Inserisci credenziali AMIU (utente e password con cui accedi al PC) </h3>
		<form action="" method="post" style="display:inline-block;">
			<table style="display:inline-block;">
				<tr>
					<td>User</td>
					<td><input type="text" name="user" value="" maxlength="50"></td>
				</tr>
				<tr>
					<td>Password</td>
					<td><input type="password" name="password" value="" maxlength="50"></td>
				</tr>
				<tr>
					<td colspan="2"><input type="submit" name="ldapLogin" value="Login"></td>
				</tr>
			</table>
		</form>


</div>
        <?php
        require_once('req_bottom.php');
        require('./footer.php');
        ?>

    </body>
</html>
