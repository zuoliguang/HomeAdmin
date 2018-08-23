<?php

/**
 * 基础后台页面
 * @Author: zuoliguang
 * @Date:   2018-08-17 16:02:52
 * @Last Modified by:   zuoliguang
 * @Last Modified time: 2018-08-23 10:52:05
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends Base_Controller
{
	public $typeDict = [
		"0" => "超级管理员",
		"1" => "普通管理员"
	];

	public $rightDict = [
		"0" => "只读",
		"1" => "读写"
	];

	public $sexDict = [
		"0" => "未知",
		"1" => "男",
		"2" => "女"
	];

	function __construct()
	{
		parent::__construct();
		$this->load->model("admin_model");
		$this->load->model("catalog_model");
	}

	/**
	 * 登录界面
	 * @author zuoliguang 2018-08-17
	 * @return [type] [description]
	 */
	public function login()
	{
		$this->load->view('signout/login.html');
	}

	/**
	 * 登录操作
	 * @author zuoliguang 2018-08-17
	 * @return [type] [description]
	 */
	public function doLogin()
	{
		if (!$this->input->is_ajax_request()) {
			$this->ajaxJson(0, "访问方式错误");
		}

		$username = $this->input->post("username");

		$password = $this->input->post("password");

		if (empty($username)) {
			$this->ajaxJson(1, "账号不能为空");
		}

		if (empty($password)) {
			$this->ajaxJson(2, "密码不能为空");
		}

		// password_hash 验证密码 
		$admin = $this->admin_model->getAdminByName($username);

		if (empty($admin)) {
			$this->ajaxJson(3, "未找到该用户信息");
		}

		$hash_pass = $admin["password"];

		if (!password_verify($password, $hash_pass)) {
			$this->ajaxJson(4, "密码错误");
		}

		// 验证通过 seesion 1 小时
		
		$tempAdminData = [
			"adminId" 	=> $admin["id"],
			"username" 	=> $admin["username"],
			"icon" 		=> $admin["icon"] ? $admin["icon"] : DEFAULT_ICON,
			"type" 		=> $admin["type"],
			"right" 	=> $admin["right"],
			"time" 		=> $this->timestemp
		];

		$this->session->set_tempdata([LOGIN_ADMIN_TAG => $tempAdminData], NULL, 60*60); // 有效时间1小时

		$this->admin_model->loginAdmin();

		$this->ajaxJson(200, "登录成功");
	}

	/**
	 * 退出系统
	 * @author zuoliguang 2018-08-20
	 * @return [type] [description]
	 */
	public function logout()
	{
		$this->session->sess_destroy();

		$this->load->view('signout/login.html');
	}

	/**
	 * 系统首页
	 * @author zuoliguang 2018-08-17
	 * @return [type] [description]
	 */
	public function index()
	{
		$adminData = $this->session->tempdata(LOGIN_ADMIN_TAG);

		if (!$adminData) {

			$this->urlRedirect("/home/login");
		} else {

			$catalogs = $this->catalog_model->getTreeList();

			$data = [ "admin" => $adminData, "catalogs" => $catalogs];

			$this->load->view('public/main.html', $data);
		}
	}

	/**
	 * 更新账号信息
	 * @author zuoliguang 2018-08-20
	 * @return [type] [description]
	 */
	public function updateAdmin()
	{
		$loginfo = $this->session->tempdata(LOGIN_ADMIN_TAG);

		$admin = $this->admin_model->getOneById($loginfo["adminId"]);

		$admin["type"] = $this->typeDict[$admin["type"]];

		$admin["right"] = $this->rightDict[$admin["right"]];

		$this->load->view('admin/update_admin.html', $admin);
	}

	public function doUpdateAdmin()
	{
		if (!$this->input->is_ajax_request()) {
			$this->ajaxJson(0, "访问方式错误");
		}

		$postData = $this->input->post();
		
		unset($postData["type"]);

		unset($postData["right"]);

		$id = intval($postData["id"]);

		if (!$id) {
			$this->ajaxJson(1, "数据错误");
		}

		$res = $this->admin_model->update($postData, ["id"=>$id]);

		if ($res > 0) {
			$this->ajaxJson(200, "修改成功");
		} else {
			$this->ajaxJson(2, "修改失败");
		}
	}

	/**
	 * 更新密码
	 * @author zuoliguang 2018-08-20
	 * @return [type] [description]
	 */
	public function updatePassword()
	{
		$this->load->view('admin/update_password.html');
	}

	/**
	 * 更新密码操作
	 * @author zuoliguang 2018-08-20
	 * @param  string $value [description]
	 * @return [type]        [description]
	 */
	public function doUpdatePassword()
	{
		if (!$this->input->is_ajax_request()) {
			$this->ajaxJson(0, "访问方式错误!");
		}

		$postData = $this->input->post();

		$password = $postData['password'];

		$newpassword = $postData['newpassword'];

		$renewpassword = $postData['renewpassword'];

		if (empty($password) || empty($newpassword) || empty($renewpassword)) {
			$this->ajaxJson(1, "参数不能为空!");
		}

		if ($newpassword !== $renewpassword) {
			$this->ajaxJson(2, "确认新密码不正确!");
		}

		if ($password == $newpassword) {
			$this->ajaxJson(3, "新旧密码相同!");
		}

		$loginfo = $this->session->tempdata(LOGIN_ADMIN_TAG);

		$admin = $this->admin_model->getOneById($loginfo["adminId"]);

		if (empty($admin)) {
			$this->ajaxJson(4, "未找到该用户信息");
		}

		$hash_pass = $admin["password"];

		if (!password_verify($password, $hash_pass)) {
			$this->ajaxJson(5, "旧密码验证错误");
		}

		// 更新密码
		
		$new_hash = password_hash($newpassword, PASSWORD_DEFAULT);

		$update = [ "password" => $new_hash ];

		$where = ["id" => intval($admin["id"])];

		$res = $this->admin_model->update($update, $where);

		if ($res > 0) {
			$this->ajaxJson(200, "密码更新成功");
		} else {
			$this->ajaxJson(6, "更新失败");
		}
	}

	/**
	 * 管理员管理列表
	 * @author zuoliguang 2018-08-17
	 * @return [type] [description]
	 */
	public function adminList()
	{
		$this->load->view('admin/admin_list.html');
	}

	/**
	 * ajax获取管理员列表
	 * @author zuoliguang 2018-08-21
	 * @return [type] [description]
	 */
	public function ajaxAdminListJson()
	{
		$post = $this->input->post();

		$page = isset($post["cPage"]) ? intval($post["cPage"]) : 1;

		$size = isset($post["pSize"]) ? intval($post["pSize"]) : 0; // 为0时使用默认

		$start = (intval($page) - 1) * intval($size);

		$fields = "id, username, icon, telphone, email, web, sex, type, right, FROM_UNIXTIME(last_login_time, '%Y-%m-%d %H:%i') AS last_login_time";

		$where = []; // 搜索条件

		!empty($post["username"]) && $where["username like"] = "%".$post["username"]."%"; // 模糊搜索

		!empty($post["telphone"]) && $where["telphone"] = $post["telphone"];

		!empty($post["email"]) && $where["email"] = $post["email"];

		$data = $this->admin_model->all($fields, $where, $start, intval($size));

		foreach ($data as &$admin) {

			$admin["icon"] = empty($admin["icon"]) ? DEFAULT_ICON : $admin["icon"];

			$admin["sex"] = $this->sexDict[$admin["sex"]];

			$admin["type"] = $this->typeDict[$admin["type"]];

			$admin["right"] = $this->rightDict[$admin["right"]];
		}

		$this->gridmanagerAjaxJson(count($data), $data);
	}

	/**
	 * 菜单目录列表
	 * @author zuoliguang 2018-08-17
	 * @return [type] [description]
	 */
	public function catalogList()
	{
		$jsonTree = $this->catalog_model->getLayuiTree();

		$treeList = $this->catalog_model->getTreeList();

		$data = ["catalogs" => $treeList];

		$this->load->view('admin/catalog_list.html', $data);
	}

	/**
	 * 获取LayuiTree的菜单list
	 * @author zuoliguang 2018-08-23
	 * @return [type] [description]
	 */
	public function ajaxCatalogLayuiTreeList()
	{
		if (!$this->input->is_ajax_request()) {
			$this->ajaxJson(0, "访问方式错误!");
		}

		$treeList = $this->catalog_model->getLayuiTree();

		$this->ajaxJson(200, "ok!", $treeList);
	}

	/**
	 * 获取一个菜单信息
	 * @author zuoliguang 2018-08-22
	 * @return [type] [description]
	 */
	public function getOneCatalog()
	{
		if (!$this->input->is_ajax_request()) {
			$this->ajaxJson(0, "访问方式错误!");
		}

		$id = $this->input->post("id");

		if (intval($id) == 0) {
			$this->ajaxJson(1, "参数错误!");
		}

		$data = $this->catalog_model->getOneById($id);

		if (empty($data)) {
			$this->ajaxJson(2, "未找到该菜单信息!");
		}

		$this->ajaxJson(200, "ok", $data);
	}

	/**
	 * 删除菜单
	 * @author zuoliguang 2018-08-22
	 * @return [type] [description]
	 */
	public function deleteCatalog()
	{
		if (!$this->input->is_ajax_request()) {
			$this->ajaxJson(0, "访问方式错误!");
		}

		$id = $this->input->post("id");

		if (intval($id) == 0) {
			$this->ajaxJson(1, "参数错误!");
		}

		$res = $this->catalog_model->delete(["id" => $id]);

		if ($res > 0) {
			$this->ajaxJson(200);
		} else {
			$this->ajaxJson(2, "执行失败!");
		}
	}

	/**
	 * 对菜单信息新增、更新
	 * @author zuoliguang 2018-08-22
	 * @return [type] [description]
	 */
	public function doCatalog()
	{
		if (!$this->input->is_ajax_request()) {
			$this->ajaxJson(0, "访问方式错误!");
		}

		$data = $this->input->post();

		$act = $data["act"];

		unset($data["act"]);

		$res = 0;

		if ($act == "create") { // 新增 

			unset($data["id"]);

			$data["create_time"] = $this->timestemp;

			$res = $this->catalog_model->insert($data);

		} elseif ($act == "update") { // 更新

			$id = intval($data["id"]);

			unset($data["id"]);

			$data["modify_time"] = $this->timestemp;

			$where = ["id" => $id];

			$res = $this->catalog_model->update($data, $where);
		} else {
			$this->ajaxJson(1, "数据错误");
		}

		if ($res > 0) {
			$this->ajaxJson(200);
		} else {
			$this->ajaxJson(2, "操作失败");
		}
	}

	/**
	 * 管理员目录权限分配
	 * @author zuoliguang 2018-08-17
	 * @return [type] [description]
	 */
	public function permission()
	{
		echo "授权中心";
	}

	/**
	 * 分析系统各部分数据的展示
	 * @author zuoliguang 2018-08-17
	 * @param  string $value [description]
	 * @return [type]        [description]
	 */
	public function dataCenter()
	{
		echo "数据中心欢迎页";
	}

}