<?php
/**
 * Created by PhpStorm.
 * User: yangyuance
 * Date: 2019/3/21
 * Time: 下午11:05
 */

define("THINKER_CMS_ROOT", __DIR__);

//Cms's Controller
\think\facade\Route::alias("thinkercms", "\\Yirius\\AdminCms\\controller\\Cms", ['deny_ext' => 'php|.htacess']);

//加入widget
\Yirius\Admin\Admin::addWidgets("cms", \Yirius\AdminCms\widgets\Cms::class);

//cms restful api
\think\facade\Route::resource("restful/cms", "\\Yirius\\AdminCms\\restful\\Cms");
\think\facade\Route::resource("restful/cmsmodels", "\\Yirius\\AdminCms\\restful\\CmsModels");
\think\facade\Route::resource("restful/cmscolumns", "\\Yirius\\AdminCms\\restful\\CmsColumns");
\think\facade\Route::resource("restful/cmsmodelsfield", "\\Yirius\\AdminCms\\restful\\CmsModelsField");
//附属表 restful api
\think\facade\Route::resource("restful/cmsguestbook", "\\Yirius\\AdminCms\\restful\\CmsGuestbook");
\think\facade\Route::resource("restful/cmsguestbookattr", "\\Yirius\\AdminCms\\restful\\CmsGuestbookAttr");
\think\facade\Route::resource("restful/cmsproduct", "\\Yirius\\AdminCms\\restful\\CmsProduct");
\think\facade\Route::resource("restful/cmsproductattr", "\\Yirius\\AdminCms\\restful\\CmsProductAttr");
//模板表
\think\facade\Route::resource("restful/cmstemplates", "\\Yirius\\AdminCms\\restful\\CmsTemplates");
\think\facade\Route::resource("restful/cmstemplatesvars", "\\Yirius\\AdminCms\\restful\\CmsTemplatesVars");

//便捷访问
\think\facade\Route::get("article_:id", "Index/Article");
\think\facade\Route::get("download_:id", "Index/Download");
\think\facade\Route::get("product_:id", "Index/Product");
\think\facade\Route::get("guestbook_:id", "Index/Guestbook");
\think\facade\Route::get("single_:id", "Index/Single");
\think\facade\Route::get("images_:id", "Index/Images");