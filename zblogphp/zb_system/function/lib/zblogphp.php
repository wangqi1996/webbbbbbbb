<?php

if (!defined('ZBP_PATH')) {
    exit('Access denied');
}
/**
 * zbp鍏ㄥ眬鎿嶄綔绫�.
 */
class ZBlogPHP
{
    private static $_zbp = null;
    /**
     * @var string 鐗堟湰鍙�
     */
    public $version = null;
    /**
     * @var Database__Interface 鏁版嵁搴�
     */
    public $db = null;
    /**
     * @var array 閰嶇疆閫夐」
     */
    public $option = array();
   
    /**
     * @var string 璺緞
     */
    public $path = null;
    /**
     * @var string 鍩熷悕
     */
    public $host = null;
    /**
     * @var string cookie浣滅敤鍩�
     */
    public $cookiespath = null;
    /**
     * @var string guid
     */
    public $guid = null;
    /**
     * @var string 褰撳墠閾炬帴
     */
    public $currenturl = null;
    /**
     * @var string 褰撳墠閾炬帴
     */
    public $fullcurrenturl = null;
    /**
     * @var string 鐢ㄦ埛鐩綍
     */
    public $usersdir = null;
    /**
     * @var string 楠岃瘉鐮佸湴鍧�
     */
    public $verifyCodeUrl = null;
    /**
     * @var string 楠岃瘉鐮佸湴鍧�锛堟嫾鍐欓敊璇級
     *
     * @deprecated
     */
    public $validcodeurl = null;
  
    /**
     * @var string
     */
    public $searchurl = null;
    /**
     * @var string
     */
    public $ajaxurl = null;
    /**
     * @var string
     */
    public $xmlrpcurl = null;
    /**
     * @var Member[] 鐢ㄦ埛鏁扮粍
     */
    public $members = array();
    /**
     * @var Member[] 鐢ㄦ埛鏁扮粍锛堜互鐢ㄦ埛鍚嶄负閿級
     */
    public $membersbyname = array();
    /**
     * @var Category[] 鍒嗙被鏁扮粍
     */
    public $categorys = array();
    public $categories = null;
    /**
     * @var Category[] 鍒嗙被鏁扮粍锛堝凡鎺掑簭锛�
     */
    public $categorysbyorder = array();
    public $categoriesbyorder = null;
   
    /**
     * @var Config[] 閰嶇疆閫夐」
     */
    public $configs = array();

 
    /**
     * @var Post[] 鏂囩珷鍒楄〃鏁扮粍
     */
    public $posts = array();

    /**
     * @var string 褰撳墠椤甸潰鏍囬
     */
    public $title = null;
    /**
     * @var string 缃戠珯鍚�
     */
    public $name = null;
    /**
     * @var string 缃戠珯瀛愭爣棰�
     */
    public $subname = null;
    

    /**
     * @var Member 褰撳墠鐢ㄦ埛
     */
    public $user = null;
    /**
     * @var Config 缂撳瓨
     */
    public $cache = null;

    /**
     * @var array|null 鏁版嵁琛�
     */
    public $table = null;
    /**
     * @var array|null 鏁版嵁琛ㄤ俊鎭�
     */
    public $datainfo = null;
    /**
     * @var array|null 绫诲瀷搴忓垪
     */
    public $posttype = null;
    /**
     * @var array|null 鎿嶄綔鍒楄〃
     */
    public $actions = null;
    /**
     * @var mixed|null|string 褰撳墠鎿嶄綔
     */
    public $action = null;
    
    /**
     * @var array 语言
     */
    public $lang = array();
    /**
     * @var array 语言包list
     */
    public $langpacklist = array();

    private $isinitialized = false; //鏄惁鍒濆鍖栨垚鍔�
    private $isconnected = false; //鏄惁杩炴帴鎴愬姛
    private $isload = false; //鏄惁杞藉叆
    private $issession = false; //鏄惁浣跨敤session
    public $ismanage = false; //鏄惁鍔犺浇绠＄悊妯″紡
    private $isGzip = false; //鏄惁寮�鍚痝zip
    public $isHttps = false; //鏄惁HTTPS

    /**
     * @var null 绀句細鍖栬瘎璁�
     */
    public $socialcomment = null;
 

    /**
     * @var int 绠＄悊椤甸潰鏄剧ず鏉℃暟
     */
    public $managecount = 50;
    /**
     * @var int 椤电爜鏄剧ず鏉℃暟
     */
    public $pagebarcount = 10;
    /**
     * @var int 鎼滅储杩斿洖鏉℃暟
     */
    public $searchcount = 10;
    /**
     * @var int 鏂囩珷鍒楄〃鏄剧ず鏉℃暟
     */
    public $displaycount = 10;
    /**
     * @var int 璇勮鏄剧ず鏁伴噺
     */
    public $commentdisplaycount = 10;

    /**
     * @var int 褰撳墠瀹炰緥涓婥SRF Token杩囨湡鏃堕棿锛堝皬鏃讹級
     */
    public $csrfExpiration = 1;

    /**
     * 鑾峰彇鍞竴瀹炰緥.
     *
     * @return null|ZBlogPHP
     */
    public static function GetInstance()
    {
        if (!isset(self::$_zbp)) {
            if (isset($GLOBALS['option']['ZC_GODZBP_FILE']) && isset($GLOBALS['option']['ZC_GODZBP_NAME']) && is_readable(ZBP_PATH . $GLOBALS['option']['ZC_GODZBP_FILE'])) {
                require ZBP_PATH . $GLOBALS['option']['ZC_GODZBP_FILE'];
                self::$_zbp = new $GLOBALS['option']['ZC_GODZBP_NAME']();
            } else {
                self::$_zbp = new self();
            }
        }

        return self::$_zbp;
    }

    /**
     * 鍒濆鍖栨暟鎹簱杩炴帴.
     *
     * @param string $type 鏁版嵁杩炴帴绫诲瀷
     *
     * @return Database__Interface
     */
    public static function InitializeDB($type)
    {
        if (!trim($type)) {
            return;
        }

        $newtype = 'Database__' . trim($type);

        return new $newtype();
    }
 

    /**
     * 鏋勯�犲嚱鏁帮紝鍔犺浇鍩烘湰閰嶇疆鍒�$zbp.
     */
    public function __construct()
    {
        global $option, $lang, $blogpath, $bloghost, $cookiespath, $usersdir, $table,
        $datainfo, $actions, $action, $blogversion, $blogtitle, $blogname, $blogsubname,
        $blogtheme, $blogstyle, $currenturl, $activedapps, $posttype;

        $this->lang = &$lang;
        //鍩烘湰閰嶇疆鍔犺浇鍒�$zbp鍐�
        $this->version = &$blogversion;
        $this->option = &$option;
        
        $this->path = &$blogpath;
        $this->host = &$bloghost; //姝ゅ�煎湪鍚庤竟鍒濆鍖栨椂鍙兘浼氬彉鍖�!
        $this->cookiespath = &$cookiespath;
        $this->usersdir = &$usersdir;

        $this->table = &$table;
        $this->datainfo = &$datainfo;
        $this->actions = &$actions;
        $this->posttype = &$posttype;
        $this->currenturl = &$currenturl;

        $this->action = &$action;
       
        
        $this->guid = &$this->option['ZC_BLOG_CLSID'];

        $this->title = &$blogtitle;
        $this->name = &$blogname;
        $this->subname = &$blogsubname;


        $this->managecount = &$this->option['ZC_MANAGE_COUNT'];
        $this->displaycount = &$this->option['ZC_DISPLAY_COUNT'];
        $this->commentdisplaycount = &$this->option['ZC_COMMENTS_DISPLAY_COUNT'];

        $this->categories = &$this->categorys;
        $this->categoriesbyorder = &$this->categorysbyorder;

        $this->user = new stdClass();
        foreach ($this->datainfo['Member'] as $key => $value) {
            $this->user->$key = $value[3];
        }
        $this->user->Metas = new Config();
    }

    /**
     *鏋愭瀯鍑芥暟锛岄噴鏀捐祫婧�.
     */
    public function __destruct()
    {
        $this->Terminate();
    }

    /**
     * @api Filter_Plugin_Zbp_Call
     *
     * @param $method
     * @param $args
     *
     * @return mixed
     */
    public function __call($method, $args)
    {
        foreach ($GLOBALS['hooks']['Filter_Plugin_Zbp_Call'] as $fpname => &$fpsignal) {
            $fpreturn = $fpname($method, $args);
            if ($fpsignal == PLUGIN_EXITSIGNAL_RETURN) {
                $fpsignal = PLUGIN_EXITSIGNAL_NONE;

                return $fpreturn;
            }
        }
    }

    /**
     * 璁剧疆鍙傛暟鍊�
     *
     * @param $name
     * @param $value
     *
     * @return mixed
     */
    public function __set($name, $value)
    {
        foreach ($GLOBALS['hooks']['Filter_Plugin_Zbp_Set'] as $fpname => &$fpsignal) {
            $fpreturn = $fpname($name, $value);
            if ($fpsignal == PLUGIN_EXITSIGNAL_RETURN) {
                $fpsignal = PLUGIN_EXITSIGNAL_NONE;

                return $fpreturn;
            }
        }
    }

    /**
     * 鑾峰彇鍙傛暟鍊�
     *
     * @param $name
     *
     * @return mixed
     */
    public function __get($name)
    {
        foreach ($GLOBALS['hooks']['Filter_Plugin_Zbp_Get'] as $fpname => &$fpsignal) {
            $fpreturn = $fpname($name);
            if ($fpsignal == PLUGIN_EXITSIGNAL_RETURN) {
                $fpsignal = PLUGIN_EXITSIGNAL_NONE;

                return $fpreturn;
            }
        }
       
    }

