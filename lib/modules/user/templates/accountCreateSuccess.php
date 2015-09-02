<?php
$errlabel=$errcv=$errcountry=$erreducation=$errfirstname=$errlastname=$erremail=$errpassword=$errphone=$errdescription=$errcaptcha_code=$erraddress=$errcity=$errzip=$errcountry=$errjobtypes="";
$errors = $sf_request->getErrors();
$select_none = "please choose ...";
foreach($errors as $key => $error) $$key = "background:#ffddcc;border:solid 1px red";
?>

<div class="head_field">
	<img src="/images/layout/login_icon.png" class="icon" />
    <div class="tab_head no_indent">
		<h1 class="absolute"><?php if(!$noform):?><?php if($user):?>Edit Profile<?php else:?>Create <?php echo ucfirst($type); ?> Account<?php endif;?><?php else:?>Registration Success<?php endif;?></h1>
	</div>
    <div class="holder">
    <div class="margin">
    <?php if($user && $type=="user"):?>
		<a href="<?php echo UtilsHelper::MAIN_SITE_DOMAIN; ?>user/edit_profile.html" class="pm">Basic</a>
		<a href="<?php echo UtilsHelper::MAIN_SITE_DOMAIN; ?>user/edit_profile/2.html" class="pm">Social</a>
		<a href="/<?php echo $accountPageUrl?>" class="pm_active">Detail Information</a>
		<br/>
		<br/>
	<?php endif;?>
	
	<?php if($noform):?>
		Thank you for registering.
	<?php endif;?>

	<?php if(!$noform):?>
	<form action="" method="post" id="form" name="form" enctype="multipart/form-data">
		<?php if($user) echo frontend_hidden('id', $user->getId());?>
		<?php echo frontend_hidden('submitted', 'submitted');?>
		<?php echo frontend_hidden('type', $type);?>

		<table border="0" cellpadding="0" cellspacing="0" class="register">
		<tr>
			<th width="110"></th>
			<td></td>
		</tr>
		<?php if($type == "company"):?>
		<tr >
			<th align="right" valign="top"></th>
			<td><strong>COMPANY DETAILS</strong></td>
		</tr>

		<tr>
			<th align="right" valign="top"><strong>Company name <span>*</span></strong></th>
			<td>
				<?php echo frontend_input('label', $company, array('style' => $errlabel, 'required' => 'true', 'onfocus' => ' validateEditForm();'), "getLabel");?>
			</td>
		</tr>

		<tr>
			<th align="right" valign="top"><strong>Account type <span>*</span></strong></th>
			<td>
				<?php echo frontend_select('accountType', $company, Lists::getListitemsForSelect('company_accout_type', array(''=>$select_none)),array('style' => $errcountry, 'required' => 'true', 'onfocus' => ' validateEditForm();'), "getAccountType");?>
			</td>
		</tr>

		<tr>
			<th align="right" valign="top"><strong>Country <span>*</span></strong></th>
			<td>
				<?php echo frontend_select('country', $company, Lists::getListitemsForSelect('all_countries', array(''=>$select_none)),array('style' => $errcountry, 'required' => 'true', 'onfocus' => ' validateEditForm();'), "getCountry");?>
			</td>
		</tr>

		<tr>
			<th align="right" valign="top"><strong>City&nbsp;&nbsp;</strong></th>
			<td>
				<?php echo frontend_input('city', $company, array('style' => $errcity, "getCity"));?>
			</td>
		</tr>

		<tr>
			<th align="right" valign="top"><strong>Zip&nbsp;&nbsp;</strong></th>
			<td>
				<?php echo frontend_input('zip', $company, array('style' => $errzip, 'validate'=>'Zip'), "getZip");?>
			</td>
		</tr>
		<tr>
			<th align="right" valign="top"><strong>Address&nbsp;&nbsp;</strong></th>
			<td>
				<?php echo frontend_textarea('address', $company, array('style' => $erraddress, 'size'=>'40x4'), "getAddress");?>
			</td>
		</tr>

		<tr>
			<th align="right" valign="top"><strong>Web site&nbsp;&nbsp;</strong></th>
			<td>

				<?php echo frontend_input('web', $company, array('validate'=>'Web', 'onfocus'=>'validateField(\'web\',\'system/validateUrl\')'), "getWeb");?>
			</td>
		</tr>

		<tr>
			<th align="right" valign="top"><strong>Description <span>*</span></strong></th>
			<td>
				<?php $countFunc = " countText('description', 'textCount', 250);"; echo frontend_textarea('description', $company, array('style' => $errdescription, 'required' => 'true', 'size' => '4x40', 'onfocus' => ' validateEditForm();'.$countFunc, 'onchange' => $countFunc, 'onkeyup' => $countFunc), "getDescription"); ?>
			</td>
		</tr>
		<!--<tr>
			<th align="right" valign="top">&nbsp;</th>
			<td>
				Remaining symbols: <span id="textCount">150</span>
			</td>
		</tr>-->

		<?php if($logo):?>
		<tr id="company_logo">
			<th align="right" valign="top"><strong>Current CV&nbsp;&nbsp;</strong></th>
			<td>
				<img src="<?php echo $logo->getRelativeThumbUrl(); ?>"/> &nbsp; <a href="javascript:;" class="red" onclick="if (confirm('Are you sure you want to delete your logo?')){deleteLogo(<?php echo $logo->getId(); ?>)}">Delete</a>
			</td>
		</tr>
		<?php endif;?>
		 <?php if(/*$user && */$type == "company"):?>
		<tr>
			<th align="right" valign="top"><strong>Logo&nbsp;&nbsp;</strong></th>
			<td>
				<input type="file" name="logo" style="<?php echo $errlogo?>">
			</td>
		</tr>
		<?php endif;?>
		<tr>
			<th align="right" valign="top"></th>
			<td><strong>CONTACT DETAILS</strong></td>
		</tr>

		<tr>
			<th align="right" valign="top"><strong>First name <span>*</span></strong></th>
			<td>
				<?php echo frontend_input('firstname', $user, array('style' => $errfirstname, 'required'=>'true', 'onfocus'=>' validateEditForm()'), "getFirstName");?>
			</td>
		</tr>

		<tr>
			<th align="right" valign="top"><strong>Last name</strong></th>
			<td>
				<?php echo frontend_input('lastname', $user, array('style' => $errlastname), "getLastName");?>
			</td>
		</tr>

		<tr>
			<th align="right" valign="top">
				<strong>Е-mail <span>*</span></strong>
				<div class="comment">will be used as login&nbsp;&nbsp;</div>
			</th>
			<td>
				<?php echo frontend_input('email', $user, array('style' => $erremail, 'required'=>'true', 'validate'=>'Email','onfocus'=>'validateField(\'email\',\'/system/validateEmail\')'), "getEmail");?>
			</td>
		</tr>

		<tr>
			<th align="right" valign="top"><strong>Password <?php if(!$user):?><span>*</span><?php else:?>&nbsp;&nbsp;<?php endif;?></strong></th>
			<td>

				<?php
				if(!$user)
					$pass_opt = array('style' => $errpassword, 'password' => true, 'required'=>'true', 'onfocus'=>' validateEditForm()');
				else
					$pass_opt = array('style' => $errpassword, 'password' => true);
				?>
				<?php
				$sf_request->setParameter("password", null);
				echo frontend_input('password', null, $pass_opt);
				?>

			</td>
		</tr>
		<tr>
			<th align="right" valign="top"><strong>Confirm password <?php if(!$user):?><span>*</span><?php else:?>&nbsp;&nbsp;<?php endif;?></strong></th>
			<td>

				<?php
				if(!$user)
					$confirmpass_opt = array('style' => $errpassword, 'password' => true, 'required'=>'true','validate'=>'compare','onfocus'=>'validateCompare(this.id,\'password\',\'Password confirmation do not match\'); validateEditForm()');
				else
					$confirmpass_opt = array('style' => $errpassword, 'password' => true, 'validate'=>'compare','onfocus'=>'validateCompare(this.id,\'password\',\'Password confirmation do not match\');')
				?>

				<?php
				$sf_request->setParameter("confirmpass", null);
				echo frontend_input('confirmpass', null, $confirmpass_opt);
				?>

			</td>
		</tr>

		<tr>
			<th align="right" valign="top"><strong>Phone&nbsp;&nbsp;</strong></th>
			<td>
			<?php echo frontend_input('phone', $user,array('style' => $errphone), "getPhone");?>
			</td>
		</tr>

		<script language="javascript" type="text/javascript" src="/js/tiny_mce/tiny_mce.js"></script>
		<script type="text/javascript">
		//countText('description', 'textCount', 250);
		tinyMCE.init(
		{
			mode : "exact",
			elements : "description",
			theme : "advanced",
			theme_advanced_buttons1 : "bold,italic,underline,bullist,numlist",
			theme_advanced_buttons2 : "",
			theme_advanced_buttons3 : "",
			theme_advanced_toolbar_location : "top",
			theme_advanced_toolbar_align : "left",
			theme_advanced_statusbar_location : "bottom",
			paste_auto_cleanup_on_paste : true,
			theme_advanced_resizing : false,
			paste_auto_cleanup_on_paste : true,
			width: 450,
			height: 200,
			content_css : "/css/frontend.css"
		}
		);
		validateEditForm();
		</script>
		<?php endif;?>

		<?php if($type == "user"):?>
		<script type="text/javascript">addLoadEvent(checkJobTypes);</script>
		<!--<tr>
			<th align="right" valign="top"><strong>Birth date&nbsp;&nbsp;</strong></th>
			<td>
				<?php echo frontend_date('birth_date' , $user, array("year_start" => "1920", "year_end" => date("Y")), "getBirthDate")?>
			</td>
		</tr>

		<tr>
			<th align="right" valign="top"><strong>Country <span>*</span></strong></th>
			<td>
				<?php echo frontend_select('country', $user, Lists::getListitemsForSelect('all_countries', array(''=>$select_none)),array('style' => $errcountry, 'required' => 'true', 'onfocus' => ' validateEditForm();'), "getCountry");?>
			</td>
		</tr>

		<tr>
			<td align="right" valign="top"><strong>City&nbsp;&nbsp;</strong></td>
			<td>
				<?php //echo frontend_input('city', $user, array('style' => $errcity, "getCity"));?>
				<input name="city" type="text" value="<?php echo $user ? $user->getCity() : '';?>" style="<?php echo $errcity;?>"/>
			</td>
		</tr>
		-->
		<tr>
			<th align="right" valign="top"><strong>Education&nbsp;&nbsp;</strong></th>
			<td>
				<?php echo frontend_select('education', $user, Lists::getListitemsForSelect('educations', array(''=>$select_none)),array('style' => $erreducation), "getEducation");?>
			</td>
		</tr>

		<tr>
			<th align="right" valign="top"><strong>Job type&nbsp;&nbsp;</strong></th>
			<td>
				<?php if(isset($user)) : ?>
					<input id="jobtypes" name="jobtypes" type="hidden" value="<?php echo $user->getJobType(); ?>"/>
				<?php endif; ?>
				<div class="job_categories"><?php echo frontend_multi_checkbox('job_types', $user, $categories, array('style'=>'width:15px', "getJobType")); ?><br class="clear"/></div>
			<a name="cv"></a>
			</td>
		</tr>
		<?php if($cv):?>
		<tr id="user_cv">
			<th align="right" valign="top"><strong>Current CV&nbsp;&nbsp;</strong></th>
			<td>
				<a href="<?php echo $cv->getRelativeUrl(); ?>">Current CV</a> &nbsp; <a href="javascript:;" class="red" onclick="if (confirm('Are you sure you want to delete your CV?')){deleteCV(<?php echo $cv->getId(); ?>)}">Delete</a>
			</td>
		</tr>
		<?php endif;?>

		<tr>
			<th align="right" valign="top"><strong>CV&nbsp;&nbsp;</strong></th>
			<td>
				<input type="file" name="cv" style="<?php echo $errcv?>">
			</td>
		</tr>
		<?php endif;?>

		<?php if(!$user):?>
		<tr>
			<td width="170" align="right" valign="top"><strong>Verification code <span>*</span></strong></td>
			<td>
				<table border="0" cellpadding="0" cellspacing="0">
					<tr>
						<td style="padding:0 !important;">
						<img src="/user/captcha"/>
						</td>

						<td>
							<?php echo frontend_input('captcha_code', '', array('style'=>'width:85px; height:37px; text-align:center; font-size:28px;'.$errcaptcha_code, 'size' => '16', 'required'=>'true', 'onfocus'=>' validateEditForm()')); ?>
						</td>
					</tr>
				</table>
			</td>
		</tr>
		<tr style='<?php echo $errterms?>'>
			<td>&nbsp;</td>
			<td align="left">
				<input type="checkbox" style="width:auto;height:auto;background:none;border:none;" name="terms" align="middle" <?php if($sf_params->get('terms') == "1") echo "checked"?> class="check_box" value="1"/>
				&nbsp;I accept
				<a onclick="doPopup('<?php echo UtilsHelper::MAIN_SITE_DOMAIN; ?>popup/terms-of-use.html'); return false;" href="#"><strong>Terms and conditions</strong></a>
				<!--<a href="<?php echo $termsUrl?>" <?php if($termsUrl != "#") echo "target=\"_blank\""?> title="Terms and conditions" valign="top"></a>-->
			</td>
		</tr>
		<?php endif;?>

		<tr>
			<td>&nbsp;</td>
			<td align="right">
			<input id='btnSubmit' type='submit' class='save_btndisabled' value='Save' style='width:200px'/>
			</td>
		</tr>
		</table>
	</form>
	
	<?php endif;?>


<br />
<br />
	</div>
</div>
</div>
<br />
<br />