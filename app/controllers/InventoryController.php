<?php 
/**
 * Inventory Page Controller
 * @category  Controller
 */
class InventoryController extends SecureController{
	function __construct(){
		parent::__construct();
		$this->tablename = "inventory";
	}
	/**
     * List page records
     * @param $fieldname (filter record by a field) 
     * @param $fieldvalue (filter field value)
     * @return BaseView
     */
	function index($fieldname = null , $fieldvalue = null){
		$request = $this->request;
		$db = $this->GetModel();
		$tablename = $this->tablename;
		$fields = array("id", 
			"name", 
			"img", 
			"cost", 
			"qty_in_stock", 
			"full_stock", 
			"selling_price", 
			"status");
		$pagination = $this->get_pagination(MAX_RECORD_COUNT); // get current pagination e.g array(page_number, page_limit)
		//search table record
		if(!empty($request->search)){
			$text = trim($request->search); 
			$search_condition = "(
				inventory.id LIKE ? OR 
				inventory.name LIKE ? OR 
				inventory.img LIKE ? OR 
				inventory.description LIKE ? OR 
				inventory.cost LIKE ? OR 
				inventory.qty_in_stock LIKE ? OR 
				inventory.record_level LIKE ? OR 
				inventory.full_stock LIKE ? OR 
				inventory.selling_price LIKE ? OR 
				inventory.status LIKE ? OR 
				inventory.date LIKE ?
			)";
			$search_params = array(
				"%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%"
			);
			//setting search conditions
			$db->where($search_condition, $search_params);
			 //template to use when ajax search
			$this->view->search_template = "inventory/search.php";
		}
		if(!empty($request->orderby)){
			$orderby = $request->orderby;
			$ordertype = (!empty($request->ordertype) ? $request->ordertype : ORDER_TYPE);
			$db->orderBy($orderby, $ordertype);
		}
		else{
			$db->orderBy("inventory.id", ORDER_TYPE);
		}
		if($fieldname){
			$db->where($fieldname , $fieldvalue); //filter by a single field name
		}
		$tc = $db->withTotalCount();
		$records = $db->get($tablename, $pagination, $fields);
		$records_count = count($records);
		$total_records = intval($tc->totalCount);
		$page_limit = $pagination[1];
		$total_pages = ceil($total_records / $page_limit);
		$data = new stdClass;
		$data->records = $records;
		$data->record_count = $records_count;
		$data->total_records = $total_records;
		$data->total_page = $total_pages;
		if($db->getLastError()){
			$this->set_page_error();
		}
		$page_title = $this->view->page_title = "Inventory";
		$this->view->report_filename = date('Y-m-d') . '-' . $page_title;
		$this->view->report_title = $page_title;
		$this->view->report_layout = "report_layout.php";
		$this->view->report_paper_size = "A4";
		$this->view->report_orientation = "portrait";
		$this->render_view("inventory/list.php", $data); //render the full page
	}
	/**
     * View record detail 
	 * @param $rec_id (select record by table primary key) 
     * @param $value value (select record by value of field name(rec_id))
     * @return BaseView
     */
	function view($rec_id = null, $value = null){
		$request = $this->request;
		$db = $this->GetModel();
		$rec_id = $this->rec_id = urldecode($rec_id);
		$tablename = $this->tablename;
		$fields = array("id", 
			"img", 
			"name", 
			"description", 
			"cost", 
			"qty_in_stock", 
			"record_level", 
			"full_stock", 
			"selling_price", 
			"status", 
			"date");
		if($value){
			$db->where($rec_id, urldecode($value)); //select record based on field name
		}
		else{
			$db->where("inventory.id", $rec_id);; //select record based on primary key
		}
		$record = $db->getOne($tablename, $fields );
		if($record){
			$page_title = $this->view->page_title = "View  Inventory";
		$this->view->report_filename = date('Y-m-d') . '-' . $page_title;
		$this->view->report_title = $page_title;
		$this->view->report_layout = "report_layout.php";
		$this->view->report_paper_size = "A4";
		$this->view->report_orientation = "portrait";
		}
		else{
			if($db->getLastError()){
				$this->set_page_error();
			}
			else{
				$this->set_page_error("No record found");
			}
		}
		return $this->render_view("inventory/view.php", $record);
	}
	/**
     * Insert new record to the database table
	 * @param $formdata array() from $_POST
     * @return BaseView
     */
	function add($formdata = null){
		if($formdata){
			$db = $this->GetModel();
			$tablename = $this->tablename;
			$request = $this->request;
			//fillable fields
			$fields = $this->fields = array("id","name","img","description","cost","qty_in_stock","record_level","full_stock","selling_price","status");
			$postdata = $this->format_request_data($formdata);
			$this->rules_array = array(
				'name' => 'required',
				'cost' => 'required|numeric',
				'qty_in_stock' => 'numeric',
				'record_level' => 'numeric',
				'full_stock' => 'numeric',
				'selling_price' => 'required|numeric',
				'status' => 'required',
			);
			$this->sanitize_array = array(
				'name' => 'sanitize_string',
				'img' => 'sanitize_string',
				'description' => 'sanitize_string',
				'cost' => 'sanitize_string',
				'qty_in_stock' => 'sanitize_string',
				'record_level' => 'sanitize_string',
				'full_stock' => 'sanitize_string',
				'selling_price' => 'sanitize_string',
				'status' => 'sanitize_string',
			);
			$this->filter_vals = true; //set whether to remove empty fields
			$modeldata = $this->modeldata = $this->validate_form($postdata);
			if($this->validated()){
				$rec_id = $this->rec_id = $db->insert($tablename, $modeldata);
				if($rec_id){
					$this->set_flash_msg("Record added successfully", "success");
					return	$this->redirect("inventory");
				}
				else{
					$this->set_page_error();
				}
			}
		}
		$page_title = $this->view->page_title = "Add New Inventory";
		$this->render_view("inventory/add.php");
	}
	/**
     * Update table record with formdata
	 * @param $rec_id (select record by table primary key)
	 * @param $formdata array() from $_POST
     * @return array
     */
	function edit($rec_id = null, $formdata = null){
		$request = $this->request;
		$db = $this->GetModel();
		$this->rec_id = $rec_id;
		$tablename = $this->tablename;
		 //editable fields
		$fields = $this->fields = array("id","name","img","description","cost","qty_in_stock","record_level","full_stock","selling_price","status");
		if($formdata){
			$postdata = $this->format_request_data($formdata);
			$this->rules_array = array(
				'name' => 'required',
				'cost' => 'required|numeric',
				'qty_in_stock' => 'numeric',
				'record_level' => 'numeric',
				'full_stock' => 'numeric',
				'selling_price' => 'required|numeric',
				'status' => 'required',
			);
			$this->sanitize_array = array(
				'name' => 'sanitize_string',
				'img' => 'sanitize_string',
				'description' => 'sanitize_string',
				'cost' => 'sanitize_string',
				'qty_in_stock' => 'sanitize_string',
				'record_level' => 'sanitize_string',
				'full_stock' => 'sanitize_string',
				'selling_price' => 'sanitize_string',
				'status' => 'sanitize_string',
			);
			$modeldata = $this->modeldata = $this->validate_form($postdata);
			if($this->validated()){
				$db->where("inventory.id", $rec_id);;
				$bool = $db->update($tablename, $modeldata);
				$numRows = $db->getRowCount(); //number of affected rows. 0 = no record field updated
				if($bool && $numRows){
					$this->set_flash_msg("Record updated successfully", "success");
					return $this->redirect("inventory");
				}
				else{
					if($db->getLastError()){
						$this->set_page_error();
					}
					elseif(!$numRows){
						//not an error, but no record was updated
						$page_error = "No record updated";
						$this->set_page_error($page_error);
						$this->set_flash_msg($page_error, "warning");
						return	$this->redirect("inventory");
					}
				}
			}
		}
		$db->where("inventory.id", $rec_id);;
		$data = $db->getOne($tablename, $fields);
		$page_title = $this->view->page_title = "Edit  Inventory";
		if(!$data){
			$this->set_page_error();
		}
		return $this->render_view("inventory/edit.php", $data);
	}
	/**
     * Update single field
	 * @param $rec_id (select record by table primary key)
	 * @param $formdata array() from $_POST
     * @return array
     */
	function editfield($rec_id = null, $formdata = null){
		$db = $this->GetModel();
		$this->rec_id = $rec_id;
		$tablename = $this->tablename;
		//editable fields
		$fields = $this->fields = array("id","name","img","description","cost","qty_in_stock","record_level","full_stock","selling_price","status");
		$page_error = null;
		if($formdata){
			$postdata = array();
			$fieldname = $formdata['name'];
			$fieldvalue = $formdata['value'];
			$postdata[$fieldname] = $fieldvalue;
			$postdata = $this->format_request_data($postdata);
			$this->rules_array = array(
				'name' => 'required',
				'cost' => 'required|numeric',
				'qty_in_stock' => 'numeric',
				'record_level' => 'numeric',
				'full_stock' => 'numeric',
				'selling_price' => 'required|numeric',
				'status' => 'required',
			);
			$this->sanitize_array = array(
				'name' => 'sanitize_string',
				'img' => 'sanitize_string',
				'description' => 'sanitize_string',
				'cost' => 'sanitize_string',
				'qty_in_stock' => 'sanitize_string',
				'record_level' => 'sanitize_string',
				'full_stock' => 'sanitize_string',
				'selling_price' => 'sanitize_string',
				'status' => 'sanitize_string',
			);
			$this->filter_rules = true; //filter validation rules by excluding fields not in the formdata
			$modeldata = $this->modeldata = $this->validate_form($postdata);
			if($this->validated()){
				$db->where("inventory.id", $rec_id);;
				$bool = $db->update($tablename, $modeldata);
				$numRows = $db->getRowCount();
				if($bool && $numRows){
					return render_json(
						array(
							'num_rows' =>$numRows,
							'rec_id' =>$rec_id,
						)
					);
				}
				else{
					if($db->getLastError()){
						$page_error = $db->getLastError();
					}
					elseif(!$numRows){
						$page_error = "No record updated";
					}
					render_error($page_error);
				}
			}
			else{
				render_error($this->view->page_error);
			}
		}
		return null;
	}
	/**
     * Delete record from the database
	 * Support multi delete by separating record id by comma.
     * @return BaseView
     */
	function delete($rec_id = null){
		Csrf::cross_check();
		$request = $this->request;
		$db = $this->GetModel();
		$tablename = $this->tablename;
		$this->rec_id = $rec_id;
		//form multiple delete, split record id separated by comma into array
		$arr_rec_id = array_map('trim', explode(",", $rec_id));
		$db->where("inventory.id", $arr_rec_id, "in");
		$bool = $db->delete($tablename);
		if($bool){
			$this->set_flash_msg("Record deleted successfully", "success");
		}
		elseif($db->getLastError()){
			$page_error = $db->getLastError();
			$this->set_flash_msg($page_error, "danger");
		}
		return	$this->redirect("inventory");
	}
}