    /**
     * 鍒濆鍖�$zbp.
     *
     * @throws Exception
     *
     * @return bool
     */
     public function Initialize()
        {
            $oldZone = $this->option['ZC_TIME_ZONE_NAME'];
            date_default_timezone_set($oldZone);
            
            $oldLang = $this->option['ZC_BLOG_LANGUAGEPACK'];
            $this->LoadLanguage('system', '');
        if ($this->option['ZC_CLOSE_WHOLE_SITE'] == true) {
            Http503();
            $this->ShowError(82, __FILE__, __LINE__);

            return false;
        }

        if (!$this->OpenConnect()) {
            return false;
        }

        $this->ConvertTableAndDatainfo();

        $this->LoadConfigsOnlySystem(true);
        $this->LoadOption();

        $this->RegPostType(0, 'article', $this->option['ZC_ARTICLE_REGEX'], $this->option['ZC_POST_DEFAULT_TEMPLATE'], 0, 0);
        $this->RegPostType(1, 'page', $this->option['ZC_PAGE_REGEX'], $this->option['ZC_POST_DEFAULT_TEMPLATE'], null, null);

        if ($this->option['ZC_BLOG_LANGUAGEPACK'] === 'SimpChinese') {
            $this->option['ZC_BLOG_LANGUAGEPACK'] = 'zh-cn';
        }

        if ($this->option['ZC_BLOG_LANGUAGEPACK'] === 'TradChinese') {
            $this->option['ZC_BLOG_LANGUAGEPACK'] = 'zh-tw';
        }

        if ($oldLang != $this->option['ZC_BLOG_LANGUAGEPACK']) {
            $this->LoadLanguage('system', '');
        }



        if ($this->option['ZC_PERMANENT_DOMAIN_ENABLE'] == true) {
            $this->host = $this->option['ZC_BLOG_HOST'];
            $this->cookiespath = strstr(str_replace('://', '', $this->host), '/');
        } else {
            $this->option['ZC_BLOG_HOST'] = $this->host;
        }

        $this->option['ZC_BLOG_PRODUCT'] = 'Z-BlogPHP';
        $this->option['ZC_BLOG_VERSION'] = ZC_BLOG_VERSION;
        $this->option['ZC_NOW_VERSION'] = $this->version;  //ZC_LAST_VERSION
        $this->option['ZC_BLOG_PRODUCT_FULL'] = $this->option['ZC_BLOG_PRODUCT'] . ' ' . ZC_VERSION_DISPLAY;
        $this->option['ZC_BLOG_PRODUCT_FULLHTML'] = '<a href="http://www.zblogcn.com/" title="RainbowSoft Z-BlogPHP" target="_blank">' . $this->option['ZC_BLOG_PRODUCT_FULL'] . '</a>';
        $this->option['ZC_BLOG_PRODUCT_HTML'] = '<a href="http://www.zblogcn.com/" title="RainbowSoft Z-BlogPHP" target="_blank">' . $this->option['ZC_BLOG_PRODUCT'] . '</a>';

        if ($oldZone != $this->option['ZC_TIME_ZONE_NAME']) {
            date_default_timezone_set($this->option['ZC_TIME_ZONE_NAME']);
        }

        /*if(isset($_COOKIE['timezone'])){
            $tz=GetVars('timezone','COOKIE');
            if(is_numeric($tz)){
            $tz=sprintf('%+d',-$tz);
            date_default_timezone_set('Etc/GMT' . $tz);
            $this->timezone=date_default_timezone_get();
            }
        */

        if ($this->option['ZC_VERSION_IN_HEADER'] && !headers_sent()) {
            header('Product:' . $this->option['ZC_BLOG_PRODUCT_FULL']);
        }

        $parsedHost = parse_url($this->host);
        $this->fullcurrenturl = $parsedHost['scheme'] . '://' . $parsedHost['host'] . $this->currenturl;
        if (substr($this->host, 0, 8) == 'https://') {
            $this->isHttps = true;
        }

        $this->verifyCodeUrl = $this->host . 'zb_system/script/c_validcode.php';
        $this->validcodeurl = &$this->verifyCodeUrl;
        $this->feedurl = $this->host . 'feed.php';
        $this->searchurl = $this->host . 'search.php';
        $this->ajaxurl = $this->host . 'zb_system/cmd.php?act=ajax&src=';
        $this->xmlrpcurl = $this->host . 'zb_system/xml-rpc/index.php';

        $this->LoadConfigsOnlySystem(false);

        $this->LoadCache();

        $this->isinitialized = true;

        return true;
    }

    /**
     * 浠庢暟鎹簱閲岃鍙栦俊鎭紝鍚姩鏁翠釜ZBP.
     *
     * @throws Exception
     *
     * @return bool
     */
    public function Load()
    {
        foreach ($GLOBALS['hooks']['Filter_Plugin_Zbp_Load_Pre'] as $fpname => &$fpsignal) {
            $fpreturn = $fpname();
            if ($fpsignal == PLUGIN_EXITSIGNAL_RETURN) {
                $fpsignal = PLUGIN_EXITSIGNAL_NONE;

                return $fpreturn;
            }
        }

        if (!$this->isinitialized) {
            return false;
        }

        if ($this->isload) {
            return false;
        }

        $this->StartGzip();

        if (!headers_sent()) {
            header('Content-type: text/html; charset=utf-8');
        }

        $this->ConvertTableAndDatainfo();

        $this->LoadMembers($this->option['ZC_LOADMEMBERS_LEVEL']);
        $this->LoadCategories();
        //$this->LoadTags();

        if (!(get_class($this->user) === 'Member' && $this->user->Level > 0 && !empty($this->user->ID))) {
            $this->Verify();
        }

        $this->RegBuildModule('catalog', 'ModuleBuilder::Catalog');
        $this->RegBuildModule('calendar', 'ModuleBuilder::Calendar');
        $this->RegBuildModule('comments', 'ModuleBuilder::Comments');
        $this->RegBuildModule('previous', 'ModuleBuilder::LatestArticles');
        $this->RegBuildModule('archives', 'ModuleBuilder::Archives');
        $this->RegBuildModule('navbar', 'ModuleBuilder::Navbar');
        $this->RegBuildModule('tags', 'ModuleBuilder::TagList');
        $this->RegBuildModule('statistics', 'ModuleBuilder::Statistics');
        $this->RegBuildModule('authors', 'ModuleBuilder::Authors');

        //鍒涘缓妯℃澘绫�
        $this->template = $this->PrepareTemplate();

        // 璇讳富棰樼増鏈俊鎭�
        $app = $this->LoadApp('theme', $this->theme);
        if ($app->type !== '') {
            $this->themeinfo = $app->GetInfoArray();
        }

        if ($this->ismanage) {
            $this->LoadManage();
        }

        Add_Filter_Plugin('Filter_Plugin_Login_Header', 'Include_AddonAdminFont');
        Add_Filter_Plugin('Filter_Plugin_Other_Header', 'Include_AddonAdminFont');
        Add_Filter_Plugin('Filter_Plugin_Admin_Header', 'Include_AddonAdminFont');

        foreach ($GLOBALS['hooks']['Filter_Plugin_Zbp_Load'] as $fpname => &$fpsignal) {
            $fpname();
        }

        if ($this->option['ZC_DEBUG_MODE']) {
            $this->CheckTemplate(false, true);
        }

        $this->isload = true;

        return true;
    }

    /**
     * 杞藉叆绠＄悊.
     *
     * @throws Exception
     */
    public function LoadManage()
    {
        if ($this->option['ZC_PERMANENT_DOMAIN_WITH_ADMIN'] == false) {
            $this->host = GetCurrentHost($this->path, $this->cookiespath);
        }

        if (substr($this->host, 0, 8) == 'https://') {
            $this->isHttps = true;
        }

        if ($this->user->Status == ZC_MEMBER_STATUS_AUDITING) {
            $this->ShowError(79, __FILE__, __LINE__);
        }

        if ($this->user->Status == ZC_MEMBER_STATUS_LOCKED) {
            $this->ShowError(80, __FILE__, __LINE__);
        }

        Add_Filter_Plugin('Filter_Plugin_Admin_PageMng_SubMenu', 'Include_Admin_Addpagesubmenu');
        Add_Filter_Plugin('Filter_Plugin_Admin_TagMng_SubMenu', 'Include_Admin_Addtagsubmenu');
        Add_Filter_Plugin('Filter_Plugin_Admin_CategoryMng_SubMenu', 'Include_Admin_Addcatesubmenu');
        Add_Filter_Plugin('Filter_Plugin_Admin_MemberMng_SubMenu', 'Include_Admin_Addmemsubmenu');
        Add_Filter_Plugin('Filter_Plugin_Admin_ModuleMng_SubMenu', 'Include_Admin_Addmodsubmenu');
        Add_Filter_Plugin('Filter_Plugin_Admin_CommentMng_SubMenu', 'Include_Admin_Addcmtsubmenu');

        $this->CheckTemplate(true);

        foreach ($GLOBALS['hooks']['Filter_Plugin_Zbp_LoadManage'] as $fpname => &$fpsignal) {
            $fpname();
        }
    }

    /**
     * 缁堟杩炴帴锛岄噴鏀捐祫婧�.
     */
    public function Terminate()
    {
        if ($this->isinitialized) {
            foreach ($GLOBALS['hooks']['Filter_Plugin_Zbp_Terminate'] as $fpname => &$fpsignal) {
                $fpname();
            }

            $this->CloseConnect();
            unset($this->db);
            $this->isinitialized = false;
        }
    }

    /**
     * 杩炴帴鏁版嵁搴�.
     *
     * @throws Exception
     *
     * @return bool
     */
    public function OpenConnect()
    {
        if ($this->isconnected) {
            return false;
        }

        if (!$this->option['ZC_DATABASE_TYPE']) {
            return false;
        }

        switch ($this->option['ZC_DATABASE_TYPE']) {
            case 'sqlite':
            case 'sqlite3':
            case 'pdo_sqlite':
                $this->db = self::InitializeDB($this->option['ZC_DATABASE_TYPE']);
                if ($this->db->Open(array(
                $this->usersdir . 'data/' . $this->option['ZC_SQLITE_NAME'],
                $this->option['ZC_SQLITE_PRE'],
                )) == false) {
                    $this->ShowError(69, __FILE__, __LINE__);
                }
                break;
            case 'pgsql':
            case 'pdo_pgsql':
                $this->db = self::InitializeDB($this->option['ZC_DATABASE_TYPE']);
                if ($this->db->Open(array(
                $this->option['ZC_PGSQL_SERVER'],
                $this->option['ZC_PGSQL_USERNAME'],
                $this->option['ZC_PGSQL_PASSWORD'],
                $this->option['ZC_PGSQL_NAME'],
                $this->option['ZC_PGSQL_PRE'],
                $this->option['ZC_PGSQL_PORT'],
                $this->option['ZC_PGSQL_PERSISTENT'],
                )) == false) {
                    $this->ShowError(67, __FILE__, __LINE__);
                }
                break;
            case 'mysql':
            case 'mysqli':
            case 'pdo_mysql':
            default:
                $this->db = self::InitializeDB($this->option['ZC_DATABASE_TYPE']);
                if ($this->db->Open(array(
                $this->option['ZC_MYSQL_SERVER'],
                $this->option['ZC_MYSQL_USERNAME'],
                $this->option['ZC_MYSQL_PASSWORD'],
                $this->option['ZC_MYSQL_NAME'],
                $this->option['ZC_MYSQL_PRE'],
                $this->option['ZC_MYSQL_PORT'],
                $this->option['ZC_MYSQL_PERSISTENT'],
                $this->option['ZC_MYSQL_ENGINE'],
                )) == false) {
                    $this->ShowError(67, __FILE__, __LINE__);
                }
                break;
        }
        // utf8mb4鏀寔
        if ($this->db->type == 'mysql' && version_compare($this->db->version, '5.5.3') < 0) {
            Add_Filter_Plugin('Filter_Plugin_DbSql_Filter', 'utf84mb_filter');
            Add_Filter_Plugin('Filter_Plugin_Edit_Begin', 'utf84mb_fixHtmlSpecialChars');
        }
        $this->isconnected = true;

        return true;
    }

    /**
     * 瀵硅〃鍚嶅拰鏁版嵁缁撴瀯杩涜棰勮浆鎹�.
     */
    public function ConvertTableAndDatainfo()
    {
        if ($this->db->dbpre) {
            $this->table = str_replace('%pre%', $this->db->dbpre, $this->table);
        }
        if ($this->db->type === 'postgresql') {
            foreach ($this->datainfo as $key => &$value) {
                foreach ($value as $k2 => &$v2) {
                    $v2[0] = strtolower($v2[0]);
                }
            }
        }
    }

