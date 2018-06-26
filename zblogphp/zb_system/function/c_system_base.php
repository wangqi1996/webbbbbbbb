<?php
/**
 * 绯荤粺鍒濆鍖栫瓑鐩稿叧鎿嶄綔.
 *
 * @copyright (C) RainbowSoft Studio
 */
/**
 * @var ZBlogPHP;
 */
$zbp = null;

error_reporting(E_ALL);
ob_start();
defined('ZBP_PATH') || define('ZBP_PATH', rtrim(str_replace('\\', '/', realpath(dirname(__FILE__) . '/../../')), '/') . '/');
defined('ZBP_HOOKERROR') || define('ZBP_HOOKERROR', true);
defined('ZBP_SAFEMODE') || define('ZBP_SAFEMODE', false);
/**
 * 鍔犺浇绯荤粺鍩虹鍑芥暟.
 */
require ZBP_PATH . 'zb_system/function/c_system_version.php';
require ZBP_PATH . 'zb_system/function/c_system_compat.php';
require ZBP_PATH . 'zb_system/function/c_system_plugin.php';

require ZBP_PATH . 'zb_system/function/c_system_common.php';
require ZBP_PATH . 'zb_system/function/c_system_event.php';
spl_autoload_register('AutoloadClass');
/*
 * 瀹氫箟绯荤粺鍙橀噺
 */
/*
 * 鎿嶄綔绯荤粺
 */
define('SYSTEM_UNKNOWN', 0);
define('SYSTEM_WINDOWS', 1);
define('SYSTEM_UNIX', 2);
define('SYSTEM_LINUX', 3);
define('SYSTEM_DARWIN', 4);
define('SYSTEM_CYGWIN', 5);
define('SYSTEM_BSD', 6);
/*
 * 缃戠珯鏈嶅姟鍣�
 */
define('SERVER_UNKNOWN', 0);
define('SERVER_APACHE', 1);
define('SERVER_IIS', 2);
define('SERVER_NGINX', 3);
define('SERVER_LIGHTTPD', 4);
define('SERVER_KANGLE', 5);
define('SERVER_CADDY', 6);
define('SERVER_BUILTIN', 7);
/*
 * PHP寮曟搸
 */
define('ENGINE_PHP', 1);
define('ENGINE_HHVM', 2);
define('PHP_SYSTEM', GetSystem());
define('PHP_SERVER', GetWebServer());
define('PHP_ENGINE', GetPHPEngine());
define('IS_X64', (PHP_INT_SIZE === 8));
/*
 * 濡傛灉鎯宠幏鍙栧噯纭殑鍊硷紝璇穤bp->Load鍚庝娇鐢�$zbp->isHttps
 * 姝ゅ浠呬负褰撳墠绯荤粺鐜妫�娴�
 */
define('HTTP_SCHEME', GetScheme($_SERVER));
/*
 * 鍏煎鎬х瓥鐣�
 */
define('IS_WINDOWS', PHP_SYSTEM === SYSTEM_WINDOWS);
define('IS_UNIX', PHP_SYSTEM === SYSTEM_UNIX);
define('IS_LINUX', PHP_SYSTEM === SYSTEM_LINUX);
define('IS_DARWIN', PHP_SYSTEM === SYSTEM_DARWIN);
define('IS_CYGWIN', PHP_SYSTEM === SYSTEM_CYGWIN);
define('IS_BSD', PHP_SYSTEM === SYSTEM_BSD);
define('IS_APACHE', PHP_SERVER === SERVER_APACHE);
define('IS_IIS', PHP_SERVER === SERVER_IIS);
define('IS_NGINX', PHP_SERVER === SERVER_NGINX);
define('IS_LIGHTTPD', PHP_SERVER === SERVER_LIGHTTPD);
define('IS_KANGLE', PHP_SERVER === SERVER_KANGLE);
define('IS_CADDY', PHP_SERVER === SERVER_CADDY);
define('IS_BUILTIN', PHP_SERVER === SERVER_BUILTIN);
define('IS_HHVM', PHP_ENGINE === ENGINE_HHVM);
define('IS_CLI', php_sapi_name() === 'cli');
/*
 * 瀹氫箟鏂囩珷绫诲瀷
 */
define('ZC_POST_TYPE_ARTICLE', 0); // 鏂囩珷
define('ZC_POST_TYPE_PAGE', 1); // 椤甸潰
define('ZC_POST_TYPE_TWEET', 2); // 涓�鍙ヨ瘽
define('ZC_POST_TYPE_DISCUSSION', 3); // 璁ㄨ
define('ZC_POST_TYPE_LINK', 4); // 閾炬帴
define('ZC_POST_TYPE_MUSIC', 5); // 闊充箰
define('ZC_POST_TYPE_VIDEO', 6); // 瑙嗛
define('ZC_POST_TYPE_PHOTO', 7); // 鐓х墖
define('ZC_POST_TYPE_ALBUM', 8); // 鐩稿唽
/*
 * 瀹氫箟绫诲瀷搴忓垪
 * @param  id=>{name,url,template}
 */
