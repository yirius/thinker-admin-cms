<?php
/**
 * Created by PhpStorm.
 * User: yangyuance
 * Date: 2019/3/13
 * Time: 下午5:07
 */

namespace Yirius\AdminCms\controller;


use Yirius\Admin\Admin;
use Yirius\Admin\controller\AdminController;
use Yirius\Admin\form\Form;
use Yirius\Admin\form\Tab;
use Yirius\AdminCms\model\CmsColumns;
use Yirius\AdminCms\model\CmsModels;
use Yirius\AdminCms\model\CmsModelsField;
use Yirius\Admin\table\Table;
use Yirius\AdminCms\model\CmsTemplates;
use Yirius\AdminCms\model\CmsTemplatesVars;

class Cms extends AdminController
{
    /**
     * @title models
     * @description
     * @createtime 2019/3/13 下午5:15
     * @return mixed
     */
    public function models()
    {
        return Admin::table("thinker_cms_models", function (Table $table) {

            $table->setRestfulUrl("/restful/cmsmodels")->setEditPath("/thinkercms/modelsEdit");

            $table->columns("", "")->setType("checkbox");

            $table->columns("id", "编号");

            $table->columns("nid", "模型标识");

            $table->columns("title", "模型名称");

            $table->columns("status", "模型状态")->setSwitchTemplet("status");

            $table->columns("update_time", "更新时间");

            $table->columns("op", "操作")->edit()
                ->button(
                    "字段",
                    "/thinkercms/modelsField?modelid={{d.id}}",
                    "add-1",
                    "layui-btn-primary",
                    true
                )
                ->delete()->setWidth(210);

            $table->tool()->edit()->delete();

            $table->toolbar()->add()->delete()->event()->add()->delete();

            $table->on()->edit();

        })->show();
    }

    /**
     * @title modelsEdit
     * @description
     * @createtime 2019/3/13 下午5:36
     * @param int $id
     * @return mixed
     * @throws \Exception
     */
    public function modelsEdit($id = 0)
    {
        return Admin::form("thinker_cms_modelsedit", function (Form $form) use ($id) {
            $form->setValue($id == 0 ? [] : CmsModels::get(['id' => $id])->toArray());

            $form->text("nid", "模型标识");

            $form->text("title", "模型名称");

            $form->text("stitle", "模型简称");

            $form->text("table", "对应库表");

            $form->switchs("status", "是否开启");

            $form->text("list_order", "排序");

            $form->footer()->submit("/restful/cmsmodels", $id);
        })->show();
    }

    /**
     * @title modelsField
     * @description
     * @createtime 2019/3/19 下午6:03
     * @param $modelid
     * @return mixed
     */
    public function modelsField($modelid)
    {
        return Admin::table("thinker_cms_modelsfield", function (Table $table) use ($modelid) {

            $table
                ->setRestfulUrl("/restful/cmsmodelsfield?modelid=" . $modelid)
                ->setEditPath("/thinkercms/modelsFieldEdit?modelid=" . $modelid);

            $table->columns("", "")->setType("checkbox");

            $table->columns("id", "编号");

            $table->columns("title", "字段标题");

            $table->columns("name", "字段名称");

            $table->columns("type", "字段类型");

            $table->columns("dvalue", "默认值");

            $table->columns("unit", "数值单位");

            $table->columns("list_order", "排序");

            $table->columns("can_see", "可用栏目");

            $table->columns("op", "操作")->edit()->delete();

            $table->tool()->edit()->delete();

            $table->toolbar()->add()->delete()->event()->add()->delete();

        })->show();
    }

