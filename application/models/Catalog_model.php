<?php

/**
 * @Author: zuoliguang
 * @Date:   2018-08-17 16:51:08
 * @Last Modified by:   zuoliguang
 * @Last Modified time: 2018-08-27 13:50:07
 */
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Catalog_model extends Base_Model
{
	function __construct()
	{
		parent::__construct();

		$this->database = $this->db_admin;

		$this->tableName = "catalog";
	}

	/**
	 * 获取菜单信息源数据
	 * @author zuoliguang 2018-08-23
	 * @return [type] [description]
	 */
	public function getAllCatalogs()
	{
		$fields = "id, pid, title, icon, url, sort";

		$where = ["is_del" => 0];

		$this->db_admin->select($fields);

		$this->db_admin->from($this->tableName);

		$this->db_admin->where($where);

		$this->db_admin->order_by("pid", "ASC");
		
		$this->db_admin->order_by("sort", "ASC");

		return $this->db_admin->get()->result_array();
	}

	/**
	 * 获取普通管理员菜单
	 * @author zuoliguang 2018-08-23
	 * @param  [type] $admin_id [description]
	 * @return [type]           [description]
	 */
	public function getAidCatalogs($admin_id)
	{
		$sql = "SELECT c.* FROM `ha_catalog` AS c LEFT JOIN `ha_permission` AS p ON p.catalog_id = c.id WHERE p.admin_id = $admin_id ORDER BY c.pid asc, c.sort asc";

		$data = $this->db_admin->query($sql)->result_array();

		$ids = [0];

		array_walk($data, function($item, $k) use (&$ids){

			if (!in_array($item["id"], $ids)) 
			{
				$ids[] = intval($item["id"]);
			}
			if (!in_array($item["pid"], $ids)) 
			{
				$ids[] = intval($item["pid"]);
			}
		});

		$fields = "id, pid, title, icon, url, sort";

		$where = ["is_del" => 0, ];

		$this->db_admin->select($fields);

		$this->db_admin->from($this->tableName);

		$this->db_admin->where($where);

		$this->db_admin->where_in("id", $ids);

		$this->db_admin->order_by("pid", "ASC");
		
		$this->db_admin->order_by("sort", "ASC");

		return $this->db_admin->get()->result_array();
	}

	/**
	 * 获取所有菜单树 两级菜单
	 * @author zuoliguang 2018-08-22
	 * @return [type] [description]
	 */
	public function getTreeList()
	{
		$data = $this->getAllCatalogs();

		$kvd = [];

		foreach ($data as $item) {

			$kvd[$item["id"]] = $item;
		}

		$treeList = [];

		foreach ($data as $catalog) {
			
			if (intval($catalog["pid"])==0) {
				
				$treeList[$catalog["id"]] = $catalog;

			} else {

				if (isset($treeList[$catalog["pid"]])) {

					$treeList[$catalog["pid"]]["items"][] = $catalog;
				}
			}
		}

		return $treeList;
	}

	/**
	 * 两级菜单
	 * 获取页面支持前端json格式的菜单树
	 * @author zuoliguang 2018-08-23
	 * @return [type] [description]
	 */
	public function getLayuiTree()
	{
		$data = $this->getAllCatalogs();

		$kvd = [];

		foreach ($data as $item) {

			$kvd[$item["id"]] = $item;
		}

		$treeList = [];

		foreach ($data as $catalog) {
			
			if (intval($catalog["pid"])==0) {
				
				$treeList[$catalog["id"]]["id"] = $catalog["id"];
				
				$treeList[$catalog["id"]]["name"] = $catalog["title"];

				$treeList[$catalog["id"]]["is_first"] = 1;

			} else {

				if (isset($treeList[$catalog["pid"]])) {

					$treeList[$catalog["pid"]]["children"][] = [ 

						"id" => $catalog["id"],

						"name"=>$catalog["title"] 
					];
				}
			}
		}

		return $treeList;
	}

	/**
	 * 获取管理员权限的菜单列表
	 * @author zuoliguang 2018-08-23
	 * @param  string $value [description]
	 * @return [type]        [description]
	 */
	public function getTreeListByaid($admin_id)
	{
		$data = $this->getAidCatalogs($admin_id);

		$kvd = [];

		foreach ($data as $item) {

			$kvd[$item["id"]] = $item;
		}

		$treeList = [];

		foreach ($data as $catalog) {
			
			if (intval($catalog["pid"])==0) {
				
				$treeList[$catalog["id"]] = $catalog;

			} else {

				if (isset($treeList[$catalog["pid"]])) {

					$treeList[$catalog["pid"]]["items"][] = $catalog;
				}
			}
		}

		return $treeList;
	}
}
