<?php if (!defined('ZBP_PATH')) {
    exit('Access denied');
}
/*
 * 鍚庡彴绠＄悊鐩稿叧
 * @package Z-BlogPHP
 * @subpackage System/Administrator 鍚庡彴绠＄悊
 * @copyright (C)  RainbowSoft Studio
 */

$zbp->ismanage = true;

$leftmenus = array();



/**
 * 鍚庡彴绠＄悊宸︿晶瀵艰埅鑿滃崟.
 */
function ResponseAdmin_LeftMenu()
{
    global $zbp;
    global $leftmenus;


    $leftmenus['nav_new'] = MakeLeftMenu("ArticleEdt", $zbp->lang['msg']['new_article'], $zbp->host . "zb_system/cmd.php?act=ArticleEdt", "nav_new", "aArticleEdt", "");
    $leftmenus['nav_article'] = MakeLeftMenu("ArticleMng", $zbp->lang['msg']['article_manage'], $zbp->host . "zb_system/cmd.php?act=ArticleMng", "nav_article", "aArticleMng", "");

    $leftmenus[] = "<li class='split'><hr/></li>";

    $leftmenus['nav_category'] = MakeLeftMenu("CategoryMng", $zbp->lang['msg']['category_manage'], $zbp->host . "zb_system/cmd.php?act=CategoryMng", "nav_category", "aCategoryMng", "");
    $leftmenus['nav_comment1'] = MakeLeftMenu("CommentMng", $zbp->lang['msg']['comment_manage'], $zbp->host . "zb_system/cmd.php?act=CommentMng", "nav_comment", "aCommentMng", "");
    $leftmenus['nav_member'] = MakeLeftMenu("MemberMng", $zbp->lang['msg']['member_manage'], $zbp->host . "zb_system/cmd.php?act=MemberMng", "nav_member", "aMemberMng", "");

    $leftmenus[] = "<li class='split'><hr/></li>";

    foreach ($GLOBALS['hooks']['Filter_Plugin_Admin_LeftMenu'] as $fpname => &$fpsignal) {
        $fpname($leftmenus);
    }

    foreach ($leftmenus as $m) {
        echo $m;
    }
}

/**
* 生成文章IsTop状态select表单.
*
* @param $default
*
* @return null|string
*/
function OutputOptionItemsOfIsTop($default)
{
    global $zbp;
    
    $s = null;
    $s .= '<option value="0" ' . ($default == 0 ? 'selected="selected"' : '') . ' >' . $zbp->lang['msg']['none'] . '</option>';
    $s .= '<option value="2" ' . ($default == 2 ? 'selected="selected"' : '') . ' >' . $zbp->lang['msg']['top_index'] . '</option>';
    $s .= '<option value="1" ' . ($default == 1 ? 'selected="selected"' : '') . ' >' . $zbp->lang['msg']['top_global'] . '</option>';
    $s .= '<option value="4" ' . ($default == 4 ? 'selected="selected"' : '') . ' >' . $zbp->lang['msg']['top_category'] . '</option>';
    
    return $s;
}

/**
 * 鍚庡彴绠＄悊椤堕儴鑿滃崟.
 */
function ResponseAdmin_TopMenu()
{
    
}


/**
 * 娣诲姞宸︿晶鑿滃崟椤�.
 *
 * @param $requireAction
 * @param $strName
 * @param $strUrl
 * @param $strLiId
 * @param $strAId
 * @param $strImgUrl
 *
 * @return null|string
 */
function MakeLeftMenu($requireAction, $strName, $strUrl, $strLiId, $strAId, $strImgUrl)
{
    global $zbp;

    static $AdminLeftMenuCount = 0;

    $AdminLeftMenuCount = $AdminLeftMenuCount + 1;
    $tmp = null;
    if ($strImgUrl != "") {
        $tmp = "<li id=\"" . $strLiId . "\"><a id=\"" . $strAId . "\" href=\"" . $strUrl . "\" title=\"" . strip_tags($strName) . "\"><span style=\"background-image:url('" . $strImgUrl . "')\">" . $strName . "</span></a></li>";
    } else {
        $tmp = "<li id=\"" . $strLiId . "\"><a id=\"" . $strAId . "\" href=\"" . $strUrl . "\" title=\"" . strip_tags($strName) . "\"><span>" . $strName . "</span></a></li>";
    }

    return $tmp;
}

