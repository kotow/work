<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
   "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
	<head>
		<?php include_http_metas() ?>
		<?php include_metas() ?>
		<?php include_title() ?>
		
		<!-- CSS -->
		<link href="/css/reset.css" type="text/css" rel="stylesheet" />
		<link href="/css/layout.css" type="text/css" rel="stylesheet" />
		<link href="/css/typography.css" type="text/css" rel="stylesheet" />
		<link href="/css/style.css" type="text/css" rel="stylesheet" />
		<link href='http://fonts.googleapis.com/css?family=PT+Sans:regular,italic,bold,bolditalic' rel='stylesheet' type='text/css'>
		<link href="/favicon.ico" rel="shortcut icon" type="image/x-icon" />
		<script src="/js/frontend/jquery-1.5.1.js" type="text/javascript"></script>
	</head>
	<body style="background:#fff">
		<div id="wrapper">
			<?php echo $sf_data->getRaw('sf_content') ?>
			<?php 	$context = sfContext::getInstance();
					$user_session = $context->getUser();
					if(($flashMsg = $user_session->getAttribute("flashMsg")) && $user_session->getAttribute("flashMsg") != ''):
			?>
				<script language="javascript" type="text/javascript">
					$("#flashMsg").hide();
					$("#flashMsg").html("<?php if ($flashMsg!=1) echo addslashes($flashMsg); ?>");
					$("#flashMsg").show('normal');
				</script>
			<?php $user_session->setAttribute("flashMsg", null); endif; ?>
		</div>
		<script src="/js/frontend/jquery.tools.min.js" type="text/javascript"></script>
		<script src="/js/frontend/jquery.fancybox-1.3.4.pack.js" type="text/javascript"></script>
		<script src="/js/frontend/jquery-scripts.js" type="text/javascript"></script>
	</body>
</html>