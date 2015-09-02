<?php $data = $sf_user->getAttribute("registrationData");?>
Hi <?php echo $data["user"]->getLabel()?>,<br />
<br /><br />
Login: <?php echo $data["user"]->getLogin()?><br />
Password: <?php echo $data["password"]?>
<br /><br />
To complete your registration, please click on the following link:<br />
<a href='<?php echo $data["comfirmUrl"]?>?hash=<?php echo $data["code"]?>'><?php echo $data["comfirmUrl"].'?hash='.$data["code"];?></a>