//###############################################################################################################


/**
 * 鐢熸垚鍒嗙被select琛ㄥ崟.
 *
 * @param $default
 *
 * @return null|string
 */
function OutputOptionItemsOfCategories($default)
{
    global $zbp;

    foreach ($GLOBALS['hooks']['Filter_Plugin_OutputOptionItemsOfCategories'] as $fpname => &$fpsignal) {
        $fpreturn = $fpname($default);
        if ($fpsignal == PLUGIN_EXITSIGNAL_RETURN) {
            $fpsignal = PLUGIN_EXITSIGNAL_NONE;

            return $fpreturn;
        }
    }

    $s = null;
    foreach ($zbp->categoriesbyorder as $id => $cate) {
        $s .= '<option ' . ($default == $cate->ID ? 'selected="selected"' : '') . ' value="' . $cate->ID . '">' . $cate->SymbolName . '</option>';
    }

    return $s;
}


/**
 * 鐢熸垚鏂囩珷鍙戝竷鐘舵�乻elect琛ㄥ崟.
 *
 * @param $default
 *
 * @return null|string
 */
function OutputOptionItemsOfPostStatus($default)
{
    global $zbp;

    $s = null;
    if (!$zbp->CheckRights('ArticlePub') && $default == 2) {
        return '<option value="2" ' . ($default == 2 ? 'selected="selected"' : '') . ' >' . $zbp->lang['post_status_name']['2'] . '</option>';
    }
    if (!$zbp->CheckRights('ArticleAll') && $default == 2) {
        return '<option value="2" ' . ($default == 2 ? 'selected="selected"' : '') . ' >' . $zbp->lang['post_status_name']['2'] . '</option>';
    }
    $s .= '<option value="0" ' . ($default == 0 ? 'selected="selected"' : '') . ' >' . $zbp->lang['post_status_name']['0'] . '</option>';
    $s .= '<option value="1" ' . ($default == 1 ? 'selected="selected"' : '') . ' >' . $zbp->lang['post_status_name']['1'] . '</option>';
    if ($zbp->CheckRights('ArticleAll')) {
        $s .= '<option value="2" ' . ($default == 2 ? 'selected="selected"' : '') . ' >' . $zbp->lang['post_status_name']['2'] . '</option>';
    }

    return $s;
}

/**
 * 鍒涘缓Div妯″潡.
 *
 * @param $m
 * @param bool $button
 */
function CreateModuleDiv($m, $button = true)
{
    global $zbp;

    echo '<div class="widget widget_source_' . $m->SourceType . ' widget_id_' . $m->FileName . '">';
    echo '<div class="widget-title"><img class="more-action" width="16" src="../image/admin/brick.png" alt="" />' . (($m->SourceType != 'theme' || $m->Source == 'plugin_' . $zbp->theme) ? $m->Name : $m->FileName) . '';

    if ($button) {
        if ($m->SourceType != 'theme' || $m->Source == 'plugin_' . $zbp->theme) {
            echo '<span class="widget-action"><a href="../cmd.php?act=ModuleEdt&amp;id=' . $m->ID . '"><img class="edit-action" src="../image/admin/brick_edit.png" alt="' . $zbp->lang['msg']['edit'] . '" title="' . $zbp->lang['msg']['edit'] . '" width="16" /></a>';
        } else {
            echo '<span class="widget-action"><a href="../cmd.php?act=ModuleEdt&amp;source=theme&amp;filename=' . $m->FileName . '"><img class="edit-action" src="../image/admin/brick_edit.png" alt="' . $zbp->lang['msg']['edit'] . '" title="' . $zbp->lang['msg']['edit'] . '" width="16" /></a>';
            echo '&nbsp;<a onclick="return window.confirm(\'' . $zbp->lang['msg']['confirm_operating'] . '\');" href="' . BuildSafeCmdURL('act=ModuleDel&amp;source=theme&amp;filename=' . $m->FileName) . '"><img src="../image/admin/delete.png" alt="' . $zbp->lang['msg']['del'] . '" title="' . $zbp->lang['msg']['del'] . '" width="16" /></a>';
        }
        if ($m->SourceType != 'system'
            && $m->SourceType != 'theme'
            && !(
                $m->SourceType == 'plugin' &&
                CheckRegExp($m->Source, '/plugin_(' . $zbp->option['ZC_USING_PLUGIN_LIST'] . ')/i')
            )
        ) {
            echo '&nbsp;<a onclick="return window.confirm(\'' . $zbp->lang['msg']['confirm_operating'] . '\');" href="' . BuildSafeCmdURL('act=ModuleDel&amp;id=' . $m->ID) . '"><img src="../image/admin/delete.png" alt="' . $zbp->lang['msg']['del'] . '" title="' . $zbp->lang['msg']['del'] . '" width="16" /></a>';
        }
        echo '</span>';
    }

    echo '</div>';
    echo '<div class="funid" style="display:none">' . $m->FileName . '</div>';
    echo '</div>';
}



   
//###############################################################################################################
/**
 * 鍚庡彴鏂囩珷绠＄悊.
 */
