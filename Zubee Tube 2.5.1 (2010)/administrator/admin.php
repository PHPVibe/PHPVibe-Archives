<?
include('../mainfile.php');

if(empty($_COOKIE['username']) or empty($_COOKIE['password'])){ redirect($site_url); exit; } else{ 
	$check = dbrows(dbquery("SELECT * FROM admin WHERE username='".$_COOKIE['username']."' AND password='".$_COOKIE['password']."'"));
	if($check == 0){ redirect($site_url); exit; }
}

$info = dbarray(dbquery("SELECT * FROM settings"));
$pass = dbarray(dbquery("SELECT * FROM admin"));

if($_POST){

	if($_GET['form'] == 1){
		$url = htmlspecialchars($_POST['url']);
		$title = htmlspecialchars($_POST['title']);
		$slogan = htmlspecialchars($_POST['slogan']);
		$description = htmlspecialchars($_POST['description']);
		$keywords = htmlspecialchars($_POST['keywords']);
		dbquery("UPDATE settings SET site_url='$url', site_title='$title', site_slogan='$slogan', site_description='$description', site_keywords='$keywords'");
		header("Location: admin.php?settings_updated=1");
	}

	if($_GET['form'] == 2){
		$youtube = htmlspecialchars($_POST['youtube']);
		$default = htmlspecialchars($_POST['default']);
		$site_homepage = htmlspecialchars($_POST['site_homepage']);
		$fvideo_id = htmlspecialchars($_POST['fvideo_id']);
		$fvideo_title = htmlspecialchars($_POST['fvideo_title']);
		$autoplay = $_POST['autoplay'];
		$template = $_POST['template'];
		dbquery("UPDATE settings SET dev_id='$youtube', default_tag='$default', site_homepage='$site_homepage', fvideo_id='$fvideo_id', fvideo_title='$fvideo_title', autoplay='$autoplay', template='$template'");
		header("Location: admin.php?settings2_updated=1");
	}

	if($_GET['form'] == 3){
		$video_id = htmlspecialchars($_POST['video_id']);
		header("Location: comments.php?video_id=".$video_id);
	}
	
	if($_GET['form'] == 4){
		$old = htmlspecialchars($_POST['old_pass']);
		$new = htmlspecialchars($_POST['new_pass']);
		$repeat = htmlspecialchars($_POST['repeat']);
		$admin_user = htmlspecialchars($_POST['admin_user']);
		if($repeat != $new){
			die("Your new passwords don't match!"); exit;
		} else {
			if(empty($new) or empty($admin_user)){
				die("You left a field blank!"); exit;
			} else {
				$sql_check = dbrows(dbquery("SELECT * FROM admin WHERE username='$admin_user' AND password='$old'"));	
				if($sql_check != 0){
					dbquery("UPDATE admin SET username='$admin_user', password='$new'");
					header("Location: admin.php?done=1");
				} else {
					die("Sorry your old password is wrong."); exit;
				}
			}
		}
	}
	
}


?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<link rel="stylesheet" type="text/css" href="tabcontent.css" />

<script type="text/javascript" src="tabcontent.js">

/***********************************************
* Tab Content script v2.2- © Dynamic Drive DHTML code library (www.dynamicdrive.com)
* This notice MUST stay intact for legal use
* Visit Dynamic Drive at http://www.dynamicdrive.com/ for full source code
***********************************************/

</script>


<title>Zubee Tube Admin</title>
</head>

<body>
<center>
<h1>Hello Zubee Tube webmaster!</h1>
</center>
<table>

<tr>
<td>
<ul id="scriptvideo" class="shadetabs">
<li><a href="#" rel="tcontent1" class="selected">Settings</a></li>
<li><a href="#" rel="tcontent2">Youtube</a></li>
<li><a href="#" rel="tcontent3">Comments</a></li>
<li><a href="#" rel="tcontent4">Admin</a></li>
<li><a href="http://www.asistenta.info/forum/" target="_blank">Zubee's Help & support</a></li>
<li><a href="http://www.asistenta.info" target="_blank">Development</a></li>
</ul>

<div style="border:1px solid gray; width:650px; margin-bottom: 1em; padding: 10px">

<div id="tcontent1" class="tabcontent">
 <? if(!empty($_GET['settings_updated'])){ echo '<table width="500" border="0" align="center" cellpadding="0" cellspacing="0" style="border:2px solid #2ab100; background-color:#e9ffe2;"><tr><td align="center" style="padding:5px;">Site Settings Updated!</td></tr></table><br />'; } ?>
  <? if(!empty($_GET['settings2_updated'])){ echo '<table width="500" border="0" align="center" cellpadding="0" cellspacing="0" style="border:2px solid #2ab100; background-color:#e9ffe2;"><tr><td align="center" style="padding:5px;">Misc Settings Updated!<br></td></tr></table><br />'; } ?>
