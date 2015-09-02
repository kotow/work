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
	<body>
		<?php echo $sf_data->getRaw('sf_content'); ?>
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
	</body>
</html>