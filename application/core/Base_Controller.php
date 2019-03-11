<?php

/**
 * @Author: zuoliguang
 * @Date:   2018-08-17 15:54:58
 * @Last Modified by:   zuoliguang
 * @Last Modified time: 2018-09-22 18:34:22
 */

if (!defined('BASEPATH')) exit('No direct script access allowed');

class Base_Controller extends CI_Controller
{
	public $timestemp;

	public $microtimestemp;

	// 不需要登录验证的操作
	
	public $unLoginActions = [ "home/login", "home/doLogin", "home/logout" ];

	// 设置操作权限的路由, 该操作在控制器内设置
	
	public $rightUris; 

	function __construct()
	{
		parent::__construct();

		$this->load->helper('url');

		$this->load->library('session');

		$this->timestemp = time();
		
		$this->microtimestemp = microtime();

		$this->checkLogin(); // 检查登录状态

		$this->checkRight(); // 检查该操作权限
	}

	/**
	 * 检测用户登录状态
	 * @author zuoliguang 2018-08-20
	 * @return [type] [description]
	 */
	public function checkLogin()
	{
		$uri = $this->uri->slash_segment(1).$this->uri->segment(2);

		if (!in_array($uri, $this->unLoginActions)) {

			$admin = $this->session->tempdata(LOGIN_ADMIN_TAG);

			if (!$admin) { // 登录信息过期

				echo "<script language='JavaScript'>if (window != top) { top.location.href = '/home/login'; } else { window.location.href = '/home/login'; }</script>";exit();die();
			}
		}
	}

	/**
	 * 检查用户权限 right 字段 0只读 1读写 当管理员只读时，提示权限信息
	 * @author zuoliguang 2018-08-24
	 * @return [type] [description]
	 */
	public function checkRight()
	{

		$admin = $this->session->tempdata(LOGIN_ADMIN_TAG);

		if ($admin["right"]==0) // 只读
		{
			$uriName = $this->uri->segment(2);

			if (in_array($uriName, $this->rightUris)) 
			{
				$this->ajaxJson(403, "暂时没有操作权限");
			}
		}
	}

	/**
	 * 页面跳转
	 * @author zuoliguang 2018-08-22
	 * @param  [type] $url [description]
	 * @return [type]      [description]
	 */
	public function urlRedirect($url)
	{
		header("Location: $url");exit();die();
	}

	/**
	 * ajax 返回数据
	 * @author zuoliguang 2018-08-20
	 * @param  integer $state   状态值
	 * @param  string  $message 信息描述
	 * @param  array   $data    数据
	 * @return [type]           [description]
	 */
	public function ajaxJson($state=0, $message="操作成功", $data=[])
	{
		echo json_encode(["state"=>$state, "message"=>$message, "data"=>$data]);exit();die();
	}

	/**
	 * layui 数据表格
	 * @author zuoliguang 2018-08-27
	 * @param  integer $code  [description]
	 * @param  string  $msg   [description]
	 * @param  integer $count [description]
	 * @param  array   $data  [description]
	 * @return [type]         [description]
	 */
	public function ajaxLayuiTableDatas($code=0, $msg="", $count=0, $data=[])
	{
		echo json_encode(["code"=>$code, "msg"=>$msg, "count"=>$count, "data"=>$data]);exit();die();
	}
}