    /**
     * 鍏抽棴鏁版嵁搴撹繛鎺�.
     */
    public function CloseConnect()
    {
        if ($this->isconnected) {
            $this->db->Close();
            $this->isconnected = false;
        }
    }

    /**
     * 鍚敤session.
     *
     * @return bool
     */
    public function StartSession()
    {
        if (session_status() == 1) {
            session_start();
            $this->issession = true;

            return true;
        }

        return false;
    }

    /**
     * 缁堟session.
     *
     * @return bool
     */
    public function EndSession()
    {
        if (session_status() == 2) {
            session_write_close();
            $this->issession = false;

            return true;
        }

        return false;
    }

    /**
     * 杞藉叆鎻掍欢Configs琛�.
     */
    public function LoadConfigs()
    {
        $this->configs = array();
        $sql = $this->db->sql->Select($this->table['Config'], array('*'), '', '', '', '');

        /** @var Config[] $array */
        $array = $this->GetListType('Config', $sql);
        foreach ($array as $c) {
            $n = $c->GetItemName();
            $this->configs[$n] = $c;
        }
    }

    /**
     * 杞藉叆鎻掍欢Configs琛� Only System Option.
     */
    private $prvConfigList = array();

    public function LoadConfigsOnlySystem($onlysystemoption = true)
    {
        if ($onlysystemoption == true) {
            $this->configs = array();
            $this->prvConfigList = array();
        }

        $sql = $this->db->sql->Select($this->table['Config'], array('*'), '', '', '', '');

        if ($onlysystemoption == true) {
            /* @var Config[] $array */
            $this->prvConfigList = $this->GetListType('Config', $sql);
            foreach ($this->prvConfigList as $c) {
                $n = $c->GetItemName();
                if ($n == 'system') {
                    $this->configs[$n] = $c;
                }
            }
        } else {
            foreach ($this->prvConfigList as $c) {
                $n = $c->GetItemName();
                if ($n != 'system') {
                    $this->configs[$n] = $c;
                }
            }
            $this->prvConfigList = array();
        }
    }

    /**
     * 淇濆瓨Configs琛�.
     *
     * @param string $name Configs琛ㄥ悕
     *
     * @return bool
     */
    public function SaveConfig($name)
    {
        if (!isset($this->configs[$name])) {
            return false;
        }

        $this->configs[$name]->Save();

        return true;
    }

    /**
     * 鍒犻櫎Configs琛�.
     *
     * @param string $name Configs琛ㄥ悕
     *
     * @return bool
     */
    public function DelConfig($name)
    {
        if (!isset($this->configs[$name])) {
            return false;
        }

        $this->configs[$name]->Delete();
        unset($this->configs[$name]);

        return true;
    }

    /**
     * 鑾峰彇Configs琛ㄥ��
     *
     * @param string $name Configs琛ㄥ悕
     *
     * @return mixed
     */
    public function Config($name)
    {
        if (!isset($this->configs[$name])) {
            $name = FilterCorrectName($name);
            if (!$name) {
                return;
            }

            $this->configs[$name] = new Config($name);
        }

        return $this->configs[$name];
    }

    /**
     * 鏌ユ煇Config鏄惁瀛樺湪.
     *
     * @param string $name Configs琛ㄥ悕
     *
     * @return bool
     */
    public function HasConfig($name)
    {
        return isset($this->configs[$name]) && $this->configs[$name]->CountItem() > 0;
    }

    //###############################################################################################################
    //Cache鐩稿叧
    private $cache_hash = null;

    /**
     * 淇濆瓨缂撳瓨.
     *
     * @return bool
     */
    public function SaveCache()
    {
        //$s=$this->usersdir . 'cache/' . $this->guid . '.cache';
        //$c=serialize($this->cache);
        //@file_put_contents($s, $c);
        //$this->configs['cache']=$this->cache;
        $new_hash = md5($this->Config('cache'));
        if ($this->cache_hash == $new_hash) {
            return true;
        }

        $this->SaveConfig('cache');
        $this->cache_hash = $new_hash;

        return true;
    }

    /**
     * 鍔犺浇缂撳瓨.
     *
     * @return bool
     */
    public function LoadCache()
    {
        $this->cache = $this->Config('cache');
        $this->cache_hash = md5($this->Config('cache'));

        return true;
    }

    /**
     * 淇濆瓨閰嶇疆.
     *
     * @return bool
     */
    public function SaveOption()
    {
        $this->option['ZC_BLOG_CLSID'] = $this->guid;

        if (ZC_VERSION_MAJOR === '1' && ZC_VERSION_MINOR === '5') {
            if (is_dir($this->path . 'zb_system/api')) {
                @rrmdir($this->path . 'zb_system/api'); // Fix bug!!!
            }
        }

        if (strpos('|SAE|BAE2|ACE|TXY|', '|' . $this->option['ZC_YUN_SITE'] . '|') === false && file_exists($this->usersdir . 'c_option.php') == false) {
            $s = "<" . "?" . "php\r\n";
            $s .= "return ";
            $option = array();
            foreach ($this->option as $key => $value) {
                if (($key == 'ZC_YUN_SITE') ||
                    ($key == 'ZC_DATABASE_TYPE') ||
                    ($key == 'ZC_SQLITE_NAME') ||
                    ($key == 'ZC_SQLITE_PRE') ||
                    ($key == 'ZC_MYSQL_SERVER') ||
                    ($key == 'ZC_MYSQL_USERNAME') ||
                    ($key == 'ZC_MYSQL_PASSWORD') ||
                    ($key == 'ZC_MYSQL_NAME') ||
                    ($key == 'ZC_MYSQL_CHARSET') ||
                    ($key == 'ZC_MYSQL_PRE') ||
                    ($key == 'ZC_MYSQL_ENGINE') ||
                    ($key == 'ZC_MYSQL_PORT') ||
                    ($key == 'ZC_MYSQL_PERSISTENT') ||
                    ($key == 'ZC_PGSQL_SERVER') ||
                    ($key == 'ZC_PGSQL_USERNAME') ||
                    ($key == 'ZC_PGSQL_PASSWORD') ||
                    ($key == 'ZC_PGSQL_NAME') ||
                    ($key == 'ZC_PGSQL_CHARSET') ||
                    ($key == 'ZC_PGSQL_PRE') ||
                    ($key == 'ZC_PGSQL_PORT') ||
                    ($key == 'ZC_PGSQL_PERSISTENT') ||
                    ($key == 'ZC_CLOSE_WHOLE_SITE')
                ) {
                    $option[$key] = $value;
                }
            }
            $s .= var_export($option, true);
            $s .= ";";
            @file_put_contents($this->usersdir . 'c_option.php', $s);
        }

        foreach ($this->option as $key => $value) {
            $this->Config('system')->$key = $value;
        }

        $this->Config('system')->ZC_BLOG_HOST = chunk_split($this->Config('system')->ZC_BLOG_HOST, 1, "|");

        $this->SaveConfig('system');

        return true;
    }

    /**
     * 杞藉叆閰嶇疆.
     *
     * @return bool
     */
    public function LoadOption()
    {
        $array = $this->Config('system')->GetData();

        if (empty($array)) {
            return false;
        }

        if (!is_array($array)) {
            return false;
        }

        foreach ($array as $key => $value) {
            //if($key=='ZC_PERMANENT_DOMAIN_ENABLE')continue;
            //if($key=='ZC_BLOG_HOST')continue;
            //if($key=='ZC_BLOG_CLSID')continue;
            //if($key=='ZC_BLOG_LANGUAGEPACK')continue;
            if ($key == 'ZC_BLOG_HOST') {
                $value = str_replace('|', '', $value);
            }

            if (($key == 'ZC_YUN_SITE') ||
                ($key == 'ZC_DATABASE_TYPE') ||
                ($key == 'ZC_SQLITE_NAME') ||
                ($key == 'ZC_SQLITE_PRE') ||
                ($key == 'ZC_MYSQL_SERVER') ||
                ($key == 'ZC_MYSQL_USERNAME') ||
                ($key == 'ZC_MYSQL_PASSWORD') ||
                ($key == 'ZC_MYSQL_NAME') ||
                ($key == 'ZC_MYSQL_CHARSET') ||
                ($key == 'ZC_MYSQL_PRE') ||
                ($key == 'ZC_MYSQL_ENGINE') ||
                ($key == 'ZC_MYSQL_PORT') ||
                ($key == 'ZC_MYSQL_PERSISTENT') ||
                ($key == 'ZC_PGSQL_SERVER') ||
                ($key == 'ZC_PGSQL_USERNAME') ||
                ($key == 'ZC_PGSQL_PASSWORD') ||
                ($key == 'ZC_PGSQL_NAME') ||
                ($key == 'ZC_PGSQL_CHARSET') ||
                ($key == 'ZC_PGSQL_PRE') ||
                ($key == 'ZC_PGSQL_PORT') ||
                ($key == 'ZC_PGSQL_PERSISTENT') ||
                ($key == 'ZC_CLOSE_WHOLE_SITE')
            ) {
                continue;
            }

            $this->option[$key] = $value;
        }
        if (!extension_loaded('gd')) {
            $this->option['ZC_COMMENT_VERIFY_ENABLE'] = false;
        }

        return true;
    }

    /**
     * 楠岃瘉鎿嶄綔鏉冮檺.
     *
     * @param string     $action 鎿嶄綔
     * @param int|string $level
     *
     * @return bool
     */
    public function CheckRights($action, $level = null)
    {
        if ($level === null) {
            $level = $this->user->Level;
        }

        foreach ($GLOBALS['hooks']['Filter_Plugin_Zbp_CheckRights'] as $fpname => &$fpsignal) {
            $fpreturn = $fpname($action, $level);
            if ($fpsignal == PLUGIN_EXITSIGNAL_RETURN) {
                $fpsignal = PLUGIN_EXITSIGNAL_NONE;

                return $fpreturn;
            }
        }
        if (!isset($this->actions[$action])) {
            if (is_numeric($action)) {
                return $level <= $action;
            } else {
                return false;
            }
        }

        return $level <= $this->actions[$action];
    }

    /**
     * 鏍规嵁鐢ㄦ埛绛夌骇楠岃瘉鎿嶄綔鏉冮檺 1.5寮�濮嬪弬鏁版崲椤哄簭.
     *
     * @param string $action 鎿嶄綔
     * @param int    $level  鐢ㄦ埛绛夌骇
     *
     * @return bool
     */
    public function CheckRightsByLevel($action, $level)
    {
        return $this->CheckRights($action, $level);
    }

    /**
     * 楠岃瘉鐢ㄦ埛鐧诲綍.
     *
     * @return bool
     */
    public function Verify()
    {
        $username = trim(GetVars('username', 'COOKIE'));
        $token = trim(GetVars('token', 'COOKIE'));
        $user = $this->VerifyUserToken($token, $username);
        if (!is_null($user)) {
            $this->user = $user;

            return true;
        }
        $this->user = new Member();
        $this->user->Guid = GetGuid();

        return false;
    }

    /**
     * 杩斿洖鐧诲綍鎴愬姛鍚庡簲淇濆瓨鐨刢ookie淇℃伅.
     *
     * @param Member $m 宸查獙杩囨垚鍔熺殑member
     *
     * @return string
     */
    public function VerifyResult($m)
    {
        return $this->GenerateUserToken($m);
    }

