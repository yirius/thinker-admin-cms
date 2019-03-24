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
use Yirius\AdminCms\model\CmsColumns;
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

        //找到所有自定义变量, 取值渲染
        $templateVars = CmsTemplatesVars::where('templateid', '=', $this->cmsTemplate['id'])->select();
        $assignValues = [
            '_rooturl' => request()->root(true)
        ];
        foreach($templateVars as $i => $v){
            $assignValues[$v['name']] = $v['value'];
        }
        $this->assign("_config", $assignValues);
    }

    /**
     * @title index
     * @description
     * @createtime 2019/3/22 下午2:14
     * @return string
     * @throws \Exception
     */
    public function index()
    {
        //find top columns
        $topMenus = CmsColumns::where([
            ['is_hidden', '=', 0],
            ['status', '=', 1]
        ])->order("list_order", "desc")->select()->toArray();

        //render home page
        return $this->assign([
            'topMenus' => Admin::tools()->tree($topMenus, null)
        ])->fetch("index");
    }

    public function cms()
    {

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