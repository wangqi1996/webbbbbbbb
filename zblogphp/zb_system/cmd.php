<?php

require './function/c_system_base.php';
$zbp->Load();
$action = GetVars('act', 'GET');
/*
if (!$zbp->CheckRights($action)) {
    $zbp->ShowError(6, __FILE__, __LINE__);
    die();
}
*/
foreach ($GLOBALS['hooks']['Filter_Plugin_Cmd_Begin'] as $fpname => &$fpsignal) {
    $fpname();
}
global $wangqi_level;
switch ($action) {

    case 'login':
        if (!empty($zbp->user->ID) && GetVars('redirect', 'GET')) {
            Redirect(GetVars('redirect', 'GET'));
        }
        if ($zbp->CheckRights('admin')) {
            Redirect('cmd.php?act=admin');
        }
        if (empty($zbp->user->ID) && GetVars('redirect', 'GET')) {
            setcookie("redirect", GetVars('redirect', 'GET'), 0, $zbp->cookiespath);
        }
        Redirect('login.php');
        break;
    case 'logout':
        CheckIsRefererValid();
        Logout();
        Redirect('../');
        break;
    case 'admin':
        Redirect('admin/index.php?act=admin');
        break;
    case 'verify':
        $wangqi_level = 1;
        /*
         * 鑰冭檻鍏煎鍘熷洜锛屾澶勪笉鍔燙SRF楠岃瘉銆俵ogout鍔犵殑鍘熷洜鏄富棰樼殑閫�鍑烘棤澶х銆�
         */
        if (VerifyLogin()) {
            if (!empty($zbp->user->ID) && GetVars('redirect', 'COOKIE')) {
                Redirect(GetVars('redirect', 'COOKIE'));
            }
            Redirect('admin/index.php?act=admin');
        } else {
            Redirect('../');
        }
        break;

   
    case 'cmt':
        $die = false;
        if (GetVars('isajax', 'POST')) {
            // 鍏煎鑰佺増鏈殑璇勮鍓嶇
            Add_Filter_Plugin('Filter_Plugin_Zbp_ShowError', 'RespondError', PLUGIN_EXITSIGNAL_RETURN);
            $die = true;
        } elseif (GetVars('format', 'POST') == "json") {
            // 1.5涔嬪悗鐨勮瘎璁轰互json褰㈠紡鍔犺浇缁欏墠绔�
            Add_Filter_Plugin('Filter_Plugin_Zbp_ShowError', 'JsonError4ShowErrorHook', PLUGIN_EXITSIGNAL_RETURN);
            $die = true;
        }

        PostComment();
        $zbp->BuildModule();
        $zbp->SaveCache();

        if ($die) {
            exit;
        }

        Redirect(GetVars('HTTP_REFERER', 'SERVER'));

        break;
    case 'getcmt':
        ViewComments((int) GetVars('postid', 'GET'), (int) GetVars('page', 'GET'));
        die();
    break;
    case 'ArticleEdt':
        Redirect('admin/edit.php?' . GetVars('QUERY_STRING', 'SERVER'));
        break;
    case 'ArticleDel':
        CheckIsRefererValid();
        DelArticle();
        $zbp->BuildModule();
        $zbp->SaveCache();
        $zbp->SetHint('good');
        Redirect('cmd.php?act=ArticleMng');
        break;
    case 'ArticleMng':
        Redirect('admin/index.php?' . GetVars('QUERY_STRING', 'SERVER'));
        break;
    case 'ArticlePst':
        $zbp->csrfExpiration = 48;
        CheckIsRefererValid();
        PostArticle();
        $zbp->BuildModule();
        $zbp->SaveCache();
        $zbp->SetHint('good');
        echo '<script>localStorage.removeItem("zblogphp_article_" + decodeURIComponent(' . urlencode(GetVars('ID', 'POST')) . '));</script>';
        RedirectByScript('cmd.php?act=ArticleMng');
        break;

    case 'CategoryMng':
        Redirect('admin/index.php?' . GetVars('QUERY_STRING', 'SERVER'));
        break;
    case 'CategoryEdt':
        Redirect('admin/category_edit.php?' . GetVars('QUERY_STRING', 'SERVER'));
        break;
    case 'CategoryPst':
        CheckIsRefererValid();
        PostCategory();
        $zbp->BuildModule();
        $zbp->SaveCache();
        $zbp->SetHint('good');
        Redirect('cmd.php?act=CategoryMng');
        break;
    case 'CategoryDel':
        CheckIsRefererValid();
        DelCategory();
        $zbp->BuildModule();
        $zbp->SaveCache();
        $zbp->SetHint('good');
        Redirect('cmd.php?act=CategoryMng');
        break;
    case 'CommentDel':
        CheckIsRefererValid();
        DelComment();
        $zbp->BuildModule();
        $zbp->SaveCache();
        $zbp->SetHint('good');
        Redirect($_SERVER["HTTP_REFERER"]);
        break;
    case 'CommentChk':
        CheckIsRefererValid();
        CheckComment();
        $zbp->BuildModule();
        $zbp->SaveCache();
        $zbp->SetHint('good');
        Redirect($_SERVER["HTTP_REFERER"]);
        break;
    case 'CommentBat':
        CheckIsRefererValid();
        BatchComment();
        $zbp->BuildModule();
        $zbp->SaveCache();
        $zbp->SetHint('good');
        Redirect($_SERVER["HTTP_REFERER"]);
        break;
    case 'CommentMng':
        Redirect('admin/index.php?' . GetVars('QUERY_STRING', 'SERVER'));
        break;
    case 'MemberMng':
        Redirect('admin/index.php?' . GetVars('QUERY_STRING', 'SERVER'));
        break;
    case 'MemberEdt':
        Redirect('admin/member_edit.php?' . GetVars('QUERY_STRING', 'SERVER'));
        break;
    case 'MemberNew':
        Redirect('admin/member_edit.php?' . GetVars('QUERY_STRING', 'SERVER'));
        break;
    case 'MemberPst':
        
        CheckIsRefererValid();
        PostMember();
        $zbp->BuildModule();
        $zbp->SaveCache();
        $zbp->SetHint('good');
       
        $wangqi_level = -1;
        Redirect('admin/index.php?act=admin');
        break;

    case 'MemberDel':
        CheckIsRefererValid();
        if (DelMember()) {
            $zbp->BuildModule();
            $zbp->SaveCache();
            $zbp->SetHint('good');
        } else {
            $zbp->SetHint('bad');
        }
            Redirect('cmd.php?act=MemberMng');
        break;

    case 'SidebarSet':
        CheckIsRefererValid();
        SetSidebar();
        $zbp->BuildModule();
        $zbp->SaveCache();
        break;
  
    case 'ajax':
        foreach ($GLOBALS['hooks']['Filter_Plugin_Cmd_Ajax'] as $fpname => &$fpsignal) {
            $fpname(GetVars('src', 'GET'));
        }

        break;
    default:
        // code...
        break;
}