    /**
     * 鐢熸垚User Token锛岀敤浜庣櫥褰曢獙璇�
     *
     * @param Member $user
     * @param int    $time
     *
     * @return string
     */
    public function GenerateUserToken($user, $time = 0)
    {
        if ($time === 0) {
            $time = time() + 3600 * 24;
        }

        return CreateWebToken($user->ID, $time, $user->Guid, $user->PassWord_MD5Path);
    }

    /**
     * 楠岃瘉鐢ㄦ埛鐧诲綍Token.
     *
     * @param string $token
     * @param string $username
     *
     * @return Member
     */
    public function VerifyUserToken($token, $username)
    {
        $user = $this->GetMemberByName($username);
        if ($user->ID > 0) {
            if (VerifyWebToken($token, $user->ID, $user->Guid, $user->PassWord_MD5Path)) {
                return $user;
            }
        }
    }

    /**
     * 楠岃瘉鐢ㄦ埛鐧诲綍锛堜竴娆D5瀵嗙爜锛�.
     *
     * @param string $name   鐢ㄦ埛鍚�
     * @param string $md5pw  md5鍔犲瘑鍚庣殑瀵嗙爜
     * @param Member $member 杩斿洖璇诲彇鎴愬姛鐨刴ember瀵硅薄
     *
     * @return bool
     */
    public function Verify_MD5($name, $md5pw, &$member)
    {
        if ($name == '' || $md5pw == '') {
            return false;
        }
        $member = $this->GetMemberByName($name);
        if ($member->ID > 0) {
            return $this->Verify_Final($name, md5($md5pw . $member->Guid), $member);
        }

        return false;
    }

    /**
     * 楠岃瘉鐢ㄦ埛鐧诲綍锛堝師濮嬫槑鏂囧瘑鐮侊級.
     *
     * @param string $name       鐢ㄦ埛鍚�
     * @param string $originalpw 瀵嗙爜鏄庢枃
     * @param Member $member     杩斿洖璇诲彇鎴愬姛鐨刴ember瀵硅薄
     *
     * @return bool
     */
    public function Verify_Original($name, $originalpw, &$member = null)
    {
        if ($name == '' || $originalpw == '') {
            return false;
        }
        $m = $this->GetMemberByName($name);
        if ($m->ID > 0) {
            return $this->Verify_MD5($name, md5($originalpw), $member);
        }

        return false;
    }

    /**
     * 楠岃瘉鐢ㄦ埛鐧诲綍锛堟暟鎹簱淇濆瓨鐨勬渶缁堣繍绠楀悗瀵嗙爜锛�.
     *
     * @param string $name     鐢ㄦ埛鍚�
     * @param string $password 浜屾鍔犲瘑鍚庣殑瀵嗙爜
     * @param object $member   杩斿洖璇诲彇鎴愬姛鐨刴ember瀵硅薄
     *
     * @return bool
     */
    public function Verify_Final($name, $password, &$member = null)
    {
        if ($name == '' || $password == '') {
            return false;
        }
        $m = $this->GetMemberByName($name);
        if ($m->ID > 0) {
            if (strcasecmp($m->Password, $password) == 0) {
                $member = $m;

                return true;
            }
        }

        return false;
    }

    /**
     * 楠岃瘉鐢ㄦ埛鐧诲綍锛堜娇鐢═oken锛屾浛浠ｅ瘑鐮佷繚瀛橈級.
     *
     * @param string $name   鐢ㄦ埛鍚�
     * @param string $wt     WebToken
     * @param string $wt_id  WebToken鐨処D璇嗗埆绗�
     * @param object $member 杩斿洖璇诲彇鎴愬姛鐨刴ember瀵硅薄
     *
     * @return bool
     */
    public function Verify_Token($name, $wt, $wt_id, &$member = null)
    {
        if ($name == '' || $wt == '') {
            return false;
        }
        $m = null;
        $m = $this->GetMemberByName($name);
        if ($m->ID > 0) {
            if (VerifyWebToken($wt, $wt_id, $this->guid, $m->ID, $m->Password) === true) {
                $member = $m;

                return true;
            }
        }

        return false;
    }

    /**
     * 杞藉叆鐢ㄦ埛鍒楄〃.
     *
     * @param int $level 鐢ㄦ埛绛夌骇
     *
     * @return bool
     */
    public function LoadMembers($level = 0)
    {
        if ($level < 0) {
            return false;
        }

        $where = null;
        if ($level > 0) {
            $where = array(array('<=', 'mem_Level', $level));
        }
        $this->members = array();
        $this->membersbyname = array();
        $array = $this->GetMemberList(null, $where);
        foreach ($array as $m) {
            $this->members[$m->ID] = $m;
            $this->membersbyname[$m->Name] = &$this->members[$m->ID];
        }

        return true;
    }

    /**
     * 杞藉叆鍒嗙被鍒楄〃.
     *
     * @return bool
     */
    public function LoadCategories()
    {
        $this->categories = array();
        $this->categoriesbyorder = array();
        $lv0 = array();
        $lv1 = array();
        $lv2 = array();
        $lv3 = array();
        $array = $this->GetCategoryList(null, null, array('cate_Order' => 'ASC'), null, null);
        if (count($array) == 0) {
            return false;
        }

        foreach ($array as $c) {
            $this->categories[$c->ID] = $c;
        }

        foreach ($this->categories as $id => $c) {
            $l = 'lv' . $c->Level;
            ${$l}[$c->ParentID][] = $id;
        }

        if (!is_array($lv0[0])) {
            $lv0[0] = array();
        }

        /*
         * 浠ヤ笅鍨冨溇浠ｇ爜锛屽繀椤婚噸鏋勶紒
         */
        foreach ($lv0[0] as $id0) {
            $this->categoriesbyorder[$id0] = &$this->categories[$id0];
            if (!isset($lv1[$id0])) {
                continue;
            }
            foreach ($lv1[$id0] as $id1) {
                if ($this->categories[$id1]->ParentID == $id0) {
                    $this->categories[$id1]->RootID = $id0;
                    $this->categories[$id0]->SubCategories[] = $this->categories[$id1];
                    $this->categories[$id0]->ChildrenCategories[] = $this->categories[$id1];
                    $this->categoriesbyorder[$id1] = &$this->categories[$id1];
                    if (!isset($lv2[$id1])) {
                        continue;
                    }
                    foreach ($lv2[$id1] as $id2) {
                        if ($this->categories[$id2]->ParentID == $id1) {
                            $this->categories[$id2]->RootID = $id0;
                            $this->categories[$id0]->ChildrenCategories[] = $this->categories[$id2];
                            $this->categories[$id1]->SubCategories[] = $this->categories[$id2];
                            $this->categories[$id1]->ChildrenCategories[] = $this->categories[$id2];
                            $this->categoriesbyorder[$id2] = &$this->categories[$id2];
                            if (!isset($lv3[$id2])) {
                                continue;
                            }
                            foreach ($lv3[$id2] as $id3) {
                                if ($this->categories[$id3]->ParentID == $id2) {
                                    $this->categories[$id3]->RootID = $id0;
                                    $this->categories[$id0]->ChildrenCategories[] = $this->categories[$id3];
                                    $this->categories[$id1]->ChildrenCategories[] = $this->categories[$id3];
                                    $this->categories[$id2]->SubCategories[] = $this->categories[$id3];
                                    $this->categories[$id2]->ChildrenCategories[] = $this->categories[$id3];
                                    $this->categoriesbyorder[$id3] = &$this->categories[$id3];
                                }
                            }
                        }
                    }
                }
            }
        }

        return true;
    }

    /**
     * 杞藉叆鏍囩鍒楄〃.
     *
     * @return bool
     */
    public function LoadTags()
    {
        $this->tags = array();
        $this->tagsbyname = array();
        $array = $this->GetTagList();
        foreach ($array as $t) {
            $this->tags[$t->ID] = $t;
            $this->tagsbyname[$t->Name] = &$this->tags[$t->ID];
        }

        return true;
    }

 

    /**
     * 杞藉叆涓婚鍒楄〃.
     *
     * @return App[]
     */
    public function LoadThemes()
    {
        $allThemes = array();
        $dirs = GetDirsInDir($this->usersdir . 'theme/');
        natcasesort($dirs);
        array_unshift($dirs, $this->theme);
        $dirs = array_unique($dirs);
        foreach ($dirs as $id) {
            $app = new App();
            if ($app->LoadInfoByXml('theme', $id) == true) {
                $allThemes[] = $app;
            }
        }

        return $allThemes;
    }

    /**
     * 杞藉叆鎻掍欢鍒楄〃.
     *
     * @return App[]
     */
    public function LoadPlugins()
    {
        $allPlugins = array();
        $dirs = GetDirsInDir($this->usersdir . 'plugin/');
        natcasesort($dirs);

        foreach ($dirs as $id) {
            $app = new App();
            if ($app->LoadInfoByXml('plugin', $id) == true) {
                $allPlugins[] = $app;
            }
        }

        return $allPlugins;
    }

    /**
     * 杞藉叆鎸囧畾搴旂敤.
     *
     * @param string $type 搴旂敤绫诲瀷(theme|plugin)
     * @param string $id   搴旂敤ID
     *
     * @return App
     */
    public function LoadApp($type, $id)
    {
        $app = new App();
        $app->LoadInfoByXml($type, $id);

        return $app;
    }

    /**
     * 妫�鏌ュ簲鐢ㄦ槸鍚﹀畨瑁呭苟鍚敤.
     *
     * @param string $name 搴旂敤锛堟彃浠舵垨涓婚锛夌殑ID
     *
     * @return bool
     */
    public function CheckPlugin($name)
    {
        return in_array($name, $this->activedapps);
    }

    /**
     * 妫�鏌ュ簲鐢ㄦ槸鍚﹀畨瑁呭苟鍚敤.
     *
     * @param string $name 搴旂敤ID锛堟彃浠舵垨涓婚锛�
     *
     * @return bool
     */
    public function CheckApp($name)
    {
        return $this->CheckPlugin($name);
    }

    /**
     * 鑾峰彇棰勬縺娲绘彃浠跺悕鏁扮粍.
     *
     * @return string[]
     */
    public function GetPreActivePlugin()
    {
        $ap = explode("|", $this->option['ZC_USING_PLUGIN_LIST']);
        $ap = array_unique($ap);

        return $ap;
    }

