<?php if (isset($_SESSION['user_id']) && isset($_SESSION['isAdmin'])) :
    require APPROOT . '/views/inc/header_admin.php';
?>
        <div class="container">
        <div class="row mb-5">
            <div class="card card-body bg-light mt-5">
                <h2>Cập nhật sản phẩm</h2>
                <p>Vui lòng điền vào form bên dưới để cập nhật sản phẩm</p>
                <form action="<?php echo URLROOT; ?>manageproducts/edit/<?php echo $data["productId"]?>" method="post" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="name" class="bold-text">Tên: <sup>*</sup></label>
                        <input type="text" name="name" placeholder="Nhập tên sản phẩm" class="form-control form-control-lg <?php echo (!empty($data['name_err'])) ? 'is-invalid' : ''; ?>" value="<?php echo $data['name']; ?>" required>
                        <span class="invalid-feedback"><?php echo $data['name_err']; ?></span>
                    </div>
                    <div class="form-group">
                        <label for="category" class="bold-text">Chọn loại sản phẩm</label>
                        <select class="form-control" id="category" name="category">
                            <?php
                            if($data["list_category"]->num_rows > 0){
                                while ($category_row = $data["list_category"]->fetch_assoc()) {
                                    $id_category = $category_row["id"];
                                    $name_category = $category_row["name"];
                                    $isSelected =($id_category == $data["category"]) ? "selected" : "";
                                    echo "<option value='$id_category' $isSelected>$name_category</option>";
                                }
                            }
                            ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="description" class="bold-text">Mô tả: </label>
                        <textarea class="form-control" id="description" name="description" rows="3" placeholder="Thêm mô tả về sản phẩm. Nhập các mô tả cách nhau bởi dấu ;" aria-describedby="descriptionHelp"><?php echo $data["description"]?></textarea>
                        <small id="descriptionHelp" class="form-text text-muted text-primary">Nhập các mô tả cách nhau bởi dấu ;</small>
                    </div>
                    <div class="form-group">
                        <label class="bold-text"> Chọn size: </label>
                        <p class="text-danger"><?php echo $data['price_list_err']; ?></p>
                        <?php if(count($data["price_list"]) == 2){
                            $size_price_quantity = $data["price_list"];
                            for($i = 0; $i < 2 ; $i++ ){
                                $size_name = ($size_price_quantity[$i]["idsize"] == 1) ? "M"  : "L";
                                $quantity = $size_price_quantity[$i]["quality"];
                                $price = $size_price_quantity[$i]["price"];
                                $size_value = $i + 1;
                                $size_id = "size".$size_name;
                                $container_id = "container" . $size_name;
                                $qualityInput_name = "quality".$size_name."Input";
                                $priceInput_name = "price".$size_name."Input";
                                $quality_name = "quality".$size_name;
                                $price_name = "price".$size_name;
                                $func_call = "size".$size_name."ChangeHandler();";
                                echo 
                                "
                                <div class='form-check pl-4'>
                                    <input class='form-check-input' type='checkbox' name='$size_id' id='$size_id' value='$size_value' checked  onchange='$func_call'>
                                    <label class='form-check-label' for='$size_id'>Size $size_name</label>
                                </div>
                                <div class='form-group d-flex justify-content-around' id='$container_id'>
                                    <div id='$qualityInput_name'>
                                        <label class='bold-text'>Số lượng</label>
                                        <input class='form-control' type='number' name='$quality_name' min='1' max='100' value=$quantity>
                                    </div>
                                    <div id='$priceInput_name'>
                                        <label class='bold-text'>Giá (đ)</label>
                                        <input class='form-control' type='number' name='$price_name' min='1000' max='500000' step='500' value=$price>
                                    </div>
                                </div>
                                ";
                            }
                        }elseif(count($data["price_list"]) == 1 && $data["price_list"][0]["idsize"] == 1){
                            $quantity = $data["price_list"][0]["quality"];
                            $price = $data["price_list"][0]["price"];
                            echo
                            "
                            <div class='form-check pl-4'>
                                <input class='form-check-input' type='checkbox' name='sizeM' id='sizeM' value='1' checked  onchange='sizeMChangeHandler();'>
                                <label class='form-check-label' for='sizeM'>Size M</label>
                            </div>
                            <div class='form-group d-flex justify-content-around' id='containerM'>
                                <div id='qualityMInput'>
                                    <label class='bold-text'>Số lượng</label>
                                    <input class='form-control' type='number' name='qualityM' min='1' max='100' value=$quantity>
                                </div>
                                <div id='priceMInput'>
                                    <label class='bold-text'>Giá (đ)</label>
                                    <input class='form-control' type='number' name='priceM' min='1000' max='500000' step='500' value=$price>
                                </div>
                            </div>

                            <div class='form-check pl-4'>
                                <input class='form-check-input' type='checkbox' name='sizeL' id='sizeL' value='2' onchange='sizeLChangeHandler();'>
                                <label class='form-check-label' for='sizeL'>Size L</label>
                            </div>
                            <div class='form-group d-flex justify-content-around' id='containerL'>
                                <div id='qualityLInput'>
                                    <label class='bold-text'>Số lượng</label>
                                    <input class='form-control' type='number' name='qualityL' min='1' max='100'>
                                </div>
                                <div id='priceLInput'>
                                    <label class='bold-text'>Giá (đ)</label>
                                    <input class='form-control' type='number' name='priceL' min='1000' max='500000' step='500'>
                                </div>
                            </div>
                            ";
                        }elseif(count($data["price_list"]) == 1 && $data["price_list"][0]["idsize"] == 2){
                            $quantity =$data["price_list"][0]["quality"];
                            $price = $data["price_list"][0]["price"];
                            echo
                            "
                            <div class='form-check pl-4'>
                                <input class='form-check-input' type='checkbox' name='sizeM' id='sizeM' value='1' onchange='sizeMChangeHandler();'>
                                <label class='form-check-label' for='sizeM'>Size M</label>
                            </div>
                            <div class='form-group d-flex justify-content-around' id='containerM'>
                                <div id='qualityMInput'>
                                    <label class='bold-text'>Số lượng</label>
                                    <input class='form-control' type='number' name='qualityM' min='1' max='100'>
                                </div>
                                <div id='priceMInput'>
                                    <label class='bold-text'>Giá (đ)</label>
                                    <input class='form-control' type='number' name='priceM' min='1000' max='500000' step='500'>
                                </div>
                            </div>

                            <div class='form-check pl-4'>
                                <input class='form-check-input' type='checkbox' name='sizeL' id='sizeL' value='2' checked onchange='sizeLChangeHandler();'>
                                <label class='form-check-label' for='sizeL'>Size L</label>
                            </div>
                            <div class='form-group d-flex justify-content-around' id='containerL'>
                                <div id='qualityLInput' >
                                    <label class='bold-text'>Số lượng</label>
                                    <input class='form-control' type='number' name='qualityL' min='1' max='100' value=$quantity>
                                </div>
                                <div id='priceLInput'>
                                    <label class='bold-text'>Giá (đ)</label>
                                    <input class='form-control' type='number' name='priceL' min='1000' max='500000' step='500' value=$price>
                                </div>
                            </div>
                            ";
                        }else{//count($data["price_list"]) = 0
                            echo "
                        <div class='form-check pl-4'>
                            <input class='form-check-input' type='checkbox' name='sizeM' id='sizeM' value='1' checked  onchange='sizeMChangeHandler();'>
                            <label class='form-check-label' for='sizeM'>Size M</label>
                        </div>
                        <div class='form-group d-flex justify-content-around' id='containerM'>
                            <div id='qualityMInput'>
                                <label class='bold-text'>Số lượng</label>
                                <input class='form-control' type='number' name='qualityM' min='1' max='100'>
                            </div>
                            <div id='priceMInput'>
                                <label class='bold-text'>Giá (đ)</label>
                                <input class='form-control' type='number' name='priceM' min='1000' max='500000' step='500'>
                            </div>
                        </div>
                        <div class='form-check pl-4'>
                            <input class='form-check-input' type='checkbox' name='sizeL' id='sizeL' value='2' checked onchange='sizeLChangeHandler();'>
                            <label class='form-check-label' for='sizeM'>Size L</label>
                        </div>
                        <div class='form-group d-flex justify-content-around' id='containerL'>
                            <div id='qualityLInput'>
                                <label class='bold-text'>Số lượng</label>
                                <input class='form-control' type='number' name='qualityL' min='1' max='100'>
                            </div>
                            <div id='priceLInput'>
                                <label class='bold-text'>Giá (đ)</label>
                                <input class='form-control' type='number' name='priceL' min='1000' max='500000' step='500'>
                            </div>
                        </div>
                            ";
                        }?>
                    </div>
                    <div class="form-group">
                        <label for="image" class="bold-text">Chọn ảnh</label>
                        <input type="file" class="form-control-file" name="image" id="image" onchange="readImageProductURL(this);" ><!-- need to add required -->
                        <p class="text-danger"><?php if (array_key_exists('image_err', $data)) echo $data['image_err']; ?></p>
                        <div class="row d-flex justify-content-center">
                            <img id="image-preview" src="<?php if ($data['image']) echo $data['image'];
                                                            else echo "#" ?>" alt="your image" class="border border-secondary rounded">
                        </div>
                    </div>
                    <div class="d-flex justify-content-center">
                        <input type="submit" value="Cập nhật sản phẩm" class="btn btn-success button-hover">
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