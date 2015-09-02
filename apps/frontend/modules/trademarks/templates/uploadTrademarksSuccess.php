<div class="qfEntryHeader"><span>Upload New Trademarks</span></div>
<div class="qfEntryContent qfEntryContentUpTr">
	<div class="qfSessHolder qfMaxWd qfUpHolder">
		<div class="qfSearchWrap">
			<div class="qfSearchTag">
				<div class="qfTrMarkContainer">
					<div class="qfTrMarkCell qfTrMarkHeading qfUpHeadingBgr">Качване в база данни</div>
				</div>
			</div>
			
            
            <div class="qfUpProgressWrap qfBoxBorderBg">
                <div class="progressRate">100%</div>
                <div class="progressBarWrap">
                    <div class="progressBarIcon progressBarIcon01"></div>
                    
                    <div id="progressbar" class="ui-progressbar ui-widget ui-widget-content ui-corner-all" role="progressbar" aria-valuemin="0" aria-valuemax="100" aria-valuenow="1">
                          <div class="ui-progressbar-value ui-widget-header ui-corner-left" style="width: 100%;"></div>
                    </div>
                    <div class="progressBarIcon progressBarIcon02"></div>
                </div>
            </div>
            
            
            
            <div class="qfUpListWrap qfBoxBorderBg">
				<div class="wrapUpItem">
					<div class="qfUpListitem">
						<div class="qfUpItemCell qfUpLeft">
							<div class="qfUpItemLData">
								<span class="qfUpItemNum">1</span>
								<span class="qfUpItemName">Българско патентно ведомство</span>
							</div>
						</div>
						<div class="qfUpItemCell qfUpRight">
							<span class="qfUpChange">
								<p><span>Последни промени на:</span></p>
								<p>22.03.2014г.</p>
							</span> 
							<input disabled="disabled" placeholder="Choose File" id="qfUploadFl">
							<div class="flUpload">
								<span class="qfUpImgIcon"></span>
								<a href="<?php echo $addTrademarkURL; ?>"><span class="qfUpFlImg" id="uploadBtn"></a>
							</div>
						</div>
					</div>
					<div class="qfUpExpand">
						<div class="qfUpExpHeading">История на промените</div>
						
						<table border="0" cellspacing="0" cellpadding="0" class="upExpTable">
							<tbody>
							<tr>
								<th>Име</th>
								<th>Дата</th>
							</tr>
<?php foreach ($importsArr[1] as $import): ?>
							<tr>
								<td><a href="<?php echo UtilsHelper::cleanUrl($import);?>"><?php echo $import->getLabel(); ?></a></td>
								<td><?php echo UtilsHelper::DateBG($import->getCreatedAt(), 'd.m.Y'); ?> г.</td>
							</tr>
<?php endforeach; ?>
							</tbody>
						</table>
						
					</div>
				</div>
                
				<div class="wrapUpItem">
					<div class="qfUpListitem">
						<div class="qfUpItemCell qfUpLeft">
							<div class="qfUpItemLData">
								<span class="qfUpItemNum">2</span>
								<span class="qfUpItemName">ОХИМ (OAMI - европейско)</span>
							</div>
						</div>
						<div class="qfUpItemCell qfUpRight">
							<span class="qfUpChange">
								<p><span>Последни промени на:</span></p>
								<p>22.03.2014г.</p>
							</span>
							<input disabled="disabled" placeholder="Choose File" id="qfUploadFl">
							<div class="flUpload">
								<span class="qfUpImgIcon"></span>
								<span class="qfUpFlImg" id="uploadBtn_1"></span>
							</div>
						</div>
					</div>
					<div class="qfUpExpand" <?php if ($reload == 1) echo 'style="display: block;"'; ?>>
                    	<div class="form-holder" id="form_holder_1" style="display: none;">
							<div id="submitting1"><span class="pulse">Качване на файл</span></div>
							<form method="post" action="" class="letter" id="upload_oami" name="upload_oami">
				
								<div class="upload_btn" id="up_btn" style="display: none;">Файл за качване</div>
								<input type="text" name="fake1" value="Моля изберете файл за импорт (DIFF_CTMS_*.ZIP)" onfocus="clearField(this)" onblur="restoreField(this);" disabled="disabled">
								<input type="file" accept="application/zip" name="filesToUpload" id="filesToUpload1" value="Изберете файл" onfocus="clearField(this)" onchange="updtFake1(fake1)" style="display: inline-block;">
								<input id="submit1" type="submit" value="Качи" name="sendit1" class="shortcode yellow flat rounded">
				
							</form>
							<div id="progress1">
								<div id="prog_num1">100%</div>
								<div id="progress_bg1"></div>
							  	<div id="progress_achieved1"></div>
							</div>
						</div>
						<div class="qfUpExpHeading">История на промените</div>
						<table border="0" cellspacing="0" cellpadding="0" class="upExpTable">
							<tbody>
							<tr>
								<th>Име на файл</th>
								<th>Размер</th>
								<th>Качена от</th>
								<th>Статус</th>
								<th>Дата</th>
							</tr>
