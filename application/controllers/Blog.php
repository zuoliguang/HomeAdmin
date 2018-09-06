<?php

/**
 * blog 后台
 * @Author: zuoliguang
 * @Date:   2018-08-23 08:54:52
 * @Last Modified by:   zuoliguang
 * @Last Modified time: 2018-09-06 16:01:49
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class Blog extends Base_Controller {

	function __construct()
	{
		// 设置该区域的权限操作
		$this->rightUris = [ "doCreateCategory", "doUpdateCategory", "deleteCategory", "doCreateArticle", "doUpdateArticle", "deleteArticle" ];

		parent::__construct();

		$this->load->model("category_model");
	}

	/**
	 * 分类页面
	 * @author zuoliguang 2018-08-27
	 * @return [type] [description]
	 */
	public function category()
	{
		$this->load->view('blog/category.html');
	}

	/**
	 * 获取文章分类信息
	 * @author zuoliguang 2018-08-24
	 * @return [type] [description]
	 */
	public function ajaxCategoryList()
	{
		$page = $this->input->get("page");

		$size = $this->input->get("limit");

		$start = (intval($page) - 1 ) * intval($size);

		$where = ["is_del"=>0];

		$data = $this->category_model->all("*", $where, $start, $size);

		foreach ($data as &$category) {
			
			$category["create_time"] = date("Y-m-d H:i:s", $category["create_time"]);
		}

		$count = $this->category_model->count($where);

		$this->ajaxLayuiTableDatas(0, "ok", $count, $data);
		
	}

	/**
	 * 新增文章分类
	 * @author zuoliguang 2018-08-24
	 * @return [type] [description]
	 */
	public function doCreateCategory()
	{
		if (!$this->input->is_ajax_request()) 
		{
			$this->ajaxJson(0, "访问方式错误");
		}

		$title = $this->input->post("title");

		$tags = $this->input->post("tags");

		$data = [

			"title" => $title,

			"tags" => $tags,

			"create_time" => $this->timestemp
		];

		$res = $this->category_model->insert($data);

		if ($res > 0) 
		{
			$this->ajaxJson(200);

		} else {
			$this->ajaxJson(1, "添加失败");
		}
	}

	/**
	 * 获取一个文章分类
	 * @author zuoliguang 2018-08-24
	 * @return [type] [description]
	 */
	public function getOneCategory()
	{
		if (!$this->input->is_ajax_request()) 
		{
			$this->ajaxJson(0, "访问方式错误");
		}

		$id = $this->input->post("id");

		$data = $this->category_model->getOneById($id);

		$this->ajaxJson(200, "获取成功", $data);
	}

	/**
	 * 更新文章分类
	 * @author zuoliguang 2018-08-24
	 * @return [type] [description]
	 */
	public function doUpdateCategory()
	{
		if (!$this->input->is_ajax_request()) 
		{
			$this->ajaxJson(0, "访问方式错误");
		}

		$id = $this->input->post("update_id");

		$title = $this->input->post("update_title");

		$tags = $this->input->post("update_tags");

		$data = [

			"title" => $title,

			"tags" => $tags,

			"modify_time" => $this->timestemp
		];

		$res = $this->category_model->update($data, ["id"=>intval($id)]);

		if ($res > 0) 
		{
			$this->ajaxJson(200);

		} else {
			$this->ajaxJson(1, "操作失败");
		}
	}

	/**
	 * 删除文章分类
	 * @author zuoliguang 2018-08-24
	 * @return [type] [description]
	 */
	public function deleteCategory()
	{
		if (!$this->input->is_ajax_request()) 
		{
			$this->ajaxJson(0, "访问方式错误");
		}

		$id = $this->input->post("id");

		$this->category_model->delete(["id"=>intval($id)]);

		$this->ajaxJson(200);
	}

	/******************************************************/

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

	/******************************************************/

	/**
	 * 首页头栏信息管理
	 * @author zuoliguang 2018-08-23
	 * @param  string $value [description]
	 * @return [type]        [description]
	 */
	public function ajaxTopList()
	{
		# code...
	}

	public function doCreateTop()
	{
		# code...
	}

	public function doUpdateTop()
	{
		# code...
	}

	public function deleteTop()
	{
		# code...
	}

	/******************************************************/

	public function aboutMe()
	{
		# code...
	}
}