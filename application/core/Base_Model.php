<?php

/**
 * @Author: zuoliguang
 * @Date:   2018-08-17 15:59:41
 * @Last Modified by:   zuoliguang
 * @Last Modified time: 2018-08-23 08:36:19
 */

if (!defined('BASEPATH')) exit('No direct script access allowed');

class Base_Model extends CI_Model
{
	public $timestemp;
	
	public $microtimestemp;

	public $pageSize = 20;

	public $tableName;

	function __construct()
	{
		parent::__construct();

		$this->timestemp = time();

		$this->microtimestemp = microtime();

		$this->bd_admin = $this->load->database('homeadmin', true);
	}

	/**
	 * 单个增加
	 * @author zuoliguang 2018-08-22
	 * @param  array  $data [description]
	 * @return [type]       [description]
	 */
	public function insert($data=[])
	{
		$this->bd_admin->insert($this->tableName, $data);

		return $this->bd_admin->insert_id();
	}

	/**
	 * 批量新增
	 * @author zuoliguang 2018-08-22
	 * @param  array  $data [description]
	 * @return [type]       [description]
	 */
	public function insert_batch($data=[])
	{
		$this->bd_admin->insert_batch($this->tableName, $data);
	}

	/**
	 * 删除数据
	 * @author zuoliguang 2018-08-22
	 * @param  [type]  $where [description]
	 * @param  boolean $flag  [description]
	 * @return [type]         [description]
	 */
	public function delete($where, $flag=false)
	{
		$this->bd_admin->where($where);

		if ($flag) { // 真删除
			$this->bd_admin->delete($this->tableName);
		} else { // 软删除
			return $this->update(["is_del" => 1], $where);
		}
	}

	/**
	 * 依据主键获取数据
	 * @author zuoliguang 2018-08-22
	 * @param  [type] $id [description]
	 * @return [type]     [description]
	 */
	public function getOneById($id)
	{
		$this->bd_admin->select("*");

		$this->bd_admin->from($this->tableName);

		$this->bd_admin->where("id", $id);

		return $this->bd_admin->get()->row_array();
	}

	/**
	 * 更新数据
	 * @author zuoliguang 2018-08-22
	 * @param  array  $data  [description]
	 * @param  array  $where [description]
	 * @return [type]        [description]
	 */
	public function update($data=[], $where=[])
	{
		$this->bd_admin->where($where);

		$this->bd_admin->update($this->tableName, $data);

		return $this->bd_admin->affected_rows();
	}

	/**
	 * 批量更新
	 * @author zuoliguang 2018-08-22
	 * @param  array  $data  [description]
	 * @param  string $field [description]
	 * @return [type]        [description]
	 */
	public function update_batch($data=[], $field="")
	{
		$this->bd_admin->update_batch($this->tableName, $data, $field);

		return $this->bd_admin->affected_rows();
	}

	/**
	 * 获取条件查询数据
	 * @author zuoliguang 2018-08-22
	 * @param  string  $fields    [description]
	 * @param  array   $where     [description]
	 * @param  integer $start     [description]
	 * @param  integer $size      [description]
	 * @param  string  $orderBy   [description]
	 * @param  string  $orderType [description]
	 * @return [type]             [description]
	 */
	public function all($fields="*", $where=[], $start=0, $size=0, $orderBy="id", $orderType="ASC")
	{
		$size = ($size==0) ? $this->pageSize : $size;

		$this->bd_admin->select($fields);

		$this->bd_admin->from($this->tableName);

		$this->bd_admin->where($where);

		$this->bd_admin->limit($size, $start);

		$this->bd_admin->order_by($orderBy, $orderType);

		return $this->bd_admin->get()->result_array();
	}


}