function Admin_ArticleMng()
{
    global $zbp;

    echo '<div class="SubMenu">';
    foreach ($GLOBALS['hooks']['Filter_Plugin_Admin_ArticleMng_SubMenu'] as $fpname => &$fpsignal) {
        $fpname();
    }
    echo '</div>';
    echo '<div id="divMain2">';
    echo '<form class="search" id="search" method="post" action="#">';

    echo '<p>' . $zbp->lang['msg']['search'] . ':&nbsp;&nbsp;' . $zbp->lang['msg']['category'] . ' <select class="edit" size="1" name="category" style="width:140px;" ><option value="">' . $zbp->lang['msg']['any'] . '</option>';
    foreach ($zbp->categoriesbyorder as $id => $cate) {
        echo '<option value="' . $cate->ID . '">' . $cate->SymbolName . '</option>';
    }
    echo '</select>&nbsp;&nbsp;&nbsp;&nbsp;' . $zbp->lang['msg']['type'] . ' <select class="edit" size="1" name="status" style="width:100px;" ><option value="">' . $zbp->lang['msg']['any'] . '</option> <option value="0" >' . $zbp->lang['post_status_name']['0'] . '</option><option value="1" >' . $zbp->lang['post_status_name']['1'] . '</option><option value="2" >' . $zbp->lang['post_status_name']['2'] . '</option></select>&nbsp;&nbsp;&nbsp;&nbsp;
	<label><input type="checkbox" name="istop" value="True"/>&nbsp;' . $zbp->lang['msg']['top'] . '</label>&nbsp;&nbsp;&nbsp;&nbsp;
	<input name="search" style="width:250px;" type="text" value="" /> &nbsp;&nbsp;&nbsp;&nbsp;<input type="submit" class="button" value="' . $zbp->lang['msg']['submit'] . '"/></p>';
    echo '</form>';


    $w = array();
    if (!$zbp->CheckRights('ArticleAll')) {
        $w[] = array('=', 'log_AuthorID', $zbp->user->ID);
    }
    if (GetVars('search')) {
        $w[] = array('search', 'log_Content', 'log_Intro', 'log_Title', GetVars('search'));
    }
    if (GetVars('istop')) {
        $w[] = array('<>', 'log_Istop', '0');
    }
    if (GetVars('status')) {
        $w[] = array('=', 'log_Status', GetVars('status'));
    }
    if (GetVars('category')) {
        $w[] = array('=', 'log_CateID', GetVars('category'));
    }

    $s = '';
    $or = array('log_PostTime' => 'DESC');

    foreach ($GLOBALS['hooks']['Filter_Plugin_LargeData_Article'] as $fpname => &$fpsignal) {
        $fpreturn = $fpname($s, $w, $or, $l, $op);
    }

    $array = $zbp->GetArticleList(
        $s,
        $w,
        $or,
        false
    );

    echo '<table border="1" class="tableFull tableBorder table_hover table_striped tableBorder-thcenter">';

    $tables = '';
    $tableths = array();
    $tableths[] = '<tr>';
    $tableths[] = '<th>' . $zbp->lang['msg']['id'] . '</th>';
    $tableths[] = '<th>' . $zbp->lang['msg']['category'] . '</th>';
    $tableths[] = '<th>' . $zbp->lang['msg']['author'] . '</th>';
    $tableths[] = '<th>' . $zbp->lang['msg']['title'] . '</th>';
    $tableths[] = '<th>' . $zbp->lang['msg']['date'] . '</th>';
    $tableths[] = '<th>' . $zbp->lang['msg']['comment'] . '</th>';
    $tableths[] = '<th>' . $zbp->lang['msg']['status'] . '</th>';
    $tableths[] = '<th></th>';
    $tableths[] = '</tr>';

    foreach ($array as $article) {
        $tabletds = array(); //table string
        $tabletds[] = '<tr>';
        $tabletds[] = '<td class="td5">' . $article->ID . '</td>';
        $tabletds[] = '<td class="td10">' . $article->Category->Name . '</td>';
        $tabletds[] = '<td class="td10">' . $article->Author->Name . '</td>';
        $tabletds[] = '<td><a href="' . $article->Url . '" target="_blank"><img src="../image/admin/link.png" alt="" title="" width="16" /></a> ' . $article->Title . '</td>';
        $tabletds[] = '<td class="td20">' . $article->Time() . '</td>';
        $tabletds[] = '<td class="td5">' . $article->CommNums . '</td>';
        $tabletds[] = '<td class="td5">' . ($article->IsTop ? $zbp->lang['msg']['top'] . '|' : '') . $article->StatusName . '</td>';
        $tabletds[] = '<td class="td10 tdCenter">' .
        '<a href="../cmd.php?act=ArticleEdt&amp;id=' . $article->ID . '"><img src="../image/admin/page_edit.png" alt="' . $zbp->lang['msg']['edit'] . '" title="' . $zbp->lang['msg']['edit'] . '" width="16" /></a>' .
        '&nbsp;&nbsp;&nbsp;&nbsp;' .
        '<a onclick="return window.confirm(\'' . $zbp->lang['msg']['confirm_operating'] . '\');" href="' . BuildSafeCmdURL('act=ArticleDel&amp;id=' . $article->ID) . '"><img src="../image/admin/delete.png" alt="' . $zbp->lang['msg']['del'] . '" title="' . $zbp->lang['msg']['del'] . '" width="16" /></a>' .
        '</td>';

        $tabletds[] = '</tr>';

        foreach ($GLOBALS['hooks']['Filter_Plugin_Admin_ArticleMng_Table'] as $fpname => &$fpsignal) {
            //浼犲叆 褰撳墠post锛屽綋鍓嶈锛岃〃澶�
            $fpreturn = $fpname($article, $tabletds, $tableths);
        }

        $tables .= implode($tabletds);
    }

    echo implode($tableths) . $tables;

    echo '</table>';
    echo '<hr/><p class="pagebar">';


    echo '</p></div>';
    echo '<script type="text/javascript">ActiveLeftMenu("aArticleMng");</script>';
    echo '<script type="text/javascript">AddHeaderIcon("' . $zbp->host . 'zb_system/image/common/article_32.png' . '");</script>';
}