    /**
     * 杞藉叆鎸囧畾搴旂敤璇█鍖�.
     *
     * @param string $type    搴旂敤绫诲瀷(system|theme|plugin)
     * @param string $id      搴旂敤ID
     * @param string $default 榛樿璇█
     *
     * @throws Exception
     *
     * @return null
     */
    public function LoadLanguage($type, $id, $default = '')
    {
        $languagePath = $this->path;
        $languageRegEx = '/^([0-9A-Z\-_]*)\.php$/ui';
        $languageList = array();
        $language = '';
        $default = str_replace(array('/', '\\'), '', $default);
        $languagePtr = &$this->lang;

        if ($default === '') {
            $default = $this->option['ZC_BLOG_LANGUAGEPACK'];
        }

        $defaultLanguageList = array($default, 'zh-cn', 'zh-tw', 'en');

        switch ($type) {
            case 'system':
                $languagePath .= 'zb_users/language/';
                break;
            case 'plugin':
            case 'theme':
                $languagePath .= 'zb_users/' . $type . '/' . $id . '/language/';
                $languagePtr = &$this->lang[$id];
                break;
            default:
                $languagePath .= $type . '/language/';
                $languagePtr = &$this->lang[$id];
                break;
        }

        $handle = @opendir($languagePath);
        $match = null;
        if ($handle) {
            while (false !== ($file = readdir($handle))) {
                if (preg_match($languageRegEx, $file, $match)) {
                    $languageList[] = $match[1];
                }
            }
            closedir($handle);
        } else {
            // 杩欓噷涓嶄細鎵ц鍒帮紝鍦╫pendir鏃跺氨宸茬粡鎶涘嚭E_WARNING
            throw new Exception('Cannot opendir(' . $languagePath . ')');
        }

        if (count($languageList) === 0) {
            throw new Exception('No language in ' . $languagePath);
        }

        for ($i = 0; $i < count($defaultLanguageList); $i++) {
            // 鍦ㄦ晥鐜囦笂锛宎rray_search鍜屽懡鍚嶆暟缁勬病鏈夋湰璐ㄥ尯鍒紝鑷冲皯鍦ㄨ繖閲屽姝ゃ��
            if (false !== array_search($defaultLanguageList[$i], $languageList)) {
                $language = $defaultLanguageList[$i];
                break;
            }
        }
        if ($language === '') {
            throw new Exception('Language ' . $default . ' is not found in ' . $languagePath);
        }

        $languagePath .= $language . '.php';
        $languagePtr = require $languagePath;
        $this->langpacklist[] = array($type, $id, $language);

        return true;
    }

    /**
     * 閲嶆柊璇诲彇璇█鍖�.
     *
     * @throws Exception
     */
    public function ReloadLanguages()
    {
        $array = $this->langpacklist;
        $this->lang = $this->langpacklist = array();
        foreach ($array as $v) {
            $this->LoadLanguage($v[0], $v[1], $v[2]);
        }
    }

    /**
     * 妯℃澘瑙ｆ瀽.
     *
     * @return bool
     */
    public function BuildTemplate()
    {
        $this->template->LoadTemplates();

        foreach ($GLOBALS['hooks']['Filter_Plugin_Zbp_BuildTemplate'] as $fpname => &$fpsignal) {
            $fpname($this->template->templates);
        }

        return $this->template->BuildTemplate();
    }





    /**
     * 鏌ヨ鎸囧畾鏁版嵁缁撴瀯鐨剆ql骞惰繑鍥濨ase瀵硅薄鍒楄〃.
     *
     * @param string|array $table    鏁版嵁琛�
     * @param array        $datainfo 鏁版嵁瀛楁
     * @param string       $sql      SQL鎿嶄綔璇彞
     *
     * @return array
     */
    public function GetListCustom($table, $datainfo, $sql)
    {
        $array = null;
        $list = array();
        $array = $this->db->Query($sql);
        if (!isset($array)) {
            return array();
        }
        foreach ($array as $a) {
            $l = new Base($table, $datainfo);
            $l->LoadInfoByAssoc($a);
            $list[] = $l;
        }

        return $list;
    }

    /**
     * 鏌ヨID鏁版嵁鐨勬寚瀹氭暟鎹粨鏋勭殑sql骞惰繑鍥濨ase瀵硅薄鍒楄〃.
     *
     * @param string|array $table    鏁版嵁琛�
     * @param array        $datainfo 鏁版嵁瀛楁
     * @param array        $array    ID鏁扮粍
     *
     * @return Base[]
     */
    public function GetListCustomByArray($table, $datainfo, $array)
    {
        if (!is_array($array)) {
            return array();
        }

        if (count($array) == 0) {
            return array();
        }

        $where = array();
        $where[] = array('IN', $datainfo['ID'][0], implode(',', $array));
        $sql = $this->db->sql->Select($table, '*', $where);
        $array = null;
        $list = array();
        $array = $this->db->Query($sql);
        if (!isset($array)) {
            return array();
        }
        foreach ($array as $a) {
            $l = new Base($table, $datainfo);
            $l->LoadInfoByAssoc($a);
            $list[] = $l;
        }

        return $list;
    }

    /**
     * 宸叉敼鍚岹etListType,1.5鐗堜腑鎵旀帀鏈夋涔夌殑GetList.
     *
     * @param $type
     * @param $sql
     *
     * @return Base[]
     */
    public function GetListType($type, $sql)
    {
        $array = null;
        $list = array();
        $array = $this->db->Query($sql);
        if (!isset($array)) {
            return array();
        }
        foreach ($array as $a) {
            /** @var Base $l */
            $l = new $type();
            $l->LoadInfoByAssoc($a);
            $list[] = $l;
        }

        return $list;
    }

    /**
     * 鏌ヨID鏁版嵁鐨勬寚瀹氱被鍨嬬殑sql骞惰繑鍥炴寚瀹氱被鍨嬪璞″垪琛�.
     *
     * @param string $type  绫诲瀷
     * @param mixed  $array ID鏁扮粍
     *
     * @return Base[]
     */
    public function GetListTypeByArray($type, $array)
    {
        if (!is_array($array)) {
            return array();
        }

        if (count($array) == 0) {
            return array();
        }

        $where = array();
        $where[] = array('IN', $this->datainfo[$type]['ID'][0], implode(',', $array));
        $sql = $this->db->sql->Select($this->table[$type], '*', $where);
        $array = null;
        $list = array();
        $array = $this->db->Query($sql);
        if (!isset($array)) {
            return array();
        }
        foreach ($array as $a) {
            /** @var Base $l */
            $l = new $type();
            $l->LoadInfoByAssoc($a);
            $list[] = $l;
        }

        return $list;
    }

    /**
     * @param mixed $select
     * @param mixed $where
     * @param mixed $order
     * @param mixed $limit
     * @param mixed $option
     *
     * @return Post[]
     */
    public function GetPostList($select = null, $where = null, $order = null, $limit = null, $option = null)
    {
        if (empty($select)) {
            $select = array('*');
        }
        if (empty($where)) {
            $where = array();
        }
        $sql = $this->db->sql->Select($this->table['Post'], $select, $where, $order, $limit, $option);

        /** @var Post[] $array */
        $array = $this->GetListType('Post', $sql);
        foreach ($array as $a) {
            $this->posts[$a->ID] = $a;
        }

        return $array;
    }

    /**
     * 閫氳繃ID鏁扮粍鑾峰彇鏂囩珷瀹炰緥.
     *
     * @param mixed[] $array
     *
     * @return Post[]|Base[] Posts
     */
    public function GetPostByArray($array)
    {
        return $this->GetListTypeByArray('Post', $array);
    }

    /**
     * @param mixed $select
     * @param mixed $where
     * @param mixed $order
     * @param mixed $limit
     * @param mixed $option
     * @param mixed $readtags
     *
     * @return Post[]
     */
    public function GetArticleList($select = null, $where = null, $order = null, $limit = null, $option = null, $readtags = true,$sql = null)
    {
        if(empty($sql)){
            if (empty($select)) {
                $select = array('*');
            }
            if (empty($where)) {
                $where = array();
            }
            
            if (is_array($where)) {
                $hasType = false;
                foreach ($where as $key => $value) {
                    if (is_array($value)) {
                        foreach ($value as $key2 => $value2) {
                            if ($key2 == 1 && $value2 == 'log_Type') {
                                $hasType = true;
                            }
                        }
                    }
                }
                if (!$hasType) {
                    array_unshift($where, array('=', 'log_Type', '0'));
                }
            }
            
            $sql = $this->db->sql->Select($this->table['Post'], $select, $where, $order, $limit, $option);
        }
        /** @var Post[] $array */
        $array = $this->GetListType('Post', $sql);

        foreach ($array as $a) {
            $this->posts[$a->ID] = $a;
        }

        if ($readtags) {
            $tagstring = '';
            foreach ($array as $a) {
                $tagstring .= $a->Tag;
            }
            $this->LoadTagsByIDString($tagstring);
        }

        return $array;
    }

    /**
     * @param mixed $select
     * @param mixed $where
     * @param mixed $order
     * @param mixed $limit
     * @param mixed $option
     *
     * @return Post[]
     */
    public function GetPageList($select = null, $where = null, $order = null, $limit = null, $option = null)
    {
        if (empty($select)) {
            $select = array('*');
        }
        if (empty($where)) {
            $where = array();
        }
        if (is_array($where)) {
            array_unshift($where, array('=', 'log_Type', '1'));
        }

        $sql = $this->db->sql->Select($this->table['Post'], $select, $where, $order, $limit, $option);
        /** @var Post[] $array */
        $array = $this->GetListType('Post', $sql);
        foreach ($array as $a) {
            $this->posts[$a->ID] = $a;
        }

        return $array;
    }



    /**
     * @param mixed $select
     * @param mixed $where
     * @param mixed $order
     * @param mixed $limit
     * @param mixed $option
     *
     * @return Member[]|Base[]
     */
    public function GetMemberList($select = null, $where = null, $order = null, $limit = null, $option = null)
    {
        if (empty($select)) {
            $select = array('*');
        }
        $sql = $this->db->sql->Select($this->table['Member'], $select, $where, $order, $limit, $option);

        return $this->GetListType('Member', $sql);
    }

    /**
     * @param mixed $select
     * @param mixed $where
     * @param mixed $order
     * @param mixed $limit
     * @param mixed $option
     *
     * @return Category[]|Base[]
     */
    public function GetCategoryList($select = null, $where = null, $order = null, $limit = null, $option = null)
    {
        if (empty($select)) {
            $select = array('*');
        }
        $sql = $this->db->sql->Select($this->table['Category'], $select, $where, $order, $limit, $option);

        return $this->GetListType('Category', $sql);
    }



    /**
     * @param $sql
     *
     * @return mixed
     */
    public function get_results($sql)
    {
        return $this->db->Query($sql);
    }

    /**
     * 鏍规嵁鍒悕寰楀埌鐩稿簲鏁版嵁.
     *
     * @param Base[]|string &$object   缂撳瓨瀵硅薄
     * @param string        $val
     * @param string        $backAttr
     * @param string        $className
     *
     * @return Base|null
     */
    private function GetSomeThingByAlias($object, $val, $backAttr = null, $className = null)
    {
        $ret = $this->GetSomeThing($object, 'Alias', $val);

        if (!is_null($ret)) {
            return $ret;
        } else {
            if (is_null($backAttr)) {
                $backAttr = $this->option['ZC_ALIAS_BACK_ATTR'];
            }

            return $this->GetSomeThing($object, $backAttr, $val, $className);
        }
    }

