<? 
require_once('mainfile.php');

        $what  = $_REQUEST['what'];
        $start = $_REQUEST['nr'];

        if($start == "") { $start = 0; }

        $eu = ($start - 0);
        $limit = 10;                                 // Videos Per Page

        if ($what == "md"){
          $result=dbquery("SELECT * FROM videos WHERE comments > 0 ORDER BY comments DESC limit $eu, $limit");
          $count = dbcount("*", "videos", "comments != 0");
          $whati = "most-discussed"; }
        elseif ($what == "mv"){
          $result=dbquery("SELECT * FROM videos ORDER BY views DESC limit $eu, $limit");
          $count = dbcount("*", "videos");
          $whati = "most-viewed"; }
        elseif ($what == "tr"){
          $result=dbquery("SELECT * FROM videos WHERE rating > 0 ORDER BY rating DESC limit $eu, $limit");
          $count = dbcount("*", "videos", "rating != 0");
          $whati = "top-rated"; }
	
	function TagCloud($nr){
	
    $result = dbquery("SELECT * FROM tags WHERE tag != '' ORDER BY RAND() LIMIT 0,".$nr."");
    
    while ($info = dbarray($result)):
      $tags .= $info['tag'].", ";
    endwhile;
    
    $tags_array = explode(', ', substr($tags, 0, -2));
    shuffle($tags_array);
      
    foreach($tags_array as $tag):
    
      $font_size = rand(1,5);
      $color_array = array('black', 'blue', 'green', 'red', 'chartreuse', 'gray', 'yellowgreen', 'yellow');
      shuffle($color_array);
      $font_color = $color_array[0];
      
      if (strlen($tag) >= 2):
        $taglink = str_replace(' ', '+', $tag);
        echo '<a href="'.$site_url.'show-videos/'.$taglink.'" style="text-decoration:none">'.$tag.',</a> ';    
      endif;
      
    endforeach;
      		
	}
	
	function TopVideos(){
    $check = dbrows(dbquery("SELECT tagid FROM tags"));
    if($check > 0):
      $result = dbquery("SELECT * FROM tags ORDER BY tcount DESC limit 13");
      while($row = dbarray($result)):
       echo "<tr>";
        echo "<td style=\"width: 90%; padding-left: 10px;\"><a href=\"".$site_url."show-videos/".str_replace(' ', '+', $row['tag'])."\">".ucfirst($row['tag'])."</a></td>";
        echo "<td style=\"width: 10%;\">".$row['tcount']."</td>";
       echo "</tr>";
      endwhile;
    endif;
	}

  // Show Template
  if($template != ""):
    if(is_file('templates/'.$template.'/mv-md-tr.php')):
      require_once('templates/'.$template.'/mv-md-tr.php');
    else:
      die("Your template appears to be corrupt. Try re-uploading the folder.".'/templates/'.$template);
    endif;
  else: die("Your default template doesn't appear to be set.");
  endif;
  
ob_end_flush();
?>