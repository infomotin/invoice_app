<?php 

/**
 * SharedController Controller
 * @category  Controller / Model
 */
class SharedController extends BaseController{
	
	/**
     * invoice_customer_id_option_list Model Action
     * @return array
     */
	function invoice_customer_id_option_list(){
		$db = $this->GetModel();
		$sqltext = "SELECT DISTINCT id AS value , F_name AS label FROM customer ORDER BY label ASC";
		$queryparams = null;
		$arr = $db->rawQuery($sqltext, $queryparams);
		return $arr;
	}

	/**
     * invoice_invoice_items_option_list Model Action
     * @return array
     */
	function invoice_invoice_items_option_list(){
		$db = $this->GetModel();
		$sqltext = "SELECT DISTINCT invoice_number AS value , id AS label FROM invoice_items ORDER BY label ASC";
		$queryparams = null;
		$arr = $db->rawQuery($sqltext, $queryparams);
		return $arr;
	}

	/**
     * invoice_items_item_invt_id_option_list Model Action
     * @return array
     */
	function invoice_items_item_invt_id_option_list(){
		$db = $this->GetModel();
		$sqltext = "SELECT DISTINCT id AS value , name AS label FROM inventory ORDER BY label ASC";
		$queryparams = null;
		$arr = $db->rawQuery($sqltext, $queryparams);
		return $arr;
	}

	/**
     * invoice_items_invoice_number_option_list Model Action
     * @return array
     */
	function invoice_items_invoice_number_option_list(){
		$db = $this->GetModel();
		$sqltext = "SELECT DISTINCT invoice_number AS value , title AS label FROM invoice ORDER BY label ASC";
		$queryparams = null;
		$arr = $db->rawQuery($sqltext, $queryparams);
		return $arr;
	}

	/**
     * user_username_value_exist Model Action
     * @return array
     */
	function user_username_value_exist($val){
		$db = $this->GetModel();
		$db->where("username", $val);
		$exist = $db->has("user");
		return $exist;
	}

	/**
     * user_email_value_exist Model Action
     * @return array
     */
	function user_email_value_exist($val){
		$db = $this->GetModel();
		$db->where("email", $val);
		$exist = $db->has("user");
		return $exist;
	}

	/**
     * user_role_option_list Model Action
     * @return array
     */
	function user_role_option_list(){
		$db = $this->GetModel();
		$sqltext = "SELECT  DISTINCT id AS value,role_name AS label FROM user_role";
		$queryparams = null;
		$arr = $db->rawQuery($sqltext, $queryparams);
		return $arr;
	}

	/**
     * user_role_option_list_2 Model Action
     * @return array
     */
	function user_role_option_list_2(){
		$db = $this->GetModel();
		$sqltext = "SELECT DISTINCT id AS value , role_name AS label FROM user_role ORDER BY label ASC";
		$queryparams = null;
		$arr = $db->rawQuery($sqltext, $queryparams);
		return $arr;
	}

}
