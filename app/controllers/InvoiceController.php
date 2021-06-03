<?php 
/**
 * Invoice Page Controller
 * @category  Controller
 */
class InvoiceController extends SecureController{
	function __construct(){
		parent::__construct();
		$this->tablename = "invoice";
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
		$fields = array("invoice.id", 
			"invoice.invoice_number", 
			"invoice.customer_id", 
			"customer.F_name AS customer_F_name", 
			"invoice.invoice_items", 
			"invoice.vat_percentage", 
			"invoice.taxt_percentage", 
			"invoice.discount_amount", 
			"invoice.status", 
			"invoice.date");
		$pagination = $this->get_pagination(MAX_RECORD_COUNT); // get current pagination e.g array(page_number, page_limit)
		//search table record
		if(!empty($request->search)){
			$text = trim($request->search); 
			$search_condition = "(
				invoice.id LIKE ? OR 
				invoice.invoice_number LIKE ? OR 
				invoice.customer_id LIKE ? OR 
				invoice.title LIKE ? OR 
				invoice.invoice_items LIKE ? OR 
				invoice.vat_percentage LIKE ? OR 
				invoice.taxt_percentage LIKE ? OR 
				invoice.discount_amount LIKE ? OR 
				invoice.status LIKE ? OR 
				invoice.date LIKE ?
			)";
			$search_params = array(
				"%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%","%$text%"
			);
			//setting search conditions
			$db->where($search_condition, $search_params);
			 //template to use when ajax search
			$this->view->search_template = "invoice/search.php";
		}
		$db->join("customer", "invoice.customer_id = customer.id", "INNER");
		if(!empty($request->orderby)){
			$orderby = $request->orderby;
			$ordertype = (!empty($request->ordertype) ? $request->ordertype : ORDER_TYPE);
			$db->orderBy($orderby, $ordertype);
		}
		else{
			$db->orderBy("invoice.id", ORDER_TYPE);
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
		$page_title = $this->view->page_title = "Invoice";
		$this->view->report_filename = date('Y-m-d') . '-' . $page_title;
		$this->view->report_title = $page_title;
		$this->view->report_layout = "report_layout.php";
		$this->view->report_paper_size = "A4";
		$this->view->report_orientation = "portrait";
		$this->render_view("invoice/list.php", $data); //render the full page
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
		$fields = array("invoice.id", 
			"invoice.title", 
			"invoice.invoice_number", 
			"invoice.customer_id", 
			"customer.F_name AS customer_F_name", 
			"invoice.invoice_items", 
			"invoice.vat_percentage", 
			"invoice.taxt_percentage", 
			"invoice.discount_amount", 
			"invoice.status", 
			"invoice.date");
		if($value){
			$db->where($rec_id, urldecode($value)); //select record based on field name
		}
		else{
			$db->where("invoice.id", $rec_id);; //select record based on primary key
		}
		$db->join("customer", "invoice.customer_id = customer.id", "INNER");  
		$record = $db->getOne($tablename, $fields );
		if($record){
			$page_title = $this->view->page_title = "View  Invoice";
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
		return $this->render_view("invoice/view.php", $record);
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
			$fields = $this->fields = array("invoice_number","customer_id","title","vat_percentage","taxt_percentage","discount_amount","status");
			$postdata = $this->format_request_data($formdata);
			$this->rules_array = array(
				'customer_id' => 'required',
				'title' => 'required',
				'vat_percentage' => 'required|numeric',
				'taxt_percentage' => 'required|numeric',
				'discount_amount' => 'required|numeric',
				'status' => 'required',
			);
			$this->sanitize_array = array(
				'customer_id' => 'sanitize_string',
				'title' => 'sanitize_string',
				'vat_percentage' => 'sanitize_string',
				'taxt_percentage' => 'sanitize_string',
				'discount_amount' => 'sanitize_string',
				'status' => 'sanitize_string',
			);
			$this->filter_vals = true; //set whether to remove empty fields
			$modeldata = $this->modeldata = $this->validate_form($postdata);
			$modeldata['invoice_number'] = "IVN".time();
			if($this->validated()){
				$rec_id = $this->rec_id = $db->insert($tablename, $modeldata);
				if($rec_id){
					$this->set_flash_msg("Record added successfully", "success");
					return	$this->redirect("invoice");
				}
				else{
					$this->set_page_error();
				}
			}
		}
		$page_title = $this->view->page_title = "Add New Invoice";
		$this->render_view("invoice/add.php");
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
		$fields = $this->fields = array("id","invoice_number","customer_id","title","invoice_items","vat_percentage","taxt_percentage","discount_amount","status","date");
		if($formdata){
			$postdata = $this->format_request_data($formdata);
			$this->rules_array = array(
				'customer_id' => 'required',
				'title' => 'required',
				'invoice_items' => 'required',
				'vat_percentage' => 'required|numeric',
				'taxt_percentage' => 'required|numeric',
				'discount_amount' => 'required|numeric',
				'status' => 'required',
			);
			$this->sanitize_array = array(
				'customer_id' => 'sanitize_string',
				'title' => 'sanitize_string',
				'invoice_items' => 'sanitize_string',
				'vat_percentage' => 'sanitize_string',
				'taxt_percentage' => 'sanitize_string',
				'discount_amount' => 'sanitize_string',
				'status' => 'sanitize_string',
			);
			$modeldata = $this->modeldata = $this->validate_form($postdata);
			$modeldata['invoice_number'] = "IVN".time();
$modeldata['date'] = date_now();
			if($this->validated()){
		# Statement to execute after adding record
		unset($modeldata['invoice_number']);
		# End of before update statement
				$db->where("invoice.id", $rec_id);;
				$bool = $db->update($tablename, $modeldata);
				$numRows = $db->getRowCount(); //number of affected rows. 0 = no record field updated
				if($bool && $numRows){
					$this->set_flash_msg("Record updated successfully", "success");
					return $this->redirect("invoice");
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
						return	$this->redirect("invoice");
					}
				}
			}
		}
		$db->where("invoice.id", $rec_id);;
		$data = $db->getOne($tablename, $fields);
		$page_title = $this->view->page_title = "Edit  Invoice";
		if(!$data){
			$this->set_page_error();
		}
		return $this->render_view("invoice/edit.php", $data);
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
		$fields = $this->fields = array("id","invoice_number","customer_id","title","invoice_items","vat_percentage","taxt_percentage","discount_amount","status","date");
		$page_error = null;
		if($formdata){
			$postdata = array();
			$fieldname = $formdata['name'];
			$fieldvalue = $formdata['value'];
			$postdata[$fieldname] = $fieldvalue;
			$postdata = $this->format_request_data($postdata);
			$this->rules_array = array(
				'customer_id' => 'required',
				'title' => 'required',
				'invoice_items' => 'required',
				'vat_percentage' => 'required|numeric',
				'taxt_percentage' => 'required|numeric',
				'discount_amount' => 'required|numeric',
				'status' => 'required',
			);
			$this->sanitize_array = array(
				'customer_id' => 'sanitize_string',
				'title' => 'sanitize_string',
				'invoice_items' => 'sanitize_string',
				'vat_percentage' => 'sanitize_string',
				'taxt_percentage' => 'sanitize_string',
				'discount_amount' => 'sanitize_string',
				'status' => 'sanitize_string',
			);
			$this->filter_rules = true; //filter validation rules by excluding fields not in the formdata
			$modeldata = $this->modeldata = $this->validate_form($postdata);
			if($this->validated()){
				$db->where("invoice.id", $rec_id);;
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
		$db->where("invoice.id", $arr_rec_id, "in");
		$bool = $db->delete($tablename);
		if($bool){
			$this->set_flash_msg("Record deleted successfully", "success");
		}
		elseif($db->getLastError()){
			$page_error = $db->getLastError();
			$this->set_flash_msg($page_error, "danger");
		}
		return	$this->redirect("invoice");
	}
}
