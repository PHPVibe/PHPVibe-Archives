<?php include_once('../../load.php');
$user = intval($_POST['the_user']);
$type = intval($_POST['the_type']);
if(is_user() && $user && $type) {
if ($type < 2) {
/* If is subscribing*/
if(!has_activity('5', $user)) {
$db->query("INSERT INTO ".DB_PREFIX."users_friends (`uid`, `fid`) VALUES ('".$user."', '".user_id()."')");
//track subscription
add_activity('5', $user);
echo _lang('Subscription added!');
} else {
echo _lang('Already subscribed!');
}
}
if ($type > 2) {
/* If is unsubscribing */
$db->query("DELETE FROM ".DB_PREFIX."users_friends where uid= '".$user."' and fid = '".user_id()."'");
remove_activity('5', $user);
echo _lang('Subscription removed!');
}
} 
?>