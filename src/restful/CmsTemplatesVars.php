<?php
/**
 * Created by PhpStorm.
 * User: yangyuance
 * Date: 2019/3/21
 * Time: 下午11:52
 */

namespace Yirius\AdminCms\restful;


use think\Request;
use Yirius\Admin\model\AdminRestful;

class CmsTemplatesVars extends AdminRestful
{
    /**
     * @var \Yirius\AdminCms\model\CmsTemplatesVars
     */
    protected $restfulTable = \Yirius\AdminCms\model\CmsTemplatesVars::class;

    protected $tableEditMsg = "修改Cms模板变量成功";

    protected $tableSaveMsg = "新增Cms模板变量成功";

    protected $tableCanEditField = ['status'];

    /**
     * @title index
     * @description
     * @createtime 2019/3/21 下午11:55
     * @param Request $request
     * @return mixed|void
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function index(Request $request)
    {
        $this->send(
            ($this->restfulTable)::adminList()->setWhere([
                'templateid'
            ])->getResult()
        );
    }

    /**
     * @title save
     * @description
     * @createtime 2019/3/22 上午12:01
     * @param Request $request
     * @param array $updateWhere
     * @return mixed|void
     * @throws \Exception
     */
    public function save(Request $request, $updateWhere = [])
    {
        $addData = $request->param();

        $validate = [[
            'title' => "require",
            'name' => "require|alphaDash",
//            'value' => "require",
        ], [
            'title.require' => "模板变量名称必须填写",
            'name.require' => "模板变量字段必须填写",
            'name.alphaDash' => "模板变量字段必须填写字母/数字/下划线/破折号",
//            'value.require' => "模板变量值必须填写",
        ]];

        $this->defaultSave($addData, $validate, $updateWhere);
    }

    public function read($id)
    {
        // TODO: Implement read() method.
    }

    /**
     * @title update
     * @description
     * @createtime 2019/3/22 上午12:01
     * @param $id
     * @param Request $request
     * @return mixed|void
     * @throws \Exception
     */
    public function update($id, Request $request)
    {
        if ($request->param("__type") == "field") {
            $this->defaultUpdate($id, $request->param("field"), $request->param("value"));
        } else {
            $this->save($request, [
                ['id', '=', $id]
            ]);
        }
    }

    /**
     * @title delete
     * @description
     * @createtime 2019/3/22 上午12:01
     * @param $id
     * @return mixed|void
     * @throws \think\Exception
     * @throws \think\exception\PDOException
     */
    public function delete($id)
    {
        $this->checkLoginPwd();

        $this->defaultDelete($id);
    }

    /**
     * @title deleteall
     * @description
     * @createtime 2019/3/22 上午12:01
     * @param Request $request
     * @return mixed|void
     * @throws \think\Exception
     * @throws \think\exception\PDOException
     */
    public function deleteall(Request $request)
    {
        $this->checkLoginPwd();

        $data = json_decode($request->param("data"), true);
        $deleteIds = [];
        foreach ($data as $i => $v) {
            $deleteIds[] = $v['id'];
        }
        $this->defaultDelete($deleteIds);
    }
}