<?php if (isset($_SESSION['user_id']) && isset($_SESSION['isAdmin'])) :
    require APPROOT . '/views/inc/header_admin.php';
?>
    <div class="container">
        <div class="row mb-5">
            <div class="card card-body bg-light mt-5">
                <h2>Thêm sản phẩm</h2>
                <p>Vui lòng điền vào form bên dưới để thêm sản phẩm</p>
                <form action="<?php echo URLROOT; ?>manageproducts/addproduct" method="post" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="name" class="bold-text">Tên: <sup>*</sup></label>
                        <input type="text" name="name" placeholder="Nhập tên sản phẩm" class="form-control form-control-lg <?php echo (!empty($data['name_err'])) ? 'is-invalid' : ''; ?>" value="<?php echo $data['name']; ?>" required>
                        <span class="invalid-feedback"><?php echo $data['name_err']; ?></span>
                    </div>
                    <div class="form-group">
                        <label for="category" class="bold-text">Chọn loại sản phẩm</label>
                        <select class="form-control" id="category" name="category">
                            <?php while ($category_row = $data["list_category"]->fetch_assoc()) {
                                $id_category = $category_row["id"];
                                $name_category = $category_row["name"];
                                echo "<option value='$id_category'>$name_category</option>";
                            } ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="description" class="bold-text">Mô tả: </label>
                        <textarea class="form-control" id="description" name="description" rows="3" placeholder="Thêm mô tả về sản phẩm. Nhập các mô tả cách nhau bởi dấu ;" aria-describedby="descriptionHelp"></textarea>
                        <small id="descriptionHelp" class="form-text text-muted text-primary">Nhập các mô tả cách nhau bởi dấu ;</small>
                    </div>
                    <div class="form-group">
                        <label class="bold-text"> Chọn size: </label>
                        <p class="text-danger"><?php echo $data['price_list_err']; ?></p>
                        <div class="form-check pl-4">
                            <input class="form-check-input" type="checkbox" name="sizeM" id="sizeM" value="1" checked  onchange="sizeMChangeHandler();">
                            <label class="form-check-label" for="sizeM">Size M</label>
                        </div>
                        <div class="form-group d-flex justify-content-around" id="containerM">
                            <div id="qualityMInput">
                                <label class="bold-text">Số lượng</label>
                                <input class="form-control" type="number" name="qualityM" min="1" max="100">
                            </div>
                            <div id="priceMInput">
                                <label class="bold-text">Giá (đ)</label>
                                <input class="form-control" type="number" name="priceM" min="1000" max="500000" step="500">
                            </div>
                        </div>
                        <div class="form-check pl-4">
                            <input class="form-check-input" type="checkbox" name="sizeL" id="sizeL" value="2" checked onchange="sizeLChangeHandler();">
                            <label class="form-check-label" for="sizeM">Size L</label>
                        </div>
                        <div class="form-group d-flex justify-content-around" id="containerL">
                            <div id="qualityLInput">
                                <label class="bold-text">Số lượng</label>
                                <input class="form-control" type="number" name="qualityL" min="1" max="100">
                            </div>
                            <div id="priceLInput">
                                <label class="bold-text">Giá (đ)</label>
                                <input class="form-control" type="number" name="priceL" min="1000" max="500000" step="500">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="image" class="bold-text">Chọn ảnh</label>
                        <input type="file" class="form-control-file" name="image" id="image" onchange="readImageProductURL(this);" required><!-- need to add required -->
                        <p class="text-danger"><?php if (array_key_exists('image_err', $data)) echo $data['image_err']; ?></p>
                        <div class="row d-flex justify-content-center">
                            <img id="image-preview" src="#" alt="your image" class="border border-secondary rounded">
                        </div>
                    </div>
                    <div class="d-flex justify-content-center">
                        <input type="submit" value="Thêm sản phẩm" class="btn btn-success button-hover">
                        <a href="<?php echo URLROOT;?>manageproducts" class="btn btn-danger ml-3">Quay lại</a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <?php require APPROOT . '/views/inc/footer.php'; ?>
<?php else : ?>
    <h1 style="text-align: center">Bạn phải là Adminitrator để xem được thông tin này</h1>
<?php endif; ?>