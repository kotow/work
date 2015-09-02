<html>
<head>

<script type="text/javascript" src="/js/panel/swfobject.js"></script>
<script type="text/javascript">

swfobject.embedSWF(
  "/images/open-flash-chart.swf", "my_chart",
  "1000", "500", "9.0.0", "expressInstall.swf",
  {"data-file":"http://jobs.expatica.com/admin/admin/pageViewsData/y/<?php echo $year?>/m/<?php echo $month?>/section/<?php echo $section?>"} );
  
</script>
</head>
<body  style="text-align:center">
<br/>
<div id="my_chart"></div>
<br>
<form>
<br/>
<?php use_helper('DateForm') ?>

<select name="section"> 
	<option value="job" <?php if($section == "job") echo "selected"?>> Jobs section </option> 
	<option value="house" <?php if($section == "house") echo "selected"?>> Housing section </option> 
</select> 

<?php echo select_month_tag('month',$month) ?> 
<?php echo select_year_tag('year', $year, array('year_end' => date("Y"), 'year_start' => date("Y")-2)) ?> 

<input type="submit" value="check">
</form>

</body>
</html>
    
