<?php
$comp_model = new SharedController;
$page_element_id = "view-page-" . random_str();
$current_page = $this->set_current_page_link();
$csrf_token = Csrf::$token;
//Page Data Information from Controller
$data = $this->view_data;
//$rec_id = $data['__tableprimarykey'];
$page_id = $this->route->page_id; //Page id from url
$view_title = $this->view_title;
$show_header = $this->show_header;
$show_edit_btn = $this->show_edit_btn;
$show_delete_btn = $this->show_delete_btn;
$show_export_btn = $this->show_export_btn;
?>
<section class="page ajax-page" id="<?php echo $page_element_id; ?>" data-page-type="view"  data-display-type="custom" data-page-url="<?php print_link($current_page); ?>">
    <?php
    if( $show_header == true ){
    ?>
    <div  class="bg-light p-3 mb-3">
        <div class="container">
            <div class="row ">
                <div class="col-12 ">
                    <h4 class="record-title">View  Invoice</h4>
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
                <div class="col-md-12 comp-grid">
                    <?php $this :: display_page_errors(); ?>
                    <div  class="card animated fadeIn page-content">
                        <?php
                        $counter = 0;
                        if(!empty($data)){
                        $rec_id = (!empty($data['id']) ? urlencode($data['id']) : null);
                        $InvoiceClass = new InvoiceController;
                        $InvoiceData = $InvoiceClass->getInvoice($data['id'],$data['customer_id']);
                        var_dump($InvoiceData);
                        $counter++;
                        ?>
                        <div id="page-report-body" class="">
                            <!--this is report template-->
                            <div class="row">
                                <div class="col-md-12 col-md-offset-3 body-main">
                                    <div class="col-md-12">
                                        <div class="row">
                                            <div class="col-md-4"> <img class="img" alt="Invoce Template" src="http://pngimg.com/uploads/shopping_cart/shopping_cart_PNG59.png" /> </div>
                                            <div class="col-md-8 text-right">
                                                <h4 style="color: #F81D2D;"><strong><?php echo SITE_NAME; ?></strong></h4>
                                                <p>221 ,Baker Street</p>
                                                <p>1800-234-124</p>
                                                <p>example@gmail.com</p>
                                            </div>
                                        </div> <br />
                                        <div class="row">
                                            <div class="col-md-12 text-center">
                                                <h2>INVOICE</h2>
                                                <h5>04854654101</h5>
                                            </div>
                                        </div> <br />
                                        <div>
                                            <table class="table">
                                                <thead>
                                                    <tr>
                                                        <th>
                                                            <h5>#</h5>
                                                        </th>
                                                        <th>
                                                            <h5>Name</h5>
                                                        </th>
                                                        <th>
                                                            <h5>Amount</h5>
                                                        </th>
                                                        <th>
                                                            <h5>Qty</h5>
                                                        </th>
                                                        <th>
                                                            <h5>Total</h5>
                                                        </th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td >1</td>
                                                        <td >Samsung Galaxy 8 64 GB</td>
                                                        <td >$1,700</td>
                                                        <td >1</td>
                                                        <td >$1,700</td>
                                                    </tr>
                                                    <tr>
                                                        <td >1</td>
                                                        <td >Samsung Galaxy 8 64 GB</td>
                                                        <td >$1,700</td>
                                                        <td >1</td>
                                                        <td >$1,700</td>
                                                    </tr>
                                                    <tr>
                                                        <td >1</td>
                                                        <td >Samsung Galaxy 8 64 GB</td>
                                                        <td >$1,700</td>
                                                        <td >1</td>
                                                        <td >$1,700</td>
                                                    </tr>
                                                    <tr>
                                                        <td >1</td>
                                                    <td ></td>JBL Bluetooth Speaker</td>
                                                    <td >$1,700</td>
                                                    <td >1</td>
                                                    <td >$1,700</td>
                                                </tr>
                                                <tr>
                                                    <td class="text-right">
                                                        <p> <strong>Shipment and Taxes:</strong> </p>
                                                        <p> <strong>Total Amount: </strong> </p>
                                                        <p> <strong>Discount: </strong> </p>
                                                        <p> <strong>Payable Amount: </strong> </p>
                                                    </td>
                                                    <td>
                                                        <p> <strong>500 </strong> </p>
                                                        <p> <strong>82,900</strong> </p>
                                                        <p> <strong>3,000 </strong> </p>
                                                        <p> <strong>79,900</strong> </p>
                                                    </td>
                                                </tr>
                                                <tr class="span12" style="color: #F81D2D;">
                                                    <td class="text-right">
                                                        <h4><strong>Total:</strong></h4>
                                                    </td>
                                                    <td class="text-left">
                                                        <h4><strong><i class="fas fa-rupee-sign" area-hidden="true"></i> 79,900 </strong></h4>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    <div>
                                        <div class="col-md-12">
                                            <p><b>Date :</b> 6 June 2019</p> <br />
                                            <p><b>Signature</b></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--<table class="table table-hover table-borderless table-striped">-->
                            <!-- Table Body Start -->
                            <!--    <tbody class="page-data" id="page-data-<?php echo $page_element_id; ?>">-->
                                <!--        <tr  class="td-title">-->
                                    <!--            <th class="title"> Title: </th>-->
                                    <!--            <td class="value">-->
                                        <!--                <span  data-value="<?php echo $data['title']; ?>" -->
                                            <!--                    data-pk="<?php echo $data['id'] ?>" -->
                                            <!--                    data-url="<?php print_link("invoice/editfield/" . urlencode($data['id'])); ?>" -->
                                            <!--                    data-name="title" -->
                                            <!--                    data-title="Enter Title" -->
                                            <!--                    data-placement="left" -->
                                            <!--                    data-toggle="click" -->
                                            <!--                    data-type="text" -->
                                            <!--                    data-mode="popover" -->
                                            <!--                    data-showbuttons="left" -->
                                            <!--                    class="is-editable" >-->
                                            <!--                    <?php echo $data['title']; ?> -->
                                        <!--                </span>-->
                                    <!--            </td>-->
                                <!--        </tr>-->
                                <!--        <tr  class="td-invoice_number">-->
                                    <!--            <th class="title"> Invoice Number: </th>-->
                                    <!--            <td class="value">-->
                                        <!--                <a size="sm" class="btn btn-sm btn-primary page-modal" href="<?php print_link("invoice/view/" . urlencode($data['invoice_number'])) ?>">-->
                                            <!--                    # <?php echo $data['invoice_number'] ?>-->
                                        <!--                </a>-->
                                    <!--            </td>-->
                                <!--        </tr>-->
                                <!--        <tr  class="td-customer_id">-->
                                    <!--            <th class="title"> Customer Id: </th>-->
                                    <!--            <td class="value">-->
                                        <!--                <a size="sm" class="btn btn-sm btn-primary page-modal" href="<?php print_link("customer/view/" . urlencode($data['customer_id'])) ?>">-->
                                            <!--                    <i class="fa fa-eye"></i> <?php echo $data['customer_F_name'] ?>-->
                                        <!--                </a>-->
                                    <!--            </td>-->
                                <!--        </tr>-->
                                <!--        <tr  class="td-invoice_items">-->
                                    <!--            <th class="title"> Invoice Number: </th>-->
                                    <!--            <td class="value">-->
                                        <!--                <?php-->
                                        <!--                $page_fields = array('invoice_number' => $data['invoice_number']);-->
                                        <!--                $page_link = "masterdetail/index/invoice/invoice_items/invoice_number/" . urlencode($data['invoice_number']);-->
                                        <!--                $md_pagelink = set_page_link($page_link, $page_fields); -->
                                        <!--                ?>-->
                                        <!--                <a size="sm" class="btn btn-sm btn-primary page-modal" href="<?php print_link($md_pagelink) ?>">-->
                                            <!--                    <i class="fa fa-eye "></i> <?php echo $data['invoice_items'] ?>-->
                                        <!--                </a>-->
                                    <!--            </td>-->
                                <!--        </tr>-->
                                <!--        <tr  class="td-vat_percentage">-->
                                    <!--            <th class="title"> Vat Percentage: </th>-->
                                    <!--            <td class="value">-->
                                        <!--                <span  data-value="<?php echo $data['vat_percentage']; ?>" -->
                                            <!--                    data-pk="<?php echo $data['id'] ?>" -->
                                            <!--                    data-url="<?php print_link("invoice/editfield/" . urlencode($data['id'])); ?>" -->
                                            <!--                    data-name="vat_percentage" -->
                                            <!--                    data-title="Enter Vat Percentage(%)" -->
                                            <!--                    data-placement="left" -->
                                            <!--                    data-toggle="click" -->
                                            <!--                    data-type="number" -->
                                            <!--                    data-mode="popover" -->
                                            <!--                    data-showbuttons="left" -->
                                            <!--                    class="is-editable" >-->
                                            <!--                    <?php echo $data['vat_percentage']; ?> -->
                                        <!--                </span>-->
                                    <!--            </td>-->
                                <!--        </tr>-->
                                <!--        <tr  class="td-taxt_percentage">-->
                                    <!--            <th class="title"> Taxt Percentage: </th>-->
                                    <!--            <td class="value">-->
                                        <!--                <span  data-value="<?php echo $data['taxt_percentage']; ?>" -->
                                            <!--                    data-pk="<?php echo $data['id'] ?>" -->
                                            <!--                    data-url="<?php print_link("invoice/editfield/" . urlencode($data['id'])); ?>" -->
                                            <!--                    data-name="taxt_percentage" -->
                                            <!--                    data-title="Enter Taxt Percentage" -->
                                            <!--                    data-placement="left" -->
                                            <!--                    data-toggle="click" -->
                                            <!--                    data-type="number" -->
                                            <!--                    data-mode="popover" -->
                                            <!--                    data-showbuttons="left" -->
                                            <!--                    class="is-editable" >-->
                                            <!--                    <?php echo $data['taxt_percentage']; ?> -->
                                        <!--                </span>-->
                                    <!--            </td>-->
                                <!--        </tr>-->
                                <!--        <tr  class="td-discount_amount">-->
                                    <!--            <th class="title"> Discount Amount: </th>-->
                                    <!--            <td class="value">-->
                                        <!--                <span  data-step="0.1" -->
                                            <!--                    data-value="<?php echo $data['discount_amount']; ?>" -->
                                            <!--                    data-pk="<?php echo $data['id'] ?>" -->
                                            <!--                    data-url="<?php print_link("invoice/editfield/" . urlencode($data['id'])); ?>" -->
                                            <!--                    data-name="discount_amount" -->
                                            <!--                    data-title="Enter Discount Amount" -->
                                            <!--                    data-placement="left" -->
                                            <!--                    data-toggle="click" -->
                                            <!--                    data-type="number" -->
                                            <!--                    data-mode="popover" -->
                                            <!--                    data-showbuttons="left" -->
                                            <!--                    class="is-editable" >-->
                                            <!--                    <?php echo $data['discount_amount']; ?> -->
                                        <!--                </span>-->
                                    <!--            </td>-->
                                <!--        </tr>-->
                                <!--        <tr  class="td-status">-->
                                    <!--            <th class="title"> Status: </th>-->
                                    <!--            <td class="value">-->
                                        <!--                <span  data-source='<?php echo json_encode_quote(Menu :: $status2); ?>' -->
                                            <!--                    data-value="<?php echo $data['status']; ?>" -->
                                            <!--                    data-pk="<?php echo $data['id'] ?>" -->
                                            <!--                    data-url="<?php print_link("invoice/editfield/" . urlencode($data['id'])); ?>" -->
                                            <!--                    data-name="status" -->
                                            <!--                    data-title="Enter Status" -->
                                            <!--                    data-placement="left" -->
                                            <!--                    data-toggle="click" -->
                                            <!--                    data-type="radiolist" -->
                                            <!--                    data-mode="popover" -->
                                            <!--                    data-showbuttons="left" -->
                                            <!--                    class="is-editable" >-->
                                            <!--                    <?php echo $data['status']; ?> -->
                                        <!--                </span>-->
                                    <!--            </td>-->
                                <!--        </tr>-->
                                <!--        <tr  class="td-date">-->
                                    <!--            <th class="title"> Date: </th>-->
                                    <!--            <td class="value">-->
                                        <!--                <span  data-value="<?php echo $data['date']; ?>" -->
                                            <!--                    data-pk="<?php echo $data['id'] ?>" -->
                                            <!--                    data-url="<?php print_link("invoice/editfield/" . urlencode($data['id'])); ?>" -->
                                            <!--                    data-name="date" -->
                                            <!--                    data-title="Enter Date" -->
                                            <!--                    data-placement="left" -->
                                            <!--                    data-toggle="click" -->
                                            <!--                    data-type="text" -->
                                            <!--                    data-mode="popover" -->
                                            <!--                    data-showbuttons="left" -->
                                            <!--                    class="is-editable" >-->
                                            <!--                    <?php echo $data['date']; ?> -->
                                        <!--                </span>-->
                                    <!--            </td>-->
                                <!--        </tr>-->
                            <!--    </tbody>-->
                            <!-- Table Body End -->
                        <!--</table>-->
                    </div>
                    <div class="p-3 d-flex">
                        <div class="dropup export-btn-holder mx-1">
                            <button class="btn btn-sm btn-primary dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fa fa-save"></i> Export
                            </button>
                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                <?php $export_print_link = $this->set_current_page_link(array('format' => 'print')); ?>
                                <a class="dropdown-item export-link-btn" data-format="print" href="<?php print_link($export_print_link); ?>" target="_blank">
                                    <img src="<?php print_link('assets/images/print.png') ?>" class="mr-2" /> PRINT
                                    </a>
                                    <?php $export_pdf_link = $this->set_current_page_link(array('format' => 'pdf')); ?>
                                    <a class="dropdown-item export-link-btn" data-format="pdf" href="<?php print_link($export_pdf_link); ?>" target="_blank">
                                        <img src="<?php print_link('assets/images/pdf.png') ?>" class="mr-2" /> PDF
                                        </a>
                                        <?php $export_word_link = $this->set_current_page_link(array('format' => 'word')); ?>
                                        <a class="dropdown-item export-link-btn" data-format="word" href="<?php print_link($export_word_link); ?>" target="_blank">
                                            <img src="<?php print_link('assets/images/doc.png') ?>" class="mr-2" /> WORD
                                            </a>
                                            <?php $export_csv_link = $this->set_current_page_link(array('format' => 'csv')); ?>
                                            <a class="dropdown-item export-link-btn" data-format="csv" href="<?php print_link($export_csv_link); ?>" target="_blank">
                                                <img src="<?php print_link('assets/images/csv.png') ?>" class="mr-2" /> CSV
                                                </a>
                                                <?php $export_excel_link = $this->set_current_page_link(array('format' => 'excel')); ?>
                                                <a class="dropdown-item export-link-btn" data-format="excel" href="<?php print_link($export_excel_link); ?>" target="_blank">
                                                    <img src="<?php print_link('assets/images/xsl.png') ?>" class="mr-2" /> EXCEL
                                                    </a>
                                                </div>
                                            </div>
                                            <a class="btn btn-sm btn-info"  href="<?php print_link("invoice/edit/$rec_id"); ?>">
                                                <i class="fa fa-edit"></i> Edit
                                            </a>
                                            <a class="btn btn-sm btn-danger record-delete-btn mx-1"  href="<?php print_link("invoice/delete/$rec_id/?csrf_token=$csrf_token&redirect=$current_page"); ?>" data-prompt-msg="Are you sure you want to delete this record?" data-display-style="modal">
                                                <i class="fa fa-times"></i> Delete
                                            </a>
                                        </div>
                                        <?php
                                        }
                                        else{
                                        ?>
                                        <!-- Empty Record Message -->
                                        <div class="text-muted p-3">
                                            <i class="fa fa-ban"></i> No Record Found
                                        </div>
                                        <?php
                                        }
                                        ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