    /**
     * @title modelsFieldEdit
     * @description
     * @createtime 2019/3/19 下午6:20
     * @param $modelid
     * @param int $id
     * @return mixed
     * @throws \Exception
     */
    public function modelsFieldEdit($modelid, $id = 0)
    {
        return Admin::form("thinker_cms_modelsfieldedit", function (Form $form) use ($modelid, $id) {
            $form->setValue($id == 0 ? [] : CmsModelsField::get(['id' => $id])->toArray());

            $form->text("title", "字段标题");

            $form->text("name", "字段名称")->setPlaceholder("只允许字母、数字和下划线的任意组合");

            $form->select("type", "字段类型")->options([
                ['text' => "单行文本", 'value' => "text"],
                ['text' => "多行文本", 'value' => "textarea"],
                ['text' => "富文本输入", 'value' => "wangeditor"],
                ['text' => "日期选择", 'value' => "date"],
                ['text' => "日期时间选择", 'value' => "datetime"],
                ['text' => "下拉单选", 'value' => "select"],
                ['text' => "下拉多选", 'value' => "selectplus"],
                ['text' => "单选框", 'value' => "radio"],
                ['text' => "复选框", 'value' => "checkbox"],
                ['text' => "开关", 'value' => "switchs"],
                ['text' => "颜色选择", 'value' => "colorpicker"],
                ['text' => "邮件文本", 'value' => "email"],
                ['text' => "隐藏文本", 'value' => "hidden"],
                ['text' => "HTML文本", 'value' => "html"],
                ['text' => "密码文本", 'value' => "password"],
                ['text' => "滑块", 'value' => "slider"],
                ['text' => "树状结构", 'value' => "tree"],
                ['text' => "图片上传", 'value' => "upload"],
                ['text' => "多文件上传", 'value' => "uploadmulti"],
                ['text' => "按钮", 'value' => "button"],
            ])->on('judgeType(obj.value);');

            $form->textarea("dvalue", "默认值")->setPlaceholder('如果定义字段类型为下拉框、单选项、多选项时，此处填写被选择的项目(用“,”分开，如“男,女,人妖”)。');

            $form->textarea("values", "可选择值")->setPlaceholder('如果定义字段类型为下拉框、单选项、多选项时，此处填写被选择的项目(用“|”分割文字与值,用【键盘回车】分割选项，如“男|1【键盘回车】女|2”)。');

            $form->text("unit", "数值单位")->setPlaceholder("如：元、个、件等等");

            $form->text("list_order", "排序");

            $form->tree("can_see", "可用栏目")->setData(
                \Yirius\Admin\Admin::tools()->tree(CmsColumns::all()->toArray(),
                    function ($data) {
                        return [
                            'text' => $data['name'],
                            'value' => $data['id']
                        ];
                    }
                )
            );

            $form->footer()->submit("/restful/cmsmodelsfield?modelid=" . $modelid, $id);

            \Yirius\Admin\Admin::script(<<<HTML
var thinkeradmin_values = $("#thinkeradmin_values"), 
    thinkeradmin_unit = $("#thinkeradmin_unit");
//判断是否是需要显示可选择值
function judgeType(objType){
    if(['checkbox','radio','select','selectplus','tree'].indexOf(objType) != -1){
        thinkeradmin_values.parent().parent().show();
        thinkeradmin_unit.parent().parent().hide();
    }else{
        thinkeradmin_values.parent().parent().hide();
        if(['text'].indexOf(objType) != -1){
            thinkeradmin_unit.parent().parent().show();
        }else{
            thinkeradmin_unit.parent().parent().hide();
        }
    }
}
judgeType('{$form->getValue("type")}' || 'text');
HTML
            );
        })->show();
    }

    /**
     * @title columns
     * @description
     * @createtime 2019/3/13 下午6:32
     */
    public function columns()
    {
        return Admin::table("thinker_cms_columns", function (Table $table) {

            $table->setRestfulUrl("/restful/cmscolumns")->setEditPath("/thinkercms/columnsEdit");

            $table->columns("", "")->setType("checkbox");

            $table->columns("id", "编号");

            $table->columns("name", "栏目名称");

            $table->columns("level", "栏目层级");

            $table->columns("cmsmodels.title", "栏目层级")->setTemplet("<div>{{d.cmsmodels.title}}</div>");

            $table->columns("is_hidden", "是否隐藏")->setSwitchTemplet("is_hidden");

            $table->columns("status", "栏目状态")->setSwitchTemplet("status");

            $table->columns("list_order", "排序");

            $table->columns("update_time", "更新时间");

            $table->columns("op", "操作")
                ->button(
                    "内容",
                    "/thinkercms/cms?id={{d.id}}&nonce=1",
                    "list",
                    "layui-btn",
                    true
                )
                ->edit()
                ->button("子栏目", "addsub", "add-1", "layui-btn-primary")
                ->delete()
                ->setWidth(280);

            $table->tool()->edit()->delete()->add(
                "addsub",
                "/thinkercms/columnsEdit?pid={{d.id}}&level={{d.level+1}}"
            );

            $table->toolbar()->add()->delete()->event()->add()->delete();

            $table->on()->edit();

            $table->setLimit(100000)->setLimits([100000]);

        })->show();
    }

    /**
     * @title columnsEdit
     * @description
     * @createtime 2019/3/13 下午6:51
     * @param int $topid
     * @param int $pid
     * @param int $id
     * @return mixed
     * @throws \Exception
     */
    public function columnsEdit($pid = 0, $id = 0, $level = 0)
    {
        return \Yirius\Admin\Admin::form("thinker_cms_columnsdit", function (Form $form) use ($pid, $id, $level) {
            $value = $id == 0 ? [] : CmsColumns::get(['id' => $id])->toArray();
            $form->setValue($value);

            $form->tab("基础设置", function (Tab $tab) {

                $tab->text("name", "*栏目名称");

                $tab->text("en_name", "英文名称");

                $tab->select("modelid", "*内容模型")->options(CmsModels::adminSelect()->getResult());

                $tab->text("list_order", "*排序");

                $tab->upload("coverpic", "封面图片");

                $tab->switchs("is_hidden", "是否隐藏");
            });

            $form->tab("高级设置", function (Tab $tab) {

                $tab->switchs("is_link", "是否链接")->on('$("#thinkeradmin_link").parent().parent()[obj.elem.checked ? "show" : "hide"]();');

                $tab->text("link", "链接地址");

                $tab->textarea("seo_title", "SEO标题");

                $tab->textarea("seo_keywords", "SEO关键字");

                $tab->textarea("seo_description", "SEO描述");

            });

            $form->hidden("pid", "")->setValue(!empty($value['pid']) ? $value['pid'] : $pid);
            $form->hidden("level", "")->setValue(!empty($value['level']) ? $value['level'] : $level);

            $form->footer()->submit("/restful/cmscolumns", $id);

            //隐藏设置
            Admin::script('$("#thinkeradmin_link").parent().parent().hide();');
        })->show();
    }

