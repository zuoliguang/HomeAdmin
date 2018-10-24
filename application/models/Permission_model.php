<?php

/**
 * 权限管理
 * @Author: zuoliguang
 * @Date:   2018-08-23 14:24:24
 * @Last Modified by:   zuoliguang
 * @Last Modified time: 2018-08-27 13:49:47
 */
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Permission_model extends Base_Model
{
	function __construct()
	{
		parent::__construct();

		$this->database = $this->bd_admin;

		$this->tableName = "permission";
	}

	/**
	 * 获取所有admin_id下的权限
	 * @author zuoliguang 2018-08-23
	 * @param  [type] $admin_id [description]
	 * @return [type]           [description]
	 */
	public function getPermissionByaid($admin_id)
	{
		$this->bd_admin->select("*");

		$this->bd_admin->from($this->tableName);

		$this->bd_admin->where("admin_id", $admin_id);

		return $this->bd_admin->get()->result_array();
	}

}