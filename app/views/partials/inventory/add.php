<?php
$comp_model = new SharedController;
$page_element_id = "add-page-" . random_str();
$current_page = $this->set_current_page_link();
$csrf_token = Csrf::$token;
$show_header = $this->show_header;
$view_title = $this->view_title;
$redirect_to = $this->redirect_to;
?>
<section class="page" id="<?php echo $page_element_id; ?>" data-page-type="add"  data-display-type="" data-page-url="<?php print_link($current_page); ?>">
    <?php
    if( $show_header == true ){
    ?>
    <div  class="bg-light p-3 mb-3">
        <div class="container">
            <div class="row ">
                <div class="col ">
                    <h4 class="record-title">Add New Inventory</h4>
                </div>
            </div>
        </div>
    </div>
    <?php
    }
    ?>
    <div  class="">
        <div class="container">
            <div class="row ">
                <div class="col-md-7 comp-grid">
                    <?php $this :: display_page_errors(); ?>
                    <div  class="bg-light p-3 animated fadeIn page-content">
                        <form id="inventory-add-form" role="form" novalidate enctype="multipart/form-data" class="form page-form form-horizontal needs-validation" action="<?php print_link("inventory/add?csrf_token=$csrf_token") ?>" method="post">
                            <div>
                                <div class="form-group ">
                                    <div class="row">
                                        <div class="col-sm-4">
                                            <label class="control-label" for="name">Name <span class="text-danger">*</span></label>
                                        </div>
                                        <div class="col-sm-8">
                                            <div class="">
                                                <input id="ctrl-name"  value="<?php  echo $this->set_field_value('name',""); ?>" type="text" placeholder="Enter Name"  required="" name="name"  class="form-control " />
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group ">
                                        <div class="row">
                                            <div class="col-sm-4">
                                                <label class="control-label" for="img">Img </label>
                                            </div>
                                            <div class="col-sm-8">
                                                <div class="">
                                                    <div class="dropzone " input="#ctrl-img" fieldname="img"    data-multiple="false" dropmsg="Choose files or drag and drop files to upload"    btntext="Browse" extensions=".jpg,.png,.gif,.jpeg" filesize="3" maximum="1">
                                                        <input name="img" id="ctrl-img" class="dropzone-input form-control" value="<?php  echo $this->set_field_value('img',""); ?>" type="text"  />
                                                            <!--<div class="invalid-feedback animated bounceIn text-center">Please a choose file</div>-->
                                                            <div class="dz-file-limit animated bounceIn text-center text-danger"></div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group ">
                                            <div class="row">
                                                <div class="col-sm-4">
                                                    <label class="control-label" for="description">Description </label>
                                                </div>
                                                <div class="col-sm-8">
                                                    <div class="">
                                                        <textarea placeholder="Enter Description" id="ctrl-description"  rows="5" name="description" class=" form-control"><?php  echo $this->set_field_value('description',""); ?></textarea>
                                                        <!--<div class="invalid-feedback animated bounceIn text-center">Please enter text</div>-->
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group ">
                                            <div class="row">
                                                <div class="col-sm-4">
                                                    <label class="control-label" for="cost">Cost <span class="text-danger">*</span></label>
                                                </div>
                                                <div class="col-sm-8">
                                                    <div class="">
                                                        <input id="ctrl-cost"  value="<?php  echo $this->set_field_value('cost',""); ?>" type="number" placeholder="Enter Cost" step="0.1"  required="" name="cost"  class="form-control " />
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group ">
                                                <div class="row">
                                                    <div class="col-sm-4">
                                                        <label class="control-label" for="qty_in_stock">Qty In Stock </label>
                                                    </div>
                                                    <div class="col-sm-8">
                                                        <div class="">
                                                            <input id="ctrl-qty_in_stock"  value="<?php  echo $this->set_field_value('qty_in_stock',""); ?>" type="number" placeholder="Enter Qty In Stock" step="1"  name="qty_in_stock"  class="form-control " />
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group ">
                                                    <div class="row">
                                                        <div class="col-sm-4">
                                                            <label class="control-label" for="record_level">Record Level </label>
                                                        </div>
                                                        <div class="col-sm-8">
                                                            <div class="">
                                                                <input id="ctrl-record_level"  value="<?php  echo $this->set_field_value('record_level',""); ?>" type="number" placeholder="Enter Record Level" step="1"  name="record_level"  class="form-control " />
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group ">
                                                        <div class="row">
                                                            <div class="col-sm-4">
                                                                <label class="control-label" for="full_stock">Full Stock </label>
                                                            </div>
                                                            <div class="col-sm-8">
                                                                <div class="">
                                                                    <input id="ctrl-full_stock"  value="<?php  echo $this->set_field_value('full_stock',""); ?>" type="number" placeholder="Enter Full Stock" step="1"  name="full_stock"  class="form-control " />
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="form-group ">
                                                            <div class="row">
                                                                <div class="col-sm-4">
                                                                    <label class="control-label" for="selling_price">Selling Price <span class="text-danger">*</span></label>
                                                                </div>
                                                                <div class="col-sm-8">
                                                                    <div class="">
                                                                        <input id="ctrl-selling_price"  value="<?php  echo $this->set_field_value('selling_price',""); ?>" type="number" placeholder="Enter Selling Price" step="0.1"  required="" name="selling_price"  class="form-control " />
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="form-group ">
                                                                <div class="row">
                                                                    <div class="col-sm-4">
                                                                        <label class="control-label" for="status">Status <span class="text-danger">*</span></label>
                                                                    </div>
                                                                    <div class="col-sm-8">
                                                                        <div class="">
                                                                            <select required=""  id="ctrl-status" name="status"  placeholder="Select a value ..."    class="custom-select" >
                                                                                <option value="">Select a value ...</option>
                                                                                <?php
                                                                                $status_options = Menu :: $status;
                                                                                if(!empty($status_options)){
                                                                                foreach($status_options as $option){
                                                                                $value = $option['value'];
                                                                                $label = $option['label'];
                                                                                $selected = $this->set_field_selected('status', $value, "");
                                                                                ?>
                                                                                <option <?php echo $selected ?> value="<?php echo $value ?>">
                                                                                    <?php echo $label ?>
                                                                                </option>                                   
                                                                                <?php
                                                                                }
                                                                                }
                                                                                ?>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="form-group form-submit-btn-holder text-center mt-3">
                                                            <div class="form-ajax-status"></div>
                                                            <button class="btn btn-primary" type="submit">
                                                                Submit
                                                                <i class="fa fa-send"></i>
                                                            </button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </section>