<?php foreach ($importsArr[2] as $import): ?>
							<tr>
								<td><?php echo $import->getLabel(); ?></td>
								<td><?php echo number_format($import->getSize(), 0, '', ' ') ?> bytes</td>
								<td><?php if ($usr = Document::getDocumentInstance($import->getUser())) echo $usr->getLabel(); else echo 'Потребител #'.$import->getUser(); ?></td>
								<td><?php echo '<span style="color: '.$statusColors[$import->getStatus()].'">'.$import->getStatus(); ?></td>
								<td><?php echo UtilsHelper::DateBG($import->getCreatedAt(), 'd.m.Y'); ?> г.</td>
							</tr>
<?php endforeach; ?>
							</tbody>
						</table>
					</div>
				</div>
				
                <!-- THIRD TAB -->
                <div class="wrapUpItem">
					<div class="qfUpListitem">
						<div class="qfUpItemCell qfUpLeft">
							<div class="qfUpItemLData">
								<span class="qfUpItemNum">3</span>
								<span class="qfUpItemName">СОИС (WIPO)</span>
							</div>
						</div>
						<div class="qfUpItemCell qfUpRight">
							<span class="qfUpChange">
								<p><span>Последни промени на:</span></p>
								<p>22.03.2014г.</p>
							</span>
							<input disabled="disabled" placeholder="Choose File" id="qfUploadFl">
							<div class="flUpload">
								<span class="qfUpImgIcon"></span>
								<span class="qfUpFlImg" id="uploadBtn_2"></span>
							</div>
						</div>
					</div>
                    
                    <!-- THIRD EXPAND -->
					<div class="qfUpExpand" <?php if ($reload == 2) echo 'style="display: block;"'; ?>>
                    	<div class="form-holder" id="form_holder_2" style="display: none;">
							<div id="submitting2"><span class="pulse">Качване на файл</span></div>
							<form method="post" action="" class="letter" id="upload_wipo" name="upload_wipo">
				
								<div class="upload_btn" id="up_btn2" style="display: none;">Файл за качване</div>
								<input type="text" name="fake2" value="Моля изберете файл за импорт (ZIP)" onfocus="clearField(this)" onblur="restoreField(this);" disabled="disabled">
								<input type="file" accept="application/zip" name="filesToUpload" id="filesToUpload2" value="Изберете файл" onfocus="clearField(this)" onchange="updtFake2(fake2)" style="display: inline-block;">
								<input id="submit2" type="submit" value="Качи" name="sendit2" class="shortcode yellow flat rounded">
				
							</form>
							<div id="progress2">
								<div id="prog_num2">100%</div>
								<div id="progress_bg2"></div>
							  	<div id="progress_achieved2"></div>
							</div>                       
						</div>
						<div class="qfUpExpHeading">История на промените</div>
						<table border="0" cellspacing="0" cellpadding="0" class="upExpTable">
							<tbody>
							<tr>
								<th>Име на файл</th>
								<th>Размер</th>
								<th>Качена от</th>
								<th>Статус</th>
								<th>Дата</th>
							</tr>
<?php foreach ($importsArr[3] as $import): ?>
							<tr>
								<td><?php echo $import->getLabel(); ?></td>
								<td><?php echo number_format($import->getSize(), 0, '', ' '); ?> bytes</td>
								<td><?php if ($usr = Document::getDocumentInstance($import->getUser())) echo $usr->getLabel(); else echo 'Потребител #'.$import->getUser(); ?></td>
								<td><?php echo '<span style="color: '.$statusColors[$import->getStatus()].'">'.$import->getStatus(); ?></td>
								<td><?php echo UtilsHelper::DateBG($import->getCreatedAt(), 'd.m.Y'); ?> г.</td>
							</tr>
