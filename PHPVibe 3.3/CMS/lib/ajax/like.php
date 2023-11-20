<?php include_once('../../load.php');
$id = intval($_POST['video_id']);
$type = intval($_POST['type']);
$stype = $type + 2;
$tran = array();
$tran[1] = _lang('like');
$tran[2] = _lang('dislike');
$tran[3] = 'like';
$tran[4] = 'dislike';
if(is_user() && ($id > 0)) {
$check = $db->get_row("SELECT count(*) as nr, type FROM ".DB_PREFIX."likes WHERE vid = '".$id ."' AND uid ='".user_id()."'");
if($check->nr > 0) {
echo _lang('You already'). ' ' .$check->type. ' '._lang('this');
} else {

$db->query("INSERT INTO ".DB_PREFIX."likes (`uid`, `vid`, `type`) VALUES ('".user_id()."', '".$id."', '".$tran[$stype]."')");
$db->query("UPDATE ".DB_PREFIX."videos set ".$tran[$stype]."d = ".$tran[$stype]."d+1 where id = '".$id."'");
echo _lang('You'). ' '.$tran[$type].' '._lang('this');
add_activity('1', $id, $tran[$type]);
}

} else {
echo _lang('Login first!');
}
?>