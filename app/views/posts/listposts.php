<?php require APPROOT . '/views/inc/header.php'; ?>
<?php if (isset($_SESSION['user_id'])) : ?>
<div class="container">
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
    ?>

    <div class="row mt-4 mb-5">
        <?php
            for($i = 0; $i < count($data['listPost']); $i++){
                $title = $data['listPost'][$i]['title'];
                $content = $data['listPost'][$i]['content'];
                if(strlen($content) > 100){
                    $content = substr($content,0,100) . " ...";
                }
                $image = $data['listPost'][$i]['image'];
                $id = $data['listPost'][$i]['id'];
                $url = URLROOT . "posts/postdetail/" . $id;
                echo <<< _END
                    <div class="col-lg-4 col-md-6 col-12 mt-2" data-aos="flip-up" data-aos-easing="ease-out-cubic" data-aos-duration="2000">
                        <div class="card" style="width: 100%;">
                            <img src="$image" class="card-img-top" alt="...">
                            <div class="card-body">
                            <h5 class="card-title text-danger font-weight-bold news-header">$title</h5>
                            <p class="card-text">$content</p>
                            </div>
                            <div class="card-body">
                            <a href="$url">Xem chi tiết</a>
                            </div>
                        </div>
                    </div>
                _END;
            }
        ?>
        
    </div>
</div>
<?php else: ?>
    <h1 class="text-center">Bạn phải đăng nhập để xem được thông tin này</h1>
<?php endif; ?>

<?php require APPROOT . '/views/inc/footer.php'; ?>