<?php endforeach; ?>
							</tbody>
						</table>
					</div>
				</div>
                
			</div>

		</div>
        
	</div>
    
</div>

<form name="reload_form" id="reload_form" method="post" action="">
	<input type="hidden" id="reload" name="reload" value="">
</form>

<script type="text/javascript" src="/js/jquery.form.js"></script>
<script type="text/javascript">

/* FORM FUNCTIONALITY AND OTHER FEATURES */

// OAMI upload ========================================================================================================

function upload1() {
	//var realUpld = $('input[type="file"]'); 
	var realUpld = $('#filesToUpload1'); 
	var	total_files = realUpld.get(0).files.length;

	if (total_files < 1) {
		alert('Моля изберете файл за качване!');
	}
	else
	{
		var options = { 
	//		target:		'#output1',   // target element(s) to be updated with server response 
			beforeSubmit:  function() {preSubmit1();},  // pre-submit callback 
			success:	   function(data) {completeHandler1(data);},  // post-submit callback 
			 // other available options: 
			url:	   "/trademarks/uploadFile1/",		 // override for form's 'action' attribute 
			type:	  "post",		// 'get' or 'post', override for form's 'method' attribute 
			//dataType:  null		// 'xml', 'script', or 'json' (expected server response type) 
			clearForm: false,		// clear all form fields after successful submit 
			resetForm: true,	   // reset the form after successful submit 
			uploadProgress: function(a, b, c, percentComplete) {uploadPrgrs1(percentComplete)}
			// $.ajax options can be used here too, for example: 
			//timeout:   3000 
		}; 
		$('form[name="upload_oami"]').ajaxSubmit(options);
	}
};

function preSubmit1() {
	$('#progress1').fadeIn(500); 
	$("#submitting1").html('<span class="pulse">Качване на файл...</span>'); 
	$("#submitting1").show('fast');
	$("#submit1").addClass('disabled');
}

function completeHandler1(msg) {
	if (msg == 'OK')
	{
		$("#submitting1").html(msg);
		setTimeout(
			function(){
				$("#form_holder_1").hide('slow');
				$('#reload').val(1);
				$('form[name="reload_form"]').submit();
			}, 4000
		);
		$('#submit1').addClass('disabled');
		$("#progress_achieved1").width('90%');
		$('#progress1').fadeOut(500);
		$('#submit1').removeClass('disabled');
		$('input[name=fake1]').val='Моля изберете файл за импорт (DIFF_CTMS_*.ZIP)';
	}
	else
	{
		// display error message
		$('#progress1').hide();
		alert(msg);
	}
}

function uploadPrgrs1(percentage) {
	$("#prog_num1").html(percentage+'%');
	var adjusted = 0.9*percentage;
	$("#progress_achieved1").width(adjusted+'%');
}

function updtFake1(target) {
	var realUpld = $('#filesToUpload1'); 
	tp = realUpld.val();
	target.value = tp;

var	count_limit = 1;
var size_limit = 700;
var	total_files = realUpld.get(0).files.length;
	
	if (total_files > count_limit) {
		$('#submit1').addClass('disabled');
		target.value = 'Too many files selected ('+total_files+'). The limit is '+count_limit+'!';	
		alert('Too many files selected ('+total_files+'). The limit is '+count_limit+'!');
	}

	else {
		$('#submit1').removeClass('disabled');
		var	the_size_pr = 0;
		
		for (var i=0; i<total_files; i++){
			the_size_pr = the_size_pr + (realUpld[0].files[i].size/1048576);
		}

		var the_size = Math.round( the_size_pr * 10 ) / 10;
		if  (the_size > size_limit) {
			$('#submit1').addClass('disabled');
			target.value = 'Прикаченият файл е много голям  ('+the_size+' MB). Лимитът е '+size_limit+'MB!';
			alert('Прикаченият файл е много голям  ('+the_size+' MB). Лимитът е '+size_limit+'MB!');
			$('#filesToUpload1').val('');
		}
		else {
			target.value = total_files+' file(s) selected. Total upload size: '+the_size+' MB.';
		}
	}
	the_size_pr = 0;
}


// WIPO upload ========================================================================================================

