
 <?php
require_once("../config.php");
require_once("../db.connection.php");
require_once("../db.functions.php");
if(isSet($_POST['comment_content']))

{
$id=time();// Demo Use
$comment=$_POST['comment_content'];
$msg_id=$_POST['msg_id'];

$sql=dbquery("insert into comments(comment,msg_id_fk)values('$comment','$msg_id')");
$result=dbquery("select * from comments order by com_id desc");
$row=dbarray($result);
$id=$row['com_id'];
$comment=$row['comment'];

}


?>

 <div class="comment_load" id="comment<?php echo $id; ?>">
 <?php echo $comment;  ?>
 <span class="cdelete_button"><a href="#" id="<?php echo $id; ?>" class="cdelete_update">X</a></span>
 </div>
