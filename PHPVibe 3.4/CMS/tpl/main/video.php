<div class="video-holder row-fluid top10">
<div class="video-header row-fluid list-header">
<?php if(has_list()){?>
<span class="label label-danger"><i class="icon-reorder"></i></span>
<span class="tt"><?php  echo _html(_cut(list_title(_get('list')),60));?></span>
<div class="next-an pull-right"><a href="<?php  echo $canonical;?>"><i class="icon-pause"></i></a></div>
<?php } else { ?>
<span class="label label-danger"><i class="icon-play"></i></span>
<span class="tt"> <?php  echo _html(_cut($video->title,300));?> <?php  echo _lang('by').' '._html(_cut($video->owner,80));?> </span>
<?php } ?>
</div>

<div class="row-fluid player-in-list">
<div id="video-content" class="span77" style="height:<?php echo $height;?>px">
<?php echo _ad('1');?>
<div id="video-wrapper">
<div class="video-player pull-left player-in-list" style="height:<?php echo $height;?>px">
<?php echo $embedvideo; ?>
<div class="clearfix"></div>
</div>
<div class="clearfix"></div>
</div>
<div class="clearfix"></div>
</div>
<div class="video-under-right nomargin pull-right span5">
<div class="video-player-sidebar pull-left">
<div class="items">
<ul>
<?php
if(has_list()){
 layout('layouts/list');
 } else {
 layout('layouts/user_videos');
} ?>
</ul>
</div>
<div class="clearfix"></div>
</div>
<div class="clearfix"></div>

</div>
</div>
<div class="video-under-right nomargin pull-right span5">
<?php echo _ad('0','related-videos-top');?>
<div class="related video-related top10 related-with-list">
<ul>
<?php
layout('layouts/related');?>			
</ul>
</div>
</div>

