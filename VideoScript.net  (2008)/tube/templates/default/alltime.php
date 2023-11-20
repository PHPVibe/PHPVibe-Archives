<? 

  echo'  
<div class="zuubed 4video-col">';


 

  // DOMElement->getElementsByTagName() -- Gets elements by tagname 

  // nodeValue : The value of this node, depending on its type. 

  // Load XML File. You can use loadXML if you wish to load XML data from a string 



  $objDOM = new DOMDocument(); 

  $objDOM->load("cache/index.xml"); //make sure path is correct 





  $note = $objDOM->getElementsByTagName("video"); 

  // for each note tag, parse the document and get values for 

  // tasks and details tag. 

$count = 0;
  foreach( $note as $value ) 
  { 
    $urls = $value->getElementsByTagName("videourl"); 

    $url  = $urls->item(0)->nodeValue; 

	

    $titles = $value->getElementsByTagName("videotitle"); 

    $title  = $titles->item(0)->nodeValue; 

	

	$cats = $value->getElementsByTagName("videocat"); 

    $cat  = $cats->item(0)->nodeValue; 

	

	$times = $value->getElementsByTagName("videotime"); 

    $time  = $times->item(0)->nodeValue; 



    $ids = $value->getElementsByTagName("videoid"); 

    $id  = $ids->item(0)->nodeValue; 

/*if($i%2==0){ $the_float='float'; }
elseif($i%2!=0) { $the_float='float right_zero'; }
else { $the_float='float left_zero'; }
*/


  echo'  
  
  <div class="zuvideoitem">
                        <div class="zuvid">
                            <center><strong><a href="'.$url.'">'.substr($title,0,27).'</a></strong></center>
                            <p class="image">
								<a href="'.$url.'" class="frame" title="'.$title.'">									
									<img src="http://i4.ytimg.com/vi/'.$id.'/0.jpg" alt="'.$title.'" width="201" height="91" />									
								</a>
							</p>
                                                  </div>
                    </div>
				';

if (++$count == 24) {
            break;
        }
  } 
  echo'  
</div>';



?> 

	

       

      