//###############################################################################################################
/**
 * 鍚庡彴鍒嗙被绠＄悊.
 */
function Admin_CategoryMng()
{
    global $zbp;

    echo '<div class="SubMenu">';

    echo '</div>';
    echo '<div id="divMain2">';
    echo '<table border="1" class="tableFull tableBorder tableBorder-thcenter table_hover table_striped">';

    $tables = '';
    $tableths = array();
    $tableths[] = '<tr>';
    $tableths[] = '<th>' . $zbp->lang['msg']['id'] . '</th>';
    $tableths[] = '<th>' . $zbp->lang['msg']['order'] . '</th>';
    $tableths[] = '<th>' . $zbp->lang['msg']['name'] . '</th>';
    $tableths[] = '<th>' . $zbp->lang['msg']['post_count'] . '</th>';
    $tableths[] = '<th></th>';
    $tableths[] = '</tr>';

    foreach ($zbp->categoriesbyorder as $category) {
        $tabletds = array(); //table string
        $tabletds[] = '<tr>';
        $tabletds[] = '<td class="td5">' . $category->ID . '</td>';
        $tabletds[] = '<td class="td5">' . $category->Order . '</td>';
        $tabletds[] = '<td class="td25">' . $category->Symbol . $category->Name . '</td>';
        $tabletds[] = '<td class="td10">' . $category->Count . '</td>';
        $tabletds[] = '<td class="td10 tdCenter">' .
           
        ((count($category->SubCategories) == 0) ?
            '<a onclick="return window.confirm(\'' . $zbp->lang['msg']['confirm_operating'] . '\');" href="' . BuildSafeCmdURL('act=CategoryDel&amp;id=' . $category->ID) . '"><img src="../image/admin/delete.png" alt="' . $zbp->lang['msg']['del'] . '" title="' . $zbp->lang['msg']['del'] . '" width="16" /></a>' : '') .
            '</td>';

        $tabletds[] = '</tr>';
        foreach ($GLOBALS['hooks']['Filter_Plugin_Admin_CategoryMng_Table'] as $fpname => &$fpsignal) {
            //浼犲叆 褰撳墠$category锛屽綋鍓嶈锛岃〃澶�
            $fpreturn = $fpname($category, $tabletds, $tableths);
        }

        $tables .= implode($tabletds);
    }

    echo implode($tableths) . $tables;

    echo '</table>';
    echo '</div>';
    echo '<script type="text/javascript">ActiveLeftMenu("aCategoryMng");</script>';
    echo '<script type="text/javascript">AddHeaderIcon("' . $zbp->host . 'zb_system/image/common/category_32.png' . '");</script>';
}

