<?php   defined('C5_EXECUTE') or die(_("Access Denied.")); 
$dh = Loader::helper('form/date_time');
$ah = Loader::helper('concrete/interface');
?>
<div id="ccm-eventsBlock-eventRow<?php  echo $eventInfo['eventsEventId']?>" class="ccm-eventsBlock-eventRow" >
	<div class="backgroundRow">
                <div class="cm-eventsBlock-eventRowIcons" >
			<div style="float:right">
                                <div style="margin-top:4px"><a onclick="EventsBlock.removeEvent('<?php  echo $eventInfo['eventsEventId']?>')"><img src="<?php  echo ASSETS_URL_IMAGES?>/icons/delete_small.png" /></a></div>
				<a onclick="EventsBlock.moveUp('<?php  echo $eventInfo['eventsEventId']?>')" class="moveUpLink"></a>
				<a onclick="EventsBlock.moveDown('<?php  echo $eventInfo['eventsEventId']?>')" class="moveDownLink"></a>									  
			</div>
		</div>
		<strong><?php echo $eventInfo['event_name']?></strong><br/><br/>
		
		<!--
		<?php  echo t('Duration')?>: <input type="text" name="duration[]" value="<?php  echo intval($imgInfo['duration'])?>" style="vertical-align: middle; width: 30px" />
		&nbsp;
		<?php  echo t('Fade Duration')?>: <input type="text" name="fadeDuration[]" value="<?php  echo intval($imgInfo['fadeDuration'])?>" style="vertical-align: middle; width: 30px" />
		&nbsp;
		<?php  echo t('Set Number')?>: <input type="text" name="groupSet[]" value="<?php  echo intval($imgInfo['groupSet'])?>" style="vertical-align: middle; width: 30px" /><br/>
		-->
		
		<table class="eventOptionsGrid" >
                    <tr>
                        <td><?php echo t('Name'); ?></td>
                        <td><input type="text" name="event_name[]" value="<?php  echo $eventInfo['event_name']?>" style="vertical-align: middle; font-size: 10px; width: 140px" />
                        </td>
                    </tr>
                    <tr>
                        <td><?php echo t('Date (YYYY-MM-DD)'); ?></td>
                        <td><input type="text" name="event_date[]" value="<?php  echo $eventInfo['event_date']?>" style="vertical-align: middle; font-size: 10px; width: 140px" />
                        </td>
                    </tr>
                    <tr>
                        <td><?php echo t('Publish From (YYYY-MM-DD)'); ?></td>
                        <td><input type="text" name="publish_from[]" value="<?php  echo $eventInfo['publish_from']?>" style="vertical-align: middle; font-size: 10px; width: 140px" />
                        </td>
                    </tr>
                    <tr>
                        <td><?php echo t('Publish To (YYYY-MM-DD)'); ?></td>
                        <td><input type="text" name="publish_to[]" value="<?php  echo $eventInfo['publish_to']?>" style="vertical-align: middle; font-size: 10px; width: 140px" />
                    </tr>
                    <tr>
                        <td><?php echo t('Short Description'); ?></td>
                        <td><textarea name="short_description[]" rows="3" cols="30"><?php  echo $eventInfo['short_description']?></textarea>
                    </tr>
                    <tr>
			<td><b>Image (Optional)</b></td>
			<td style="border: 1px dotted #aaa">
				<span id="ccm-eventsBlock-chooseImg"><?php  echo $ah->button_js(t('Select Image'), 'EventsBlock.chooseImg('.$eventInfo['eventsEventId'].')');?></span>
                                <span id="ccm-eventsBlock-removeImg"><?php  echo $ah->button_js(t('Remove Image'), 'EventsBlock.removeImg('.$eventInfo['eventsEventId'].')');?></span>
				<input type="hidden" id="fID_<?php echo $eventInfo['eventsEventId'] ?>" name="fID[]" value="<?php echo $eventInfo['fID']; ?>"/>
				<span id="fID_bg_<?php echo $eventInfo['eventsEventId']; ?>" style="display: block; width: 100px; height: 60px; background: url(<?php echo $eventInfo['thumbPath']; ?>) no-repeat top left;">&nbsp;</span>
				&nbsp;
				<span id="fID_title_<?php echo $eventInfo['eventsEventId']; ?>" style="font-weight: bold;"><?php echo $eventInfo['fileName']; ?></span>
			</td>
                    </tr>
		</table>
                <input type="hidden" name="eventsEventId[]" value="<?php echo $eventInfo['eventsEventId']; ?>"/>
	</div>
</div>
