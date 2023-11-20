<?php include_once("header.php");?>
	<div id="content">
<div class="box">
<div class="box-header"><h1>Youtube import </h1></div>
<div class="box-content">
 <div class="searchWidget">
                    <form action="youtube_search.php">
                        <input type="text" name="s" id="s" placeholder="Search from Youtube: Enter keyword(s)" />
                        <input type="submit" value="" />
                    </form>
                </div>

<div class="widget" style="width:100%; min-width:700px;">
 <div class="title"><img src="img/icons/magnify.png" alt="" class="titleIcon" /><h6>Import from Youtube</h6></div>
<div class="body">
Recent videos on Youtube
<div style="float:right;margin-right:3px;">
<div class="num"><a href="<?php echo $admin_panel;?>youtube_feed.php?list=most_recent" class="blueNum">Today</a></div>
</div>
</div>
<div class="body">
Most viewed on Youtube
<div style="float:right;margin-right:3px;">
<div class="num"><a href="<?php echo $admin_panel;?>youtube_feed.php?list=most_viewed&time=today" class="blueNum">Today</a></div>
<div class="num"><a href="<?php echo $admin_panel;?>youtube_feed.php?list=most_viewed&time=this_week" class="redNum">This month</a></div>
<div class="num"><a href="<?php echo $admin_panel;?>youtube_feed.php?list=most_viewed&time=all_time" class="greenNum">Always</a></div>

</div>
</div>
<div class="body">
Top rated on Youtube
<div style="float:right;margin-right:3px;">
<div class="num"><a href="<?php echo $admin_panel;?>youtube_feed.php?list=top_rated&time=today" class="blueNum">Today</a></div>
<div class="num"><a href="<?php echo $admin_panel;?>youtube_feed.php?list=top_rated&time=this_week" class="redNum">This month</a></div>
<div class="num"><a href="<?php echo $admin_panel;?>youtube_feed.php?list=top_rated&time=all_time" class="greenNum">Always</a></div>

</div>
</div>
<div class="body">
Popular on Youtube
<div style="float:right;margin-right:3px;">
<div class="num"><a href="<?php echo $admin_panel;?>youtube_feed.php?list=most_popular&time=today" class="blueNum">Today</a></div>
<div class="num"><a href="<?php echo $admin_panel;?>youtube_feed.php?list=most_popular&time=this_week" class="redNum">This month</a></div>
<div class="num"><a href="<?php echo $admin_panel;?>youtube_feed.php?list=most_popular&time=all_time" class="greenNum">Always</a></div>

</div>
</div>
<div class="body">
Most commented on Youtube
<div style="float:right;margin-right:3px;">
<div class="num"><a href="<?php echo $admin_panel;?>youtube_feed.php?list=most_discussed&time=today" class="blueNum">Today</a></div>
<div class="num"><a href="<?php echo $admin_panel;?>youtube_feed.php?list=most_discussed&time=this_week" class="redNum">This month</a></div>
<div class="num"><a href="<?php echo $admin_panel;?>youtube_feed.php?list=most_discussed&time=all_time" class="greenNum">Always</a></div>

</div>
</div>
</div>
</div>


<br style="clear:both;">

		
	
</div>	

	</div>
	
<?php include_once("footer.php");?>