<form method="post" action="admin.php?form=1" name="login">
  <table width="500" border="0" align="center" cellpadding="0" cellspacing="0" style="border:2px solid #A3E95D; background-color:#FFFFFF">
  <tr>
    <td><div style="font-size:18px; font-family:Verdana; text-align:center">Settings</div> <br />
      <table width="480" border="0" align="center" cellpadding="5" cellspacing="0">
        <tr>
          <td width="158" style="font-size:18px; font-family:Verdana;">Site Url</td>
          <td width="302"><input name="url" type="text" style="font-size:18px; font-family:Verdana;" value="<?=$info['site_url']?>" size="30" /></td>
        </tr>
        <tr>
          <td style="font-size:18px; font-family:Verdana;">Site Title </td>
          <td><input name="title" type="text" id="title" style="font-size:18px; font-family:Verdana;" value="<?=$info['site_title']?>" size="30" /></td>
        </tr>
        <tr>
          <td style="font-size:18px; font-family:Verdana;">Site Slogan </td>
          <td><input name="slogan" type="text" id="slogan" style="font-size:18px; font-family:Verdana;" value="<?=$info['site_slogan']?>" size="30" /></td>
        </tr>
        <tr>
          <td style="font-size:18px; font-family:Verdana;">Site Description </td>
          <td><input name="description" type="text" id="description" style="font-size:18px; font-family:Verdana;" value="<?=$info['site_description']?>" size="30" /></td>
        </tr>
        <tr>
          <td style="font-size:18px; font-family:Verdana;">Site Keywords <br /><font size="1">(Seperate by commas)</font></td>
          <td><input name="keywords" type="text" style="font-size:18px; font-family:Verdana;" value="<?=$info['site_keywords']?>" size="30" /></td>
        </tr>
        <tr>
          <td colspan="2" align="center" style="font-size:18px; font-family:Verdana; padding-top:10px;"><input type="submit" value="Update" style="font-size:18px; font-family:Verdana; background-color:#A3E95D;" /><br /></td>
          </tr>
      </table>
      </td>
  </tr>
</table>
</form>
</div>

<div id="tcontent2" class="tabcontent">
<form method="post" action="admin.php?form=2" name="login">
  <table width="500" border="0" align="center" cellpadding="0" cellspacing="0" style="border:2px solid #A3E95D; background-color:#FFFFFF">
  <tr>
    <td><div style="font-size:18px; font-family:Verdana; text-align:center">Video Settings</div> <br />
      <table width="480" border="0" align="center" cellpadding="5" cellspacing="0">
       
        <tr>
          <td style="font-size:18px; font-family:Verdana;">Default Tag<br />
            <font size="1">(Replace space with +)</font></td>
          <td><input name="default" type="text" id="default" style="font-size:18px; font-family:Verdana;" value="<?=$info['default_tag']?>" size="30" /></td>
        </tr>
		<tr>
		  <td style="font-size:18px; font-family:Verdana;">Homepage<br />
            <font size="1">(Choose what to show on homepage)</font></td>
          <td><?php site_homepage_select($info['site_homepage']); ?></td>
		</tr>
        <tr>
          <td style="font-size:18px; font-family:Verdana;">Video ID<br />
            <font size="1">(Feautured Video)</font></td>
          <td><input name="fvideo_id" type="text" id="fvideo_id" style="font-size:18px; font-family:Verdana;" value="<?=$info['fvideo_id']?>" size="30" /></td>
        </tr>
        <tr>
          <td style="font-size:18px; font-family:Verdana;">Video Title<br />
            <font size="1">(Feautured Video)</font></td>
          <td><input name="fvideo_title" type="text" id="fvideo_title" style="font-size:18px; font-family:Verdana;" value="<?=$info['fvideo_title']?>" size="30" /></td>
        </tr>
        <tr>
          <td style="font-size:18px; font-family:Verdana;">Autoplay Videos<br /></td>
          <td>
            <select name="autoplay" id="autoplay" style="font-size:18px; font-family:Verdana;">
              <option value="yes" <? if($info['autoplay'] == "yes") { echo 'selected="selected"'; } ?>>Yes</option>
              <option value="no" <? if($info['autoplay'] == "no") { echo 'selected="selected"'; } ?>>No</option>
            </select>
          </td>
        </tr>
        <tr>
          <td style="font-size:18px; font-family:Verdana;">Layout <br /></td>
          <td>
            <select name="template" id="template" style="font-size:18px; font-family:Verdana;">
              <? 
                if ($handle = opendir('../templates/')) {
                  while (false !== ($file = readdir($handle))) {
                    if($file != '.' and $file != '..'){
                      echo '<option value="'.$file.'"'; if($info['template'] == $file){ echo 'selected="selected"'; } echo '>'.$file.'</option>'; 
                    }
                  }
                  closedir($handle);
                }
              ?>
            </select>
          </td>
        </tr>
        <tr>
          <td colspan="2" align="center" style="font-size:18px; font-family:Verdana; padding-top:10px;"><input type="submit" value="Update" style="font-size:18px; font-family:Verdana; background-color:#A3E95D;" /><br /></td>
          </tr>
      </table>
      </td>
  </tr>
