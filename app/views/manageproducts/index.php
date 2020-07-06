<?php if (isset($_SESSION['user_id']) && isset($_SESSION['isAdmin'])) :
    require APPROOT . '/views/inc/header_admin.php';
?>
    <div class="row mt-3">
        <div class="col-md-2 col-12" style="margin-left:40px">
            <div class="list-group" id="list-tab">
                <a class="list-group-item list-group-item-action" id="list-info-list" href="<?php echo URLROOT; ?>admin/index" aria-controls="info"><i class="far fa-user"></i>&nbsp;&nbsp; Quản lý người dùng</a>
                <a class="list-group-item list-group-item-action" id="list-order-list" href="#" role="tab" aria-controls="order"><i class="fas fa-file-alt"></i>&nbsp;&nbsp; Quản lí đơn hàng</a>
                <a class="list-group-item list-group-item-action" id="list-changePass-list" href="<?php echo URLROOT; ?>users/changepass/<?php echo $_SESSION['user_id'] ?>" role="tab" aria-controls="pass"><i class="fas fa-key"></i> &nbsp;&nbsp;Thay đổi mật khẩu</a>
                <a class="list-group-item list-group-item-action active" id="list-products-list" href="<?php echo URLROOT; ?>manageproducts" role="tab" aria-controls="products"><i class="fas fa-coffee"></i> &nbsp;&nbsp;Quản lí sản phẩm</a>
            </div>
        </div>
        <div class="col-md-9 col-12">
            <div class="container card bg-light mb-5 mr-lg-4 ml-lg-4">
                <?php flash('add_product')?>
                <?php flash('update_product');?>
                <?php flash('delete_product');?>
                <div class="row d-flex justify-content-between mt-3">
                    <div class="col-md-6 col-12">
                        <h2>Danh sách sản phẩm</h2>
                    </div>
                    <div class="col-md-6 col-12 d-flex justify-content-md-end">
                        <a class="btn btn-dark" href="<?php echo URLROOT;?>manageproducts/addproduct">Thêm sản phẩm&nbsp;&nbsp;<i class="fas fa-plus"></i></a>
                    </div>
                </div>
                <table class="table table-striped mt-2" style="overflow-x: scroll;">
                    <thead class=" thead-dark">
                        <tr>
                            <th scope="col">ID</th>
                            <th scope="col">Tên</th>
                            <th scope="col">Size/Giá(đ)/Số lượng</th>
                            <th scope="col">Hình ảnh</th>
                            <th scope="col">Mô tả</th>
                            <th scope="col">Loại</th>
                            <th scope="col">Hành động</th>

                        </tr>
                    </thead>
                    <tbody>
                            <?php
                                $products = $data["products"];
                                for($i =0 ; $i < count($products);$i++){
                                    $product = $products[$i];
                                    $product_id = $product["id_product"];
                                    $product_name = $product["name_product"];
                                    $product_image = $product["image"];
                                    $size_price_quality_display = "";
                                    $link_edit = URLROOT. "manageproducts/edit/".$product_id;
                                    $link_delete = URLROOT."manageproducts/delete/".$product_id;
                                    while($row_price = $product["size_price_quality"]->fetch_assoc()){
                                        $size = $row_price["size"];
                                        $price = $row_price["price"];
                                        $quantity = $row_price["quantity"];
                                        $size_price_quality_display .= "<li><span>$size</span>/<span>$price</span>/<span>$quantity</span></li>";
                                    }
                                    $description_display = "";
                                    $arr_description = explode(";", $product["description"]);
                                    for ($j = 0; $j < count($arr_description); $j++) {
                                        $description_display.= "<li>$arr_description[$j]</li>";
                                    }
                                    $category_name = $product["name_category"];
                                    echo
                                    "
                                    <div id='ModalConfirm".$product_id."' class='modal fade'>
                                        <div class='modal-dialog modal-confirm'>
                                            <div class='modal-content'>
                                                <div class='modal-header flex-column'>
                                                    <div class='icon-box'>
                                                        <i>&times;</i>
                                                    </div>
                                                    <h4 class='modal-title w-100'>Xóa sản phẩm</h4>
                                                    <button type='button' class='close' data-dismiss='modal' aria-hidden='true'>&times;</button>
                                                </div>
                                                <div class='modal-body'>
                                                    <p>Bạn có chắc chắn muốn xóa sản phẩm ".$product_name." ?</p>
                                                </div>
                                                <div class='modal-footer justify-content-center'>
                                                    <button type='button' class='btn btn-secondary button-hover' data-dismiss='modal'>Hủy</button>
                                                    <a href='$link_delete'><button type='button' class='btn btn-danger button-hover'>Xóa</button></a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <tr>
                                        <th scope='row'>$product_id</th>
                                        <td>$product_name</td>
                                        <td>
                                            <ul class='list-description-admin'>"
                                            . $size_price_quality_display.
                                            "</ul>
                                        </td>
                                        <td><a href='$product_image'><img style='width:55px;height:55px;' src='$product_image' alt='$product_name image'></a></td>
                                        <td>
                                            <ul class='list-description-admin'>"
                                            .$description_display.
                                            "</ul>
                                        </td>
                                        <td>$category_name</td>
                                        <td class='d-flex justify-content-center'>
                                            <a href='$link_edit' class='btn btn-outline-success'><i class='fas fa-edit'></i></a>
                                            <a href='#ModalConfirm".$product_id."' class='btn btn-outline-danger ml-1' data-toggle='modal'><i class='fas fa-trash'></i></a>
                                        </td>
                                    </tr>
                                    ";
                                }
                            ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <?php require APPROOT . '/views/inc/footer.php'; ?>

<?php else : ?>
    <h1 style="text-align: center">Bạn phải là Adminitrator để xem được thông tin này</h1>
<?php endif; ?>

