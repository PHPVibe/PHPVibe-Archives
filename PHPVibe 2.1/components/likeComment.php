<?php
  require_once('../phpvibe.php');

    $_REQUEST['comment_id']  = (int)$_REQUEST['comment_id'];

    if($_REQUEST['comment_id']){
        //insert comment into database
        $db->exec('INSERT INTO em_likes SET
                                    comment_id   = '.$db->quote($_REQUEST['comment_id']).',
                                    sender_ip    = '.(int)ip2long($_SERVER['REMOTE_ADDR']));
        
        //generate reply
        $total = $db->query("SELECT count(*) AS total FROM em_likes WHERE comment_id = ".$db->quote($_REQUEST['comment_id']))->fetch();
        $total = (int)$total['total'];

        //update cache
        $db->exec('UPDATE em_comments SET rating_cache = '.$total.' WHERE id = '.$_REQUEST['comment_id']);
    
        header('Content-type: application/x-json');
        echo json_encode(array(
                                'id'    => $db->lastInsertId(),
                                'text'  => commentLikeText($total-1),
                                'total' => $total
                                ));
    }
?>