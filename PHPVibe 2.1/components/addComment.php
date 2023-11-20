<?php
 
    require_once('../phpvibe.php');
    $_REQUEST['comment'] = cleanInput($_REQUEST['comment']);
    $com_user = $user->getDisplayName();
    $info_user = $user->getId();
	$avatar = $user->getAvatar();     
	$av_user = $avatar;

    //error check extreme
    if($com_user == $lang['enterName']){
        unset($com_user);
    }

    if($info_user == $lang['enterMail']){
        unset($info_user);
    }

    if($_REQUEST['comment'] == $lang['enterComment']){
        unset($_REQUEST['comment']);
    }

    //link    
    $_REQUEST['comment'] = twitterify($_REQUEST['comment']);


    ### COMMENT INSERT #########################################################################
    #
    if($_REQUEST['comment']) {
        //insert comment into database
        $db->exec('INSERT INTO em_comments SET
                                    object_id    = '.$db->quote($_REQUEST['object_id']).',
                                    created      = NOW(),
                                    sender_name  = '.$db->quote($com_user).',
                                    sender_id  = '.$db->quote($info_user).',
                                    sender_ip    = '.$db->quote($av_user).',
                                    comment_text = '.$db->quote($_REQUEST['comment']).',
                                    visible      = '.$db->quote(($MODCOM?0:1)).',
                                    access_key   = '.$db->quote(md5(uniqid())));

        $total      = $db->query("SELECT count(*) AS total FROM em_comments WHERE object_id = ".$db->quote($_REQUEST['object_id']))->fetch();
        $commentID  = $db->lastInsertId();
        $key        = $db->query("SELECT access_key FROM em_comments WHERE id = ".(int)$commentID)->fetch();
        // /finished insert
        
        
        
        // some data formatting
        if($com_user){
            if($info_user){
                $com_user = jsEncode($info_user,$com_user);
				//'<a href="../../user.php?id='.$info_user.'">'.$com_user.'</a>';
            }
            $sender = '<span class="emSenderName">'.$com_user.'</span>: ';
        }else{
            $sender = '';
        }
        // /finish data formattin


        //send reply to browser
        header('Content-type: application/x-json');
        echo json_encode(array(
                                'id'    => $commentID,
                                'text'  => stripslashes($sender.$_REQUEST['comment']),
                                'name'  => stripslashes($com_user),
                                'mail'  => stripslashes($info_user),
                                'image' => '<img src="'.$site_url.'components/thumb.php?f='. stripslashes($av_user).'&h=32&w=32&m=crop" />',
                                'date'  => strftime($DATEFORMAT),
                                'total' => (int)$total['total'],
                                'like'  => '<a href="javascript:iLikeThisComment('.$commentID.')">'.$lang['ilike'].'</a>'
                                ));
    }
?>