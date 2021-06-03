<?php
$current_page = $this->set_current_page_link();
$csrf_token = Csrf::$token;
$field_name = $this->route->field_name;
$field_value = $this->route->field_value;
$view_data = $this->view_data;
$records = $view_data->records;
$record_count = $view_data->record_count;
$total_records = $view_data->total_records;
if (!empty($records)) {
?>
<!--record-->
<?php
$counter = 0;
foreach($records as $data){
$rec_id = (!empty($data['id']) ? urlencode($data['id']) : null);
$counter++;
?>
<tr>
    <th class=" td-checkbox">
        <label class="custom-control custom-checkbox custom-control-inline">
            <input class="optioncheck custom-control-input" name="optioncheck[]" value="<?php echo $data['id'] ?>" type="checkbox" />
                <span class="custom-control-label"></span>
            </label>
        </th>
        <th class="td-sno"><?php echo $counter; ?></th>
        <td class="td-item_invt_id">
            <a size="sm" class="btn btn-sm btn-primary page-modal" href="<?php print_link("inventory/view/" . urlencode($data['item_invt_id'])) ?>">
                <i class="fa fa-eye"></i> <?php echo $data['inventory_name'] ?>
            </a>
        </td>
        <td class="td-invoice_number">
            <a size="sm" class="btn btn-sm btn-primary page-modal" href="<?php print_link("invoice/view/" . urlencode($data['invoice_number'])) ?>">
                # <?php echo $data['invoice_number'] ?>
            </a>
        </td>
        <td class="td-quantity"> <?php echo $data['quantity']; ?></td>
        <td class="td-date"> <?php echo $data['date']; ?></td>
        <th class="td-btn">
            <a class="btn btn-sm btn-success has-tooltip page-modal" title="View Record" href="<?php print_link("invoice_items/view/$rec_id"); ?>">
                <i class="fa fa-eye"></i> View
            </a>
            <a class="btn btn-sm btn-danger has-tooltip record-delete-btn" title="Delete this record" href="<?php print_link("invoice_items/delete/$rec_id/?csrf_token=$csrf_token&redirect=$current_page"); ?>" data-prompt-msg="Are you sure you want to delete this record?" data-display-style="modal">
                <i class="fa fa-times"></i>
                Delete
            </a>
        </th>
    </tr>
    <?php 
    }
    ?>
    <?php
    } else {
    ?>
    <td class="no-record-found col-12" colspan="100">
        <h4 class="text-muted text-center ">
            No Record Found
        </h4>
    </td>
    <?php
    }
    ?>
    