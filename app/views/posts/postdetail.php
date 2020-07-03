<?php require APPROOT . '/views/inc/header.php'; ?>
<?php if (isset($_SESSION['user_id'])) : ?>
    <?php
        // var_dump($data["listComment"]);
        // var_dump($data["listPostRecently"]);
    ?>
<div class="container mt-3">
    <div class="row">
        <div class="col-xl-9 col-lg-9 col-12">
            <div class="d-flex align-items-center mb-3">
                <div class="title-avatar">
                    <img class="title-avatar-img" src="<?php echo $data["postDetail"]["avatar"]; ?>" alt="">
                </div>
                <div>
                    <div class="title-name-user"><?php echo $data["postDetail"]["name"]; ?></div>
                    <div class="title-date-create"><?php echo $data["postDetail"]["createdAt"]; ?></div>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-12 font-weight-bold">
                    <?php echo $data["postDetail"]["title"]; ?>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-12 d-flex justify-content-center">
                    <img class="content-main-img" src="<?php echo $data["postDetail"]["image"]; ?>" alt="">
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-12">
                    <?php echo $data["postDetail"]["content"]; ?>
                </div>
            </div>
            <!-- <div class="row mb-1">
                <div class="col-12 d-flex justify-content-between">
                    <div class="number-of-like mr-5 ml-5">
                        <i class="far fa-thumbs-up"></i>
                        <span>243</span>
                    </div>
                    <div class="number-of-comment mr-5 ml-5">
                    <span>14 </span> bình luận
                    </div>
                </div>
            </div> -->
            <div class="row mb-3">
                <div class="col-12">
                    <div class="d-flex align-items-center wrap-react">
                        <!-- <div class="d-flex align-items-center ml-5 mr-5">
                            <i class="far fa-thumbs-up icon-like"></i>
                            <div class="text-in-icon">Thích</div>
                        </div> -->
                        <label class="d-flex align-items-center ml-5 mr-5 mb-0 btn btn-info" for="input-add-comment">
                            <i class="far fa-comment-alt icon-like"></i>
                            <div class="text-in-icon">Bình luận</div>
                        </label>
                    </div>
                </div>
            </div>

            <div id="list-comments">

            </div>

            <form action="<?php echo URLROOT; ?>posts/addcomment" method="POST">
                <div class="form-group d-flex">
                    <input type="text" class="form-control mr-2" name="comment" id="input-add-comment" aria-describedby="emailHelp" placeholder="Thêm bình luận mới">
                    <input type="text" value="<?php echo $data["postDetail"]["idpost"]; ?>" class="d-none form-control mr-2" name="idpost" aria-describedby="emailHelp">
                    <button type="button" idpost="<?php echo $data["postDetail"]["idpost"]; ?>" id="my-btn-add-comment" class="btn btn-info btn-add-comment">Add</button>
                </div>
            </form>
            <a href="<?php echo URLROOT; ?>posts/listposts" class="btn btn-primary col-6 col-xl-3 col-lg-3 col-md-3 mr-2">Quay lại danh sách</a>
        </div>

        <div class="col-3 list-post-recently hidden-list-recently-post">
            <h5 class="list-post-recently-title">Bài đăng gần đây</h5>
            <ul>
                <li>
                    <?php
                        
                        foreach ($data["listPostRecently"] as $item){
                            $image = $item["image"];
                            $title = $item["title"];
                            if(strlen($title) > 50){
                                $title = substr($title,0,50) . "...";
                            }
                            $urlPostDetail = URLROOT . "posts/postdetail/" . $item["id"];
                            echo <<< _END
                                <a href="$urlPostDetail" class="d-flex list-post-recently-link">
                                    <img class="list-post-recently-img" src="$image" alt="">
                                    <div class="list-post-recently-content-title">$title</div>
                                </a>
                            _END;
                        }
                    ?>
                </li>
                
            </ul>
        </div>
    </div>
</div>
<?php else: ?>
<h1 class="text-center">Bạn phải đăng nhập để xem được thông tin này</h1>
<?php endif; ?>
<?php require APPROOT . '/views/inc/footer.php'; ?>