<div class="video-under span77">
<div class="video-header row-fluid nomargin">
<h1><?php echo _html($video->title);?></h1>
</div>
<div class="full top10 bottom20">
<div class="pull-left user-box" style="">
<?php
echo '<a class="userav" href="'.profile_url($video->user_id,$video->owner).'" title="'.$video->owner.'"><img class="img-shadow" src="'.thumb_fix($video->avatar).'" /></a>';?>
<div class="pull-right">
<?php
echo '<a class="" href="'.profile_url($video->user_id,$video->owner).'" title="'.$video->owner.'"><h3>'.$video->owner.'</h3></a>';?>
<?php
subscribe_box($video->user_id);?>
</div>
</div>
<div class="likes-holder">
<a href="javascript:iLikeThis(<?php
echo $video->id;?>)" id="i-like-it" class="tipE likes" title="<?php
echo _lang('Like');?>"><i class="icon-thumbs-up"></i><?php
echo _lang('Like');?></a>
<a href="javascript:iHateThis(<?php
echo $video->id;?>)" id="i-dislike-it" class="pv_tip dislikes" data-toggle="tooltip" data-placement="right" title="<?php
echo _lang('Dislike');?>"><i class="icon-thumbs-down"></i></a>
<a id="addtolist" href="javascript:void(0)" class="tipW" title="<?php
echo _lang('Add To');?>"><i class="icon-plus"></i> <?php
echo _lang('Add To');?></a>
<a id="report" href="javascript:void(0)" class="tipW" title="<?php
echo _lang('Report video');?>"><i class="icon-flag"></i></a>
</div>
<div class="like-box pull-right">
<div class="like-views pull-right">
<?php
echo number_format($video->views);?>
</div>
<div class="progress progress-micro"><div class="bar bar-success" style="width: <?php echo $likes_percent;?>%;"></div>
<div class="bar bar-danger second" style="width: <?php echo $dislikes_percent;?>%;"></div></div>
<div class="like-show">
<i class="icon-thumbs-up"></i> <?php echo $video->liked;?> 
<i class="icon-thumbs-down"></i> <?php echo $video->disliked; ?>
</div>
</div>	
<div class="clearfix"></div>
</div>
<div class="clearfix"></div>
<div id="report-it" class="well clearfix">
<div class="form-name"><i class="icon-flag"></i><?php echo _lang('Report video');?>  </div>
<?php
if(!is_user()){?>
<p><?php
 echo _lang('Please login in order to report videos.');?></p>
<?php
}elseif(is_user()){?>
<div class="ajax-form-result"></div>  
<form class="horizontal-form ajax-form" action="<?php
 echo site_url().'lib/ajax/report.php';?>" enctype="multipart/form-data" method="post">
<input type="hidden" name="id" value="<?php  echo $video->id;?>" />
<input type="hidden" name="token" value="<?php  echo $_SESSION['token'];?>" />
<div class="control-group" style="border-top: 1px solid #fff;">
	                                        <label class="control-label"><?php  echo _lang('Reason for reporting');?>: </label>
	                                        <div class="controls">
												<label class="checkbox">
													<input type="checkbox" name="rep[]" value="<?php
 echo _lang('Video not playing');?>" class="styled">
													<?php
 echo _lang('Video not playing');?>
												</label>
												<label class="checkbox">
													<input type="checkbox" name="rep[]" value="<?php
 echo _lang('Wrong title/description');?>" class="styled">
													<?php
 echo _lang('Wrong title/description');?>
												</label>
												<label class="checkbox">
													<input type="checkbox" name="rep[]" value="<?php
 echo _lang('Video is offensive');?>" class="styled">
													<?php
 echo _lang('Video is offensive');?>
												</label>
												<label class="checkbox">
													<input type="checkbox" name="rep[]" value="<?php
 echo _lang('Video is restricted');?>" class="styled">
													<?php
 echo _lang('Video is restricted');?>
												</label>
												<label class="checkbox">
													<input type="checkbox" name="rep[]" value="<?php
 echo _lang('Copyrighted material');?>" class="styled">
													<?php
 echo _lang('Copyrighted material');?>
												</label>

												
	</div>										

</div>
<div class="control-group">
	                                    <label class="control-label"><?php
 echo _lang('Details of the report');?></label>
	                                    <div class="controls">
	                                        <textarea rows="5" cols="3" name="report-text" class="full auto"></textarea>
	                                    </div>
	                                </div>
<button class="button pull-right" type="submit"><i class="icon-ok"></i><?php
 echo _lang('Send report');?>	</button>
</form>		
<?php
}?>							
</div>
<div id="bookit" class="well clearfix">
<div class="form-name"><i class="icon-plus"></i><?php
echo _lang('Add To');?>  </div>
<?php
if(!is_user()){?>
<p><?php
 echo _lang('Please login in order to collect videos.');?></p>
<?php
}elseif(is_user()){?>
<div class="ajax-form-result"></div>  
<form class="horizontal-form ajax-form" action="<?php
 echo site_url().'lib/ajax/playlist-add.php';?>" enctype="multipart/form-data" method="post">
<input type="hidden" name="vp-id" value="<?php
 echo $video->id;?>" />
<input type="hidden" name="token" value="<?php
 echo $_SESSION['token'];?>" />
<?php
 $playlists=$db->get_results("SELECT id, title from ".DB_PREFIX."playlists where owner='".user_id()."' and id not in (SELECT playlist from ".DB_PREFIX."playlist_data where video_id='".$video->id."') limit 0,10000");if($playlists){?>
<div class="bottom20 clearfix">
<button class="button pull-right" type="submit"><i class="icon-ok"></i><?php
 echo _lang('Collect in selected');?>	</button>
</div>	
				
	                	<!-- Left box -->
	                    <div class="left-box">
	                        <input type="text" id="box1Filter" class="box-filter" placeholder="Filter entries..." /><button type="button" id="box1Clear" class="filter">x</button>
	                        <select id="box1View" multiple="multiple" class="multiple">
							<?php
 foreach($playlists as $pl){?>
	                            <option value="<?php
 echo $pl->id;?>"><?php
 echo _html($pl->title);?></option>
	                            
	                           <?php
}?>
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
						
	              
<?php
}else{echo _lang('You have no playlists that don\'t contain this video');}?>	
 	<div class="clearfix"></div>
</form> 
<?php
}?>			  
				  	<div class="clearfix"></div>
					
	                </div>
	     