$GLOBALS['posttype'] = array(
    array('article', '', '', 0, 0),
    array('page', '', '', null, null),
    array('tweet', '', '', null, null),
    array('discussion', '', '', null, null),
    array('link', '', '', null, null),
    array('music', '', '', null, null),
    array('video', '', '', null, null),
    array('photo', '', '', null, null),
    array('album', '', '', null, null),
);
/*
 * 瀹氫箟鏂囩珷鐘舵��
 */
/*
 * 鏂囩珷鐘舵�侊細鍏紑鍙戝竷
 */
define('ZC_POST_STATUS_PUBLIC', 0);
/*
 * 鏂囩珷鐘舵�侊細鑽夌
 */
define('ZC_POST_STATUS_DRAFT', 1);
/*
 * 鏂囩珷鐘舵�侊細瀹℃牳
 */
define('ZC_POST_STATUS_AUDITING', 2);
/*
 * 鐢ㄦ埛鐘舵�侊細姝ｅ父
 */
define('ZC_MEMBER_STATUS_NORMAL', 0);
/*
 * 鐢ㄦ埛鐘舵�侊細瀹℃牳涓�
 */
define('ZC_MEMBER_STATUS_AUDITING', 1);
/*
 * 鐢ㄦ埛鐘舵�侊細宸查攣瀹�
 */
define('ZC_MEMBER_STATUS_LOCKED', 2);
/*
 *瀹氫箟鍛戒护
 */
$GLOBALS['actions'] = array(
    'login'  => 6,
    'logout' => 6,
    'verify' => 6,
    'admin'  => 5,
    'search' => 6,
    'misc'   => 6,
    'feed'   => 6,
    'cmt'    => 6,
    'getcmt' => 6,
    'ajax'   => 6,
    'ArticleEdt' => 4,
    'ArticlePst' => 4,
    'ArticleDel' => 4,
    'ArticlePub' => 3,
    'PageEdt' => 2,
    'PagePst' => 2,
    'PageDel' => 2,
    'CategoryEdt' => 2,
    'CategoryPst' => 2,
    'CategoryDel' => 2,
    'CommentEdt' => 5,
    'CommentSav' => 5,
    'CommentDel' => 5,
    'CommentChk' => 5,
    'CommentBat' => 5,
    'MemberEdt' => 5,
    'MemberPst' => 5,
    'MemberDel' => 1,
    'MemberNew' => 1,
    'TagEdt' => 2,
    'TagPst' => 2,
    'TagDel' => 2,
    'TagNew' => 2,
    'PluginEnb' => 1,
    'PluginDis' => 1,
    'UploadPst' => 3,
    'UploadDel' => 3,
    'ModuleEdt' => 1,
    'ModulePst' => 1,
    'ModuleDel' => 1,
    'ThemeSet'   => 1,
    'SidebarSet' => 1,
    'SettingSav' => 1,
    'ArticleMng'  => 4,
    'PageMng'     => 2,
    'CategoryMng' => 2,
    'SettingMng'  => 1,
    'TagMng'      => 2,
    'CommentMng'  => 5,
    'UploadMng'   => 3,
    'MemberMng'   => 5,
    'ThemeMng'    => 1,
    'PluginMng'   => 1,
    'ModuleMng'   => 1,
    'ArticleAll'  => 2,
    'PageAll'     => 2,
    'CategoryAll' => 2,
    'CommentAll'  => 2,
    'MemberAll'   => 1,
    'TagAll'      => 2,
    'UploadAll'   => 2,
    'NoValidCode' => 5,
    'root' => 1,
);
/*
 *瀹氫箟鏁版嵁琛�
 */
$GLOBALS['table'] = array(
    'Post'     => '%pre%post',
    'Category' => '%pre%category',
    'Comment'  => '%pre%comment',
    'Tag'      => '%pre%tag',
    'Upload'   => '%pre%upload',
    'Module'   => '%pre%module',
    'Member'   => '%pre%member',
    'Config'   => '%pre%config',
);
/*
 *瀹氫箟鏁版嵁缁撴瀯
 */
