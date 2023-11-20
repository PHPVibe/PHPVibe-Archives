<?php the_sidebar(); ?>
<div class="span10 nomargin video-holder top10">
<?php if(has_list()) { ?>
<div class="video-header row-fluid nomargin <?php if(has_list()) { echo 'list-header'; }?>">
<div class="span8 nomargin left-header">
<i class="icon-signal"></i><span class="tt"><?php echo stripslashes(_cut(list_title(_get('list')), 60)); ?></span>
</div>
<div class="pull-right span4 nomargin">
<div class="pull-right">
<?php if(!empty($_SESSION['last-seen'])) {echo '<a href="'.$_SESSION['last-seen'].'" class="tipN" title="'.$_SESSION['last-seen-title'].'"><i class="icon-double-angle-left"></i></a>';}?>
<?php if($next['av']) { echo '<a href="'.$next['link'].'" class="tipN" title="'.$next['title'].'"><i class="icon-double-angle-right"></i></a>';}?>
</div>
</div>
</div>
<?php } ?>
<div id="video-content" class="span7">
<div id="video-wrapper">

<div class="video-player pull-left">
<?php echo $embedvideo;  ?>
<div class="clearfix"></div>
</div>
<div class="clearfix"></div>
</div>

<div class="video-under">
<div class="full top10 bottom20">
<div class="pull-left user-box" style="">
<?php echo '<a class="userav" href="'.profile_url($video->user_id, $video->owner).'" title="'.$video->owner.'"><img class="img-shadow" src="'.thumb_fix($video->avatar).'" /></a>'; ?>
<div class="pull-right">
<?php echo '<a class="" href="'.profile_url($video->user_id, $video->owner).'" title="'.$video->owner.'"><h3>'.$video->owner.'</h3></a>'; ?>
<?php subscribe_box($video->user_id); ?>
</div>
</div>
<div class="likes-holder">
<a href="javascript:iLikeThis(<?php echo $video->id; ?>)" id="i-like-it" class="tipE likes" title="<?php echo _lang('Like');?>"><i class="icon-thumbs-up"></i><?php echo _lang('Like');?></a>
<a href="javascript:iHateThis(<?php echo $video->id; ?>)" id="i-dislike-it" class="pv_tip dislikes" data-toggle="tooltip" data-placement="right" title="<?php echo _lang('Dislike');?>"><i class="icon-thumbs-down"></i></a>
<a id="addtolist" href="javascript:void(0)" class="tipW" title="<?php echo _lang('Add To');?>"><i class="icon-plus"></i> <?php echo _lang('Add To');?></a>
<a id="report" href="javascript:void(0)" class="tipW" title="<?php echo _lang('Report video');?>"><i class="icon-flag"></i></a>
</div>
<div class="like-box pull-right">
<div class="like-views pull-right">
<?php echo number_format($video->views); ?>
</div>
<div class="progress progress-micro"><div class="bar bar-green" style="width: <?php echo $likes_percent;?>%;"></div><div class="bar bar-red second" style="width: <?php echo $dislikes_percent;?>%;"></div></div>
<div class="like-show">
<i class="icon-thumbs-up"></i> <?php echo $video->liked; ?> 
<i class="icon-thumbs-down"></i> <?php echo $video->disliked; ?>
</div>
</div>	
<div class="clearfix"></div>
</div>
<div class="video-header row-fluid nomargin">
<div class="span8 nomargin">
<?php echo stripslashes(_cut($video->title, 280)); ?> - <?php echo time_ago($video->date)?>
</div>
<div class="pull-right span4 nomargin">
<div class="pull-right">
<?php if(!empty($_SESSION['last-seen'])) {echo '<a class="tipN" href="'.$_SESSION['last-seen'].'" title="'.$_SESSION['last-seen-title'].'"><i class="icon-double-angle-left"></i></a>';}?>
<?php if($next['av']) { echo '<a class="tipN" href="'.$next['link'].'" title="'.$next['title'].'"><i class="icon-double-angle-right"></i></a>';}?>
</div>
</div>
</div>
<div class="clearfix"></div>
<div id="report-it" class="well clearfix">
<div class="form-name"><i class="icon-flag"></i><?php echo _lang('Report video');?>  </div>
<?php if (!is_user()) { ?>
<p><?php echo _lang('Please login in order to report videos.');?></p>
<?php } elseif (is_user()) { ?>
<div class="ajax-form-result"></div>  
<form class="horizontal-form ajax-form" action="<?php echo site_url().'lib/ajax/report.php';?>" enctype="multipart/form-data" method="post">
<input type="hidden" name="id" value="<?php echo $video->id;?>" />
<input type="hidden" name="token" value="<?php echo $_SESSION['token'];?>" />
<div class="control-group" style="border-top: 1px solid #fff;">
	                                        <label class="control-label"><?php echo _lang('Reason for reporting');?>: </label>
	                                        <div class="controls">
												<label class="checkbox">
													<input type="checkbox" name="rep[]" value="<?php echo _lang('Video not playing');?>" class="styled">
													<?php echo _lang('Video not playing');?>
												</label>
												<label class="checkbox">
													<input type="checkbox" name="rep[]" value="<?php echo _lang('Wrong title/description');?>" class="styled">
													<?php echo _lang('Wrong title/description');?>
												</label>
												<label class="checkbox">
													<input type="checkbox" name="rep[]" value="<?php echo _lang('Video is offensive');?>" class="styled">
													<?php echo _lang('Video is offensive');?>
												</label>
												<label class="checkbox">
													<input type="checkbox" name="rep[]" value="<?php echo _lang('Video is restricted');?>" class="styled">
													<?php echo _lang('Video is restricted');?>
												</label>
												<label class="checkbox">
													<input type="checkbox" name="rep[]" value="<?php echo _lang('Copyrighted material');?>" class="styled">
													<?php echo _lang('Copyrighted material');?>
												</label>

												
	</div>										

</div>
<div class="control-group">
	                                    <label class="control-label"><?php echo _lang('Details of the report');?></label>
	                                    <div class="controls">
	                                        <textarea rows="5" cols="3" name="report-text" class="full auto"></textarea>
	                                    </div>
	                                </div>
<button class="button pull-right" type="submit"><i class="icon-ok"></i><?php echo _lang('Send report');?>	</button>
</form>		
<?php } ?>							
</div>
<div id="bookit" class="well clearfix">
<div class="form-name"><i class="icon-plus"></i><?php echo _lang('Add To');?>  </div>
<?php if (!is_user()) { ?>
<p><?php echo _lang('Please login in order to collect videos.');?></p>
<?php } elseif (is_user()) { ?>
<div class="ajax-form-result"></div>  
<form class="horizontal-form ajax-form" action="<?php echo site_url().'lib/ajax/playlist-add.php';?>" enctype="multipart/form-data" method="post">
<input type="hidden" name="vp-id" value="<?php echo $video->id;?>" />
<input type="hidden" name="token" value="<?php echo $_SESSION['token'];?>" />
<?php $playlists = $db->get_results("SELECT id, title from ".DB_PREFIX."playlists where owner='".user_id()."' and id not in (SELECT playlist from ".DB_PREFIX."playlist_data where video_id='".$video->id."') limit 0,10000");
if($playlists) {							
?>
<div class="bottom20 clearfix">
<button class="button pull-right" type="submit"><i class="icon-ok"></i><?php echo _lang('Collect in selected');?>	</button>
</div>	
				
	                	<!-- Left box -->
	                    <div class="left-box">
	                        <input type="text" id="box1Filter" class="box-filter" placeholder="Filter entries..." /><button type="button" id="box1Clear" class="filter">x</button>
	                        <select id="box1View" multiple="multiple" class="multiple">
							<?php foreach ($playlists as $pl) { ?>
	                            <option value="<?php echo $pl->id;?>"><?php echo stripslashes($pl->title);?></option>
	                            
	                           <?php } ?>
	                        </select>
	                        <span id="box1Counter" class="count-label"></span>
	                        <select id="box1Storage"></select>
	                    </div>
	                    <!-- /left-box -->
	                    
	                    <!-- Control buttons -->
	                    <div class="dual-control">
	                        <button id="to2" type="button" class="btn">&nbsp;&gt;&nbsp;</button>
	                        <button id="allTo2" type="button" class="btn">&nbsp;&gt;&gt;&nbsp;</button><br />
	                        <button id="to1" type="button" class="btn">&nbsp;&lt;&nbsp;</button>
	                        <button id="allTo1" type="button" class="btn">&nbsp;&lt;&lt;&nbsp;</button>
	                    </div>
	                    <!-- /control buttons -->
	                    
	                    <!-- Right box -->
	                    <div class="right-box">
	                        <input type="text" id="box2Filter" class="box-filter" placeholder="Filter entries..." /><button type="button" id="box2Clear" class="filter">x</button>
	                        <select id="box2View" name="booked[]" multiple="multiple" class="multiple">
	                           
	                        </select>
	                        <span id="box2Counter" class="count-label"></span>
	                        <select id="box2Storage"></select>
	                    </div>
	                    <!-- /right box -->
						
	              
<?php } else {echo _lang('You have no playlists that don\'t contain this video');} ?>	
 	<div class="clearfix"></div>
</form> 
<?php } ?>			  
				  	<div class="clearfix"></div>
					
	                </div>
	     
	           

