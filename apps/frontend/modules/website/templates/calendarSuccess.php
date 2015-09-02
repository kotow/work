<div class="eventPlus" onclick="toggleAddEvent('<?php echo $date ?>', this)">Add Event</div>
<div id="eventForm">
Form
</div>
<h1><?php 
if($culture == "bg")
{
	echo UtilsHelper::DateBG($date, "d F Y");
}
else
{
	 echo UtilsHelper::Date($date, "d F Y");
}
?>
</h1>
<br>

<?php if(count($events)>0):?>
	<h2><?php echo UtilsHelper::Localize("website.frontend.EventsTitle");?></h2>
	<ul class="event">
		<?php foreach ($events as $event):
			?>
				<li>
					<div class="eventPlus" onclick="toggleEvent('<?php echo $event->getId() ?>', this)">
						<b><?php echo  UtilsHelper::DateBG($event->getStartDate(), "d F Y")?></b>
						<?php echo $event->getLabel()?>
					</div>
					<div  class="eventContent" id="content_<?php echo $event->getId()?>">
						<?php echo $event->getContent()?>
					</div>
				</li>
		<?php endforeach;?>
	</ul>
<?php endif;?>