$GLOBALS['datainfo'] = array(
    'Config' => array(
        'ID'    => array('conf_ID', 'integer', '', 0),
        'Name'  => array('conf_Name', 'string', 50, ''),
        'Value' => array('conf_Value', 'string', '', ''),
    ),
    'Post' => array(
        'ID'       => array('log_ID', 'integer', '', 0),
        'CateID'   => array('log_CateID', 'integer', '', 0),
        'AuthorID' => array('log_AuthorID', 'integer', '', 0),
        'Tag'      => array('log_Tag', 'string', 250, ''),
        'Status'   => array('log_Status', 'integer', '', 0),
        'Type'     => array('log_Type', 'integer', '', 0),
        'Alias'    => array('log_Alias', 'string', 250, ''),
        'IsTop'    => array('log_IsTop', 'integer', '', 0),
        'IsLock'   => array('log_IsLock', 'boolean', '', false),
        'Title'    => array('log_Title', 'string', 250, ''),
        'Intro'    => array('log_Intro', 'string', '', ''),
        'Content'  => array('log_Content', 'string', '', ''),
        'PostTime' => array('log_PostTime', 'integer', '', 0),
        'CommNums' => array('log_CommNums', 'integer', '', 0),
        'ViewNums' => array('log_ViewNums', 'integer', '', 0),
        'Template' => array('log_Template', 'string', 50, ''),
        'Meta'     => array('log_Meta', 'string', '', ''),
    ),
    'Category' => array(
        'ID'          => array('cate_ID', 'integer', '', 0),
        'Name'        => array('cate_Name', 'string', 250, ''),
        'Order'       => array('cate_Order', 'integer', '', 0),
        'Type'        => array('cate_Type', 'integer', '', 0),
        'Count'       => array('cate_Count', 'integer', '', 0),
        'Alias'       => array('cate_Alias', 'string', 50, ''),
        'Intro'       => array('cate_Intro', 'string', '', ''),
        'RootID'      => array('cate_RootID', 'integer', '', 0),
        'ParentID'    => array('cate_ParentID', 'integer', '', 0),
        'Template'    => array('cate_Template', 'string', 50, ''),
        'LogTemplate' => array('cate_LogTemplate', 'string', 50, ''),
        'Meta'        => array('cate_Meta', 'string', '', ''),
    ),
    'Comment' => array(
        'ID'         => array('comm_ID', 'integer', '', 0),
        'LogID'      => array('comm_LogID', 'integer', '', 0),
        'IsChecking' => array('comm_IsChecking', 'boolean', '', false),
        'RootID'     => array('comm_RootID', 'integer', '', 0),
        'ParentID'   => array('comm_ParentID', 'integer', '', 0),
        'AuthorID'   => array('comm_AuthorID', 'integer', '', 0),
        'Name'       => array('comm_Name', 'string', 50, ''),
        'Content'    => array('comm_Content', 'string', '', ''),
        'Email'      => array('comm_Email', 'string', 50, ''),
        'HomePage'   => array('comm_HomePage', 'string', 250, ''),
        'PostTime'   => array('comm_PostTime', 'integer', '', 0),
        'IP'         => array('comm_IP', 'string', 15, ''),
        'Agent'      => array('comm_Agent', 'string', '', ''),
        'Meta'       => array('comm_Meta', 'string', '', ''),
    ),

    'Member' => array(
        'ID'       => array('mem_ID', 'integer', '', 0),
        'Guid'     => array('mem_Guid', 'string', 36, ''),
        'Level'    => array('mem_Level', 'integer', '', 6),
        'Status'   => array('mem_Status', 'integer', '', 0),
        'Name'     => array('mem_Name', 'string', 50, ''),
        'Password' => array('mem_Password', 'string', 32, ''),
        'Email'    => array('mem_Email', 'string', 50, ''),
        'HomePage' => array('mem_HomePage', 'string', 250, ''),
        'IP'       => array('mem_IP', 'string', 15, ''),
        'PostTime' => array('mem_PostTime', 'integer', '', 0),
        'Alias'    => array('mem_Alias', 'string', 50, ''),
        'Intro'    => array('mem_Intro', 'string', '', ''),
        'Articles' => array('mem_Articles', 'integer', '', 0),
        'Pages'    => array('mem_Pages', 'integer', '', 0),
        'Comments' => array('mem_Comments', 'integer', '', 0),
        'Uploads'  => array('mem_Uploads', 'integer', '', 0),
        'Template' => array('mem_Template', 'string', 50, ''),
        'Meta'     => array('mem_Meta', 'string', '', ''),
    ),

);
/*
 * 鍒濆鍖栫粺璁′俊鎭�
 */
$_SERVER['_start_time'] = microtime(true); //RunTime
$_SERVER['_query_count'] = 0;
$_SERVER['_memory_usage'] = 0;
$_SERVER['_error_count'] = 0;
if (function_exists('memory_get_usage')) {
    $_SERVER['_memory_usage'] = memory_get_usage(true);
}
/*
 * 鐗堟湰鍏煎澶勭悊
 */
if (function_exists('get_magic_quotes_gpc') && get_magic_quotes_gpc()) {
    function _stripslashes(&$var)
    {
        if (is_array($var)) {
            foreach ($var as $k => &$v) {
                _stripslashes($v);
            }
        } else {
            $var = stripslashes($var);
        }
    }
    _stripslashes($_GET);
    _stripslashes($_POST);
    _stripslashes($_COOKIE);
    _stripslashes($_REQUEST);
}
/*
 * CLI Mock 澶勭悊
 */