//###############################################################################################################
/**
 * 鍚庡彴璇勮绠＄悊.
 */
function Admin_CommentMng()
{
    global $zbp;

    echo '<div class="SubMenu">';

    echo '</div>';
    echo '<div id="divMain2">';

    echo '<form class="search" id="search" method="post" action="#">';
    echo '<p>' . $zbp->lang['msg']['search'] . '&nbsp;&nbsp;&nbsp;&nbsp;<input name="search" style="width:450px;" type="text" value="" /> &nbsp;&nbsp;&nbsp;&nbsp;<input type="submit" class="button" value="' . $zbp->lang['msg']['submit'] . '"/></p>';
    echo '</form>';
    echo '<form method="post" action="' . $zbp->host . 'zb_system/cmd.php?act=CommentBat">';
    echo '<input type="hidden" name="csrfToken" value="' . $zbp->GetCSRFToken() . '">';

   
    $w = array();
    if (!$zbp->CheckRights('CommentAll')) {
        $w[] = array('=', 'comm_AuthorID', $zbp->user->ID);
    }
    if (GetVars('search')) {
        $w[] = array('search', 'comm_Content', 'comm_Name', GetVars('search'));
    }
    if (GetVars('id')) {
        $w[] = array('=', 'comm_ID', GetVars('id'));
    }

    $w[] = array('=', 'comm_Ischecking', (int) GetVars('ischecking'));

    $s = '';
    $or = array('comm_ID' => 'DESC');


    foreach ($GLOBALS['hooks']['Filter_Plugin_LargeData_Comment'] as $fpname => &$fpsignal) {
        $fpreturn = $fpname($s, $w, $or, $l, $op);
    }

    $array = $zbp->GetCommentList(
        $s,
        $w,
        $or

    );

    echo '<table border="1" class="tableFull tableBorder tableBorder-thcenter table_hover table_striped">';
    $tables = '';
    $tableths = array();
    $tableths[] = '<tr>';
    $tableths[] = '<th>' . $zbp->lang['msg']['id'] . '</th>';
    $tableths[] = '<th>' . $zbp->lang['msg']['name'] . '</th>';
    $tableths[] = '<th>' . $zbp->lang['msg']['content'] . '</th>';
    $tableths[] = '<th>' . $zbp->lang['msg']['article'] . '</th>';
    $tableths[] = '<th>' . $zbp->lang['msg']['date'] . '</th>';
    $tableths[] = '<th></th>';
    $tableths[] = '<th><a href="" onclick="BatchSelectAll();return false;">' . $zbp->lang['msg']['select_all'] . '</a></th>';
    $tableths[] = '</tr>';

    foreach ($array as $cmt) {
        $article = $zbp->GetPostByID($cmt->LogID);
        if ($article->ID == 0) {
            $article = null;
        }

        $tabletds = array(); //table string
        $tabletds[] = '<tr>';
        $tabletds[] = '<td class="td5"><a href="?act=CommentMng&id=' . $cmt->ID . '" title="' . $zbp->lang['msg']['jump_comment'] . $cmt->ID . '">' . $cmt->ID . '</a></td>';

        $tabletds[] = '<td class="td10"><span class="cmt-note" title="' . $zbp->lang['msg']['email'] . ':' . htmlspecialchars($cmt->Email) . '"><a href="mailto:' . htmlspecialchars($cmt->Email) . '">' . $cmt->Author->Name . '</a></span></td>';
        $tabletds[] = '<td><div style="overflow:hidden;max-width:500px;">' .
        (($article) ?
            '<a href="' . $article->Url . '" target="_blank"><img src="../image/admin/link.png" alt="" title="" width="16" /></a> '
        :
            '<a href="javascript:;"><img src="../image/admin/delete.png" alt="no exists" title="no exists" width="16" /></a>'
        ) .
            $cmt->Content . '<div></td>';
        $tabletds[] = '<td class="td5">' . $cmt->LogID . '</td>';
        $tabletds[] = '<td class="td15">' . $cmt->Time() . '</td>';
        $tabletds[] = '<td class="td10 tdCenter">' .
            '<a onclick="return window.confirm(\'' . $zbp->lang['msg']['confirm_operating'] . '\');" href="' . BuildSafeCmdURL('act=CommentDel&amp;id=' . $cmt->ID) . '"><img src="../image/admin/delete.png" alt="' . $zbp->lang['msg']['del'] . '" title="' . $zbp->lang['msg']['del'] . '" width="16" /></a>' .
            '&nbsp;&nbsp;&nbsp;&nbsp;' .
            (!GetVars('ischecking', 'GET') ?
                '<a href="' . BuildSafeCmdURL('act=CommentChk&amp;id=' . $cmt->ID . '&amp;ischecking=' . (int) !GetVars('ischecking', 'GET')) . '"><img src="../image/admin/minus-shield.png" alt="' . $zbp->lang['msg']['audit'] . '" title="' . $zbp->lang['msg']['audit'] . '" width="16" /></a>'
                :
                '<a href="' . BuildSafeCmdURL('act=CommentChk&amp;id=' . $cmt->ID . '&amp;ischecking=' . (int) !GetVars('ischecking', 'GET')) . '"><img src="../image/admin/ok.png" alt="' . $zbp->lang['msg']['pass'] . '" title="' . $zbp->lang['msg']['pass'] . '" width="16" /></a>'
            ) .
            '</td>';
        $tabletds[] = '<td class="td5 tdCenter">' . '<input type="checkbox" id="id' . $cmt->ID . '" name="id[]" value="' . $cmt->ID . '"/>' . '</td>';

        $tabletds[] = '</tr>';
        foreach ($GLOBALS['hooks']['Filter_Plugin_Admin_CommentMng_Table'] as $fpname => &$fpsignal) {
            //浼犲叆 褰撳墠$cmt锛屽綋鍓嶈锛岃〃澶�
            $fpreturn = $fpname($cmt, $tabletds, $tableths, $article);
        }

        $tables .= implode($tabletds);
    }

    echo implode($tableths) . $tables;
    echo '</table>';
    echo '<hr/>';

    echo '<p style="float:right;">';

    if ((bool) GetVars('ischecking')) {
        echo '<input type="submit" name="all_del"  value="' . $zbp->lang['msg']['all_del'] . '"/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
        echo '<input type="submit" name="all_pass"  value="' . $zbp->lang['msg']['all_pass'] . '"/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
    } else {
        echo '<input type="submit" name="all_del"  value="' . $zbp->lang['msg']['all_del'] . '"/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
        echo '<input type="submit" name="all_audit"  value="' . $zbp->lang['msg']['all_audit'] . '"/>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
    }

    echo '</p>';

    echo '<p class="pagebar">';



    echo '</p>';

    echo '<hr/></form>';

    echo '</div>';
    echo '<script type="text/javascript">ActiveLeftMenu("aCommentMng");</script>';
    echo '<script type="text/javascript">AddHeaderIcon("' . $zbp->host . 'zb_system/image/common/comments_32.png' . '");$(".cmt-note").tooltip();</script>';
}

