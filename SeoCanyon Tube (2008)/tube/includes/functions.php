<?php
// create the tag cloud
function TagCloud($nr)

{

	

	$result = dbquery("SELECT * FROM tags WHERE tag != '' ORDER BY RAND() LIMIT 0,".$nr."");

	$tags = "";

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

			echo '<a href="show/'.$taglink.'" style="text-decoration:none">'.$tag.',</a> ';    

		endif;

      

	endforeach;

      		

}

// show top tags

function TopVideos()

{

	$check = dbrows(dbquery("SELECT tagid FROM tags"));

	if($check > 0):

		$result = dbquery("SELECT * FROM tags ORDER BY tcount DESC limit 13");

		while($row = dbarray($result)):

			echo "<tr>";

			echo "<td style=\"width: 90%; padding-left: 10px;\"><a href=\"show/".str_replace(' ', '+', $row['tag'])."\">".ucfirst($row['tag'])."</a></td>";

			echo "<td style=\"width: 10%;\">".$row['tcount']."</td>";

			echo "</tr>";

		endwhile;

	endif;

}
?>