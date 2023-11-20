<?php include_once("header.php");
$channel = MK_Request::getQuery('channel');	
?>
	<div id="content">
<div class="box">
<div class="box-header"><h1>Youtube import </h1></div>
<div class="box-content">
 <div class="searchWidget combined">
                    <form action="youtube_keyword.php">
                        <input type="text" name="s" id="s" placeholder="Search from Youtube: Enter keyword(s)"/>
						<select name="channel"> <?php				
 $chsql = dbquery("SELECT * FROM `channels` order by cat_name ASC");
 while($row = mysql_fetch_array($chsql)){
echo '			
<option value="'.$row["cat_id"].'" />'.$row["cat_name"].' </option>';		
} ?>			
	</select>
                        <input type="submit" value="" />
                    </form>
                </div>
	 <div class="searchWidget combined">
                    <form action="youtube_channel.php">
                        <input type="text" name="s" id="s" placeholder="Youtube Category. Enter a category name"/>
						<select name="channel"> <?php				
 $chsql = dbquery("SELECT * FROM `channels` order by cat_name ASC");
 while($row = mysql_fetch_array($chsql)){
echo '			
<option value="'.$row["cat_id"].'" />'.$row["cat_name"].' </option>';		
} ?>			
	</select>
                        <input type="submit" value="" />
                    </form>
                </div>					
	 <div class="searchWidget combined">
                    <form action="youtube_user.php">
                        <input type="text" name="s" id="s" placeholder="Youtube user videos: Enter username"/>
						<select name="channel"> <?php				
 $chsql = dbquery("SELECT * FROM `channels` order by cat_name ASC");
 while($row = mysql_fetch_array($chsql)){
echo '			
<option value="'.$row["cat_id"].'" />'.$row["cat_name"].' </option>';		
} ?>			
	</select>
                        <input type="submit" value="" />
                    </form>
                </div>			
 <div class="searchWidget combined">
                    <form action="youtube_favorites.php">
                        <input type="text" name="s" id="s" placeholder="Youtube user favorites: Enter username"/>
						<select name="channel"> <?php				
 $chsql = dbquery("SELECT * FROM `channels` order by cat_name ASC");
 while($row = mysql_fetch_array($chsql)){
echo '			
<option value="'.$row["cat_id"].'" />'.$row["cat_name"].' </option>';		
} ?>			
	</select>
                        <input type="submit" value="" />
                    </form>
                </div>		
<div class="widget" style="width:100%; min-width:700px;">
 <div class="title"><img src="img/icons/magnify.png" alt="" class="titleIcon" /><h6>Import from Youtube</h6></div>
<div class="body">

 <div class="searchWidget combined">
                    <form action="">
					  <input type="text" disabled="disabled" placeholder="Select a category before clicking the actual feed >>"/>
						<select name="channel"> <?php				
 $chsql = dbquery("SELECT * FROM `channels` order by cat_name ASC");
 while($row = mysql_fetch_array($chsql)){
echo '			
<option value="'.$row["cat_id"].'" />'.$row["cat_name"].' </option>';		
} ?>			
	</select>
                        <input type="submit" value="" />
                    </form>
                </div>
		<?php if(empty($channel)) { ?>
		<div class="hMsg hWarning">
                <p>There is no channel selected for imported videos</p>
            </div>
			<?php } else { ?>
			<div class="hMsg hSuccess">
                <p>Channel selected. Let's go import videos</p>
            </div>
				<?php } ?>
<br/>
Recent videos on Youtube
<div style="float:right;margin-right:3px;">
<div class="num"><a href="<?php echo $admin_panel;?>youtube_auto_feed.php?channel=<?php echo $channel; ?>&list=most_recent" class="blueNum">Today</a></div>
</div>
</div>
<div class="body">
Most viewed on Youtube
<div style="float:right;margin-right:3px;">
<div class="num"><a href="<?php echo $admin_panel;?>youtube_auto_feed.php?channel=<?php echo $channel; ?>&list=most_viewed&time=today" class="blueNum">Today</a></div>
<div class="num"><a href="<?php echo $admin_panel;?>youtube_auto_feed.php?channel=<?php echo $channel; ?>&list=most_viewed&time=this_week" class="redNum">This month</a></div>
<div class="num"><a href="<?php echo $admin_panel;?>youtube_auto_feed.php?channel=<?php echo $channel; ?>&list=most_viewed&time=all_time" class="greenNum">Always</a></div>

</div>
</div>
<div class="body">
Top rated on Youtube
<div style="float:right;margin-right:3px;">
<div class="num"><a href="<?php echo $admin_panel;?>youtube_auto_feed.php?channel=<?php echo $channel; ?>&list=top_rated&time=today" class="blueNum">Today</a></div>
<div class="num"><a href="<?php echo $admin_panel;?>youtube_auto_feed.php?channel=<?php echo $channel; ?>&list=top_rated&time=this_week" class="redNum">This month</a></div>
<div class="num"><a href="<?php echo $admin_panel;?>youtube_auto_feed.php?channel=<?php echo $channel; ?>&list=top_rated&time=all_time" class="greenNum">Always</a></div>

</div>
</div>
<div class="body">
Popular on Youtube
<div style="float:right;margin-right:3px;">
<div class="num"><a href="<?php echo $admin_panel;?>youtube_auto_feed.php?channel=<?php echo $channel; ?>&list=most_popular&time=today" class="blueNum">Today</a></div>
<div class="num"><a href="<?php echo $admin_panel;?>youtube_auto_feed.php?channel=<?php echo $channel; ?>&list=most_popular&time=this_week" class="redNum">This month</a></div>
<div class="num"><a href="<?php echo $admin_panel;?>youtube_auto_feed.php?channel=<?php echo $channel; ?>&list=most_popular&time=all_time" class="greenNum">Always</a></div>

</div>
</div>
<div class="body">
Most commented on Youtube
<div style="float:right;margin-right:3px;">
<div class="num"><a href="<?php echo $admin_panel;?>youtube_auto_feed.php?channel=<?php echo $channel; ?>&list=most_discussed&time=today" class="blueNum">Today</a></div>
<div class="num"><a href="<?php echo $admin_panel;?>youtube_auto_feed.php?channel=<?php echo $channel; ?>&list=most_discussed&time=this_week" class="redNum">This month</a></div>
<div class="num"><a href="<?php echo $admin_panel;?>youtube_auto_feed.php?channel=<?php echo $channel; ?>&list=most_discussed&time=all_time" class="greenNum">Always</a></div>

</div>
</div>
</div>
</div>


<br style="clear:both;">

		
	
</div>	

	</div>
	
<?php include_once("footer.php");?>