    /**
     * 鏍规嵁ID寰楀埌鐩稿簲鏁版嵁.
     *
     * @param Base[]     &$object   缂撳瓨瀵硅薄
     * @param string     $className 鎵句笉鍒癐D鏃跺垵濮嬪寲瀵硅薄鐨勭被鍚�
     * @param int|string $id        涓庢绫荤浉鍏崇殑ID
     *
     * @return Base|null
     */
    private function GetSomeThingById(&$object, $className, $id)
    {
        if ($id == 0) {
            return;
        }
        if ($object != null) {
            //$modules闈濱D涓簁ey

            if (isset($object[$id])) {
                return $object[$id];
            } elseif ($className == "Post" || $className == "Comment" || $className == "Tag") {
                // 鏂囩珷闇�瑕佽鍙栵紝鍏朵粬鐨勭洿鎺ヨ繑鍥炵┖瀵硅薄鍗冲彲
                /** @var Base $p */
                $p = new $className();
                $p->LoadInfoByID($id);
                $object[$id] = $p;

                return $p;
            } else {
                return $this->GetSomeThingByAttr($object, 'ID', $id);
            }
        } else {
            /** @var Base $p */
            $p = new $className();
            $p->LoadInfoByID($id);

            return $p;
        }
    }

    /**
     * 鏍规嵁灞炴�у�煎緱鍒扮浉搴旀暟鎹�.
     *
     * @param Base[] &$object 缂撳瓨瀵硅薄
     * @param string $attr    灞炴�у悕
     * @param mixed  $val     瑕佹煡鎵剧殑鍊�
     *
     * @return null
     */
    private function GetSomeThingByAttr(&$object, $attr, $val)
    {
        $val = trim($val);
        foreach ($object as $key => &$value) {
            if (is_null($value)) {
                continue;
            }
            if ($value->$attr == $val) {
                return $value;
            }
        }
    }

    /**
     * 鑾峰彇鏁版嵁閫氱敤鍑芥暟.
     *
     * @param Base[]|string $object    缂撳瓨瀵硅薄锛坰tring / object锛�
     * @param string        $attr      娆叉煡鎵剧殑灞炴��
     * @param mixed         $val       瑕佹煡鎵惧唴瀹�
     * @param string        $className 瀵硅薄鏈壘鍒版椂锛屽垵濮嬪寲绫诲悕
     *
     * @return Base|null
     */
    public function GetSomeThing($object, $attr, $val, $className = null)
    {
        $cacheObject = null;
        if (is_object($object)) {
            $cacheObject = $object;
        } elseif ($object != "") {
            $cacheObject = &$this->$object;
        }
        if ($attr == "ID") {
            $ret = $this->GetSomeThingById($cacheObject, $className, $val);
        } else {
            $ret = $this->GetSomeThingByAttr($cacheObject, $attr, $val);
        }
        if ($ret === null && !is_null($className)) {
            /** @var Base $ret */
            $ret = new $className();
        }

        return $ret;
    }

    /**
     * 閫氳繃ID鑾峰彇鏂囩珷瀹炰緥.
     *
     * @param int $id
     *
     * @return Post|Base
     */
    public function GetPostByID($id)
    {
        return $this->GetSomeThing('posts', 'ID', $id, 'Post');
    }

    /**
     * 閫氳繃ID鑾峰彇鍒嗙被瀹炰緥.
     *
     * @param int $id
     *
     * @return Category|Base
     */
    public function GetCategoryByID($id)
    {
        return $this->GetSomeThing('categories', 'ID', $id, 'Category');
    }

    /**
     * 閫氳繃鍒嗙被鍚嶈幏鍙栧垎绫诲疄渚�.
     *
     * @param string $name
     *
     * @return Category|Base
     */
    public function GetCategoryByName($name)
    {
        return $this->GetSomeThing('categories', 'Name', $name, 'Category');
    }

    /**
     * 閫氳繃鍒嗙被鍒悕鑾峰彇鍒嗙被瀹炰緥.
     *
     * @param string $name
     * @param null   $backKey
     *
     * @return Category|Base
     */
    public function GetCategoryByAlias($name, $backKey = null)
    {
        return $this->GetSomeThingByAlias('categories', $name, $backKey, 'Category');
    }

    /**
     * 涓庤�佺増鏈繚鎸佸吋瀹瑰嚱鏁�.
     *
     * @param string $name
     *
     * @return Category
     */
    public function GetCategoryByAliasOrName($name)
    {
        return $this->GetCategoryByAlias($name, 'Name');
    }
    public function GetCommentList($select = null, $where = null, $order = null, $limit = null, $option = null)
    {
        if (empty($select)) {
            $select = array('*');
        }
        $sql = $this->db->sql->Select($this->table['Comment'], $select, $where, $order, $limit, $option);
        /** @var Comment[] $array */
        $array = $this->GetListType('Comment', $sql);
        foreach ($array as $comment) {
            $this->comments[$comment->ID] = $comment;
        }
        
        return $array;
    }
    /**
     * 閫氳繃ID鑾峰彇妯″潡瀹炰緥.
     *
     * @param int $id
     *
     * @return Base
     */
    public function GetModuleByID($id)
    {
        return $this->GetSomeThing('modules', 'ID', $id, 'Module'); // What the fuck?
    }

    /**
     * 閫氳繃FileName鑾峰彇妯″潡瀹炰緥.
     *
     * @param string $fn
     *
     * @return Base
     */
    public function GetModuleByFileName($fn)
    {
        return $this->GetSomeThing('modulesbyfilename', 'FileName', $fn, 'Module');
    }

    /**
     * 閫氳繃ID鑾峰彇鐢ㄦ埛瀹炰緥.
     *
     * @param int $id
     *
     * @return Member|Base
     */
    public function GetMemberByID($id)
    {
        /** @var Member $ret */
        $ret = $this->GetSomeThing('members', 'ID', $id, 'Member');
        if ($ret->ID == 0) {
            $ret->Guid = GetGuid();
            //濡傛灉鏄儴浠藉姞杞界敤鎴�
            if ($this->option['ZC_LOADMEMBERS_LEVEL'] != 0) {
                if ($ret->LoadInfoByID($id) == true) {
                    $this->members[$ret->ID] = $ret;
                    $this->membersbyname[$ret->Name] = &$this->members[$ret->ID];
                }
            }
        }

        return $ret;
    }

    /**
     * 閫氳繃鐢ㄦ埛鍚嶈幏鍙栫敤鎴峰疄渚�(涓嶅尯鍒嗗ぇ灏忓啓).
     *
     * @param string $name
     *
     * @return Member|Base
     */
    public function GetMemberByName($name)
    {
        $name = trim($name);
        if (!$name || !CheckRegExp($name, '[username]')) {
            return new Member();
        }

        if (isset($this->membersbyname[$name])) {
            return $this->membersbyname[$name];
        } else {
            $array = array_keys($this->membersbyname);
            foreach ($array as $k => $v) {
                if (strcasecmp($name, $v) == 0) {
                    return $this->membersbyname[$v];
                }
            }
        }

        $like = ($this->db->type == 'pgsql') ? 'ILIKE' : 'LIKE';
        $sql = $this->db->sql->Select($this->table['Member'], '*', array(array($like, 'mem_Name', $name)), null, 1, null);

        /** @var Member[] $am */
        $am = $this->GetListType('Member', $sql);
        if (count($am) > 0) {
            $m = $am[0];
            if (!isset($this->members[$m->ID])) {
                $this->members[$m->ID] = $m;
            }
            if (!isset($this->membersbyname[$m->Name])) {
                $this->membersbyname[$m->Name] = &$this->members[$m->ID];
            }

            return $m;
        }

        return new Member();
    }

    /**
     * 閫氳繃鑾峰彇鐢ㄦ埛鍚嶆垨鍒悕瀹炰緥(涓嶅尯鍒嗗ぇ灏忓啓).
     *
     * @param string $name
     *
     * @return Member|Base
     */
    public function GetMemberByNameOrAlias($name)
    {
        $name = trim($name);
        if (!$name || !(CheckRegExp($name, '[username]') || CheckRegExp($name, '[nickname]'))) {
            return new Member();
        }

        foreach ($this->members as $key => &$value) {
            if (strcasecmp($value->Name, $name) == 0 || strcasecmp($value->Alias, $name) == 0) {
                return $value;
            }
        }

        $like = ($this->db->type == 'pgsql') ? 'ILIKE' : 'LIKE';

        $sql = $this->db->sql->get()->select($this->table['Member'])->where(array("$like array", array(
                array('mem_Name', $name),
                array('mem_Alias', $name),
            )))->limit(1)->sql;

        /** @var Member[] $am */
        $am = $this->GetListType('Member', $sql);
        if (count($am) > 0) {
            $m = $am[0];
            if (!isset($this->members[$m->ID])) {
                $this->members[$m->ID] = $m;
            }
            if (!isset($this->membersbyname[$m->Name])) {
                $this->membersbyname[$m->Name] = &$this->members[$m->ID];
            }

            return $m;
        }

        return new Member();
    }

    /**
     * 閫氳繃閭鍚嶈幏鍙栫敤鎴峰疄渚�(涓嶅尯鍒嗗ぇ灏忓啓).
     *
     * @param string $email
     *
     * @return Member
     */
    public function GetMemberByEmail($email)
    {
        $email = strtolower(trim($email));
        if (!$email || !CheckRegExp($email, '[email]')) {
            return new Member();
        }

        $sql = $this->db->sql->Select($this->table['Member'], '*', array(array('LIKE', 'mem_Email', $email)), null, 1, null);
        /** @var Member[] $am */
        $am = $this->GetListType('Member', $sql);
        if (count($am) > 0) {
            $m = $am[0];
            if (!isset($this->members[$m->ID])) {
                $this->members[$m->ID] = $m;
            }
            if (!isset($this->membersbyname[$m->Name])) {
                $this->membersbyname[$m->Name] = &$this->members[$m->ID];
            }

            return $m;
        }

        return new Member();
    }

    /**
     * 妫�鏌ユ寚瀹氬悕绉扮殑鐢ㄦ埛鏄惁瀛樺湪(涓嶅尯鍒嗗ぇ灏忓啓).
     *
     * @param $name
     *
     * @return bool
     */
    public function CheckMemberNameExist($name)
    {
        $m = $this->GetMemberByName($name);

        return $m->ID > 0;
    }

    /**
     * 妫�鏌ユ寚瀹氬悕绉版垨鍒悕鐨勭敤鎴锋槸鍚﹀瓨鍦�(涓嶅尯鍒嗗ぇ灏忓啓).
     *
     * @param $name
     *
     * @return bool
     */
    public function CheckMemberByNameOrAliasExist($name)
    {
        $m = $this->GetMemberByNameOrAlias($name);

        return $m->ID > 0;
    }

    /**
     * 妫�鏌ユ寚瀹氶偖绠辩殑鐢ㄦ埛鏄惁瀛樺湪(涓嶅尯鍒嗗ぇ灏忓啓).
     *
     * @param $email
     *
     * @return bool
     */
    public function CheckMemberByEmailExist($email)
    {
        $m = $this->GetMemberByEmail($email);

        return $m->ID > 0;
    }

 
    /**
     * 閫氳繃ID鑾峰彇闄勪欢瀹炰緥.
     *
     * @param int $id
     *
     * @return Base
     */
    public function GetUploadByID($id)
    {
        return $this->GetSomeThing('', 'ID', $id, 'Upload');
    }