function upload2() {
	//var realUpld = $('input[type="file"]'); 
	var realUpld = $('#filesToUpload2'); 
	var	total_files = realUpld.get(0).files.length;

	if (total_files < 1) {
		alert('Моля изберете файл за качване!');
	}
	else
	{
		var options = { 
	//		target:		'#output1',   // target element(s) to be updated with server response 
			beforeSubmit:  function() {preSubmit2();},  // pre-submit callback 
			success:	   function(data) {completeHandler2(data);},  // post-submit callback 
			 // other available options: 
			url:	   "/trademarks/uploadFile2/",		 // override for form's 'action' attribute 
			type:	  "post",		// 'get' or 'post', override for form's 'method' attribute 
			//dataType:  null		// 'xml', 'script', or 'json' (expected server response type) 
			clearForm: false,		// clear all form fields after successful submit 
			resetForm: true,	   // reset the form after successful submit 
			uploadProgress: function(a, b, c, percentComplete) {uploadPrgrs2(percentComplete)}
			// $.ajax options can be used here too, for example: 
			//timeout:   3000 
		}; 
		$('form[name="upload_wipo"]').ajaxSubmit(options);
	}
};

function preSubmit2() {
	$('#progress2').fadeIn(500); 
	$("#submitting2").html('<span class="pulse">Качване на файл...</span>'); 
	$("#submitting2").show('fast');
	$("#submit2").addClass('disabled');
}

function completeHandler2(msg) {
	if (msg == 'OK')
	{
		$("#submitting2").html(msg);
		setTimeout(
			function() {
				$("#form_holder_2").hide('slow');
				$('#reload').val(2);
				$('form[name="reload_form"]').submit();
			}, 4000
		);
		$('#submit2').addClass('disabled');
		$("#progress_achieved2").width('90%');
		$('#progress2').fadeOut(500);
		$('#submit2').removeClass('disabled');
		$('input[name=fake2]').val='Моля изберете файл за импорт (ZIP)';
	}
	else
	{
		// display error message
		$('#progress2').hide();
		alert(msg);
	}
}

function uploadPrgrs2(percentage) {
	$("#prog_num2").html(percentage+'%');
	var adjusted = 0.9*percentage;
	$("#progress_achieved2").width(adjusted+'%');
}

function updtFake2(target) {
	var realUpld = $('#filesToUpload2');
	tp = realUpld.val();
	target.value = tp;

var	count_limit = 1;
var size_limit = 700;
var	total_files = realUpld.get(0).files.length;
	
	if (total_files > count_limit) {
		$('#submit2').addClass('disabled');
		target.value = 'Too many files selected ('+total_files+'). The limit is '+count_limit+'!';	
		alert('Too many files selected ('+total_files+'). The limit is '+count_limit+'!');
	}

	else {
		$('#submit2').removeClass('disabled');
		var	the_size_pr = 0;
		
		for (var i=0;i<total_files;i++){
			the_size_pr = the_size_pr + (realUpld[0].files[i].size/1048576);
		}

		var the_size = Math.round( the_size_pr * 10 ) / 10;
		if(the_size > size_limit){
			$('#submit2').addClass('disabled');
			target.value = 'Прикаченият файл е много голям ('+the_size+'MB). Лимитът е '+size_limit+'MB!';
			alert('Прикаченият файл е много голям ('+the_size+'MB). Лимитът е '+size_limit+'MB!');
			$('#filesToUpload2').val('');
		}
		else {
			target.value = total_files+' file(s) selected. Total upload size: '+the_size+' MB.';
		}
	}

	the_size_pr = 0;
}

var fieldval;

function clearField(el){
	if (el.defaultValue==el.value) {fieldval = el.value; el.value = ""};
};

function restoreField(el){
	if (el.value=="") el.value=fieldval;
};

$(document).ready(function(){
	var fake1 = $('input[name=fake1]');
	var fake2 = $('input[name=fake2]');

	// OAMI upload form
	$('#uploadBtn_1').click(function(e){
		$('#form_holder_1').toggle();
		$("#submitting1").html('Качване на файл');
		$('input[name=fake1]').val('Моля изберете файл за импорт (DIFF_CTMS_*.ZIP)');
	});
	$('input[name="sendit1"]').click(function(e){
		e.preventDefault(); upload1();
	});
	
	// WIPO upload form
	$('#uploadBtn_2').click(function(e){
		$('#form_holder_2').toggle();
		$("#submitting2").html('Качване на файл');
		$('input[name=fake2]').val('Моля изберете файл за импорт (ZIP)');
	});
	$('input[name="sendit2"]').click(function(e){
		e.preventDefault(); upload2();
	});
});

</script>
