<?php require APPROOT . '/views/inc/header.php'; ?>
<?php if (isset($_SESSION['user_id'])) : ?>
<div class="d-flex justify-content-center">
    <div class="col-xl-9 col-lg-9 col-12">
        <h2 class="mb-3">Tạo bài đăng mới</h2>
        <form action="<?php echo URLROOT; ?>posts/addnewpost" method="post" enctype="multipart/form-data">
            <div class="form-group">
                <label for="exampleInputEmail1">Tiêu đề</label>
                <input type="text" name="post_title" required value="<?php echo $data['post_title']; ?>" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
                <p><?php echo $data['post_title_err']; ?></p>
            </div>
            <div class="form-group">
                <label for="exampleFormControlTextarea1">Nội dung</label>
                <textarea class="form-control" required name="post_content" value="<?php echo $data['post_content']; ?>" id="exampleFormControlTextarea1" rows="4"></textarea>
                <p><?php echo $data['post_content_err']; ?></p>
            </div>
            <label for="post_img" style="margin: 0;">Chọn ảnh</label>
            <div class="form-group d-flex row">
                <div class="d-flex align-items-center col-12 col-xl-6 col-lg-6 col-md-6 mb-4">
                    <input type="file" required class="form-control-file" name="post_img" id="post_img" onchange="readImagePostURL(this);">
                    <p class="text-danger"><?php if(array_key_exists('post_img_err', $data)) echo $data['post_img_err']; ?></p>
                </div>
                <div class="d-flex justify-content-center col-12 col-xl-6 col-lg-6 col-md-6">
                    <img id="post-preview" src="<?php echo $data['post_img'];?>" alt="Post image" class="border border-secondary rounded img-fluid">
                </div>  
            </div>
            <div class="d-flex justify-content-center">
                <a href="<?php echo URLROOT; ?>posts/listposts" class="btn btn-primary col-6 col-xl-3 col-lg-3 col-md-3 mr-2">Quay lại danh sách</a>
                <button type="submit" class="btn btn-primary col-6 col-xl-3 col-lg-3 col-md-3 cur-point">Tạo</button>
            </div>
        </form>
    </div>
</div>
<?php else: ?>
    <h1 class="text-center">Bạn phải đăng nhập để xem được thông tin này</h1>
<?php endif; ?>

<?php require APPROOT . '/views/inc/footer.php'; ?>