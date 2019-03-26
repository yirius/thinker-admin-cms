<?php
/**
 * Created by PhpStorm.
 * User: yangyuance
 * Date: 2019/3/22
 * Time: 上午12:20
 */

namespace Yirius\AdminCms\controller;

use think\facade\View;
use Yirius\Admin\Admin;
use Yirius\Admin\model\table\AdminConfigs;
use Yirius\AdminCms\model\CmsColumns;
use Yirius\AdminCms\model\CmsGuestbookAttr;
use Yirius\AdminCms\model\CmsTemplates;
use Yirius\AdminCms\model\CmsTemplatesVars;

class CmsController
{
    /**
     * @var null|\think\View
     */
    protected $view = null;

    /**
     * @var CmsTemplates
     */
    protected $cmsTemplate = null;

    protected $cmsTemplatePath = '';

    /**
     * CmsController constructor.
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function __construct()
    {
        $this->view = View::init();

        $this->cmsTemplate = CmsTemplates::get(['status' => 1]);

        //找到模板地址
        $this->cmsTemplatePath = str_replace(
            ['THINKER_CMS_ROOT', 'ROOT_PATH'],
            [THINKER_CMS_ROOT, env("root_path")],
            $this->cmsTemplate['path']
        );

        $this->view->config("view_path", $this->cmsTemplatePath);

        //找到所有自定义变量, 取值渲染
        $templateVars = CmsTemplatesVars::where('templateid', '=', $this->cmsTemplate['id'])->select();
        $assignValues = [
            '_rooturl' => request()->root(true)
        ];
        foreach($templateVars as $i => $v){
            $assignValues[$v['name']] = $v['value'];
        }
        $this->assign("_config", $assignValues);

        //找到网站设置
        $this->assign("_siteconfig", AdminConfigs::getValues());

        //find top columns
        $topMenus = CmsColumns::where([
            ['is_hidden', '=', 0],
            ['status', '=', 1]
        ])->field("id,name,pid,modelid")->order("list_order", "desc")->select()
            ->each(function($item){
                $item->cms_models;
            })->toArray();

        $this->assign('topMenus', Admin::tools()->tree($topMenus, null));
    }

    /**
     * @title index
     * @description CmsIndexPage
     * @createtime 2019/3/22 下午2:14
     * @return string
     * @throws \Exception
     */
    public function index()
    {
        //find latest five news
        $latestFiveCms = \Yirius\AdminCms\model\Cms::with("CmsModels")
            ->order("list_order", "desc")
            ->limit(5)->select()->toArray();

        //render home page
        return $this->assign([
            'latestcms' => $latestFiveCms
        ])->fetch("index");
    }

    /**
     * @title article
     * @description
     * @createtime 2019/3/26 下午3:20
     * @param $id
     * @return string
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function article($id)
    {
        //render home page
        return $this->assign(
            "article_content",
            \Yirius\AdminCms\model\Cms::with("CmsColumns,CmsModels")
                ->where("columnid", '=', $id)
                ->select()
        )->fetch("article");
    }

    /**
     * @title single
     * @description
     * @createtime 2019/3/26 下午4:38
     * @param $id
     * @return string
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function single($id)
    {
        //render home page
        return $this->assign(
            "article_content",
            \Yirius\AdminCms\model\Cms::with("CmsColumns,CmsModels")
                ->where("columnid", '=', $id)
                ->find()
        )->fetch("single");
    }

    /**
     * @title guestbook
     * @description
     * @createtime 2019/3/26 下午4:47
     * @param $id
     * @return string
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function guestbook($id)
    {
        $guestbookAttr = CmsGuestbookAttr::where('columnid', '=', $id)->select();

        //render home page
        return $this->assign("guestbook_content", $guestbookAttr)->fetch("guestbook");
    }

    /**
     * @title product
     * @description
     * @createtime 2019/3/26 下午4:50
     * @param $id
     * @return string
     */
    public function product($id)
    {
        return '';
    }

    /**
     * @title download
     * @description
     * @createtime 2019/3/26 下午7:57
     * @param $id
     * @return string
     */
    public function download($id)
    {
        return '';
    }

    /**
     * @title assign
     * @description
     * @createtime 2019/3/22 下午2:15
     * @param $name
     * @param $value
     * @return $this
     */
    protected function assign($name, $value = '')
    {
        $this->view->assign($name, $value);

        return $this;
    }

    /**
     * @title fetch
     * @description
     * @createtime 2019/3/22 下午2:13
     * @param string $template
     * @param array $vars
     * @param array $config
     * @param bool $renderContent
     * @return string
     * @throws \Exception
     */
    protected function fetch($template, $vars = [], $config = [], $renderContent = false)
    {
        $viewPath = $this->cmsTemplatePath . $template . ".html";
        return $this->view->fetch($viewPath, $vars, $config, $renderContent);
    }
}