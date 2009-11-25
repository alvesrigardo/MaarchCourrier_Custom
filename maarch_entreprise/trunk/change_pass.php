<?php
/**
* File : change_pass.php
*
* Change password and personnal data form (first connexion)
*
* @package  Maarch Framework v3
* @version 2.1
* @since 06/2006
* @license GPL
* @author  Claire Figueras  <dev@maarch.org>
*/

$core_tools = new core_tools();
$core_tools->load_lang();
$core_tools->load_html();
//here we building the header
$core_tools->load_header( _MODIFICATION_PSW);
$time = $core_tools->get_session_time_expire();
?>

<body onload="setTimeout(window.close, <?php  echo $time;?>*60*1000);">
<div id="container">
<div id="content" >
<div class="error"><?php  echo $_SESSION['error'];  $_SESSION['error'] = "";?></div>

<div id="inner_content" class="clearfix">

<h2 class="tit" ><img src="<?php  echo $_SESSION['config']['businessappurl'];?>static.php?filename=maarch_box.gif"; ?>"><?php  echo _FIRST_CONN;?></h2>
<div class="block">

<h3> <?php  echo _YOUR_FIRST_CONNEXION.", "._PLEASE_CHANGE_PSW.".<br/>"._ASKED_ONLY_ONCE.".";?>  </h3>
<div class="blank_space">&nbsp;</div>
<form name="frmuser" method="post"  action="<?php echo $_SESSION['config']['businessappurl'];?>index.php?display=true&page=verif_pass" class="forms" >
	<input type="hidden" name="display" value="true" />	
	<input type="hidden" name="page" value="verif_pass" />
	<p>
		<label><?php  echo _ID; ?> : </label>
		<input type="text" readonly="readonly" class="readonly" value="<?php  echo $_SESSION['user']['UserId']; ?>"/>
	</p>
	<p>
		<label><?php  echo _PASSWORD; ?> : </label>
		<input name="pass1"  type="password" id="pass1" value="" /><span class="red_asterisk">*</span>
	</p>
	<p>
		<label><?php   echo _REENTER_PSW; ?> : </label>
		<input name="pass2"  type="password" id="pass2" value="" /><span class="red_asterisk">*</span>
	</p>
	<p>
		<label><?php  echo _LASTNAME; ?> : </label>
		<input name="LastName"  type="text" id="LastName"  value="<?php  echo $_SESSION['user']['LastName']; ?>" /><span class="red_asterisk">*</span>
	</p>
	<p>
		<label><?php  echo _FIRSTNAME; ?> : </label>
		<input name="FirstName" type="text" id="FirstName" value="<?php  echo $_SESSION['user']['FirstName']; ?>" /><span class="red_asterisk">*</span>
	</p>
	<?php if(!$core_tools->is_module_loaded("entities") )
	{?>
	<p>
		<label ><?php  echo _DEPARTMENT;?> : </label>
		<input name="Department"  type="text" id="Department"  value="<?php  echo $_SESSION['user']['department']; ?>" />
	</p>
	<?php } ?>
	<p>
		<label><?php  echo _PHONE_NUMBER; ?> : </label>
		<input name="Phone"  type="text" id="Phone" value="<?php  echo $_SESSION['user']['Phone']; ?>" />
	</p>
	<p>
		<label ><?php  echo _MAIL;?> : </label>
		<input name="Mail"   type="text" id="Mail"  value="<?php  echo $_SESSION['user']['Mail']; ?>" /><span class="red_asterisk">*</span>
	</p>
	<p class="buttons">
		<input type="submit" name="Submit" value="<?php  echo _VALIDATE;?>" class="button" />
        <input type="button" name="cancel" value="<?php  echo _CANCEL;?>" class="button" onclick="window.location.href='<?php echo $_SESSION['config']['businessappurl'];?>index.php?display=true&page=login&coreurl=<?php  echo $_SESSION['config']['coreurl'];?>';" />
	</p>

</form>
</div>
<div class="block_end">&nbsp;</div>
</div>


</div>
<div id="footer">&nbsp;</div>
</div>
</body>
</html>
