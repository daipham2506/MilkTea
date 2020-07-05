<?php require APPROOT . '/views/inc/header.php'; ?>

<div class="row mb-5">
    <div class="col-md-6 mx-auto">
        <div class="card card-body bg-light mt-5">
            <div class="container text-center">
                <div class="row ">
                    <div class="col-md-2 col-md-offset-2 "> </div>
                    <div class="col-md-8 col-md-offset-8 ">
                        <div class="panel panel-default">
                            <div class="panel-body">
                                <div class="text-center">
                                    <h3><i class="fa fa-lock fa-4x"></i></h3>
                                    <h2 class="text-center">Quên mật khẩu?</h2>
                                    <p>Vui lòng nhập Email để lấy lại mật khẩu!</p>
                                    <?php flash('forgot-pass') ?>
                                    <div class="panel-body">

                                        <form action="<?php echo URLROOT; ?>users/forgotpass" method="post">

                                            <div class="form-group">
                                                <div class="input-group">
                                                    <span class="input-group-addon"><i class="fa fa-envelope color-blue"></i></span>
                                                    <input id="email" name="email" placeholder="Email..." class="form-control" type="email" required>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <input name="recover-submit" class="btn btn-lg btn-primary btn-block" value="Xác nhận" type="submit">
                                            </div>

                                            <input type="hidden" class="hide" name="token" id="token" value="">
                                        </form>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require APPROOT . '/views/inc/footer.php'; ?>