    /**
     * @title cms
     * @description
     * @createtime 2019/3/21 上午11:16
     * @param $id
     * @return mixed
     * @throws \Exception
     */
    public function cms($id)
    {
        return Admin::widgets("cms", function (\Yirius\AdminCms\widgets\Cms $cms) use ($id) {

            $cms->setCmsColumn($id);

        })->render();
    }

    /**
     * @title cmsEdit
     * @description
     * @createtime 2019/3/19 下午12:22
     * @param $columnid
     * @param int $id
     * @return mixed
     * @throws \Exception
     */
    public function cmsEdit($columnid, $id = 0)
    {
        return Admin::widgets("cms", function (\Yirius\AdminCms\widgets\Cms $cms) use ($columnid, $id) {

            $cms->setCmsColumn($columnid);

            $cms->setType();

            $cms->setCmsid($id);

        })->render();
    }

    /**
     * @title cmsAttr
     * @description
     * @createtime 2019/3/21 下午9:02
     * @param $id
     * @return mixed
     * @throws \Exception
     */
    public function cmsAttr($id)
    {
        return Admin::widgets("cms", function (\Yirius\AdminCms\widgets\Cms $cms) use ($id) {

            $cms->setCmsColumn($id);

            $cms->setType("Attr");

        })->render();
    }

    /**
     * @title cmsAttrEdit
     * @description
     * @createtime 2019/3/21 下午9:53
     * @param $columnid
     * @return mixed
     * @throws \Exception
     */
    public function cmsAttrEdit($columnid)
    {
        return Admin::widgets("cms", function (\Yirius\AdminCms\widgets\Cms $cms) use ($columnid) {

            $cms->setCmsColumn($columnid);

            $cms->setType("AttrEdit");

        })->render();
    }

    /**
     * @title templates
     * @description
     * @createtime 2019/3/21 下午11:50
     * @return mixed
     */
    public function templates()
    {
        return Admin::table("thinker_cms_templates", function (Table $table) {

            $table->setRestfulUrl("/restful/cmstemplates")->setEditPath("/thinkercms/templatesEdit");

            $table->columns("id", "模板编号");

            $table->columns("title", "模板名称");

            $table->columns("status", "状态")->setSwitchTemplet("status");

            $table->columns("create_time", "创建时间");

            $table->columns("op", "操作")
                ->button(
                    "变量",
                    "/thinkercms/templateVars?id={{d.id}}",
                    "set",
                    "layui-btn-warm",
                    true
                )
                ->edit()->delete()->setWidth(210);

            $table->tool()->edit()->delete();

            $table->toolbar()->add()->delete()->event()->add()->delete();

        })->show();
    }

    /**
     * @title templatesEdit
     * @description
     * @createtime 2019/3/22 上午12:00
     * @param int $id
     * @return mixed
     * @throws \Exception
     */
    public function templatesEdit($id = 0)
    {
        return Admin::form("thinker_cms_templatesedit", function (Form $form) use ($id) {

            $form->setValue($id == 0 ? [] : CmsTemplates::get(['id' => $id]));

            $form->text("title", "模板名称");

            $form->switchs("status", "状态");

            $form->text("path", "模板路径");

            $form->footer()->submit("/restful/cmstemplates", $id);
        })->show();
    }

    /**
     * @title templateVars
     * @description
     * @createtime 2019/3/22 下午3:11
     * @param $id
     * @return mixed
     */
    public function templateVars($id)
    {
        return Admin::table("thinker_cms_templatevars", function (Table $table) use ($id) {
            $table
                ->setRestfulUrl("/restful/cmstemplatesvars?templateid=" . $id)
                ->setEditPath("/thinkercms/templateVarsEdit?templateid=" . $id);

            $table->columns("id", "编号");

            $table->columns("title", "变量名称");

            $table->columns("name", "变量字段");

            $table->columns("value", "变量值");

            $table->columns("create_time", "创建时间");

            $table->columns("op", "操作")->edit()->delete();

            $table->tool()->edit()->delete();

            $table->toolbar()->add()->delete()->event()->add()->delete();

        })->show();
    }

    /**
     * @title templateVarsEdit
     * @description
     * @createtime 2019/3/26 下午2:00
     * @param $templateid
     * @param int $id
     * @return mixed
     * @throws \Exception
     */
    public function templateVarsEdit($templateid, $id = 0)
    {
        return Admin::form("thinker_cms_templatevarsedit", function (Form $form) use ($templateid, $id) {

            $form->setValue($id == 0 ? [] : CmsTemplatesVars::get(['id' => $id]));

            $form->text("title", "变量名称");

            $form->text("name", "变量字段");

            $form->textarea("value", "变量值");

            $form->footer()->submit("/restful/cmstemplatesvars?templateid=" . $templateid, $id);

        })->show();
    }
}