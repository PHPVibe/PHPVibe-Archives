<?php   require_once('../phpvibe.php');
    $com_user = $user->getDisplayName();
    $info_user = $user->getId();
	$avatar = $user->getAvatar();     

    if($_REQUEST['comment'] == $lang['enterComment']){
        unset($_REQUEST['comment']);
    }

    if($_REQUEST['comment']) {
	
	$com_body = mysql_real_escape_string(cleanInput($_REQUEST['comment']));
	$obj_id = mysql_real_escape_string(addslashes($_REQUEST['object_id']));
    $it = "INSERT INTO em_comments(`object_id`, `created`, `sender_id`, `comment_text`, `admin_reply`, `rating_cache`, `access_key`, `visible`) VALUES ('".$obj_id."', '".date("F j, Y, g:i a",time())."', '".mysql_real_escape_string($info_user)."', '".$com_body."', '0', '0', '".mysql_real_escape_string(md5(uniqid()))."', '".mysql_real_escape_string(($MODCOM?0:1))."')";
	
     	$addit = dbquery($it);
        $total      =  dbquery("SELECT count(*) AS total FROM em_comments WHERE object_id = '".mysql_real_escape_string($_REQUEST['object_id'])."'");
        $commentID  = mysql_insert_id();
      
        // /finished insert
        
        
        
        // some data formatting
        if($com_user){
            $sender = '<span class="emSenderName">'.$com_user.'</span>: ';
        }else{
            $sender = '';
        }
        // /finish data formattin


        //send reply to browser
        //header('Content-type: application/x-json');
		$new_com = twitterify(stripslashes($com_body));
        echo json_encode(array(
                                'id'    => $commentID,
                                'text'  => stripslashes($sender).'<br />'.stripslashes($new_com),
                                'name'  => stripslashes($com_user),
                                'mail'  => stripslashes($info_user),
                                'image' => '<img src="'.$site_url.'com/timthumb.php?src='. stripslashes($avatar).'&h=32&w=32&crop&q=100" />',
                                'date'  => time_ago(date("F j, Y, g:i a",time())),
                                'total' => (int)$total['total'],
                                'like'  => '<a href="javascript:iLikeThisComment('.$commentID.')">'.$lang['ilike'].'</a>'
                                ));
    }
MK_MySQL::disconnect();
	?>