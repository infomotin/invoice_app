    <?php
    $comp_model = new SharedController;
    $view_data = $this->view_data; //array of all  data passed from controller
    $field_name = $view_data['field_name'];
    $field_value = $view_data['field_value'];
    $form_data = $this->form_data; //request pass to the page as form fields values
    $page_id = random_str(6);
    ?>
    <div class="master-detail-page">
        <div class="card-header p-0 pt-2 px-2">
            <ul class="nav nav-tabs">
                <li class="nav-item">
                    <a data-toggle="tab" href="#invoice_invoice_items_List_<?php echo $page_id ?>" class="nav-link active">
                        List
                    </a>
                </li>
                <li class="nav-item">
                    <a data-toggle="tab" href="#invoice_invoice_items_Add_<?php echo $page_id ?>" class="nav-link ">
                        Add
                    </a>
                </li>
            </ul>
        </div>
        <div class="tab-content">
            <div class="tab-pane fade show active show" id="invoice_invoice_items_List_<?php echo $page_id ?>" role="tabpanel">
                <?php $this->render_page("invoice_items/list/invoice_number/$field_value"); ?>
            </div>
            <div class="tab-pane fade show " id="invoice_invoice_items_Add_<?php echo $page_id ?>" role="tabpanel">
                <?php $this->render_page("invoice_items/add/?invoice_number=$field_value", array('invoice_number' => get_value('invoice_number'))); ?>
            </div>
        </div>
    </div>
    