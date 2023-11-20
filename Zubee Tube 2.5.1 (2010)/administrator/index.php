<?
include('../mainfile.php');
if($_POST){

	$user = htmlspecialchars($_POST['username']);
	$pass = htmlspecialchars($_POST['password']);
	if(empty($user) or empty($pass)){ $msg = "Please fill out all the fields."; } else{
	
		$check = dbrows(dbquery("SELECT * FROM admin WHERE username='$user' and password='$pass'"));
		if($check == 0){ $msg = "You've entered a wrong username/password"; } else{
		
			setcookie("username", $user, time()+604800);
			setcookie("password", $pass, time()+604800);
			header("Location: admin.php");
		
		}
	
	}

}

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Login</title>
</head>

<body><br /><br />
<form method="post" action="<?=$_SERVER['PHP_SELF']?>" name="login">
  <? if(!empty($msg)){ echo '<table width="400" border="0" align="center" cellpadding="0" cellspacing="0" style="border:2px solid #d50000; background-color:#ffdbdb;"><tr><td align="center" style="padding:5px;">'.$msg.'</td></tr></table><br />'; } ?>
  <table width="400" border="0" align="center" cellpadding="0" cellspacing="0" style="border:2px solid #A3E95D; background-color:#FFFFFF">
  <tr>
    <td><br />
      <table width="380" border="0" align="center" cellpadding="5" cellspacing="0">
        <tr>
          <td width="141" style="font-size:18px; font-family:Verdana;">Username:</td>
          <td width="219"><input name="username" type="text" style="font-size:18px; font-family:Verdana;" size="20" /></td>
        </tr>
        <tr>
          <td style="font-size:18px; font-family:Verdana;">Password</td>
          <td><input name="password" type="password" style="font-size:18px; font-family:Verdana;" value="" size="20" /></td>
        </tr>
        <tr>
          <td colspan="2" align="center" style="font-size:18px; font-family:Verdana; padding-top:10px;"><input type="submit" value="Login" style="border:2px solid #A3E95D; background-color:#FFFFFF" /><br /></td>
          </tr>
      </table>
      </td>
  </tr>
</table>
</form>
</body>
</html>
