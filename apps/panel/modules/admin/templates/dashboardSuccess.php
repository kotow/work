<div class="box drop-shadow">
	<h3 class="lead-heading">Dashboard</h3>
	<div id="boardbox">
<?php
	foreach ($modules as $name => $data)
	{
		echo '
		<div class="tab '.$data['class'].'">
			<h5>'.$name.'</h5>
			<p>
				<a href="'.$data['list'].'" title="List">List</a>
';
		if (isset($data['add']))
		{
			$dataName = $data['add'][0];
			$dataLink = $data['add'][1];
			echo '<br/><a href="'.$dataLink.'" title="Add '.$dataName.'">Add '.$dataName.'</a>
';
		}
		echo '
			</p>
		</div>
';
	}
?>
	</div>
	<div class="clear"></div>
</div>

<div class="content">
	<h3 class="outside-heading">FAQ's</h3>
	<h4>How do I add a new record?</h4>
	<p>To Add a new record, first select the desired section of the menu, then select the button <strong>Add new</strong>... located directly below it.</p>
	<h4>How do I edit a record?</h4>
	<p>To edit an existing record, first select the desired section of the menu, and then will be loaded List of records in it. Find the relevant entry and select the "<strong>Edit</strong>" located right on the same line.</p>
	<h4>How to delete record?</h4>
	<p>To delete an entry, first select the desired section of the menu, and then will be loaded List of records in it. Find the relevant entry and select the "<strong>Delete</strong>" located right on the same line. After confirming the operation, the record will be deleted.</p>
</div>

<div class="clear"></div>