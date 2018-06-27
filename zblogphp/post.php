<?php 
require 'zb_system/function/c_system_base.php';
    $id = $_GET['id'];
    $value = $zbp->GetPostByID($id);
    $content = $value->Content;
    $title =  $value->Title;
    $posttime = $value->Time();
    $commnums = $value->CommNums;
    $author = $zbp->GetMemberByID($value->AuthorID)->Name;
    $comments = $zbp->GetCommentList(
        '*',
        array(
            array('=', 'comm_LogID', $id),
        ),
        array('comm_ID' => ($zbp->option['ZC_COMMENT_REVERSE_ORDER'] ? 'DESC' : 'ASC')),
        null,
        null
        );
    echo '

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
<title>'. $title .'-webbbbbbbb</title>
<link href="css/xcode.min.css" rel="stylesheet">
<link href="css/style.min.css" rel="stylesheet">
<script src="script/jquery.min.js"></script>

</head>
<body  class="bg-grey"  gtools_scp_screen_capture_injected="true">


<header id="header" class="header bg-white">
    <div class="navbar-container">
        <a href="index.php" class="navbar-logo">
            <img src="logo.png" alt="webbbbbbbb"/>
			<span style = "font-family:consolas;color:gray;">Webbbbbbbb</span>
        </a>
    </div>
</header>
<article class="main-content page-page" itemscope itemtype="http://schema.org/Article">
    <div class="post-header">
        <h1 class="post-title" itemprop="name headline">' . $title . '
        </h1>
        <div class="post-data">
            <time datetime="2017-02-25" itemprop="datePublished">发布于'. $posttime .'</time>
            / 默认分类 / <a href="#comments">'. $commnums .'条评论</a> 
        </div>
    </div>
    <div id="post-content" class="post-content" itemprop="articleBody">
<p>'. $content .'</p>
                <p class="post-info">
            本文由'. $author .'创作，本站文章除注明转载/出处外，均为本站原创或翻译，转载前请务必署名<br>
        </p>
    </div>
</article>
<div id="13" class="comment-container">
    <div id="comments" class="clearfix">
        <span class="response"></span>

        <form method="post" id="comment-form" class="comment-form" role="form" onsubmit="return TaleComment.subComment();">
            <input type="hidden" name="coid" id="coid"/>
            <input type="hidden" name="cid" id="cid" value="13"/>
            <input type="hidden" name="csrf_token" value="9PH1LJe7G7LOkn3v3p2iQ1"/>
            <input name="author" maxlength="12" id="author" class="form-control input-control clearfix"
                   placeholder="姓名 (*)" value="" required/>
            <input type="email" name="mail" id="mail" class="form-control input-control clearfix" placeholder="邮箱 (*)"
                   value="" required/>
            <input type="url" name="url" id="url" class="form-control input-control clearfix" placeholder="网址 (http://)"
                   value=""/>
            <textarea name="content" id="textarea" class="form-control" placeholder="发表你的评论." required minlength="5" maxlength="2000"></textarea>
            <button class="submit" id="misubmit">提交</button>
        </form>




        <ol class="comment-list">
            <li id="li-comment-942" class="comment-body comment-parent comment-odd">
                <div id="comment-942">
                    <div class="comment-view" onclick="">
                        <div class="comment-header">
                            <img class="avatar" src="https://cn.gravatar.com/avatar/b92177642a87064440389c87fd6889a4?s=80&r=G&d=" title="ascascas"
                                 width="80" height="80">
                            <span class="comment-author">
                                <a href="" target="_blank" rel="external nofollow">游客</a>
                            </span>
                        </div>
                        <div class="comment-content">
                            <span class="comment-author-at"></span>
                            <p><p>6666666666</p>
</p>
                        </div>
                        <div class="comment-meta">
                            <time class="comment-time">2018-06-26</time>
                            <span class="comment-reply">
                                <a rel="nofollow" onclick="">回复</a>
                            </span>
                        </div>
                    </div>
                </div>
            </li>
            <li id="li-comment-941" class="comment-body comment-parent comment-odd">
                <div id="comment-941">
                    <div class="comment-view" onclick="">
                        <div class="comment-header">
                            <img class="avatar" src="https://cn.gravatar.com/avatar/f433ba1168a7eca448db90dd05fe1d49?s=80&r=G&d=" title="噢噢"
                                 width="80" height="80">
                            <span class="comment-author">
                                <a href="" target="_blank" rel="external nofollow">lzg</a>
                            </span>
                        </div>
                        <div class="comment-content">
                            <span class="comment-author-at"></span>
                            <p><p>测试测试测试</p>
</p>
                        </div>
                        <div class="comment-meta">
                            <time class="comment-time">2018-06-25</time>
                            <span class="comment-reply">
                                <a rel="nofollow" onclick="">回复</a>
                            </span>
                        </div>
                    </div>
                </div>
            </li>
            <li id="li-comment-897" class="comment-body comment-parent comment-odd">
                <div id="comment-897">
                    <div class="comment-view" onclick="">
                        <div class="comment-header">
                            <img class="avatar" src="https://cn.gravatar.com/avatar/42c79e6afd03d5538501a96a46a10310?s=80&r=G&d=" title="哈？"
                                 width="80" height="80">
                            <span class="comment-author">
                                <a href="" target="_blank" rel="external nofollow">wdq</a>
                            </span>
                        </div>
                        <div class="comment-content">
                            <span class="comment-author-at"></span>
                            <p><p>我就要留测试</p>
</p>
                        </div>
                        <div class="comment-meta">
                            <time class="comment-time">2018-05-29</time>
                            <span class="comment-reply">
                                <a rel="nofollow" onclick="">回复</a>
                            </span>
                        </div>
                    </div>
                </div>
            </li>
        </ol>
        <div class="lists-navigator clearfix">
            <ol class="page-navigator">
                <li  class="current" ><a href="?cp=1#comments">1</a></li>
            </ol>

        </div>
    </div>
</div>

</body>
</html>';
 ?>
 
 
 
 
 