<div class="fb-like" data-href="<?php echo $canonical; ?>" data-send="true" data-width="450" data-show-faces="true"></div>
<?php if(get_option('addthis') == 1 ) {  ?>
<!-- AddThis Button BEGIN -->
<div class="addthis_toolbox addthis_default_style addthis_32x32_style">
<a class="addthis_button_preferred_1"></a>
<a class="addthis_button_preferred_2"></a>
<a class="addthis_button_preferred_3"></a>
<a class="addthis_button_preferred_4"></a>
<a class="addthis_button_compact"></a>
<a class="addthis_counter addthis_bubble_style"></a>
</div>
<script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=xa-523ac5df4791e1ff"></script>
<!-- AddThis Button END -->
<?php } ?>
<div class="more_desc clearfix full">
 <span class="meta-mores more" id="55549">
 <a href="javascript:void(0)" id="show_desc" class="btn"> 
<?php echo _lang('Details & embed'); ?>
 </a>
</span>
 </div>
 
 <div class="video-description i-box clearfix bottom20" style="width:98%;">
<h1><?php echo _html($video->title); ?></h1>
<p><?php echo _lang('Channel'); ?> : <a href="<?php echo channel_url($video->category, $video->channel_name); ?>"><?php echo stripslashes($video->channel_name); ?></a></p>
<form class="horizontal-form">
<div class="control-group">
<label class="control-label"><i class="icon-play-circle"></i><?php echo _lang('Link to video'); ?></label>
<div class="controls">
<input type="text" name="link-to-this" class="span6" value="<?php echo canonical(); ?>" /> 						
</div>	
</div>
<div class="control-group">
	<label class="control-label"><i class="icon-share"></i><?php echo _lang('Embed code'); ?></label>
	<div class="controls">
	<textarea id="embed" name="share-embed" class="span6"><?php echo $embedvideo;  ?><br /> <a href="<?php echo canonical(); ?>" target="_blank" title="<?php echo stripslashes(_cut($video->title, 280)); ?>"><?php echo stripslashes(_cut($video->title, 280)); ?></a> -  <a href="<?php echo site_url(); ?>" title="<?php echo get_option('seo_title'); ?>" target="_blank"><?php echo get_option('site-logo-text'); ?></a></textarea>
	
	</div>
	</div>
</form>
<p><?php echo _html($video->description); ?></p>
<ul class="video-tags full top10"><?php echo pretty_tags($video->tags,'btn small-button','<li>','</li>');?></ul>

 <div class="clearfix"></div>
</div>
 
 <div class="clearfix"></div>
<?php echo comments() ?>
<div class="clearfix"></div>
</div>
</div>
<div class="video-under-right nomargin">
<?php  if(has_list()) { ?>
<div class="video-player-sidebar pull-left">
<div class="items">
<ul>
<?php
layout('layouts/list');
?>
	
</ul>
</div>
<div class="clearfix"></div>
</div>
<div class="clearfix"></div>
<?php }  ?>
<div class="related video-related">
<ul>
<?php
layout('layouts/related');
?>
			
</ul>
</div>
</div>
</div>
</div>