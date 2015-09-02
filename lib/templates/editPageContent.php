<!doctype html>
<html lang="en">
<head>
  	<?php include_http_metas() ?>
	<?php include_metas() ?>
	<?php include_title() ?>

	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
    <meta content="True" name="HandheldFriendly">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" />
    <meta name="viewport" content="width=device-width" />
<?php /*
  	<title>Trademark Tracking System</title>
*/ ?>
  	<link href="favicon.ico" rel="shortcut icon" type="image/vnd.microsoft.icon" />
    <link rel="stylesheet" href="/css/style.css" type="text/css" />
    <link rel="stylesheet" href="/css/style-bp.css" type="text/css" />
    <link rel="stylesheet" href="/css/select2.css" type="text/css" />
    <link rel="stylesheet" href="/css/jquery-ui-1.10.4.custom.css" type="text/css" />
    <link href='http://fonts.googleapis.com/css?family=Exo+2:400,700,800&subset=latin,cyrillic' rel='stylesheet' type='text/css'>
    <!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js" type="text/javascript"></script> -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <script src="/js/jquery-ui-1.10.4.custom.min.js"></script>
    <script src="/js/animations.js"></script>
    <script src="/js/select2.js"></script>
     <script src="/js/jquery.confirm.min.js"></script>
     <script src="http://code.jquery.com/jquery-migrate-1.2.1.js"></script>
</head>
<?php
	$subscriber = $sf_user->getSubscriber(); 
	$isAdmin = ( $subscriber && (strstr($subscriber->getType(), "admin")) );
?>
<body>
		<?php echo $sf_data->getRaw('sf_content') ?>
		<?php
			$context = sfContext::getInstance();
			$user_session = $context->getUser();
		?>
		<?php if (($flashMsg = $user_session->getAttribute("flashMsg")) && $user_session->getAttribute("flashMsg") != ''): ?>
			<script language="javascript" type="text/javascript">
				$("#flashMsg").hide();
				$("#flashMsg").html("<?php if ($flashMsg!=1) echo addslashes($flashMsg); ?>");
				$("#flashMsg").show('normal');
			</script>
			<?php $user_session->setAttribute("flashMsg", null);?>
		<?php endif; ?>

<?php /*
	    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.1/jquery.js"></script>
*/ ?>
		<div id="blocks_insert" style="display:none ;background-color:#222; border:solid 1px #ccc; cursor:move; z-index:10001; padding:10px; border-radius:5px;"></div>
		<?php if ($isAdmin): ?>
			<div class="contextMenu" id="freeBlock" style="z-index:10000;">
				<ul>
					<li id="insertBlock"><img src="/images/panel/doc_import_icon&16.png"/>Insert block</li>
					<li id="deleteBlock"><img src="/images/panel/doc_export_icon&16.png"/>Delete block</li>
				</ul>
			</div>
		<?php endif;?>
		<script language="javascript" type="text/javascript" src="/js/backend/ui.mouse.js"></script>
		<script language="javascript" type="text/javascript" src="/js/backend/ui.draggable.js"></script>
		<script language="javascript" type="text/javascript" src="/js/backend/ui.draggableext.js"></script>
		<script language="javascript" type="text/javascript" src="/js/backend/jquery.contextmenu.js"></script>
		<script language="javascript" type="text/javascript" src="/js/panel/editPageContent.js"></script>
		<script language="javascript" type="text/javascript" src="/js/tiny_mce/tiny_mce.js"></script>
	</body>
</html>