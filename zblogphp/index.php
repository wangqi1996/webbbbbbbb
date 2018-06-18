<?php 
	require 'zb_system/function/c_system_base.php';

	$zbp->RedirectInstall();
	$zbp->CheckGzip();
	$zbp->Load();
	$zbp->RedirectPermanentDomain();
	$zbp->CheckSiteClosed();
	$he = $he + 1;
	foreach ($GLOBALS['hooks']['Filter_Plugin_Index_Begin'] as $fpname => &$fpsignal) {
		$fpname();
	}
function unicode_decode($name)
{
  // 转换编码，将Unicode编码转换成可以浏览的utf-8编码
  $pattern = '/([\w]+)|(\\\u([\w]{4}))/i';
  preg_match_all($pattern, $name, $matches);
  if (!empty($matches))
  {
    $name = '';
    for ($j = 0; $j < count($matches[0]); $j++)
    {
      $str = $matches[0][$j];
      if (strpos($str, '\\u') === 0)
      {
        $code = base_convert(substr($str, 2, 2), 16, 10);
        $code2 = base_convert(substr($str, 4), 16, 10);
        $c = chr($code).chr($code2);
        $c = iconv('UCS-2', 'UTF-8', $c);
        $name .= $c;
      }
      else
      {
        $name .= $str;
      }
    }
  }
  return $name;
}

function addDivItem()
{ 
	global $zbp;
	$current_page = 1;
	echo $current_page;
	$current_image_index = -1;
	$current_ico_index = 1;
	$indexData = $zbp->GetArticleList();
	$i = 0;
	foreach ($indexData as $key => $value) {
		for($i = 0; $i < ($current_page-1)*9; $i++)
			continue;
		if($i >= 9*$current_page){
			break;
		}
		$i = $i + 1;
		$content = $value->__get('Content');
		$title =  $value->__get('Title');
		$url = $value->__get('Url');
		$current_image_index = ($current_image_index+1)%20+1;
		$current_ico_index = mt_rand(1,11);
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
	<script>
		static current_page = 1;
		function pre_page(){
			current_page = current_page +1;
			window.location.href="index.php?current_page"+current_page;
			
		}
		function next_page(){
			var t = <?php echo $current_page+1; ?>;
			window.location.reload()
		}
	
	</script>
    <!--[if lt IE 9]>
    <script src="//cdn.bootcss.com/html5shiv/r29/html5.min.js"></script>
    <script src="//cdn.bootcss.com/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body  class="bg-grey"  gtools_scp_screen_capture_injected="true">
<!--[if lt IE 8]>
<div class="browsehappy" role="dialog">
    当前网页 <strong>不支持</strong> 你正在使用的浏览器. 为了正常的访问, 请 <a href="http://browsehappy.com/" target="_blank">升级你的浏览器</a>。
</div>
<![endif]-->
<header id="header" class="header bg-white">
    <div class="navbar-container">
        <a href="" class="navbar-logo">
            <img src="logo.png" alt="webbbbbbbb"/>
			<span style = "font-family:consolas;color:gray;">Webbbbbbbb</span>
        </a>
        <div class="navbar-menu">
            <a href="https://tale.biezhi.me/archives">关于</a>
            <a href="./zb_system/login.php">登录</a>
            <a href="./zb_system/register.php">注册</a>
        </div>
        <div class="navbar-search" onclick="">
            <span class="icon-search"></span>
            <form role="search" onsubmit="return false;">
                <span class="search-box">
                    <input type="text" id="search-inp" class="input" placeholder="搜索..." maxlength="30"
                           autocomplete="off">
                </span>
            </form>
        </div>
        <div class="navbar-mobile-menu" onclick="">
            <span class="icon-menu cross"><span class="middle"></span></span>
            <ul>
                <li><a href="https://tale.biezhi.me/archives">关于</a></li>
                <li><a href="./zb_system/login.php">登录</a></li>
                <li><a href="https://tale.biezhi.me/about">注册</a></li>
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
			<li class="current"><?php  echo $GLOBALS['current_page']; ?></li>
			<li class="next"><a href="javascript:next_page()">→</a></li>
		</ol>
    </div> 
</div>


<script src="//cdn.bootcss.com/headroom/0.9.1/headroom.min.js"></script>
<script src="//cdn.bootcss.com/highlight.js/9.12.0/highlight.min.js"></script>
<script src="//cdn.bootcss.com/instantclick/3.0.1/instantclick.min.js"></script>

<script type="text/javascript">

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
                window.location.href = '/search/' + q;
            }
        }
    });
</script>
<script data-no-instant>
    InstantClick.on('change', function (isInitialLoad) {
        var blocks = document.querySelectorAll('pre code');
        for (var i = 0; i < blocks.length; i++) {
            hljs.highlightBlock(blocks[i]);
        }
        if (isInitialLoad === false) {
            if (typeof ga !== 'undefined') ga('send', 'pageview', location.pathname + location.search);
        }
    });
    InstantClick.init('mousedown');
</script>
</body>
</html>
<?php
foreach ($GLOBALS['hooks']['Filter_Plugin_Index_End'] as $fpname => &$fpsignal) {
    $fpname();
}

RunTime();

?>