<?php

/**
 * @Author: zuoliguang
 * @Date:   2018-08-17 15:54:58
 * @Last Modified by:   zuoliguang
 * @Last Modified time: 2018-08-20 16:24:55
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
	 * @param  integer $state   [description]
	 * @param  string  $message [description]
	 * @param  array   $data    [description]
	 * @return [type]           [description]
	 */
	public function ajaxJson($state=0, $message="", $data=[])
	{
		echo json_encode(["state"=>$state, "message"=>$message, "data"=>$data]);
		exit();
	}
}