<?php

/**
 * blog 后台
 * @Author: zuoliguang
 * @Date:   2018-08-23 08:54:52
 * @Last Modified by:   zuoliguang
 * @Last Modified time: 2018-09-22 18:21:52
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class Blog extends Base_Controller {

	function __construct()
	{
		// 设置该区域的权限操作
		$this->rightUris = [ "doCreateCategory", "doUpdateCategory", "deleteCategory", "doCreateArticle", "doUpdateArticle", "deleteArticle" ];

		parent::__construct();

		$this->load->model("category_model"); // 博文分类

		$this->load->model("article_model"); // 文章

		$this->load->model("tops_model"); // 首页tops

		$this->load->model("aboutme_model"); // 关于我

		$this->load->model("friendships_model"); // 友情链接
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
		$post = $this->input->post();
		
		$page = isset($post["page"]) ? intval($post["page"]) : 1;

		$size = isset($post["limit"]) ? intval($post["limit"]) : 20; // 为0时使用默认

		$start = (intval($page) - 1 ) * intval($size);

		$where = ["is_del" => 0];

		!empty($post["title"]) && $where["title like"] = "%".$post["title"]."%"; // 模糊搜索

		!empty($post["tags"]) && $where["tags like"] = "%".$post["tags"]."%"; // 模糊搜索

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
	 * 分类页面
	 * @author zuoliguang 2018-08-27
	 * @return [type] [description]
	 */
	public function articles()
	{
		$data = [];

		$data['categoryList'] = $this->category_model->all("id,title", ["is_del" => 0], 0, 100);

		$this->load->view('blog/articles.html', $data);
	}

	/**
	 * 文章管理列表
	 * @author zuoliguang 2018-08-23
	 * @param  string $value [description]
	 */
	public function ajaxArticleList()
	{
		$post = $this->input->post();
		
		$page = isset($post["page"]) ? intval($post["page"]) : 1;

		$size = isset($post["limit"]) ? intval($post["limit"]) : 20; // 为0时使用默认

		$start = (intval($page) - 1 ) * intval($size);

		$where = ['is_del' => 0];

		!empty($post["category_id"]) && $where["category_id"] = $post["category_id"];

		!empty($post["title"]) && $where["title like"] = "%".$post["title"]."%"; // 模糊搜索

		!empty($post["tags"]) && $where["tags like"] = "%".$post["tags"]."%"; // 模糊搜索

		!empty($post["is_recommend"]) && $where["is_recommend"] = $post["is_recommend"];

		!empty($post["is_show"]) && $where["is_show"] = $post["is_show"];

		!empty($post["create_time"]) && $where["create_time <="] = strtotime($post["create_time"]); // 传来的为截止时间

		$data = $this->article_model->all("*", $where, $start, $size);

		foreach ($data as &$article) {
			
			$article["create_time"] = date("Y-m-d H:i:s", $article["create_time"]);

			$article["category"] = $this->category_model->getOneById($article["category_id"])['title'];
		}

		$count = $this->article_model->count($where);

		$this->ajaxLayuiTableDatas(0, "ok", $count, $data);
	}

	/**
	 * 创建文章页面
	 * @author zuoliguang 2018-08-24
	 * @return [type] [description]
	 */
	public function createArticle()
	{
		$data = [];

		$data['categoryList'] = $this->category_model->all("id,title", ["is_del" => 0], 0, 100);

		$this->load->view('blog/create-article.html', $data);
	}

	/**
	 * 创建文章操作
	 * @author zuoliguang 2018-08-24
	 * @return [type] [description]
	 */
	public function doCreateArticle()
	{
		$data = $this->input->post();

		// 保存字段
		$addFileds = ['category_id', 'content', 'img', 'intro', 'is_recommend', 'is_show', 'link_url', 'tags', 'title'];

		$new = [];

		foreach ($addFileds as $field) {
			
			$new[$field] = $data[$field];
		}

		$adminData = $this->session->tempdata(LOGIN_ADMIN_TAG);

		$new['author'] = $adminData['username'];

		$new['times'] = 0; // 浏览

		$new['admire'] = 0; // 赞

		$new['create_time'] = $this->timestemp;
		
		$id = $this->article_model->insert($new);

		if ($id > 0) {
			
			$this->ajaxJson(200);
		} else {

			$this->ajaxJson(1, "操作失败");
		}
	}

	/**
	 * 更新文章
	 * @author zuoliguang 2018-08-24
	 * @return [type] [description]
	 */
	public function updateArticle()
	{
		$id = $this->input->get('id');

		$data = [];

		$data['article'] = $this->article_model->getOneById($id);

		$data['categoryList'] = $this->category_model->all("id,title", ["is_del" => 0], 0, 100);

		$this->load->view('blog/update-article.html', $data);
	}

	/**
	 * 更新文章操作
	 * @author zuoliguang 2018-08-24
	 * @return [type] [description]
	 */
	public function doUpdateArticle()
	{
		$data = $this->input->post();

		// 更新字段
		$updateFileds = ['category_id', 'content', 'img', 'intro', 'is_recommend', 'is_show', 'link_url', 'tags', 'title'];

		$update = [];

		foreach ($updateFileds as $field) {
			
			$update[$field] = $data[$field];
		}

		$update['modify_time'] = $this->timestemp;

		$id = intval($data['id']);

		$res = $this->article_model->update($update, ['id'=>$id]);

		if ($res > 0) {
			
			$this->ajaxJson(200);
		} else {

			$this->ajaxJson(1, "保存失败");
		}
	}
	
	/**
	 * 删除文章
	 * @author zuoliguang 2018-08-24
	 * @return [type] [description]
	 */
	public function deleteArticle()
	{
		if (!$this->input->is_ajax_request()) 
		{
			$this->ajaxJson(0, "访问方式错误");
		}

		$id = $this->input->post("id");

		$this->article_model->delete(["id"=>intval($id)]);

		$this->ajaxJson(200);
	}

	/******************************************************/

	/**
	 * 首页顶部列表
	 * @return [type] [description]
	 */
	public function tops()
	{
		$this->load->view('blog/tops.html');
	}

	/**
	 * 首页头栏信息管理
	 * @author zuoliguang 2018-08-23
	 * @param  string $value [description]
	 * @return [type]        [description]
	 */
	public function ajaxTopList()
	{
		$post = $this->input->post();
		
		$page = isset($post["page"]) ? intval($post["page"]) : 1;

		$size = isset($post["limit"]) ? intval($post["limit"]) : 20; // 为0时使用默认

		$start = (intval($page) - 1 ) * intval($size);

		$where = ['is_del' => 0];

		!empty($post["title"]) && $where["title like"] = "%".$post["title"]."%"; // 模糊搜索

		$data = $this->tops_model->all("*", $where, $start, $size);

		foreach ($data as &$top) {
			
			$top['create_time'] = date("Y-m-d H:i:s", intval($top['create_time']));
		}

		$count = $this->tops_model->count($where);

		$this->ajaxLayuiTableDatas(0, "ok", $count, $data);
	}

	/**
	 * 新增tops
	 * @return [type] [description]
	 */
	public function doCreateTop()
	{
		$data = $this->input->post();

		$top = [];

		$top['title'] = $data['title'];

		$top['img'] = $data['img'];

		$top['create_time'] = $this->timestemp;

		$id = $this->tops_model->insert($top);

		if ($id > 0) {
			
			$this->ajaxJson(200);
		} else {

			$this->ajaxJson(1, "操作失败");
		}
	}

	/**
	 * 获取一个top信息
	 * @return [type] [description]
	 */
	public function getOneTop()
	{
		$id = $this->input->post("id");

		$data = $this->tops_model->getOneById(intval($id));

		$image = $data['img'];

		if ( @fopen($image, 'r' ) ) { // 文件的可读性
			
			$image_info = getimagesize($image);

			$data['width'] = $image_info[0];

			$data['height'] = $image_info[1];

		} else {

			$data['width'] = 0;

			$data['height'] = 0;
		}

		$this->ajaxJson(200, "获取成功", $data);
	}

	/**
	 * 更新top操作
	 * @return [type] [description]
	 */
	public function doUpdateTop()
	{
		$data = $this->input->post();

		$top = [];

		foreach ($data as $k => $v) {
			
			if (strpos($k, "update_")!==false) {
				
				$top[str_replace("update_", "", $k)] = $v;
			}
		}

		$top['modify_time'] = $this->timestemp;

		$res = $this->tops_model->update($top, ['id'=>intval($top['id'])]);

		if ($res > 0) {
			
			$this->ajaxJson(200);
		} else {

			$this->ajaxJson(1, "操作失败");
		}
	}

	/**
	 * 删除top
	 * @return [type] [description]
	 */
	public function deleteTop()
	{
		if (!$this->input->is_ajax_request()) 
		{
			$this->ajaxJson(0, "访问方式错误");
		}

		$id = $this->input->post("id");

		$this->tops_model->delete(["id"=>intval($id)]);

		$this->ajaxJson(200);
	}

	/******************************************************/

	/**
	 * 关于我 
	 * 默认使用最后一条数据
	 * @return [type] [description]
	 */
	public function aboutMe()
	{
		$this->load->view('blog/aboutme.html');
	}

	/**
	 * 获取关于我
	 * @return [type] [description]
	 */
	public function getAboutMe()
	{
		$where = ['is_del' => 0];

		$data = $this->aboutme_model->all("*", $where, 0, 1, "id", "DESC");

		$aboutme = [];

		if (!empty($data)) {
			
			$aboutme = current($data);
		}

		$this->ajaxJson(200, "ok", $aboutme);
	}

	/**
	 * 保存关于我的信息
	 * @return [type] [description]
	 */
	public function saveAboutMe()
	{
		$data = $this->input->post();

		unset($data['file']);

		$data['introduce'] = htmlspecialchars($data['introduce']);
		
		$data['is_default'] = 1;

		$result = false;

		if (empty($data['id'])) { // 创建
			
			$data['create_time'] = $this->timestemp;

			$insert_id = $this->aboutme_model->insert($data);

			if ($insert_id > 0) {
				
				$result = true;
			}

		} else { // 更新

			$id = intval($data['id']);

			unset($data['id']);

			$data['modify_time'] = $this->timestemp;

			$res = $this->aboutme_model->update($data, ['id'=>$id]);

			if ($res > 0) {
				
				$result = true;
			}
		}

		if(!$result) {
			$this->ajaxJson(-1, "保存失败");
		}

		$this->ajaxJson(200);
	}

	/******************************************************/

	/**
	 * 友情链接
	 * @return [type] [description]
	 */
	public function friendships()
	{
		$this->load->view('blog/friendships.html');
	}

	/**
	 * 友情链接地址
	 * @return [type] [description]
	 */
	public function ajaxFriendshipsList()
	{
		$post = $this->input->post();
		
		$page = isset($post["page"]) ? intval($post["page"]) : 1;

		$size = isset($post["limit"]) ? intval($post["limit"]) : 20; // 为0时使用默认

		$start = (intval($page) - 1 ) * intval($size);

		$where = ['is_del' => 0];

		!empty($post["title"]) && $where["title like"] = "%".$post["title"]."%"; // 模糊搜索

		!empty($post["friendsship_link"]) && $where["friendsship_link like"] = "%".$post["friendsship_link"]."%"; // 模糊搜索

		$data = $this->friendships_model->all("*", $where, $start, $size);

		$count = $this->friendships_model->count($where);

		$this->ajaxLayuiTableDatas(0, "ok", $count, $data);
	}

	/**
	 * 新增链接
	 * @return [type] [description]
	 */
	public function insertFriendships()
	{
		$data = $this->input->post();

		$friendships = [];

		$friendships['title'] = $data['title'];

		$friendships['pic'] = $data['pic'];

		$friendships['friendsship_link'] = $data['friendsship_link'];

		$friendships['is_del'] = 0;

		$friendships['create_time'] = $this->timestemp;

		$id = $this->friendships_model->insert($friendships);

		if ($id > 0) {
			
			$this->ajaxJson(200);
		} else {

			$this->ajaxJson(1, "操作失败");
		}
	}

	/**
	 * 获取链接
	 * @return [type] [description]
	 */
	public function getOneFriendships()
	{
		$id = $this->input->post("id");

		$data = $this->friendships_model->getOneById(intval($id));

		$this->ajaxJson(200, "获取成功", $data);
	}

	/**
	 * 更新链接
	 * @return [type] [description]
	 */
	public function updateFriendships()
	{
		$data = $this->input->post();

		$friendships = [];

		foreach ($data as $k => $v) {
			
			if (strpos($k, "update_")!==false) {
				
				$friendships[str_replace("update_", "", $k)] = $v;
			}
		}

		$friendships['modify_time'] = $this->timestemp;

		$res = $this->friendships_model->update($friendships, ['id'=>intval($friendships['id'])]);

		if ($res > 0) {
			
			$this->ajaxJson(200);
		} else {

			$this->ajaxJson(1, "操作失败");
		}
	}

	/**
	 * 删除链接
	 * @return [type] [description]
	 */
	public function deleteFriendships()
	{
		if (!$this->input->is_ajax_request()) 
		{
			$this->ajaxJson(0, "访问方式错误");
		}

		$id = $this->input->post("id");

		$this->friendships_model->delete(["id"=>intval($id)]);

		$this->ajaxJson(200);
	}

	/******************************************************/

	/**
	 * 博客数据中心
	 * @return [type] [description]
	 */
	public function dataCenter()
	{
		echo "博客数据中心";
	}
}