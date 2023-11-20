<?


$media_type = $_REQUEST['type'];
$the_id=$_REQUEST['id'];
if ($media_type=="big") 
{
header('Content-type: image/png');
readfile("http://i4.ytimg.com/vi/$the_id/0.jpg");
}
elseif ($media_type=="default") {
header('Content-type: image/png');
readfile("http://i4.ytimg.com/vi/$the_id/default.jpg");
}
?>