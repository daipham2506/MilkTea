<?php if (isset($_SESSION['user_id']) && isset($_SESSION['isAdmin'])) :
    require APPROOT . '/views/inc/header_admin.php';
?>
    <div class="row mt-3">
        <div class="col-lg-2 col-12">
            <div class="list-group" id="list-tab">
                <a class="list-group-item list-group-item-action active" id="list-info-list" href="<?php echo URLROOT; ?>admin/index" aria-controls="info"><i class="far fa-user"></i>&nbsp;&nbsp; Quản lý người dùng</a>

                <a class="list-group-item list-group-item-action" id="list-order-list" href="<?php echo URLROOT; ?>admin/manageOrders" role="tab" aria-controls="order"><i class="fas fa-file-alt"></i>&nbsp;&nbsp; Quản lí đơn hàng</a>

                <a class="list-group-item list-group-item-action" id="list-products-list" href="<?php echo URLROOT; ?>manageproducts" role="tab" aria-controls="products"><i class="fas fa-coffee"></i> &nbsp;&nbsp;Quản lí sản phẩm</a>

                <a class="list-group-item list-group-item-action" id="list-changePass-list" href="<?php echo URLROOT; ?>admin/changepass/<?php echo $_SESSION['user_id'] ?>" role="tab" aria-controls="pass"><i class="fas fa-key"></i> &nbsp;&nbsp;Thay đổi mật khẩu</a>

            </div>
        </div>
        <div class="col-lg-10 col-12">
            <div class="card card-body bg-light mb-5 mr-lg-4 ml-lg-4">
                <h2>Danh sách người dùng</h2>
                <?php flash('del_user'); ?>
                <div style="overflow-x: auto;">
                    <table class="table table-striped">
                        <thead class=" thead-dark">
                            <tr>
                                <th scope="col">ID</th>
                                <th scope="col">Họ Tên</th>
                                <th scope="col">Email</th>
                                <th scope="col">Số điện thoại</th>
                                <th scope="col">Avatar</th>
                                <th scope="col">Địa chỉ</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            foreach ($data['users'] as $user) {
                                $url = URLROOT . 'admin/deleteUser/' . $user['id'];
                                echo
                                    '
                            <div id="ModalConfirm' . $user['id'] . '" class="modal fade">
                                <div class="modal-dialog modal-confirm">
                                    <div class="modal-content">
                                        <div class="modal-header flex-column">
                                            <div class="icon-box">
                                                <i>&times;</i>
                                            </div>
                                            <h4 class="modal-title w-100">Are you sure?</h4>
                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                        </div>
                                        <div class="modal-body">
                                            <p>Bạn có chắc chắn muốn xóa user ' . $user['name'] . '?</p>
                                        </div>
                                        <div class="modal-footer justify-content-center">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                            <a href=' . $url . '><button type="button" class="btn btn-danger">Delete</button></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <tr>
                                <th scope="row">' . $user['id'] . '</th>
                                <td>' . $user['name'] . '</td>
                                <td>' . $user['email'] . '</td>
                                <td>' . $user['phone'] . '</td>
                                <td><img style="width:40px;height:40px;border-radius:50%" src=' . $user['avatar'] . ' alt="user-avatar"></td>
                                <td>' . $user['address'] . '</td>
                                <td> <a href="#ModalConfirm' . $user['id'] . '" data-toggle="modal"><button type="button" class="btn btn-outline-danger">Xóa</button></a></td>
                            </tr>';
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
                <div class="d-flex justify-content-end align-items-center">
                    <p class="mr-3 mb-0">Trang: </p>
                    <nav aria-label="Page navigation example" style="height: 40px;">
                        <ul class="pagination" id="pagination">
                            <?php
                            $page = 1;
                            if(isset($_GET["page"])){
                                $page = $_GET["page"];
                            }
                            $urlGetListProduct = URLROOT . "admin?page=";
                            for ($i = 1; $i <= $data["totalPage"]; $i++) {
                                $url = $urlGetListProduct . $i;
                                if($page == $i){
                                    echo <<< _END
                                        <a href="$url" class="page-item cursor-pointer"><p class="page-link btn_page active_page">$i</p></a>
                                    _END;
                                }
                                else{
                                    echo <<< _END
                                        <a href="$url" class="page-item cursor-pointer"><p class="page-link btn_page">$i</p></a>
                                    _END;
                                }
                            }
                            ?>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </div>

    <?php require APPROOT . '/views/inc/footer.php'; ?>

<?php else : ?>
    <h1 style="text-align: center">Bạn phải là Adminitrator để xem được thông tin này</h1>
<?php endif; ?>