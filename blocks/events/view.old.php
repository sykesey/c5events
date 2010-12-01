<?php   defined('C5_EXECUTE') or die(_("Access Denied.")); ?>
<?php   
	$ih = Loader::helper('image');
	
?>	
<!--[if lte IE 7]><link rel="stylesheet" type="text/css" media="all" href="<?php echo DIR_REL; ?>/packages/events/blocks/events/ie.css" /><![endif]-->
<!--[if IE 6]><link rel="stylesheet" type="text/css" media="all" href="<?php echo DIR_REL; ?>/packages/events/blocks/events/ie6.css" /><![endif]-->
<div id="events-wrap-<?php echo $bID?>" class="events-wrap">
<h2 class="eventsheading"><?php echo $title ? $title : "Events"; ?></h2>
<div class="eventlist" id="event-list-<?php echo $bID ?>">
<?php foreach ($events as $event):
$page = Page::getById($event['page_id']);
?>
<div class="event">
	<a href="<?php echo DIR_REL . $page->getCollectionPath(); ?>">
	<?php
	if ($event['fID'] != 0)
	{
		$f = File::getByID($event['fID']);
		$thumbPath = $f->getThumbnailSRC(1);
	?>
	<div class="eventimage">
		<img src="<?php echo $thumbPath; ?>" alt="<?php echo $event['event_name'] ?>"/>
	</div>
	<?php } else { ?>
	<div class="eventdate">
		<span class="month"><?php echo date_format(new DateTime($event['event_date']),'M'); ?></span>
		<span class="date"><?php echo date_format(new DateTime($event['event_date']),'d'); ?></span>
	</div>
	<?php } ?>
	<div class="eventdetail <?php echo ($event['fID'] != 0 ? 'withimage' : ''); ?>">
		<div class="eventheading"><?php echo $event['event_name']; ?></div>
		<span class="eventshort"><?php echo $event['short_description']; ?></span>
	</div>
	</a>
</div>
<?php endforeach; ?>
</div>

</div>