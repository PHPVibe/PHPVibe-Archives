  
<div class="right_ads">
<?php include("ads.php"); ?>	
</div>
  
<div class="right_articles">
	 <h2>Featured Video : <?=$feautured_video_title?></h2>
	 <script type='text/javascript' src='embed/swfobject.js'></script>
<div id='feat'>Enable javascript.</div>
<script type='text/javascript'>
var s1 = new SWFObject('embed/player.swf','ply','290','200','9','#ffffff');
s1.addParam('allowfullscreen','true');
s1.addParam('allowscriptaccess','always');
s1.addParam('wmode','opaque');
s1.addVariable('file','http://www.youtube.com/watch?v=<?=$feautured_video_id?>');
s1.addVariable('image','http://i4.ytimg.com/vi/<?=$feautured_video_id?>/0.jpg');
s1.addVariable('stretching','exactfit');
s1.write('feat');
</script>
</div>             
        <div class="right_articles">
            <p class="title">Top Videos<p>
            <p><table width="100%"><? TopVideos() ?></table></p>
        </div>
          
        <div class="right_articles">
            <p class="title">Tag Cloud<p>
            <p><? TagCloud(40); ?></p>
        </div>