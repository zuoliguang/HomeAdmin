<?php

/**
 * @Author: zuoliguang
 * @Date:   2018-08-17 16:02:52
 * @Last Modified by:   zuoliguang
 * @Last Modified time: 2018-08-17 17:36:21
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends Base_Controller
{
	function __construct()
	{
		parent::__construct();
	}

	/**
	 * 登录界面
	 * @author zuoliguang 2018-08-17
	 * @return [type] [description]
	 */
	public function login()
	{
		echo "login";
	}

	/**
	 * 登录操作
	 * @author zuoliguang 2018-08-17
	 * @return [type] [description]
	 */
	public function doLogin()
	{
		echo "doLogin";
	}

	/**
	 * 系统首页
	 * @author zuoliguang 2018-08-17
	 * @return [type] [description]
	 */
	public function index()
	{
		echo "index";
	}

	/**
	 * 分析系统各部分数据的展示
	 * @author zuoliguang 2018-08-17
	 * @param  string $value [description]
	 * @return [type]        [description]
	 */
	public function dataCenter()
	{
		echo "dataCenter";
	}

	/**
	 * 管理员管理列表
	 * @author zuoliguang 2018-08-17
	 * @return [type] [description]
	 */
	public function adminList()
	{
		echo "adminList";
	}

	/**
	 * 菜单目录列表
	 * @author zuoliguang 2018-08-17
	 * @return [type] [description]
	 */
	public function catalogList()
	{
		echo "catalogList";
	}

	/**
	 * 管理员目录权限分配
	 * @author zuoliguang 2018-08-17
	 * @return [type] [description]
	 */
	public function permission()
	{
		echo "permission";
	}

}