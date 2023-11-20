<ul>
<li><a href="<? echo $site_url?>">Home</a></li>
<li><a href="<? echo $site_url?>member_search.php">Members</a></li>
<li class="hassubmenu">
			<a href="javascript:;">Videos</a>
										
<div class="submenu nrtwo">	
				
				<div class="col">
					<h3>Most searched</h3>
						
					<p>
					<table width="100%"><? TopVideos() ?></table>
					</p>
				</div><!-- .col -->
				
				
				<div class="col">		
					
					<h3>Find by tags</h3>
						
					<p><? TagCloud(25); ?></p>			
				</div><!-- .col -->
			</div><!-- .submenu -->					
		</li>
		
				
<li class="right">
<form id="form1" name="form1" method="get" action="index.php" onsubmit="location.href='<?=$site_url?>show/' + encodeURIComponent(this.tag.value).replace(/%20/g, '+'); return false;">
                <input name="tag" type="text" class="text big" id="search2" />               
            </form>
</li>		
	</ul>		