    /**
     * 閫氳繃tag鍚嶈幏鍙杢ag瀹炰緥.
     *
     * @param string $name
     * @param null   $backKey
     *
     * @return Base
     */
    public function GetTagByAlias($name, $backKey = null)
    {
        $ret = $this->GetSomeThingByAlias('tags', $name, $backKey, 'Tag');
        if ($ret->ID >= 0) {
            $this->tagsbyname[$ret->ID] = &$this->tags[$ret->ID];
        }

        return $ret;
    }



    /**
     * 閫氳繃ID鑾峰彇tag瀹炰緥.
     *
     * @param int $id
     *
     * @return Base
     */
    public function GetTagByID($id)
    {
        $ret = $this->GetSomeThing('tags', 'ID', $id, 'Tag');
        if ($ret->ID > 0) {
            $this->tagsbyname[$ret->ID] = &$this->tags[$ret->ID];
        }

        return $ret;
    }

    /**
     * 閫氳繃绫讳技'{1}{2}{3}{4}'杞藉叆tags.
     *
     * @param $s
     *
     * @return array
     */
    public function LoadTagsByIDString($s)
    {
        $s = trim($s);
        if ($s == '') {
            return array();
        }

        $s = str_replace('}{', '|', $s);
        $s = str_replace('{', '', $s);
        $s = str_replace('}', '', $s);
        $a = explode('|', $s);
        $b = array();
        foreach ($a as &$value) {
            $value = trim($value);
            if ($value) {
                $b[] = $value;
            }
        }
        $t = array_unique($b);

        if (count($t) == 0) {
            return array();
        }

        $a = array();
        $b = array();
        $c = array();
        foreach ($t as $v) {
            if (isset($this->tags[$v]) == false) {
                $a[] = array('tag_ID', $v);
                $c[] = $v;
            } else {
                $b[$v] = &$this->tags[$v];
            }
        }

        if (count($a) == 0) {
            return $b;
        } else {
            $t = array();
            //$array=$this->GetTagList('',array(array('array',$a)),'','','');
            $array = $this->GetTagList('', array(array('IN', 'tag_ID', $c)), '', '', '');
            foreach ($array as $v) {
                $this->tags[$v->ID] = $v;
                $this->tagsbyname[$v->Name] = &$this->tags[$v->ID];
                $t[$v->ID] = &$this->tags[$v->ID];
            }

            return $b + $t;
        }
    }

    /**
     * 閫氳繃绫讳技'aaa,bbb,ccc,ddd'杞藉叆tags.
     *
     * @param string $s 鏍囩鍚嶅瓧绗︿覆锛屽'aaa,bbb,ccc,ddd
     *
     * @return array
     */
    public function LoadTagsByNameString($s)
    {
        $s = trim($s);
        $s = str_replace(';', ',', $s);
        $s = str_replace('锛�', ',', $s);
        $s = str_replace('銆�', ',', $s);
        $s = trim($s);
        $s = strip_tags($s);
        if ($s == '') {
            return array();
        }

        if ($s == ',') {
            return array();
        }

        $a = explode(',', $s);
        $t = array_unique($a);

        if (count($t) == 0) {
            return array();
        }

        $a = array();
        $b = array();
        foreach ($t as $v) {
            if (isset($this->tagsbyname[$v]) == false) {
                $a[] = array('tag_Name', $v);
            } else {
                $b[$v] = &$this->tagsbyname[$v];
            }
        }

        if (count($a) == 0) {
            return $b;
        } else {
            $t = array();
            $array = $this->GetTagList('', array(array('array', $a)), '', '', '');
            foreach ($array as $v) {
                $this->tags[$v->ID] = $v;
                $this->tagsbyname[$v->Name] = &$this->tags[$v->ID];
                $t[$v->Name] = &$this->tags[$v->ID];
            }

            return $b + $t;
        }
    }

    /**
     * 閫氳繃鏁扮粍array[111,333,444,555,666]杞崲鎴愬瓨鍌ㄤ覆.
     *
     * @param array $array 鏍囩ID鏁扮粍
     *
     * @return string
     */
    public function ConvertTagIDtoString($array)
    {
        $s = '';
        foreach ($array as $a) {
            $s .= '{' . $a . '}';
        }

        return $s;
    }

    /**
     * 鑾峰彇鍏ㄩ儴缃《鏂囩珷锛堜紭鍏堜粠cache閲岃鏁扮粍锛�.
     *
     * @param int $type
     *
     * @return array
     */
    public function GetTopArticle($type = 0)
    {
        $varname = 'top_post_array_' . $type;
        if ($this->cache->HasKey($varname) == false) {
            return array();
        }

        $articles_top_notorder_idarray = unserialize($this->cache->$varname);
        if (!is_array($articles_top_notorder_idarray)) {
            CountTopArticle($type, null, null);
            $articles_top_notorder_idarray = unserialize($this->cache->$varname);
        }
        $articles_top_notorder = $this->GetPostByArray($articles_top_notorder_idarray);

        return $articles_top_notorder;
    }

    //###############################################################################################################
    //楠岃瘉鐩稿叧

    /**
     * 鑾峰彇璇勮key.
     *
     * @param $id
     *
     * @return string
     */
    public function GetCmtKey($id)
    {
        return md5($this->guid . $id . date('Ymdh'));
    }

    /**
     * 楠岃瘉璇勮key.
     *
     * @param $id
     * @param $key
     *
     * @return bool
     */
    public function ValidCmtKey($id, $key)
    {
        $nowkey = md5($this->guid . $id . date('Ymdh'));
        $nowkey2 = md5($this->guid . $id . date('Ymdh', time() - (3600 * 1)));

        return $key == $nowkey || $key == $nowkey2;
    }

    /**
     * 鑾峰彇CSRF Token.
     *
     * @param string $id 搴旂敤ID锛屽彲浠ヤ繚璇佹瘡涓簲鐢ㄨ幏鍙栦笉鍚岀殑Token
     *
     * @return string
     */
    public function GetCSRFToken($id = '')
    {
        $s = $this->user->ID . $this->user->Password . $this->user->Status;

        return md5($this->guid . $s . $id . date('Ymdh'));
    }

    /**
     * 楠岃瘉CSRF Token.
     *
     * @param string $token
     * @param string $id    搴旂敤ID锛屽彲涓烘瘡涓簲鐢ㄧ敓鎴愪竴涓笓灞瀟oken
     *
     * @return bool
     */
    public function VerifyCSRFToken($token, $id = '')
    {
        $userString = $this->user->ID . $this->user->Password . $this->user->Status;
        $tokenString = $this->guid . $userString . $id;

        for ($i = 0; $i <= $this->csrfExpiration; $i++) {
            if ($token === md5($tokenString . date('Ymdh', time() - (3600 * $i)))) {
                return true;
            }
        }

        return false;
    }

    /**
     * 鏄剧ず楠岃瘉鐮�
     *
     * @api Filter_Plugin_Zbp_ShowValidCode 濡傝鎺ュ彛鏈鎸傝浇鍒欐樉绀洪粯璁ら獙璇佸浘鐗�
     *
     * @param string $id 鍛藉悕浜嬩欢
     *
     * @return bool
     */
    public function ShowValidCode($id = '')
    {
        foreach ($GLOBALS['hooks']['Filter_Plugin_Zbp_ShowValidCode'] as $fpname => &$fpsignal) {
            return $fpname($id); //*
        }

        $_vc = new ValidateCode();
        $_vc->GetImg();
        setcookie('captcha_' . crc32($this->guid . $id), md5($this->guid . date("Ymdh") . $_vc->GetCode()), null, $this->cookiespath);

        return true;
    }

    /**
     * 姣斿楠岃瘉鐮�
     *
     * @api Filter_Plugin_Zbp_CheckValidCode 濡傝鎺ュ彛鏈鎸傝浇鍒欐瘮瀵归粯璁ら獙璇佺爜
     *
     * @param string $verifyCode 楠岃瘉鐮佹暟鍊�
     * @param string $id         鍛藉悕浜嬩欢
     *
     * @return bool
     */
    public function CheckValidCode($verifyCode, $id = '')
    {
        $verifyCode = strtolower($verifyCode);
        foreach ($GLOBALS['hooks']['Filter_Plugin_Zbp_CheckValidCode'] as $fpname => &$fpsignal) {
            return $fpname($verifyCode, $id); //*
        }

        $original = GetVars('captcha_' . crc32($this->guid . $id), 'COOKIE');
        setcookie('captcha_' . crc32($this->guid . $id), '', time() - 3600, $this->cookiespath);

        return md5($this->guid . date("Ymdh") . strtolower($verifyCode)) == $original
                ||
                md5($this->guid . date("Ymdh", time() - (3600 * 1)) . strtolower($verifyCode)) == $original;
    }

    /**
     * 鍚戝鑸彍鍗曟坊鍔犵浉搴旀潯鐩�.
     *
     * @param string $type $type=category,tag,page,item
     * @param string $id
     * @param string $name
     * @param string $url
     */
    public function AddItemToNavbar($type, $id, $name, $url)
    {
        if (!$type) {
            $type = 'item';
        }

        $m = $this->modulesbyfilename['navbar'];
        $s = $m->Content;

        $a = '<li id="navbar-' . $type . '-' . $id . '"><a href="' . $url . '">' . $name . '</a></li>';

        if ($this->CheckItemToNavbar($type, $id)) {
            $s = preg_replace('/<li id="navbar-' . $type . '-' . $id . '">.*?<\/li>/', $a, $s);
        } else {
            $s .= '<li id="navbar-' . $type . '-' . $id . '"><a href="' . $url . '">' . $name . '</a></li>';
        }

        $m->Content = $s;
        $m->Save();
    }

    /**
     * 鍒犻櫎瀵艰埅鑿滃崟涓浉搴旀潯鐩�.
     *
     * @param string $type
     * @param $id
     */
    public function DelItemToNavbar($type, $id)
    {
        if (!$type) {
            $type = 'item';
        }

        $m = $this->modulesbyfilename['navbar'];
        $s = $m->Content;

        $s = preg_replace('/<li id="navbar-' . $type . '-' . $id . '">.*?<\/li>/', '', $s);

        $m->Content = $s;
        $m->Save();
    }

    /**
     * 妫�鏌ユ潯鐩槸鍚﹀湪瀵艰埅鑿滃崟涓�.
     *
     * @param string $type
     * @param $id
     *
     * @return bool
     */
    public function CheckItemToNavbar($type, $id)
    {
        if (!$type) {
            $type = 'item';
        }

        $m = $this->modulesbyfilename['navbar'];
        $s = $m->Content;

        return (bool) strpos($s, 'id="navbar-' . $type . '-' . $id . '"');
    }

    //$signal = good,bad,tips
    private $hint1 = null;
    private $hint2 = null;
    private $hint3 = null;
    private $hint4 = null;
    private $hint5 = null;

