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
<section class="page" id="<?php echo $page_element_id; ?>" data-page-type="view"  data-display-type="table" data-page-url="<?php print_link($current_page); ?>">
    <?php
    if( $show_header == true ){
    ?>
    <div  class="bg-light p-3 mb-3">
        <div class="container">
            <div class="row ">
                <div class="col ">
                    <h4 class="record-title">My Account</h4>
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
                        $counter++;
                        ?>
                        <div class="bg-primary m-2 mb-4">
                            <div class="profile">
                                <div class="avatar">
                                    <?php 
                                    if(!empty(USER_PHOTO)){
                                    Html::page_img(USER_PHOTO, 100, 100); 
                                    }
                                    ?>
                                </div>
                                <h1 class="title mt-4"><?php echo $data['username']; ?></h1>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-3">
                                <div class="mx-3 mb-3">
                                    <ul class="nav nav-pills flex-column text-left">
                                        <li class="nav-item">
                                            <a data-toggle="tab" href="#AccountPageView" class="nav-link active">
                                                <i class="fa fa-user"></i> Account Detail
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a data-toggle="tab" href="#AccountPageEdit" class="nav-link">
                                                <i class="fa fa-edit"></i> Edit Account
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a data-toggle="tab" href="#AccountPageChangeEmail" class="nav-link">
                                                <i class="fa fa-envelope"></i> Change Email
                                            </a>
                                        </li>
                                        <li class="nav-item">
                                            <a data-toggle="tab" href="#AccountPageChangePassword" class="nav-link">
                                                <i class="fa fa-key"></i> Reset Password
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="col-sm-9">
                                <div class="mb-3">
                                    <div class="tab-content">
                                        <div class="tab-pane show active fade" id="AccountPageView" role="tabpanel">
                                            <table class="table table-hover table-borderless table-striped">
                                                <tbody class="page-data" id="page-data-<?php echo $page_element_id; ?>">
                                                    <tr  class="td-id">
                                                        <th class="title"> Id: </th>
                                                        <td class="value"> <?php echo $data['id']; ?></td>
                                                    </tr>
                                                    <tr  class="td-f_name">
                                                        <th class="title"> F Name: </th>
                                                        <td class="value">
                                                            <span  data-value="<?php echo $data['f_name']; ?>" 
                                                                data-pk="<?php echo $data['id'] ?>" 
                                                                data-url="<?php print_link("user/editfield/" . urlencode($data['id'])); ?>" 
                                                                data-name="f_name" 
                                                                data-title="Enter F Name" 
                                                                data-placement="left" 
                                                                data-toggle="click" 
                                                                data-type="text" 
                                                                data-mode="popover" 
                                                                data-showbuttons="left" 
                                                                class="is-editable" >
                                                                <?php echo $data['f_name']; ?> 
                                                            </span>
                                                        </td>
                                                    </tr>
                                                    <tr  class="td-l_name">
                                                        <th class="title"> L Name: </th>
                                                        <td class="value">
                                                            <span  data-value="<?php echo $data['l_name']; ?>" 
                                                                data-pk="<?php echo $data['id'] ?>" 
                                                                data-url="<?php print_link("user/editfield/" . urlencode($data['id'])); ?>" 
                                                                data-name="l_name" 
                                                                data-title="Enter L Name" 
                                                                data-placement="left" 
                                                                data-toggle="click" 
                                                                data-type="text" 
                                                                data-mode="popover" 
                                                                data-showbuttons="left" 
                                                                class="is-editable" >
                                                                <?php echo $data['l_name']; ?> 
                                                            </span>
                                                        </td>
                                                    </tr>
                                                    <tr  class="td-username">
                                                        <th class="title"> Username: </th>
                                                        <td class="value">
                                                            <span  data-value="<?php echo $data['username']; ?>" 
                                                                data-pk="<?php echo $data['id'] ?>" 
                                                                data-url="<?php print_link("user/editfield/" . urlencode($data['id'])); ?>" 
                                                                data-name="username" 
                                                                data-title="Enter Username" 
                                                                data-placement="left" 
                                                                data-toggle="click" 
                                                                data-type="text" 
                                                                data-mode="popover" 
                                                                data-showbuttons="left" 
                                                                class="is-editable" >
                                                                <?php echo $data['username']; ?> 
                                                            </span>
                                                        </td>
                                                    </tr>
                                                    <tr  class="td-email">
                                                        <th class="title"> Email: </th>
                                                        <td class="value"> <?php echo $data['email']; ?></td>
                                                    </tr>
                                                    <tr  class="td-role">
                                                        <th class="title"> Role: </th>
                                                        <td class="value">
                                                            <a size="sm" class="btn btn-sm btn-primary page-modal" href="<?php print_link("masterdetail/index/account/account_role/id/" . urlencode($data['role'])) ?>">
                                                                <i class="fa fa-eye"></i> <?php echo $data['user_role_role_name'] ?>
                                                            </a>
                                                        </td>
                                                    </tr>
                                                    <tr  class="td-phone">
                                                        <th class="title"> Phone: </th>
                                                        <td class="value">
                                                            <span  data-value="<?php echo $data['phone']; ?>" 
                                                                data-pk="<?php echo $data['id'] ?>" 
                                                                data-url="<?php print_link("user/editfield/" . urlencode($data['id'])); ?>" 
                                                                data-name="phone" 
                                                                data-title="Enter Phone" 
                                                                data-placement="left" 
                                                                data-toggle="click" 
                                                                data-type="text" 
                                                                data-mode="popover" 
                                                                data-showbuttons="left" 
                                                                class="is-editable" >
                                                                <?php echo $data['phone']; ?> 
                                                            </span>
                                                        </td>
                                                    </tr>
                                                </tbody>    
                                            </table>
                                        </div>
                                        <div class="tab-pane fade" id="AccountPageEdit" role="tabpanel">
                                            <div class=" reset-grids">
                                                <?php  $this->render_page("account/edit"); ?>
                                            </div>
                                        </div>
                                        <div class="tab-pane  fade" id="AccountPageChangeEmail" role="tabpanel">
                                            <div class=" reset-grids">
                                                <?php  $this->render_page("account/change_email"); ?>
                                            </div>
                                        </div>
                                        <div class="tab-pane fade" id="AccountPageChangePassword" role="tabpanel">
                                            <div class=" reset-grids">
                                                <?php  $this->render_page("passwordmanager"); ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
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
