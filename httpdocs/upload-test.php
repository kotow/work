<?php

if($_FILES['the_file']) {
	echo 'A file is present';
}

?>

<form action="upload-test.php" method="post" enctype="multipart/form-data" name="megaupload" id="megaupload">
	<input type="file" name="the_file" id="the_file" />
    <input type="submit" value="GO!" name="the_submit" />
</form>

<?

phpinfo();
