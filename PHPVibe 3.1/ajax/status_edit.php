<?php include_once("../phpvibe.php");
$this_id = cleanInput($_GET["id"]);
if(isset($this_id) && $user->isAuthorized()) {
$result=mysql_query("select * from user_wall where msg_id = '".$this_id."' and u_id = '".$user->getId()."' limit 0,1");
$sts = dbarray($result);
echo '
 <div class="enterMessage">
 <form method="post" name="form" action="'.$site_url.'wall/">
            <input type="text"  name="enterMessage" placeholder="'.$sts["message"].'" />
		
            <div class="sendStatus">
             <input type="submit" name="sendMessage" class="buttonS bLightBlue" value="Save"/>
            </div>
				<input type="hidden" name="id" value="'.$sts["msg_id"].'" />
				</form>
        </div>

';
}

?>