<?php
  require_once('../phpvibe.php');

    $_REQUEST['comment_id']  = (int)$_REQUEST['comment_id'];

    if($_REQUEST['comment_id']){
        //insert comment into database
        $insert_com = dbquery('INSERT INTO em_likes SET
                                    comment_id   = '.mysql_real_escape_string($_REQUEST['comment_id']).',
                                    sender_ip    = '.(int)ip2long($_SERVER['REMOTE_ADDR']));
        
        //generate reply
        $total = dbquery("SELECT count(*) AS total FROM em_likes WHERE comment_id = ".addslashes($_REQUEST['comment_id']));
		$t=dbarray($total);
        $total = (int)$t['total'];

        //update cache
        $up_rate = dbquery('UPDATE em_comments SET rating_cache = '.$total.' WHERE id = '.$_REQUEST['comment_id']);
    
        header('Content-type: application/x-json');
        echo json_encode(array(
                                'id'    => mysql_insert_id(),
                                'text'  => commentLikeText($total-1),
                                'total' => $total
                                ));
    }
MK_MySQL::disconnect();
?>