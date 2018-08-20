<?php

/**
 * @Author: zuoliguang
 * @Date:   2018-08-17 16:51:08
 * @Last Modified by:   zuoliguang
 * @Last Modified time: 2018-08-20 16:28:50
 */
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Admin_model extends Base_Model
{
	public $tableName = "admin";

	function __construct()
	{
		parent::__construct();
	}

	public function getAdminById($id)
	{
		$this->bd_admin->select("*");

		$this->bd_admin->from($this->tableName);

		$this->bd_admin->where("id", $id);

		return $this->bd_admin->get()->row_array();
	}

	public function getAdminByName($name)
	{
		$this->bd_admin->select("*");

		$this->bd_admin->from($this->tableName);

		$this->bd_admin->where("username", $name);

		return $this->bd_admin->get()->row_array();
	}

	public function getAdminsByTelphone($telphone)
	{
		$this->bd_admin->select("*");

		$this->bd_admin->from($this->tableName);

		$this->bd_admin->where("telphone", $telphone);

		return $this->bd_admin->get()->result_array();
	}

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

	public function update($data=[], $where=[])
	{
		$this->bd_admin->where($where);

		$this->bd_admin->update($this->tableName, $data);

		return $this->bd_admin->affected_rows();
	}
}