//###############################################################################################################
/**
 * 鍚庡彴鐢ㄦ埛绠＄悊.
 */
function Admin_MemberMng()
{
    global $zbp;

    echo '<div class="SubMenu">';

    echo '</div>';
    echo '<div id="divMain2">';
    echo '<form class="search" id="search" method="post" action="#">';

    echo '<p>' . $zbp->lang['msg']['search'] . ':&nbsp;&nbsp;' . $zbp->lang['msg']['member_level'] . ' <select class="edit" size="1" name="level" style="width:140px;" ><option value="">' . $zbp->lang['msg']['any'] . '</option>';
    foreach ($zbp->lang['user_level_name'] as $id => $name) {
        echo '<option value="' . $id . '">' . $name . '</option>';
    }
    echo '</select>&nbsp;&nbsp;&nbsp;&nbsp;
	<input name="search" style="width:250px;" type="text" value="" /> &nbsp;&nbsp;&nbsp;&nbsp;<input type="submit" class="button" value="' . $zbp->lang['msg']['submit'] . '"/></p>';
    echo '</form>';

    
    $w = array();
    if (!$zbp->CheckRights('MemberAll')) {
        $w[] = array('=', 'mem_ID', $zbp->user->ID);
    }
    if (GetVars('level')) {
        $w[] = array('=', 'mem_Level', GetVars('level'));
    }
    if (GetVars('search')) {
        $w[] = array('search', 'mem_Name', 'mem_Email', GetVars('search'));
    }
    $array = $zbp->GetMemberList(
        '',
        $w,
        array('mem_ID' => 'ASC')
    
    );

    echo '<table border="1" class="tableFull tableBorder tableBorder-thcenter table_hover table_striped">';
    $tables = '';
    $tableths = array();
    $tableths[] = '<tr>';
    $tableths[] = '<th>' . $zbp->lang['msg']['id'] . '</th>';
    $tableths[] = '<th>' . $zbp->lang['msg']['member_level'] . '</th>';
    $tableths[] = '<th>' . $zbp->lang['msg']['name'] . '</th>';
    $tableths[] = '<th>' . $zbp->lang['msg']['all_artiles'] . '</th>';
    $tableths[] = '<th>' . $zbp->lang['msg']['all_comments'] . '</th>';
    $tableths[] = '<th></th>';
    $tableths[] = '</tr>';

    foreach ($array as $member) {
        $tabletds = array(); //table string
        $tabletds[] = '<tr>';
        $tabletds[] = '<td class="td5">' . $member->ID . '</td>';
        $tabletds[] = '<td class="td10">' . $member->LevelName . ($member->Status > 0 ? '(' . $zbp->lang['user_status_name'][$member->Status] . ')' : '') . '</td>';
        $tabletds[] = '<td>' . $member->Name . '</td>';
        $tabletds[] = '<td class="td10">' . $member->Articles . '</td>';
        $tabletds[] = '<td class="td10">' . $member->Comments . '</td>';
        $tabletds[] = '<td class="td10 tdCenter">' .
            
            (($zbp->CheckRights('MemberDel') && ($member->IsGod !== true)) ?
                '&nbsp;&nbsp;&nbsp;&nbsp;' .
                '<a onclick="return window.confirm(\'' . $zbp->lang['msg']['confirm_operating'] . '\');" href="' . BuildSafeCmdURL('act=MemberDel&amp;id=' . $member->ID) . '"><img src="../image/admin/delete.png" alt="' . $zbp->lang['msg']['del'] . '" title="' . $zbp->lang['msg']['del'] . '" width="16" /></a>'
                
                : '') .
                '</td>';
                
                $tabletds[] = '</tr>';

        $tabletds[] = '</tr>';

        foreach ($GLOBALS['hooks']['Filter_Plugin_Admin_MemberMng_Table'] as $fpname => &$fpsignal) {
            //浼犲叆 褰撳墠$member锛屽綋鍓嶈锛岃〃澶�
            $fpreturn = $fpname($member, $tabletds, $tableths);
        }

        $tables .= implode($tabletds);
    }

    echo implode($tableths) . $tables;

    echo '</table>';
    echo '<hr/><p class="pagebar">';

    echo '</p></div>';
    echo '<script type="text/javascript">ActiveLeftMenu("aMemberMng");</script>';
    echo '<script type="text/javascript">AddHeaderIcon("' . $zbp->host . 'zb_system/image/common/user_32.png' . '");</script>';
}

?>
