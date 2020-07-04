<?php require APPROOT . '/views/inc/header.php'; ?>
<?php if (isset($_SESSION['user_id'])) : ?>
<div class="container mt-3">
    <?php
        flash("add_post_success");
        flash("update_post_success");
        flash("delete_post_success");
    ?>
    <a href="<?php echo URLROOT; ?>posts/addpost" class="btn btn-info">Thêm bài đăng mới</a>

    <?php
        // $date = new DateTime();
        // var_dump(($date));
        // date_default_timezone_set('Asia/Ho_Chi_Minh');
        // echo date("Y-m-d H:i:s");
        // echo date("2020-06-29 17:12:57");
        // $temp_date = strtotime("2020-06-29 17:12:57");
        // echo date('H', $temp_date);
        // var_dump($data['listPost']);
        // target="_blank"
        // echo $data['numOfPost'];
    ?>

    <div class="row mt-3 mb-5">
        <?php
            $currrent_iduser = $_SESSION['user_id'];
            for($i = 0; $i < count($data['listPost']); $i++){
                $title = $data['listPost'][$i]['title'];
                $content = $data['listPost'][$i]['content'];
                $iduser = $data['listPost'][$i]['iduser'];
                $id = $data['listPost'][$i]['id'];
                if(strlen($content) > 100){
                    $content = substr($content,0,100) . " ...";
                }
                if(strlen($title) > 60){
                    $title = substr($title,0,60) . "...";
                }
                
                $image = $data['listPost'][$i]['image'];
                $id = $data['listPost'][$i]['id'];
                $url = URLROOT . "posts/postdetail/" . $id;
                $urlDeletePost= URLROOT . "posts/deletepost/" . $id;
                $urlEditPost = URLROOT . "posts/rendereditpost/" . $id;

                echo <<< _END
                <div id="ModalConfirm-$id" class="modal fade">
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
                                <p>Bạn có chắc chắn muốn xóa bài post này?</p>
                                <p class="card-title text-danger font-weight-bold news-header">$title</p>
                            </div>
                            <div class="modal-footer justify-content-center">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                <a href="$urlDeletePost"><button type="button" class="btn btn-danger">Delete</button></a>
                            </div>
                        </div>
                    </div>
                </div>
                _END;
                echo <<< _END
                    <div class="col-lg-4 col-md-6 col-12 mt-2" data-aos="flip-up" data-aos-easing="ease-out-cubic" data-aos-duration="2000">
                        <div class="card" style="width: 100%;">
                            <div class="wrap-img-card-list-post">
                                <img src="$image" class="img-card-list-post" alt="...">
                            </div>
                            <div class="card-body">
                            <h5 class="card-title text-danger font-weight-bold news-header content-title">$title</h5>
                            <p class="card-text content-post">$content</p>
                            </div>  
                            <div class="card-body d-flex justify-content-between align-items-center">
                                <a href="$url" class="btn btn-info">Xem chi tiết</a>
                _END;
                if($currrent_iduser == $iduser){
                    echo <<< _END
                    <div class="d-flex">
                        <a href="$urlEditPost" class="btn btn-warning mr-1"><i class="far fa-edit"></i></a>
                        <a href="#ModalConfirm-$id" class="btn btn-danger cursor-pointer" data-toggle="modal"><i class="far fa-trash-alt"></i></a>
                    </div>
                    _END;
                }
                
                echo <<< _END
                            </div>
                        </div>
                    </div>
                _END;
            }
        ?>
        
    </div>
    <div class="d-flex justify-content-end align-items-center">
        <p style="margin-right: 4px;">Trang: </p>
        <nav aria-label="Page navigation example">
            <ul class="pagination" id="pagination">
                <?php 
                    $urlGetListPost = URLROOT . "posts/listposts?pageno=";
                    for ($i = 1; $i <= $data['totalPage']; $i++){
                        $url = $urlGetListPost . $i;
                        echo <<< _END
                            <a href="$url" class="page-item cursor-pointer"><p class="page-link btn_page">$i</p></a>
                        _END;
                    }
                ?>
            </ul>
        </nav>
    </div>
</div>
<?php else: ?>
    <h1 class="text-center mb-5 mt-5">Bạn phải đăng nhập để xem được thông tin này</h1>
<?php endif; ?>

<?php require APPROOT . '/views/inc/footer.php'; ?>