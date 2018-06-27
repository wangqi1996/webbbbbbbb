<?php 
	require 'zb_system/function/c_system_base.php';
	$zbp->RedirectInstall();
	$zbp->CheckGzip();
	$zbp->Load();
	$zbp->RedirectPermanentDomain();
	$zbp->CheckSiteClosed();

	foreach ($GLOBALS['hooks']['Filter_Plugin_Index_Begin'] as $fpname => &$fpsignal) {
		$fpname();
	}
	$current_page = null;

function addDivItem()
{ 
	global $zbp;
	global $current_page;
	if(isset($_GET['current_page'])){
	    $current_page = $_GET['current_page'];
	}else{
	    $current_page = 1;
	}


	
	$current_image_index = -1;
	$current_ico_index = 1;
    
	if(isset($_GET['hint'])){
	    $hint = $_GET['hint'];
	    $sql2 = "select * from zbp_post where log_Title REGEXP '.*".$hint.".*';";
	    $indexData = $zbp->GetArticleList(null,null,null,null,null,null,$sql = $sql2);
	   
	}else{
	    $indexData = $zbp->GetArticleList();
	}

	$i = -1;
	foreach ($indexData as $key => $value) {
	    $i++;
		if($i < ($current_page-1)*9) 
			continue;
		if($i >= 9*$current_page){
			break;
		}
		$content = $value->__get('Content');
		$title =  $value->__get('Title');
		$url = $value->__get('Url');
		$current_image_index = ($current_image_index+1)%20+1;
		$current_ico_index = mt_rand(1,11);
		$url_array = explode("?",$url);
		$url = $url_array[0].'post.php?'.$url_array[1];

		echo '
		<div class="post-list-item">
                <div class="post-list-item-container">
                    <div class="item-thumb bg-deepgrey" style="background-image:url(image/rand/' . $current_image_index .'.jpg);"></div>
                    <a href="'. $url .
					'">
						<div class="item-desc">
							<p>'. $content .'</p>
						</div>
                    </a>
                    <div class="item-slant reverse-slant bg-deepgrey"></div>
                    <div class="item-slant"></div>
                    <div class="item-label">
                        <div class="item-title"><a href="'. $url .'">'. $title .'</a>
                        </div>
                        <div class="item-meta clearfix">
                            <div class="item-meta-ico bg-ico-chat"
                                 style="background: url(image/bg_ico/' . $current_ico_index .'.png);background-size:40px 40px;"></div>
                            <div class="item-meta-cat">
                                默认分类
                            </div>
                        </div>
                    </div>
                </div>
            </div>
		';
	} 

}

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge, chrome=1">
    <meta name="renderer" content="webkit">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta http-equiv="Cache-Control" content="no-transform"/>
    <meta http-equiv="Cache-Control" content="no-siteapp"/>
    <meta name="keywords" content="webbbbbbbb,博客系统"/>
    <meta name="description" content="博客系统,webbbbbbbb"/>
    <link rel="shortcut icon" href="logo.png"/>
    <link rel="apple-touch-icon" href="logo.png"/>
    <title>webbbbbbbb</title>
    <link href="css/xcode.min.css" rel="stylesheet">
    <link href="css/style.min.css" rel="stylesheet">
    <script src="script/jquery.min.js"></script>

</head>
<body  class="bg-grey"  gtools_scp_screen_capture_injected="true">

<header id="header" class="header bg-white">
    <div class="navbar-container">
        <a href="" class="navbar-logo">
            <img src="logo.png" alt="webbbbbbbb"/>
			<span style = "font-family:consolas;color:gray;">Webbbbbbbb</span>
        </a>
        <div class="navbar-menu">
            <a href="./zb_system/about.php">关于</a>
            <a href="./zb_system/login.php?v201806251">登录</a>
            <a href="./zb_system/register.php">注册</a>
        </div>

        <div class="navbar-search" onclick="">
            <span class="icon-search"></span>
            <form role="search" onsubmit="return false;">
                <span class="search-box">
                    <input type="search" id="search-inp" class="input" placeholder="搜索..." maxlength="30"
                           autocomplete="off">
                </span>
            </form>
        </div>
        <div class="navbar-mobile-menu" onclick="">
            <span class="icon-menu cross"><span class="middle"></span></span>
            <ul>
                <li><a href="./zb_system/about.php">关于</a></li>
                <li><a href="./zb_system/login.php?v201806251">登录</a></li>
                <li><a href="./zb_system/register.php">注册</a></li>
            </ul>
        </div>
    </div>
</header>
<div class="main-content index-page clearfix">
    <div class="post-lists">
        <div class="post-lists-body">
		
			<?php addDivItem(); ?>     
			
        </div>
    </div>
    <div class="lists-navigator clearfix">
        <ol class="page-navigator">
			<li class="pre"><a href="javascript:pre_page()">&larr;</a></li>
			<li class="current"><?php  echo $current_page; ?></li>
			<li class="next"><a href="javascript:next_page()">→</a></li>
		</ol>
    </div> 
</div>

<script src="//cdn.bootcss.com/headroom/0.9.1/headroom.min.js"></script>
<script src="//cdn.bootcss.com/highlight.js/9.12.0/highlight.min.js"></script>
<script src="//cdn.bootcss.com/instantclick/3.0.1/instantclick.min.js"></script>
<script type="text/javascript">
function pre_page(){
	var current_page = "<?php echo $current_page;?>"
	if(current_page <= 1){
	    current_page = 2;
	}
	var url = "http://localhost/zblogphp/?current_page="+(parseInt(current_page)-1);
	window.location.href=url;
}
function next_page(){
	var current_page = "<?php echo $current_page;?>"

	var url = "http://localhost/zblogphp/?current_page="+(parseInt(current_page)+1);
	window.location.href=url;
}
    var header = new Headroom(document.getElementById("header"), {
        tolerance: 10,
        offset : 80,
        classes: {
            initial: "animated",
            pinned: "slideDown",
            unpinned: "slideUp"
        }
    });
    header.init();
    $('#search-inp').keypress(function (e) {
        var key = e.which; //e.which是按键的值
        if (key == 13) {
            var q = $(this).val();
            if (q && q != '') {
            	//这里调用php函数
            	var url = "http://localhost/zblogphp/?hint="+q;
            	window.location.href=url;
            }
        }
    });
</script>


</body>
</html>
