</table>
</form>
</div>

<div id="tcontent3" class="tabcontent">
<form method="post" action="admin.php?form=3" name="comments">
  <table width="500" border="0" align="center" cellpadding="0" cellspacing="0" style="border:2px solid #A3E95D; background-color:#FFFFFF">
  <tr>
    <td><div style="font-size:18px; font-family:Verdana; text-align:center">Moderate Comments</div> 
      <br />
      <table width="480" border="0" align="center" cellpadding="5" cellspacing="0">
        <tr>
          <td width="158" style="font-size:18px; font-family:Verdana;">Video ID:</td>
          <td width="302"><input name="video_id" type="text" id="video_id" style="font-size:18px; font-family:Verdana;" size="30" /></td>
        </tr>
        <tr>
          <td colspan="2" align="center" style="font-size:18px; font-family:Verdana; padding-top:10px;"><input type="submit" value="View Comments of This ID" style="font-size:18px; font-family:Verdana; background-color:#A3E95D;" /><br /></td>
          </tr>
        <tr>
          <td colspan="2" align="center" style="font-size:18px; font-family:Verdana; padding-top:10px;"><a style="color:black;" href="<?=$site_url."administrator/comments.php"?>">View all comments</a></td>
          </tr>
      </table>
      </td>
  </tr>
</table>
</form>
</div>

<div id="tcontent4" class="tabcontent">
<form method="post" action="admin.php?form=4" name="login">
  <table width="500" border="0" align="center" cellpadding="0" cellspacing="0" style="border:2px solid #A3E95D; background-color:#FFFFFF">
  <tr>
    <td><div style="font-size:18px; font-family:Verdana; text-align:center">Change Username / Password </div> 
      <br />
      <table width="480" border="0" align="center" cellpadding="5" cellspacing="0">
        <tr>
          <td width="158" style="font-size:18px; font-family:Verdana;">Username:</td>
          <td width="302"><input name="admin_user" type="text" id="admin_user" style="font-size:18px; font-family:Verdana;" value="<?=$pass['username']?>" size="30" /></td>
        </tr>
        <tr>
          <td style="font-size:18px; font-family:Verdana;">Old Password:</td>
          <td><input name="old_pass" type="password" id="old_pass" style="font-size:18px; font-family:Verdana;" size="30" /></td>
        </tr>
        <tr>
          <td style="font-size:18px; font-family:Verdana;">New Password:</td>
          <td><input name="new_pass" type="password" id="new_pass" style="font-size:18px; font-family:Verdana;" size="30" /></td>
        </tr>
        <tr>
          <td style="font-size:18px; font-family:Verdana;">Repeat:</td>
          <td><input name="repeat" type="password" id="repeat" style="font-size:18px; font-family:Verdana;" size="30" /></td>
        </tr>
        <tr>
          <td colspan="2" align="center" style="font-size:18px; font-family:Verdana; padding-top:10px;"><input type="submit" value="Change" style="font-size:18px; font-family:Verdana; background-color:#A3E95D;" /><br /></td>
          </tr>
      </table>
      </td>
  </tr>
</table>
</form>
</div>
</div>
<script type="text/javascript">

var myflowers=new ddtabcontent("scriptvideo") //enter ID of Tab Container
myflowers.setpersist(true) //toogle persistence of the tabs' state
myflowers.setselectedClassTarget("link") //"link" or "linkparent"
myflowers.init()

</script>
</td>
<td width="20px">
</td>
<td width="250px">

<p><strong>Keep Zubee Tube's free version alive by subscribing as an PRO user on the forum!<br/>
 Premium membership costs 5$ per 3 months and provides you access to premium turorials and better support!<br/>
 PRO forum it's not visible by normal users.
 </strong> <br/>


</p>
Pls remember to protect your admin page with .htaccess password! <br/> You are using <a href="http://www.asistenta.info/" title="ZuBee Tube - Youtube Script" target="_blank">Zubee Tube</a> v 2.5.1.<br/> <a href="http://www.asistenta.info/download/" target="_blank">Pls check for stable release constantly</a>.


<?php echo '<br/>Visit the <a href="http://www.asistenta.info/forum/">forum</a> for new mods and debates!<br/><br/>';
echo '<strong>Zubee Tube latest support issues</strong><br/>';
$feedURL = 'http://feeds.feedburner.com/ZubeeTubeForum';
$doc = new DOMDocument();
$doc->load($feedURL);
foreach ($doc->getElementsByTagName('item') as $node) {
 $title = $node->getElementsByTagName('title')->item(0)->nodeValue;
 $link = $node->getElementsByTagName('link')->item(0)->nodeValue;
 
 echo '<a href="'.$link.'" target="_blank">'.$title.'</a><br/>';
}
?>
</td></tr>
</table>
<p>Thank you for using Zubee Tube from RoyalWays.ro , check Read Me file in achive for instructions and forum for upgrades and changes. </p>
</body>
</html>
