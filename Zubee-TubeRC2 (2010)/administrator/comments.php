<?
include('../mainfile.php');

if(empty($_COOKIE['username']) or empty($_COOKIE['password'])){ redirect($site_url); exit; } else{ 
	$check = dbrows(dbquery("SELECT * FROM admin WHERE username='".$_COOKIE['username']."' AND password='".$_COOKIE['password']."'"));
	if($check == 0){ redirect($site_url); exit; }
}

      $video_id  = $_GET['video_id'];
      
if (isset($_GET['comm_nr'])){

  dbquery("DELETE FROM comments WHERE id = '".$_GET['comm_nr']."'");
  dbquery("UPDATE videos SET comments = comments-1 WHERE video_id = '".$video_id."'");
  dbquery("ALTER TABLE `comments` AUTO_INCREMENT = 1");

} else {

      $start     = $_GET['nr'];

            if(!($start > 0)) {
              $start = 0;
            }

            $eu = ($start - 0); 
            $limit = 30;                                 // Comments per Page
            $this1 = $eu + $limit; 
            $back = $eu - $limit; 
            $next = $eu + $limit;
                      
            if ($video_id != ""){
              $result = dbquery("SELECT * FROM comments WHERE vid='".$video_id."' ORDER BY id DESC limit $eu, $limit");
              $count  = dbcount("*", "comments", "vid='".$video_id."'");
            } else {
              $result = dbquery("SELECT * FROM comments ORDER BY id DESC limit $eu, $limit");
              $count  = dbcount("*", "comments");
            }
            
}

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Moderate Comments</title>
</head>

<body><br />
  <? echo '<table width="500" border="0" align="center" cellpadding="0" cellspacing="0" style="border:2px solid #2ab100; background-color:#e9ffe2;"><tr><td align="center" style="padding:5px;"><a href="'.$site_url.'administrator/admin.php" style="color:#000;">Back to administration</a></td></tr></table><br />';  ?>
  <table width="500" border="0" align="center" cellpadding="0" cellspacing="0" style="border:2px solid #DAF7BB; background-color:#FFFFFF">
  <tr>
    <td><div style="font-size:18px; font-family:Verdana; text-align:center"><? if($video_id != ""){ echo "Comments of ID: ".$video_id; } else { echo "Whole Comments List"; } ?></div> 
      <br />
      <table width="480" border="0" align="center" cellpadding="0" cellspacing="0">
        <tr>
          <td width="478">
          <?
          
          if (isset($_GET['comm_nr'])){
          
          echo '<div style="text-align: center; margin-bottom: 5px;">Comment Deleted<br />';
          echo '<a href="javascript:history.back();">Go Back</a></div>';
          
          } else {

                              while($row = dbarray($result))
                              {
                                echo '<div style="border-bottom: 1px solid #E6E6E6; margin-bottom: 10px; font-size: 13px;">';
                                echo 'Posted by: ';
                
                                if ($row['uwebsite']){
                                  echo '<a rel="nofollow" href="'.$site_url.'redirect.php?url='.$row['uwebsite'].'" target="_blank">'.$row['uname'].'</a>';
                                } else {
                                  echo $row['uname'];
                                }
                                
                                echo ' @ '.$row['date'];
                                echo ' - <strong>[ <a href="'.$site_url.'administrator/comments.php?video_id='.$row['vid'].'&comm_nr='.$row['id'].'">Delete Comment</a> ]</strong>';
                                echo '<br />';
                                echo '<div style="color:#000000; padding-left:5px;">'.SpecialChars($row['comment']).'</div>';
                                echo '</div>';
                              }

            if ($count > 0) {

                  echo "
                         <div style=\"text-align:center; clear:both;\"><br />";
                  $i=0;
                  $l=1;
                  for($i=0;$i < $count;$i=$i+$limit)
                  {
                  if ($video_id == ""){
                    if($i <> $eu){ echo " <strong><a href='".$site_url."administrator/comments.php?nr=".$i."'>".$l."</a></strong> "; }
                    else { echo " <strong><a href='".$site_url."administrator/comments.php?nr=".$i."'>".$l."</a></strong> "; }
                  } else {
                    if($i <> $eu){ echo " <strong><a href='".$site_url."administrator/comments.php?video_id=".$video_id."&nr=".$i."'>".$l."</a></strong> "; }
                    else { echo " <strong><a href='".$site_url."administrator/comments.php?video_id=".$video_id."&nr=".$i."'>".$l."</a></strong> "; }
                  }
                    $l=$l+1;
                  }
                  echo "</div><br />";
            }
            
          }
    
          ?>
          </td>
        </tr>
      </table>
      </td>
  </tr>
</table>
</body>
</html>
