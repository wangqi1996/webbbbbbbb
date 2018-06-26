<?php if (!defined('ZBP_PATH')) {
    exit('Access denied');
} ?>
</head>
<body>
<header class="header">
    <div><a href="<?php echo $bloghost ?>" title="webbbbbbbbb" target="_blank" ><img src = "../image/admin/logo6.png" width = "137px" height = "85px"></a></div>
    <div class="user"> 
      <div class="username"><?php echo $zbp->user->LevelName ?>：<?php echo $zbp->user->StaticName ?></div>
      <div class="userbtn"><a class="profile" href="<?php echo $bloghost ?>" title="" target="_blank"><?php echo $lang['msg']['return_to_site'] ?></a>&nbsp;&nbsp;<a class="logout" href="<?php echo BuildSafeCmdURL('act=logout'); ?>" title=""><?php echo $lang['msg']['logout'] ?></a></div>
    </div>

</header>
<?php 
require ZBP_PATH . 'zb_system/admin/admin_left.php'; 
?>
<section class="main">
<?php $zbp->GetHint(); ?>
