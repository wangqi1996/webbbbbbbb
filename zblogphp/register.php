<?php
require './zb_system/function/c_system_base.php';

$zbp->CheckGzip();
$zbp->Load();
if ($zbp->CheckRights('admin')) {
    Redirect('cmd.php?act=admin');
}
$lang['msg']['repassword'] = "repassword";
$lang['msg']['email'] = "email";
?>
<!DOCTYPE HTML>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge,chrome=1" />
    <meta name="robots" content="none" />
    <meta name="viewport" content="width=device-width,initial-scale=1.0,minimum-scale=1.0,maximum-scale=1.0"/>
    <meta name="generator" content="<?php echo $option['ZC_BLOG_PRODUCT_FULL'] ?>" />
    <meta name="renderer" content="webkit" />
    <link rel="stylesheet" href="css/admin.css" type="text/css" media="screen" />
    <script src="script/common.js" type="text/javascript"></script>
    <script src="script/md5.js" type="text/javascript"></script>
    <script src="script/c_admin_js_add.php" type="text/javascript"></script>
    <title><?php echo $blogname . '-' . $lang['msg']['login'] ?></title>
<?php
foreach ($GLOBALS['hooks']['Filter_Plugin_Login_Header'] as $fpname => &$fpsignal) {
    $fpname();
}

?>
</head>
<body>
<div class="bg">
<div id="wrapper">
  <div class="logo"><img src="../logo.png" title="<?php echo htmlspecialchars($blogname) ?>" alt="<?php echo htmlspecialchars($blogname) ?>"/></div>
  <div class="login">
    <form method="post" action="#">
    <dl>
      <dt></dt>
      <dd class="username"><label for="edtUserName"><?php echo $lang['msg']['username'] ?></label><input type="text" id="edtUserName" name="edtUserName" size="20" value="<?php echo GetVars('username', 'COOKIE') ?>" tabindex="1" /></dd>
    </dl>
	<dl>
	  <dd class="password"><label for="edtPassWord"><?php echo $lang['msg']['password'] ?></label><input type="password" id="edtPassWord" name="edtPassWord" size="20" tabindex="2" /></dd>
    </dl>
	<dl>
	  <dd class="repassword"><label for="edtrePassWord"><?php echo $lang['msg']['repassword'] ?></label><input type="password" id="edtrePassWord" name="edtrePassWord" size="20" tabindex="2" /></dd>
    </dl>
	<dl>
	  <dd class="email"><label for="edtEmail"><?php echo $lang['msg']['email'] ?></label><input type="password" id="edtEmail" name="edtEmail" size="20" tabindex="2" /></dd>
    </dl>
    <dl>
      <dt></dt>
      <dd class="checkbox"><input type="checkbox" name="chkRemember" id="chkRemember"  tabindex="98" /><label for="chkRemember"><?php echo $lang['msg']['stay_signed_in'] ?></label></dd>
    </dl>
	<dl>	
	  <dd class="submit"><input id="btnPost" name="btnPost" type="submit" value="<?php echo $lang['msg']['login'] ?>" class="button" tabindex="99"/></dd>
    </dl>
    <input type="hidden" name="username" id="username" value="" />
    <input type="hidden" name="password" id="password" value="" />
    <input type="hidden" name="savedate" id="savedate" value="1" />
	<input type="hidden" name="repassword" id="repassword" value="" />
    <input type="hidden" name="email" id="email" value="" />
    </form>
  </div>
</div>
</div>
<script type="text/javascript">
$("#btnPost").click(function(){

    var strUserName=$("#edtUserName").val();
    var strPassWord=$("#edtPassWord").val();
	var strrePassWord=$("#edtrePassWord").val();
	var strEmail=$("#edtEmail").val();
    var strSaveDate=$("#savedate").val()

    if (strUserName=== "" || strPassWord === ""){
        alert("<?php echo $lang['error']['66'] ?>");
        return false;
    }
	if(strPassword != strrePassword){
		alert("两次密码不一致");
		
	}
    $("#edtUserName").remove();
    $("#edtPassWord").remove();

    //$("form").attr("action","cmd.php?act=");
    $("#username").val(strUserName);
    $("#password").val(MD5(strPassWord));
    $("#savedate").val(strSaveDate);
})

$("#chkRemember").click(function(){
    $("#savedate").attr("value", $("#chkRemember").attr("checked") == "checked" ? 30 : 1);
})

</script>
</body>
</html>
<?php
RunTime();
?>
