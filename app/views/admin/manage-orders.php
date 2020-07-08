<?php if (isset($_SESSION['user_id']) && isset($_SESSION['isAdmin'])) :
    require APPROOT . '/views/inc/header_admin.php';
?>

    <div class="row mt-3">
        <div class="col-lg-2 col-12">
            <div class="list-group" id="list-tab">
                <a class="list-group-item list-group-item-action " id="list-info-list" href="<?php echo URLROOT; ?>admin/index" aria-controls="info"><i class="far fa-user"></i>&nbsp;&nbsp; Quản lý người dùng</a>

                <a class="list-group-item list-group-item-action active" id="list-order-list" href="<?php echo URLROOT; ?>admin/manageOrders" role="tab" aria-controls="order"><i class="fas fa-file-alt"></i>&nbsp;&nbsp; Quản lí đơn hàng</a>

                <a class="list-group-item list-group-item-action" id="list-products-list" href="<?php echo URLROOT; ?>manageproducts" role="tab" aria-controls="products"><i class="fas fa-coffee"></i> &nbsp;&nbsp;Quản lí sản phẩm</a>

                <a class="list-group-item list-group-item-action" id="list-changePass-list" href="<?php echo URLROOT; ?>admin/changepass/<?php echo $_SESSION['user_id'] ?>" role="tab" aria-controls="pass"><i class="fas fa-key"></i> &nbsp;&nbsp;Thay đổi mật khẩu</a>
            </div>
        </div>
        <div class="col-lg-10 col-12">
            <div class="card card-body bg-light mb-5 mr-lg-4 ml-lg-4">
                <h4 class="text-center">Danh sách các đơn hàng</h4>
                <?php flash('update-status'); ?>
                <section id="tabs" class="project-tab">
                    <!-- <div class=""> -->
                    <div class="row">
                        <div class="col-md-12">
                            <nav>
                                <div class="nav nav-tabs nav-fill" id="nav-tab" role="tablist">
                                    <a class="nav-item nav-link active " data-toggle="tab" href="#1" role="tab">Chờ Xác nhận</a>
                                    <a class="nav-item nav-link " data-toggle="tab" href="#2" role="tab">Đã Xác nhận</a>
                                    <a class="nav-item nav-link" data-toggle="tab" href="#3" role="tab">Đang giao hàng</a>
                                    <a class="nav-item nav-link" data-toggle="tab" href="#4" role="tab">Đã giao hàng</a>
                                </div>
                            </nav>
                            <div class="tab-content" id="nav-tabContent">
                                <div class="tab-pane fade show active" id="1" role="tabpanel">
                                    <?php
                                    for ($i = 0; $i < count($data); $i++) :
                                        if ($data[$i]['status'] == 1) {
                                            $status = 'Chờ xác nhận';
                                            $color = 'gray';
                                        } else if ($data[$i]['status'] == 2) {
                                            continue;
                                            $status = 'Đã xác nhận';
                                            $color = 'black';
                                        } else if ($data[$i]['status'] == 3) {
                                            continue;
                                            $status = 'Đang giao hàng';
                                            $color = 'blue';
                                        } else if ($data[$i]['status'] == 4) {
                                            continue;
                                            $status = 'Đã giao hàng';
                                            $color = 'green';
                                        }
                                    ?>
                                        <div class='card' style="margin-top:25px; padding:15px 10px;overflow-x:auto;">
                                            <table class="table table-hover shopping-cart-wrap">
                                                <h6 class="text-center">Mã đơn hàng: #<?php echo $data[$i]['id'] ?></h6>
                                                <h6 class="text-center">Tên khách hàng: <?php echo $data[$i]['user']->name ?></h6>
                                                <h6 class="text-center">Địa chỉ giao hàng: <?php echo $data[$i]['user']->address ?></h6>
                                                <h6 class="text-center">Số điện thoại: <?php echo $data[$i]['user']->phone ?></h6>
                                                <h6 class="text-center" style="margin-bottom:20px">Email: <?php echo $data[$i]['user']->email ?></h6>
                                                <thead class="text-muted">
                                                    <tr>
                                                        <th scope="col">Sản phẩm</th>
                                                        <th scope="col" width="100">Size</th>
                                                        <th scope="col" width="120">Số lượng</th>
                                                        <th scope="col" width="120">Giá</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    $total_price = 0;
                                                    for ($x = 0; $x < count($data[$i]['product']); $x++) :
                                                        $product = $data[$i]['product'][$x];
                                                        $total_price += $product['quantity'] * $product['price'];
                                                    ?>
                                                        <tr>
                                                            <td>
                                                                <figure class="media">
                                                                    <div class="img-wrap" id='container-img-cart'><img src="<?php echo $product['image']; ?>" class="img-thumbnail img-sm" id="img-cart"></div>
                                                                    <figcaption class="media-body">
                                                                        <h6 class="title text-truncate"><?php echo $product['name']; ?></h6>
                                                                    </figcaption>
                                                                </figure>
                                                            </td>
                                                            <td><?php echo $product['size']; ?></td>
                                                            <td>
                                                                <?php echo $product['quantity'] ?>
                                                            </td>
                                                            <td>
                                                                <div class="price-wrap">
                                                                    <var class="price"><?php echo $product['price']; ?>đ</var>
                                                                </div>
                                                            </td>
                                                        </tr>

                                                    <?php endfor; ?>
                                                </tbody>
                                            </table>
                                            <p class='price text-right' style='padding-right:25px'>Tổng giá tiền: <?php echo $total_price; ?>đ</p>

                                            <form action="<?php echo URLROOT; ?>admin/changeStatus/<?php echo $data[$i]['id'] . "/" . $data[$i]['userId'] ?>" method="post">
                                                <div class="form-group" style="margin:15px 30px;">
                                                    <label>Chọn trạng thái đơn hàng</label>
                                                    <select class="form-control" name="status" style="font-size: 14px">
                                                        <option value="1" <?php if ($data[$i]['status'] == 1) echo "selected" ?>>Chờ xác nhận</option>
                                                        <option value="2" <?php if ($data[$i]['status'] == 2) echo "selected" ?>>Xác nhận</option>
                                                        <option value="3" <?php if ($data[$i]['status'] == 3) echo "selected" ?>>Đang giao hàng</option>
                                                        <option value="4" <?php if ($data[$i]['status'] == 4) echo "selected" ?>>Đã giao hàng</option>
                                                    </select>
                                                    <div style='margin-top:15px' class="d-flex justify-content-end">
                                                        <input type="submit" value="Thay đổi trạng thái" class="btn btn-outline-success">
                                                    </div>
                                                </div>
                                            </form>

                                        </div>
                                    <?php endfor; ?>
                                </div>
                                <div class="tab-pane fade" id="2" role="tabpanel">
                                    <?php
                                    for ($i = 0; $i < count($data); $i++) :
                                        if ($data[$i]['status'] == 1) {
                                            continue;
                                            $status = 'Chờ xác nhận';
                                            $color = 'gray';
                                        } else if ($data[$i]['status'] == 2) {
                                            $status = 'Đã xác nhận';
                                            $color = 'black';
                                        } else if ($data[$i]['status'] == 3) {
                                            continue;
                                            $status = 'Đang giao hàng';
                                            $color = 'blue';
                                        } else if ($data[$i]['status'] == 4) {
                                            continue;
                                            $status = 'Đã giao hàng';
                                            $color = 'green';
                                        }
                                    ?>
                                        <div class='card' style="margin-top:25px; padding:15px 10px;">
                                            <table class="table table-hover shopping-cart-wrap">
                                                <h6 class="text-center">Mã đơn hàng: #<?php echo $data[$i]['id'] ?></h6>
                                                <h6 class="text-center">Tên khách hàng: <?php echo $data[$i]['user']->name ?></h6>
                                                <h6 class="text-center">Địa chỉ giao hàng: <?php echo $data[$i]['user']->address ?></h6>
                                                <h6 class="text-center">Số điện thoại: <?php echo $data[$i]['user']->phone ?></h6>
                                                <h6 class="text-center" style="margin-bottom:20px">Email: <?php echo $data[$i]['user']->email ?></h6>
                                                <thead class="text-muted">
                                                    <tr>
                                                        <th scope="col">Sản phẩm</th>
                                                        <th scope="col" width="100">Size</th>
                                                        <th scope="col" width="120">Số lượng</th>
                                                        <th scope="col" width="120">Giá</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    $total_price = 0;
                                                    for ($x = 0; $x < count($data[$i]['product']); $x++) :
                                                        $product = $data[$i]['product'][$x];
                                                        $total_price += $product['quantity'] * $product['price'];
                                                    ?>
                                                        <tr>
                                                            <td>
                                                                <figure class="media">
                                                                    <div class="img-wrap" id='container-img-cart'><img src="<?php echo $product['image']; ?>" class="img-thumbnail img-sm" id="img-cart"></div>
                                                                    <figcaption class="media-body">
                                                                        <h6 class="title text-truncate"><?php echo $product['name']; ?></h6>
                                                                    </figcaption>
                                                                </figure>
                                                            </td>
                                                            <td><?php echo $product['size']; ?></td>
                                                            <td>
                                                                <?php echo $product['quantity'] ?>
                                                            </td>
                                                            <td>
                                                                <div class="price-wrap">
                                                                    <var class="price"><?php echo $product['price']; ?>đ</var>
                                                                </div>
                                                            </td>
                                                        </tr>

                                                    <?php endfor; ?>
                                                </tbody>
                                            </table>
                                            <p class='price text-right' style='padding-right:25px'>Tổng giá tiền: <?php echo $total_price; ?>đ</p>

                                            <form action="<?php echo URLROOT; ?>admin/changeStatus/<?php echo $data[$i]['id'] . "/" . $data[$i]['userId'] ?>" method="post">
                                                <div class="form-group" style="margin:15px 30px;">
                                                    <label>Chọn trạng thái đơn hàng</label>
                                                    <select class="form-control" name="status" style="font-size: 14px">
                                                        <option value="2" <?php if ($data[$i]['status'] == 2) echo "selected" ?>>Xác nhận</option>
                                                        <option value="3" <?php if ($data[$i]['status'] == 3) echo "selected" ?>>Đang giao hàng</option>
                                                        <option value="4" <?php if ($data[$i]['status'] == 4) echo "selected" ?>>Đã giao hàng</option>
                                                    </select>
                                                    <div style='margin-top:15px' class="d-flex justify-content-end">
                                                        <input type="submit" value="Thay đổi trạng thái" class="btn btn-outline-success">
                                                    </div>
                                                </div>
                                            </form>

                                        </div>
                                    <?php endfor; ?>
                                </div>
                                <div class="tab-pane fade" id="3" role="tabpanel">
                                    <?php
                                    for ($i = 0; $i < count($data); $i++) :
                                        if ($data[$i]['status'] == 1) {
                                            continue;
                                            $status = 'Chờ xác nhận';
                                            $color = 'gray';
                                        } else if ($data[$i]['status'] == 2) {
                                            continue;
                                            $status = 'Đã xác nhận';
                                            $color = 'black';
                                        } else if ($data[$i]['status'] == 3) {
                                            $status = 'Đang giao hàng';
                                            $color = 'blue';
                                        } else if ($data[$i]['status'] == 4) {
                                            continue;
                                            $status = 'Đã giao hàng';
                                            $color = 'green';
                                        }
                                    ?>
                                        <div class='card' style="margin-top:25px; padding:15px 10px;">
                                            <table class="table table-hover shopping-cart-wrap">
                                                <h6 class="text-center">Mã đơn hàng: #<?php echo $data[$i]['id'] ?></h6>
                                                <h6 class="text-center">Tên khách hàng: <?php echo $data[$i]['user']->name ?></h6>
                                                <h6 class="text-center">Địa chỉ giao hàng: <?php echo $data[$i]['user']->address ?></h6>
                                                <h6 class="text-center">Số điện thoại: <?php echo $data[$i]['user']->phone ?></h6>
                                                <h6 class="text-center" style="margin-bottom:20px">Email: <?php echo $data[$i]['user']->email ?></h6>
                                                <thead class="text-muted">
                                                    <tr>
                                                        <th scope="col">Sản phẩm</th>
                                                        <th scope="col" width="100">Size</th>
                                                        <th scope="col" width="120">Số lượng</th>
                                                        <th scope="col" width="120">Giá</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    $total_price = 0;
                                                    for ($x = 0; $x < count($data[$i]['product']); $x++) :
                                                        $product = $data[$i]['product'][$x];
                                                        $total_price += $product['quantity'] * $product['price'];
                                                    ?>
                                                        <tr>
                                                            <td>
                                                                <figure class="media">
                                                                    <div class="img-wrap" id='container-img-cart'><img src="<?php echo $product['image']; ?>" class="img-thumbnail img-sm" id="img-cart"></div>
                                                                    <figcaption class="media-body">
                                                                        <h6 class="title text-truncate"><?php echo $product['name']; ?></h6>
                                                                    </figcaption>
                                                                </figure>
                                                            </td>
                                                            <td><?php echo $product['size']; ?></td>
                                                            <td>
                                                                <?php echo $product['quantity'] ?>
                                                            </td>
                                                            <td>
                                                                <div class="price-wrap">
                                                                    <var class="price"><?php echo $product['price']; ?>đ</var>
                                                                </div>
                                                            </td>
                                                        </tr>

                                                    <?php endfor; ?>
                                                </tbody>
                                            </table>
                                            <p class='price text-right' style='padding-right:25px'>Tổng giá tiền: <?php echo $total_price; ?>đ</p>

                                            <form action="<?php echo URLROOT; ?>admin/changeStatus/<?php echo $data[$i]['id'] . "/" . $data[$i]['userId'] ?>" method="post">
                                                <div class="form-group" style="margin:15px 30px;">
                                                    <label>Chọn trạng thái đơn hàng</label>
                                                    <select class="form-control" name="status" style="font-size: 14px">
                                                        <option value="3" <?php if ($data[$i]['status'] == 3) echo "selected" ?>>Đang giao hàng</option>
                                                        <option value="4" <?php if ($data[$i]['status'] == 4) echo "selected" ?>>Đã giao hàng</option>
                                                    </select>
                                                    <div style='margin-top:15px' class="d-flex justify-content-end">
                                                        <input type="submit" value="Thay đổi trạng thái" class="btn btn-outline-success">
                                                    </div>
                                                </div>
                                            </form>

                                        </div>
                                    <?php endfor; ?>
                                </div>
                                <div class="tab-pane fade" id="4" role="tabpanel">
                                    <?php
                                    for ($i = 0; $i < count($data); $i++) :
                                        if ($data[$i]['status'] == 1) {
                                            continue;
                                            $status = 'Chờ xác nhận';
                                            $color = 'gray';
                                        } else if ($data[$i]['status'] == 2) {
                                            continue;
                                            $status = 'Đã xác nhận';
                                            $color = 'black';
                                        } else if ($data[$i]['status'] == 3) {
                                            continue;
                                            $status = 'Đang giao hàng';
                                            $color = 'blue';
                                        } else if ($data[$i]['status'] == 4) {
                                            $status = 'Đã giao hàng';
                                            $color = 'green';
                                        }
                                    ?>
                                        <div class='card' style="margin-top:25px; padding:15px 10px;">
                                            <table class="table table-hover shopping-cart-wrap">
                                                <h6 class="text-center">Mã đơn hàng: #<?php echo $data[$i]['id'] ?></h6>
                                                <h6 class="text-center">Tên khách hàng: <?php echo $data[$i]['user']->name ?></h6>
                                                <h6 class="text-center">Địa chỉ giao hàng: <?php echo $data[$i]['user']->address ?></h6>
                                                <h6 class="text-center">Số điện thoại: <?php echo $data[$i]['user']->phone ?></h6>
                                                <h6 class="text-center" style="margin-bottom:20px">Email: <?php echo $data[$i]['user']->email ?></h6>

                                                <thead class="text-muted">
                                                    <tr>
                                                        <th scope="col">Sản phẩm</th>
                                                        <th scope="col" width="100">Size</th>
                                                        <th scope="col" width="120">Số lượng</th>
                                                        <th scope="col" width="120">Giá</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    $total_price = 0;
                                                    for ($x = 0; $x < count($data[$i]['product']); $x++) :
                                                        $product = $data[$i]['product'][$x];
                                                        $total_price += $product['quantity'] * $product['price'];
                                                    ?>
                                                        <tr>
                                                            <td>
                                                                <figure class="media">
                                                                    <div class="img-wrap" id='container-img-cart'><img src="<?php echo $product['image']; ?>" class="img-thumbnail img-sm" id="img-cart"></div>
                                                                    <figcaption class="media-body">
                                                                        <h6 class="title text-truncate"><?php echo $product['name']; ?></h6>
                                                                    </figcaption>
                                                                </figure>
                                                            </td>
                                                            <td><?php echo $product['size']; ?></td>
                                                            <td>
                                                                <?php echo $product['quantity'] ?>
                                                            </td>
                                                            <td>
                                                                <div class="price-wrap">
                                                                    <var class="price"><?php echo $product['price']; ?>đ</var>
                                                                </div>
                                                            </td>
                                                        </tr>

                                                    <?php endfor; ?>
                                                </tbody>
                                            </table>
                                            <p class='price text-right' style='padding-right:25px'>Tổng giá tiền: <?php echo $total_price; ?>đ</p>

                                        </div>
                                    <?php endfor; ?>
                                </div>
                            </div>
                        </div>
                    </div>
            </div>
            <!-- </div> -->
            </section>

        </div>
    </div>
    </div>
    <?php require APPROOT . '/views/inc/footer.php'; ?>
<?php else : ?>
    <h1 style="text-align: center">Bạn phải là Adminitrator để xem được thông tin này</h1>
<?php endif; ?>