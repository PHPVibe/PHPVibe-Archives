<div id="top_right">
	<div class="bluesearch">
            <h2>Search:</h2>
            <form id="form1" name="form1" action="index.php" method="get" onsubmit="location.href='<?=$site_url?>show-videos/' + encodeURIComponent(this.tag.value).replace(/%20/g, '+'); return false;">
              <label><span>
                <input name="tag" type="text" id="tag" class="keywords" maxlength="50" value="" />
                </span>
                <input name="b" type="image" src="<?=$site_url?>templates/<?=$template?>/images/search.gif" class="button" />
              </label>
            </form>            
   </div>
	</div>
	
	<!-- Logo & Slogan -->
	<div id="logo">
	 <h1><a href="<?=$site_url?>"><?=$site_title?></a></h1>
	 <p id="slogan"><?=$site_slogan?></p>
	</div>
	<!-- Logo & Slogan / END -->
	
<div id="mainmenu">
<ul id="nav" class="dropdown dropdown-horizontal">
<li><span class="dir">Most Searched</span>
<ul>
<? MenuVideos() ?>
</ul>
</li>

<li id="n-news"><a href="<?=$site_url?>most-discussed" class="dir">Most discussed</a></li>
<li id="n-music"><a href="<?=$site_url?>top-rated" class="dir">Top Rated</a></li>
<li id="n-pop"><a href="<?=$site_url?>most-viewed" class="dir">Popular Videos</a></li>
<li id="n-movies"><span class="dir">TV Categories &amp; More</span>		<ul>
			<? CatMenu() ?>
	
		</ul>
</li>

</ul>
</div>