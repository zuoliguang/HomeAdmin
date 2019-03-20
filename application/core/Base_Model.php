<?php

/**
 * @Author: zuoliguang
 * @Date:   2018-08-17 15:59:41
 * @Last Modified by:   zuoliguang
 * @Last Modified time: 2019-01-24 13:10:01
 */

if (!defined('BASEPATH')) exit('No direct script access allowed');

class Base_Model extends CI_Model
{
	public $timestemp;
	
	public $microtimestemp;

	public $tableName;

	public $database = null; 

	function __construct()
	{
		parent::__construct();

		$this->timestemp = time();

		$this->microtimestemp = microtime();

		$this->db_admin = $this->load->database('homeadmin', true);

		$this->db_channel = $this->load->database('channel', true);
	}

	/**
	 * 单个增加
	 * @author zuoliguang 2018-08-22
	 * @param  array  $data [description]
	 * @return [type]       [description]
	 */
	public function insert($data=[])
	{
		$this->database->insert($this->tableName, $data);

		return $this->database->insert_id();
	}

	/**
	 * 批量新增
	 * @author zuoliguang 2018-08-22
	 * @param  array  $data [description]
	 * @return [type]       [description]
	 */
	public function insert_batch($data=[])
	{
		$this->database->insert_batch($this->tableName, $data);
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
		$this->database->where($where);

		if ($flag) { // 真删除
			$this->database->delete($this->tableName);
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
		$this->database->select("*");

		$this->database->from($this->tableName);

		$this->database->where("id", $id);

		return $this->database->get()->row_array();
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
		$this->database->where($where);

        $this->database->set($data);

		$this->database->update($this->tableName);

		return $this->database->affected_rows();
	}

    /**
     * 保存数据，无增添加，有则更新
     * @author zuoliguang 2018-08-22
     * @param  array  $data  [description]
     * @param  array  $where [description]
     * @return [type]        [description]
     */
	public function save($data=[], $where=[]){

        $this->database->from($this->tableName);

        $this->database->where($where);

        $res = $this->database->get()->result_array();

        if (empty($res)) {

            return $this->insert($data);

        } else {

            return $this->update($data, $where);
        }
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
		$this->database->update_batch($this->tableName, $data, $field);

		return $this->database->affected_rows();
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
	public function all($fields="*", $where=[], $start=0, $size=20, $orderBy="id", $orderType="ASC")
	{
		$this->database->select($fields);

		$this->database->from($this->tableName);

		$this->database->where($where);

		$this->database->limit($size, $start);

		$this->database->order_by($orderBy, $orderType);

		return $this->database->get()->result_array();
	}

	/**
	 * 获取查询条件的数据量
	 * @author zuoliguang 2018-08-27
	 * @param  array  $where [description]
	 * @return [type]        [description]
	 */
	public function count($where=[])
	{
		$this->database->select("COUNT(*) AS num");

		$this->database->from($this->tableName);

		$this->database->where($where);

		$data = $this->database->get()->row_array();

		return $data['num'];
	}

	/**
	 * 宝库sql获取数据
	 * @author zuoliguang
	 */
	public function get_data_by_sql_from_baoku($sql='')
    {
         if (empty($sql)) {

             return false;
         }

        $api = "http://101.201.196.218:8055/getDataBySql";

        $data = ["sql"=>$sql];

        $res = curl_request($api, $data);

        return json_decode($res, true);
    }

    /**
     * 获取erp商品品类数据
     * @return array
     */
	public function getErpProductCategorys()
	{
		$sql = "SELECT CategoryId, CategoryId1, CategoryId2, CategoryId3, Description, DetailDescription FROM ArtProduct.dbo.Category WHERE Status = 1";

		$data = $this->get_data_by_sql_from_baoku($sql);

		$result = [];

		foreach ($data as $cat) {

			$key = $cat['CategoryId'];

			$result["$key"] = $cat;
		}

		return $result;
	}

















}