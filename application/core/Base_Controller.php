<?php

/**
 * @Author: zuoliguang
 * @Date:   2018-08-17 15:54:58
 * @Last Modified by:   zuoliguang
 * @Last Modified time: 2018-08-21 11:05:45
 */

if (!defined('BASEPATH')) exit('No direct script access allowed');

class Base_Controller extends CI_Controller
{
	public $timestemp;

	public $microtimestemp;

	public $unLoginActions = [ // 不需要登录验证的操作
		"home/login",
		"home/doLogin",
		"home/logout"
	];

	function __construct()
	{
		parent::__construct();

		$this->load->helper('url');

		$this->load->library('session');

		$this->timestemp = time();
		
		$this->microtimestemp = microtime();

		$this->checkLogin();
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

			$adminData = $this->session->tempdata(LOGIN_ADMIN_TAG);

			if (!$adminData) {

				$this->load->view('home/signout/login.html');
			}
		}
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
		echo json_encode(["state"=>$state, "message"=>$message, "data"=>$data]);
		exit();die();
	}

	/**
	 * gridmanager 表格插件数据
	 * @author zuoliguang 2018-08-21
	 * @param  integer $totals 数据总量
	 * @param  array   $data   数据
	 * @param  string  $status 信息
	 * @return [type]          [description]
	 */
	public function gridmanagerAjaxJson($totals=0, $data=[], $status="success")
	{
		echo json_encode(["totals"=>$totals, "status"=>$status, "data"=>$data]);
		exit();die();
	}
}