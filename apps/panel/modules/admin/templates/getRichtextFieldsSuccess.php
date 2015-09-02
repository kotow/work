<?php
foreach ($boxes as $i => $target)
{
	echo panel_textarea('attrContent'.$i, $obj, array('labelname' => 'Content'.$i , 'model' => 'PageI18n', 'size'=> '50x5', 'richtext' => 'true', 'class' => 'mceEditor', 'target' => $target), 'getContent');
}
?>