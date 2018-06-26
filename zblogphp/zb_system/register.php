<?php
require './function/c_system_base.php';
require './function/c_system_admin.php';
echo (new ReflectionFunction('RunTime'))->getFileName();

$zbp->CheckGzip();
$zbp->Load();
$blogtitle = $lang['msg']['member_edit'];

$memberid = null;
if (isset($_GET['id'])) {
    $memberid = (int) GetVars('id', 'GET');
} else {
    $memberid = 0;
}

if (!$zbp->CheckRights('MemberAll')) {
    if ((int) $memberid != (int) $zbp->user->ID) {
        $zbp->ShowError(6, __FILE__, __LINE__);
    }
}

$member = $zbp->GetMemberByID($memberid);
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
    <link rel="stylesheet" href="css/admin.css?v1222" type="text/css" media="screen" />
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
    <form id="edit" name="edit" method="post" action="#">
               <input id="edtID" name="ID" type="hidden" value="<?php echo $member->ID; ?>" />
                <dl>
				<dt></dt>
				<dd>
					<label for = "edtName"><?php echo $lang['msg']['name']?></label><input id="edtName" class="edit" size="40" name="Name" maxlength="20" type="text"
						/>
				</dd>
				</dl>
				
				<dl>
				<dt></dt>
				<dd>
                    <label><?php echo $lang['msg']['password']?></label>
                <input id="edtPassword" class="edit" size="40" name="Password"  type="password" value="" />
				</dd>
				</dl>
				
				<dl>
				<dt></dt>
				<dd>
                    <label><?php echo $lang['msg']['re_password']?></label>
                <input id="edtPasswordRe" class="edit" size="40" name="PasswordRe"  type="password" value="" />
				</dd>
				</dl>
				
				<dl>
				<dt></dt>
				<dd>
                    <label><?php echo $lang['msg']['email']?>:</label>
                <input id="edtEmail" class="edit" size="40" name="Email" type="text" value="<?php echo $member->Email; ?>" /></p>
				</dd>
				</dl>
				<dl>
				<dt></dt>
				<dd>
                <input type="submit" class="button" value="<?php echo $lang['msg']['submit']?>" id="btnPost" onclick="return checkInfo();" /></p>
				</dd>
		</form>
  </div>
  </div>
  </div>

<script type="text/javascript">
function checkInfo(){
  document.getElementById("edit").action="<?php echo BuildSafeCmdURL('act=MemberPst'); ?>";


  if(!$("#edtEmail").val()){
    alert("<?php echo $lang['error']['29']?>");
    return false
  }


  if(!$("#edtName").val()){
    alert("<?php echo $lang['error']['72']?>");
    return false
  }

  if($("#edtPassword").val()!==$("#edtPasswordRe").val()){
    alert("<?php echo $lang['error']['73']?>");
    return false;
  }

}
</script>


</body>
</html>
<?php
RunTime();
?>
