<?php  
defined('C5_EXECUTE') or die(_("Access Denied."));
$al = Loader::helper('concrete/asset_library');
$ah = Loader::helper('concrete/interface');
$dh = Loader::helper('form/date_time');

?>
<style>
#ccm-eventsBlock-addEventFormWrap { display: none; border: 1px solid #ccc; padding: 5px; margin-bottom: 15px; }

#ccm-eventsBlock-eventRows a{cursor:pointer}
#ccm-eventsBlock-eventRows .ccm-eventsBlock-eventRow,
#ccm-eventsBlock-fsRow {margin-bottom:16px;clear:both;padding:7px;background-color:#eee}
#ccm-eventsBlock-eventRows .ccm-eventsBlock-eventRow a.moveUpLink{ display:block; background:url(<?php  echo DIR_REL?>/concrete/images/icons/arrow_up.png) no-repeat center; height:10px; width:16px; }
#ccm-eventsBlock-eventRows .ccm-eventsBlock-eventRow a.moveDownLink{ display:block; background:url(<?php  echo DIR_REL?>/concrete/images/icons/arrow_down.png) no-repeat center; height:10px; width:16px; }
#ccm-eventsBlock-eventRows .ccm-eventsBlock-eventRow a.moveUpLink:hover{background:url(<?php  echo DIR_REL?>/concrete/images/icons/arrow_up_black.png) no-repeat center;}
#ccm-eventsBlock-eventRows .ccm-eventsBlock-eventRow a.moveDownLink:hover{background:url(<?php  echo DIR_REL?>/concrete/images/icons/arrow_down_black.png) no-repeat center;}
#ccm-eventsBlock-eventRows .ccm-eventsBlock-eventRowIcons{ float:right; width:35px; text-align:left; }
#ccm-events-tabs { margin-bottom: 10px; }

table.imgOptionsGrid { margin-top:4px; }
table.imgOptionsGrid td, table.setOptionsGrid td{ vertical-align:top }
</style>
<ul class="ccm-dialog-tabs" id="ccm-events-tabs">
	<li class="ccm-nav-active"><a href="javascript:void(0)" id="ccm-events-list"><?php  echo t('Event List')?></a></li>
	<li><a href="javascript:void(0)" id="ccm-events-options"><?php  echo t('Options')?></a></li>
</ul>
<div id="ccm-events-options-tab" style="display:none">
	<div>
		<label for="title">Title</label><input type="text" name="title" maxlength="255" value="<?php echo $title ? $title : "Events"; ?>"/>
	</div>	
</div>
<div id="ccm-events-list-tab">
	<div id="ccm-eventsBlock-addEventFormWrap">
		<div id="newEvent" style="margin-top:10px;">
		<h4>New Event</h4>
		<table cellspacing="0" cellpadding="3" border="0" width="100%">
		<tr>
			<td><b>Name</b></td>
			<td><input type="text" name="event_name" id="event_name"/></td>
		</tr>
		<tr>
			<td colspan="2"><b>Short Description</b></td>
		</tr>
		<tr>
			<td colspan="2"><textarea cols="30" rows="5" name="short_description" id="short_description"></textarea></td>
		</tr>
		<tr>
			<td><b>Date</b></td>
			<td><?php echo $dh->date('event_date'); ?> <em>Note: Calendar shown if image not set below</em></td>
		</tr>
		<tr>
			<td><b>Publish From</b></td>
			<td><?php echo $dh->date('publish_from'); ?></td>
		</tr>
		<tr>
			<td><b>Publish To</b></td>
			<td><?php echo $dh->date('publish_to'); ?></td>
		</tr>
		<tr>
			<td><b>Image (Optional)</b></td>
			<td style="border: 1px dotted #aaa">
				<span id="ccm-eventsBlock-chooseImg"><?php  echo $ah->button_js(t('Select Image'), 'EventsBlock.chooseImg()');?></span>
				<span id="ccm-eventsBlock-removeImg"><?php  echo $ah->button_js(t('Remove Image'), 'EventsBlock.removeImg()');?></span>
				<input type="hidden" name="fID" id="fID" value="0"/>
				<input type="hidden" name="fID_thumbpath" id="fID_thumbpath" value=""/>
				<span id="fID_bg" style="display: block; width: 100px; height: 60px;">&nbsp;</span>
				&nbsp;
				<span id="fID_title" style="font-weight: bold;"></span>
			</td>
		</tr>
		
		
		<tr style="padding-top: 8px">
		<td colspan="2">
		<br />
		<?php  echo $ah->button_js(t('Save Event'), 'EventsBlock.addNewEvent()', 'left');?>
		<?php  echo $ah->button_js(t('Cancel'), 'EventsBlock.hideAddEvent()', 'right');?>		
		</td>
		</tr>
		</table>
		</div>
	</div>
	<span id="ccm-eventsBlock-addEventButton"><?php  echo $ah->button_js(t('Add New Event'), 'EventsBlock.showAddEvent()', 'left');?></span>
	<br style="clear:both;"/>
	
<h4>Events</h4>
 <div id="ccm-eventsBlock-eventRows">
	
	<?php
	foreach($events as $eventInfo){
		if ($eventInfo['fID'] !== 0)
		{
			$f = File::getByID($eventInfo['fID']);
			$eventInfo['thumbPath'] = $f->getThumbnailSRC(1);
			$eventInfo['fileName'] = $f->getTitle();
		}
		else
		{
			$eventInfo['thumbPath'] = '';
			$eventInfo['fileName'] = '';
		}
		$this->inc('event_row_include.php', array('eventInfo' => $eventInfo));
	}	
	?>

	<div id="eventRowTemplateWrap" style="display: none;">
	<?php  
	$eventInfo['eventsEventId']='tempEventsEventId';
	$eventInfo['fID']='tempfID';
	$eventInfo['fileName']='tempfileName';
	$eventInfo['thumbPath']='tempThumbPath';
	$eventInfo['event_name']='tempName';
	$eventInfo['event_date']='tempEventDate';
	$eventInfo['publish_from']='tempPublishFrom';
	$eventInfo['publish_to']='tempPublishTo';
	$eventInfo['short_description']='tempShortDescription';
	$eventInfo['class']='ccm-eventsBlock-eventRow';
	
	$this->inc('event_row_include.php', array('eventInfo' => $eventInfo)); ?> 
	</div>
 </div>
</div>
<!-- Tab Setup -->
<script type="text/javascript">
	var ccm_fpActiveTab = "ccm-events-list";	
	$("#ccm-events-tabs a").click(function() {
		$("li.ccm-nav-active").removeClass('ccm-nav-active');
		$("#" + ccm_fpActiveTab + "-tab").hide();
		ccm_fpActiveTab = $(this).attr('id');
		$(this).parent().addClass("ccm-nav-active");
		$("#" + ccm_fpActiveTab + "-tab").show();
	});
</script>