if (IS_CLI) {
    if (isset($GLOBALS['argv'])) {
        $_SERVER["QUERY_STRING"] = implode('&', array_slice($GLOBALS['argv'], 1));
    } else {
        $_SERVER["QUERY_STRING"] = '';
    }
    $_SERVER["HTTP_HOST"] = "localhost";
    $_SERVER['SERVER_SOFTWARE'] = "CLI";
    $_GET = array();
    parse_str($_SERVER["QUERY_STRING"], $_GET);
    // $_POST = json_decode(file_get_contents('php://stdin'), true);
}
/*
 * 瀹氫箟绯荤粺鍏ㄥ眬鍙橀噺
 */
/*
 * 褰撳墠鍔ㄤ綔鍛戒护
 */
$GLOBALS['action'] = '';
/*
 * 褰撳墠璇锋眰璺緞
 */
$GLOBALS['currenturl'] = GetRequestUri();
/*
 * 璇█鍖�
 */
$GLOBALS['lang'] = array();
$lang['msg']['unnamed'] = "";
/*
 * 绯荤粺鏍硅矾寰�
 */
$GLOBALS['blogpath'] = ZBP_PATH;
/*
 * 鐢ㄦ埛璺緞
 */
$GLOBALS['usersdir'] = ZBP_PATH . 'zb_users/';
/*
 * 宸叉縺娲绘彃浠跺垪琛�
 */
$GLOBALS['activedapps'] = array();
//淇濈暀activeapps锛屽吋瀹逛互鍓嶇増鏈�
$GLOBALS['activeapps'] = &$GLOBALS['activedapps'];
/*
 * 鍔犺浇璁剧疆
 */
$GLOBALS['option'] = require ZBP_PATH . 'zb_system/defend/option.php';
$op_users = null;
if (!ZBP_HOOKERROR && isset($_ENV['ZBP_USER_OPTION']) && is_readable($file_base = $_ENV['ZBP_USER_OPTION'])) {
    $op_users = require $file_base;
    $GLOBALS['option'] = array_merge($GLOBALS['option'], $op_users);
} elseif (is_readable($file_base = $GLOBALS['usersdir'] . 'c_option.php')) {
    $op_users = require $file_base;
    $GLOBALS['option'] = array_merge($GLOBALS['option'], $op_users);
}
$GLOBALS['blogtitle'] = $GLOBALS['option']['ZC_BLOG_SUBNAME']; // 涓嶆槸婕忓啓锛�
$GLOBALS['blogname'] = &$GLOBALS['option']['ZC_BLOG_NAME'];
$GLOBALS['blogsubname'] = &$GLOBALS['option']['ZC_BLOG_SUBNAME'];
$GLOBALS['blogtheme'] = &$GLOBALS['option']['ZC_BLOG_THEME'];
$GLOBALS['blogstyle'] = &$GLOBALS['option']['ZC_BLOG_CSS'];
$GLOBALS['cookiespath'] = null;
$GLOBALS['bloghost'] = GetCurrentHost($GLOBALS['blogpath'], $GLOBALS['cookiespath']);
/*
 * 绯荤粺瀹炰緥鍖�
 */
AutoloadClass('ZBlogPHP');
AutoloadClass('DbSql');
AutoloadClass('Config');
$GLOBALS['zbp'] = ZBlogPHP::GetInstance();
$GLOBALS['zbp']->Initialize();
/*
 * 鍔犺浇涓婚鍜屾彃浠禔PP
 */
if (ZBP_SAFEMODE === false) {
    if (is_readable($file_base = $GLOBALS['usersdir'] . 'theme/' . $GLOBALS['blogtheme'] . '/theme.xml')) {
        $GLOBALS['activedapps'][] = $GLOBALS['blogtheme'];
    }
    if (is_readable($file_base = $GLOBALS['usersdir'] . 'theme/' . $GLOBALS['blogtheme'] . '/include.php')) {
        require $file_base;
    }
    $aps = $GLOBALS['zbp']->GetPreActivePlugin();
    foreach ($aps as $ap) {
        if (is_readable($file_base = $GLOBALS['usersdir'] . 'plugin/' . $ap . '/plugin.xml')) {
            $GLOBALS['activedapps'][] = $ap;
        }
        if (is_readable($file_base = $GLOBALS['usersdir'] . 'plugin/' . $ap . '/include.php')) {
            require $file_base;
        }
    }
    foreach ($GLOBALS['plugins'] as &$fn) {
        if (function_exists($fn)) {
            $fn();
        }
    }
}
unset($file_base, $aps, $fn, $ap, $op_users, $opk, $opv);