<div class="row-fluid">
<div class="box">
<div class="box-body list">
<ul>
<li> <i class="icon-list"></i><a href="<?php echo channel_url($video->category,$video->channel_name);?>" title="<?php echo _html($video->channel_name);?>"><span class="redText"><?php echo _html($video->channel_name);?></span></a></li>
<li> <i class="icon-info-sign"></i><span class="small-text"><?php echo makeLn(_html($video->description));?></span></li>
<li> <?php echo pretty_tags($video->tags,'innerR','<i class="icon-tag" style="font-size: 10pt;"></i>','');?></li>
</ul>
</div>
</div>
<div class="video-share">    
        
    <ul class="share-top">
    	<li class="share-sign"><i class="icon-link"></i></li>
        <li class="share-link span11 nomargin"><div class="share-link-input"><input type="text" name="link-to-this" id="share-this-link" class="span12" title="<?php echo _lang('Link to video');?>" value="<?php echo canonical();?>" /> </div></li>
    </ul>
	    <ul class="share-top">
    	<li class="share-sign smt">480x360</li>
        <li class="share-link span11 nomargin"><div class="share-link-input"><input type="text" id="share-embed-code-small" name="embed-this" class="span12" title="<?php echo _lang('Embed this video as 480x360');?>" value='<iframe width="480" height="360" src="<?php echo site_url().embedcode.'/'.$video->id.'/';?>" frameborder="0" allowfullscreen></iframe>' /> </div></li>
    </ul>
	 <ul class="share-top">
    	<li class="share-sign smt">640x480</li>
        <li class="share-link span11 nomargin"><div class="share-link-input"><input type="text" id="share-embed-code-large" name="embed-this" class="span12" title="<?php echo _lang('Embed this video as 640x480');?>" value='<iframe width="640" height="480" src="<?php echo site_url().embedcode.'/'.$video->id.'/';?>" frameborder="0" allowfullscreen></iframe>' /> </div></li>
    </ul>
    <ul class="share-body">
    
        <li class="facebook">
        <a target="_blank" class="icon-facebook" href="http://www.facebook.com/sharer.php?u=<?php echo $canonical; ?>&amp;t=<?php  echo _html(_cut($video->title,300));?>" title=""></a>
        </li>
        
		<li class="twitter">
        <a target="_blank" class="icon-twitter" href="http://twitter.com/home?status=<?php echo $canonical; ?>" title=""></a>
        </li>
        
        <li class="googleplus">
        <a target="_blank" class="icon-google-plus" href="https://plus.google.com/share?url=<?php echo $canonical; ?>" title=""></a>
        </li>
        
        <li class="linkedin">
        <a target="_blank" class="icon-linkedin" href="http://www.linkedin.com/shareArticle?mini=true&amp;url=<?php echo $canonical; ?>" title=""></a>
        </li>
        
    	<li class="pinterest">
        <a target="_blank" class="icon-pinterest" href="http://pinterest.com/pin/create/button/?url=<?php echo $canonical; ?>&media=<?php  echo thumb_fix($video->thumb); ?>&description=<?php  echo _html(_cut($video->title,300));?>" title=""></a>
        </li>
		<li class="fbxs">
		<div class="fb-like" data-href="<?php echo $canonical; ?>" data-width="124" data-layout="button_count" data-action="like" data-show-faces="true" data-share="true"></div>
		</li>
        
    </ul>
        
    </div>
	</div>


<div class="clearfix top20"></div>
<?php echo _ad('0','top-of-comments');?>
<?php
echo comments();?>
<div class="clearfix"></div>
</div>

</div>
</div>