    /**
     * 璁剧疆鎻愮ず娑堟伅骞跺瓨鍏ookie.
     *
     * @param string $signal  鎻愮ず绫诲瀷锛坓ood|bad|tips锛�
     * @param string $content 鎻愮ず鍐呭
     */
    public function SetHint($signal, $content = '')
    {
        if ($content == '') {
            if ($signal == 'good') {
                $content = $this->lang['msg']['operation_succeed'];
            }

            if ($signal == 'bad') {
                $content = $this->lang['msg']['operation_failed'];
            }
        }
        $content = substr($content, 0, 255);
        if ($this->hint1 == null) {
            $this->hint1 = $signal . '|' . $content;
            setcookie("hint_signal1", $signal . '|' . $content, 0, $this->cookiespath);
        } elseif ($this->hint2 == null) {
            $this->hint2 = $signal . '|' . $content;
            setcookie("hint_signal2", $signal . '|' . $content, 0, $this->cookiespath);
        } elseif ($this->hint3 == null) {
            $this->hint3 = $signal . '|' . $content;
            setcookie("hint_signal3", $signal . '|' . $content, 0, $this->cookiespath);
        } elseif ($this->hint4 == null) {
            $this->hint4 = $signal . '|' . $content;
            setcookie("hint_signal4", $signal . '|' . $content, 0, $this->cookiespath);
        } elseif ($this->hint5 == null) {
            $this->hint5 = $signal . '|' . $content;
            setcookie("hint_signal5", $signal . '|' . $content, 0, $this->cookiespath);
        }
    }

    /**
     * 鎻愬彇Cookie涓殑鎻愮ず娑堟伅.
     */
    public function GetHint()
    {
        for ($i = 1; $i <= 5; $i++) {
            $signal = 'hint' . $i;
            $signal = $this->$signal;
            if ($signal) {
                $a = explode('|', $signal);
                $this->ShowHint($a[0], $a[1]);
                setcookie("hint_signal" . $i, '', time() - 3600, $this->cookiespath);
            }
        }
        for ($i = 1; $i <= 5; $i++) {
            $signal = GetVars('hint_signal' . $i, 'COOKIE');
            if ($signal) {
                $a = explode('|', $signal);
                $this->ShowHint($a[0], $a[1]);
                setcookie("hint_signal" . $i, '', time() - 3600, $this->cookiespath);
            }
        }
    }

    /**
     * 鐢辨彁绀烘秷鎭幏鍙朒TML.
     *
     * @param string $signal  鎻愮ず绫诲瀷锛坓ood|bad|tips锛�
     * @param string $content 鎻愮ず鍐呭
     */
    public function ShowHint($signal, $content = '')
    {
        if ($content == '') {
            if ($signal == 'good') {
                $content = $this->lang['msg']['operation_succeed'];
            }

            if ($signal == 'bad') {
                $content = $this->lang['msg']['operation_failed'];
            }
        }
        echo "<div class=\"hint\"><p class=\"hint hint_$signal\">$content</p></div>";
    }


    /**
     * 妫�鏌ュ苟寮�鍚疓zip鍘嬬缉.
     */
    public function CheckGzip()
    {
        if (extension_loaded("zlib") &&
            isset($_SERVER["HTTP_ACCEPT_ENCODING"]) &&
            strstr($_SERVER["HTTP_ACCEPT_ENCODING"], "gzip")
        ) {
            $this->isGzip = true;
        }
    }

    /**
     * 鍚敤Gzip.
     */
    public function StartGzip()
    {
        if (!headers_sent() && $this->isGzip && $this->option['ZC_GZIP_ENABLE']) {
            if (ini_get('output_handler')) {
                return false;
            }

            $a = ob_list_handlers();
            if (in_array('ob_gzhandler', $a) || in_array('zlib output compression', $a)) {
                return false;
            }

            if (function_exists('ini_set') && function_exists('zlib_encode') && $this->option['ZC_YUN_SITE'] !== 'SAE') {
                @ob_end_clean();
                @ini_set('zlib.output_compression', 'On');
                @ini_set('zlib.output_compression_level', '5');
            } elseif (function_exists('ob_gzhandler')) {
                @ob_end_clean();
                @ob_start('ob_gzhandler');
            }
            ob_start();

            return true;
        }

        return false;
    }

    /**
     * 妫�娴嬬綉绔欏叧闂紝濡傛灉鍏抽棴锛屽垯鎶涘嚭閿欒.
     *
     * @throws Exception
     */
    public function CheckSiteClosed()
    {
        if ($this->option['ZC_CLOSE_SITE']) {
            $this->ShowError(82, __FILE__, __LINE__);
            exit;
        }
    }

    /**
     * 璺宠浆鍒板畨瑁呴〉闈�.
     */
    public function RedirectInstall()
    {
        if (!$this->option['ZC_DATABASE_TYPE']) {
            Redirect('./zb_install/index.php');
        }

        if ($this->option['ZC_YUN_SITE']) {
            if ($this->Config('system')->CountItem() == 0) {
                Redirect('./zb_install/index.php');
            }
        }
    }

    /**
     * 妫�娴嬪綋鍓島rl锛屽鏋滀笉绗﹀悎璁剧疆灏辫烦杞埌鍥哄畾鍩熷悕鐨勯摼鎺�.
     */
    public function RedirectPermanentDomain()
    {
        if ($this->option['ZC_PERMANENT_DOMAIN_ENABLE'] == false) {
            return;
        }

        if ($this->option['ZC_PERMANENT_DOMAIN_REDIRECT'] == false) {
            return;
        }

        $host = str_replace(array('https://', 'http://'), array('', ''), GetCurrentHost(ZBP_PATH, $null));
        $host2 = str_replace(array('https://', 'http://'), array('', ''), $this->host);

        if ($host != $host2) {
            $u = GetRequestUri();
            $u = $this->host . substr($u, 1, strlen($u));
            Redirect301($u);
        }
    }

    /**
     * 娉ㄥ唽PostType.
     *
     * @param $typeId
     * @param $name
     * @param string $urlRule      榛樿鏄彇Page绫诲瀷鐨刄rl Rule
     * @param string $template     榛樿妯℃澘鍚峱age
     * @param string $categoryType 褰撳墠鏂囩珷绫荤殑鍒嗙被Type
     * @param string $tagType      褰撳墠鏂囩珷绫荤殑鏍囩Type
     *
     * @throws Exception
     */
    public function RegPostType($typeId, $name, $urlRule = '', $template = 'single', $categoryType = null, $tagType = null)
    {
        if ($urlRule == '') {
            $urlRule = $this->option['ZC_PAGE_REGEX'];
        }

        $typeId = (int) $typeId;
        $name = strtolower(trim($name));
        if ($typeId > 99) {
            if (isset($this->posttype[$typeId])) {
                $this->ShowError(87, __FILE__, __LINE__);
            }
        }
        $this->posttype[$typeId] = array($name, $urlRule, $template, $categoryType, $tagType);
    }

    /**
     * @param $typeid
     *
     * @return string
     */
    public function GetPostType_Name($typeid)
    {
        if (isset($this->posttype[$typeid])) {
            return $this->posttype[$typeid][0];
        }

        return '';
    }

    public function GetPostType_UrlRule($typeid)
    {
        if (isset($this->posttype[$typeid])) {
            return $this->posttype[$typeid][1];
        }

        return $this->option['ZC_PAGE_REGEX'];
    }

    public function GetPostType_Template($typeid)
    {
        if (isset($this->posttype[$typeid])) {
            return $this->posttype[$typeid][2];
        }

        return 'single';
    }

    public function GetPostType_CategoryType($typeid)
    {
        if (isset($this->posttype[$typeid])) {
            return $this->posttype[$typeid][3];
        }
    }

    public function GetPostType_TagType($typeid)
    {
        if (isset($this->posttype[$typeid])) {
            return $this->posttype[$typeid][4];
        }
    }

    /**
     * 娉ㄥ唽Action.
     *
     * @param $name
     * @param $level
     * @param $title
     */
    public function RegAction($name, $level, $title)
    {
        $this->actions[$name] = $level;
        $this->lang['actions'][$name] = $title;
    }

    /**
     * 鑾峰緱Action鏉冮檺娉ㄩ噴.
     *
     * @param $name
     *
     * @return mixed
     */
    public function GetActionDescription($name)
    {
        if (isset($this->lang['actions'][$name])) {
            return $this->lang['actions'][$name];
        }

        return $name;
    }

    /**
     * 浠ヤ笅閮ㄥ垎涓哄凡搴熷純锛屼絾鑰冭檻鍒板吋瀹规�т繚鐣欑殑浠ｇ爜
     */

    /**
     * 楠岃瘉鐢ㄦ埛鐧诲綍锛圡D5鍔爖bp->guid鐩愬悗鐨勫瘑鐮侊級.
     *
     * @deprecated
     *
     * @param string $name         鐢ㄦ埛鍚�
     * @param string $ps_path_hash MD5鍔爖bp->guid鐩愬悗鐨勫瘑鐮�
     * @param object $member       杩斿洖璇诲彇鎴愬姛鐨刴ember瀵硅薄
     *
     * @return bool
     */
    public function Verify_MD5Path($name, $ps_path_hash, &$member = null)
    {
        if ($name == '' || $ps_path_hash == '') {
            return false;
        }
        $m = $this->GetMemberByName($name);
        if ($m->ID > 0) {
            if ($m->PassWord_MD5Path == $ps_path_hash) {
                $member = $m;

                return true;
            }
        }

        return false;
    }

    /**
     * 鑾峰彇CSRF Token鐨勯敊璇埆鍚�.
     *
     * @deprecated Use ``GetCSRFToken``
     *
     * @param string $id 搴旂敤ID锛屽彲浠ヤ繚璇佹瘡涓簲鐢ㄨ幏鍙栦笉鍚岀殑Token
     *
     * @return string
     */
    public function GetToken($id = '')
    {
        return $this->GetCSRFToken($id);
    }

    /**
     * 楠岃瘉CSRF Token鐨勯敊璇埆鍚�.
     *
     * @deprecated Use ``VerifyCSRFToken``
     *
     * @param $t
     * @param $id
     *
     * @return bool
     */
    public function ValidToken($t, $id = '')
    {
        return $this->VerifyCSRFToken($t, $id);
    }

    /**
     * @deprecated
     *
     * @return bool
     */
    public function LoadCategorys()
    {
        return $this->LoadCategories();
    }

    /**
     * 鎵�鏈夋ā鍧楅噸缃�.
     *
     * @deprecated
     */
    public function AddBuildModuleAll()
    {
    }

    /**
     * 鑾峰彇浼氳瘽WebToken.
     *
     * @deprecated 姣棤鎰忎箟锛屽嵆灏嗗簾寮�
     *
     * @param string $wt_id
     * @param int    $day   榛樿1澶╂湁鏁堟湡锛�1灏忔椂涓�1/24锛�1鍒嗛挓涓�1/(24*60)
     *
     * @return string
     */
    public function GetWebToken($wt_id = '', $day = 1)
    {
        $t = intval($day * 24 * 3600) + time();

        return CreateWebToken($wt_id, $t, $this->guid, $this->user->Status, $this->user->ID, $this->user->Password);
    }

    /**
     * 楠岃瘉浼氳瘽WebToken.
     *
     * @deprecated 姣棤鎰忎箟锛屽嵆灏嗗簾寮�
     *
     * @param $wt
     * @param $wt_id
     *
     * @return bool
     */
    public function ValidWebToken($wt, $wt_id = '')
    {
        if (VerifyWebToken($wt, $wt_id, $this->guid, $this->user->Status, $this->user->ID, $this->user->Password) === true) {
            return true;
        }

        return false;
    }
}
