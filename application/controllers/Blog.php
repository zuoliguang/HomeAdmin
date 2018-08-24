<?php

/**
 * blog 后台
 * @Author: zuoliguang
 * @Date:   2018-08-23 08:54:52
 * @Last Modified by:   zuoliguang
 * @Last Modified time: 2018-08-24 09:58:53
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class Blog extends Base_Controller {

	function __construct()
	{
		// 设置该区域的权限操作
		$this->rightUris = [ "doCreateCategory", "doUpdateCategory", "deleteCategory", "doCreateArticle", "doUpdateArticle" ];

		parent::__construct();
	}

	/**
	 * 获取文章分类信息
	 * @author zuoliguang 2018-08-24
	 * @return [type] [description]
	 */
	public function ajaxCategoryList()
	{
		# code...
	}

	/**
	 * 新增文章分类
	 * @author zuoliguang 2018-08-24
	 * @return [type] [description]
	 */
	public function doCreateCategory()
	{
		# code...
	}

	/**
	 * 获取一个文章分类
	 * @author zuoliguang 2018-08-24
	 * @return [type] [description]
	 */
	public function getOneCategory()
	{
		# code...
	}

	/**
	 * 更新文章分类
	 * @author zuoliguang 2018-08-24
	 * @return [type] [description]
	 */
	public function doUpdateCategory()
	{
		# code...
	}

	/**
	 * 删除文章分类
	 * @author zuoliguang 2018-08-24
	 * @return [type] [description]
	 */
	public function deleteCategory()
	{
		# code...
	}

	/**
	 * 文章管理列表
	 * @author zuoliguang 2018-08-23
	 * @param  string $value [description]
	 */
	public function ajaxArticleList()
	{
		# code...
	}

	/**
	 * 创建文章页面
	 * @author zuoliguang 2018-08-24
	 * @return [type] [description]
	 */
	public function createArticle()
	{
		# code...
	}

	/**
	 * 创建文章操作
	 * @author zuoliguang 2018-08-24
	 * @return [type] [description]
	 */
	public function doCreateArticle()
	{
		# code...
	}

	/**
	 * 更新文章
	 * @author zuoliguang 2018-08-24
	 * @return [type] [description]
	 */
	public function updateArticle()
	{
		# code...
	}

	/**
	 * 更新文章操作
	 * @author zuoliguang 2018-08-24
	 * @return [type] [description]
	 */
	public function doUpdateArticle()
	{
		# code...
	}
	
	/**
	 * 删除文章
	 * @author zuoliguang 2018-08-24
	 * @return [type] [description]
	 */
	public function deleteArticle()
	{
		# code...
	}

	/*----------------------------------------------------------------------*/

	/**
	 * 首页头信息
	 * @author zuoliguang 2018-08-23
	 * @param  string $value [description]
	 * @return [type]        [description]
	 */
	public function topList($value='')
	{
		# code...
	}
}