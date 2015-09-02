<br/>
<br/>
<div id="loginBox">
welcome<br/>
<b><?php echo $user->getLabel()?></b><br/><a href="javascript:;" onclick="document.getElementById('logoutForm').submit()">logout</a>
<form id="logoutForm" method="POST">
<input type="hidden" value="1" name="logout">

</form>
</div>