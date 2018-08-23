<?php

/**
 * @Author: zuoliguang
 * @Date:   2018-08-17 16:51:08
 * @Last Modified by:   zuoliguang
 * @Last Modified time: 2018-08-23 13:24:43
 */
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Admin_model extends Base_Model
{
	function __construct()
	{
		parent::__construct();

		$this->tableName = "admin";
	}

	/**
	 * 获取一个符合账户名称的管理员
	 * @author zuoliguang 2018-08-23
	 * @param  [type] $name [description]
	 * @return [type]       [description]
	 */
	public function getAdminByName($name)
	{
		$this->bd_admin->select("*");

		$this->bd_admin->from($this->tableName);

		$this->bd_admin->where("username", $name);

		return $this->bd_admin->get()->row_array();
	}

	/**
	 * 依据手机号获取管理员信息
	 * @author zuoliguang 2018-08-23
	 * @param  [type] $telphone [description]
	 * @return [type]           [description]
	 */
	public function getAdminsByTelphone($telphone)
	{
		$this->bd_admin->select("*");

		$this->bd_admin->from($this->tableName);

		$this->bd_admin->where("telphone", $telphone);

		return $this->bd_admin->get()->result_array();
	}

	/**
	 * 登录打点
	 * @author zuoliguang 2018-08-23
	 * @return [type] [description]
	 */
	public function loginAdmin()
	{
		$admin = $this->session->tempdata(LOGIN_ADMIN_TAG);

		if (!$admin) {
			return false;
		}

		$this->bd_admin->where("id", $admin["adminId"]);

		$this->bd_admin->update($this->tableName, ["last_login_time" => $this->timestemp]);
		
		return $this->bd_admin->affected_rows();
	}

	/**
	 * 一次获取所有的管理员列表
	 * @author zuoliguang 2018-08-23
	 * @return [type] [description]
	 */
	public function allAdmins()
	{
		$this->bd_admin->select("*");

		$this->bd_admin->from($this->tableName);

		return $this->bd_admin->get()->result_array();
	}
}