<?php
class ManageProducts extends Controller
{
  public function __construct()
  {
    $this->productModel = $this->model('Product');
  }
  public function index(){
    $data = [];
    $num_of_product_per_page = 5;
    $pageNumber = 1;
    if(isset($_GET['page'])){
      $pageNumber = $_GET['page'];
    }
    $numOfProduct = $this->productModel->getNumOfProduct();
    $totalPage = ceil($numOfProduct / $num_of_product_per_page);

    $product_arr = $this->productModel->getAllProduct($pageNumber, $num_of_product_per_page);
    if($this->productModel->getAllCategory()){
      $categories = $this->productModel->getAllCategory();
    }
    $data = [
      "products"=> $product_arr,
      "categories" => $categories,  // need to fetch
      "totalPage"=>$totalPage
    ];
    $this->view("manageproducts/index", $data);
  }
  public function category($categoryId){
    $data = [];
    $product_arr = $this->productModel->getProductByCategoryAdmin($categoryId);
    if($this->productModel->getAllCategory()){
      $categories = $this->productModel->getAllCategory();
    }
    $data = [
      "products"=> $product_arr,
      "categories" => $categories  // need to fetch
    ];
    $this->view("manageproducts/category", $data);
  }
  public function addproduct(){
    $data = [
      "name"=>"",
      "description"=>"",
      "category"=>"",
      "image"=>"",
      "name_err"=>"",
      "image_err"=>"",
      "list_category"=>"", //need to fetch
      "price_list"=>[], //array of id size, price, quality
      "price_list_err"=>""
    ];
    if($this->productModel->getAllCategory()){
      $data["list_category"] = $this->productModel->getAllCategory();
    }
    if($_SERVER['REQUEST_METHOD'] != 'POST'){
      $this->view("manageproducts/addproduct",$data);
    }
    else{ //Post method
      // Sanitize POST data
      
      $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
      // var_dump($_POST);
      //get size/price/quality
      if(!isset($_POST["sizeM"]) && !isset($_POST["sizeL"])){
        $data["price_list_err"] = "Vui lòng chọn size cho sản phẩm";
      }else{
        if(isset($_POST["sizeM"])){
          if(!isset($_POST["qualityM"])  || empty($_POST["qualityM"]) ){
            $data["price_list_err"] = "Vui lòng chọn số lượng cho sản phẩm size M";
          }elseif(!isset($_POST["priceM"]) || empty($_POST["priceM"])){
            $data["price_list_err"] = "Vui lòng chọn giá cho sản phẩm size M";
          }else{
            array_push($data["price_list"], ["idsize" => $_POST["sizeM"],"quality"=> $_POST["qualityM"], "price"=> $_POST["priceM"]]);
          }
        }
        if(isset($_POST["sizeL"])){
          if(!isset($_POST["qualityL"]) || empty($_POST["qualityL"])){
            $data["price_list_err"] = "Vui lòng chọn số lượng cho sản phẩm size L";
          }elseif(!isset($_POST["priceL"]) || empty($_POST["priceL"])){
            $data["price_list_err"] = "Vui lòng chọn giá cho sản phẩm size L";
          }else{
            array_push($data["price_list"], ["idsize" => $_POST["sizeL"],"quality"=> $_POST["qualityL"], "price"=> $_POST["priceL"]]);
          }
        }
      }
      $data["name"] = trim($_POST["name"]);
      $data["description"] = trim($_POST["description"]);
      $data["category"] = trim($_POST["category"]);

      if (isset($_FILES['image']) && $_FILES['image']['name'] != "") {
        $ext = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
        $filename = pathinfo($_FILES['image']['name'], PATHINFO_FILENAME);
        $uploaddir = "img/product/" . $filename . uniqid(rand(), true). ".".$ext ;
        if ($ext != 'gif' && $ext != 'png' && $ext != 'jpg' && $ext != 'jpeg') {
          $data["image_err"] = "Sai định dạng ảnh (.jpg, .jpeg, .png, .gif)";
        } else if ($_FILES['image']['size'] > 5242880) {
          $data["image_err"] = "Vượt kích thước cho phép (5MB)";
        } else {
          if (move_uploaded_file($_FILES['image']['tmp_name'], $uploaddir)) {
            $data['image'] = URLROOT . $uploaddir;
          }
        }
      }
      if (empty($data['name'])) {
        $data['name_err'] = 'Hãy nhập tên sản phẩm';
      }
      if (empty($data['image'])) {
        $data['image_err'] = 'Hãy chọn ảnh cho sản phẩm';
      }
      
      // Make sure errors are empty
      if (empty($data['name_err']) && empty($data['image_err']) && empty($data['price_list_err'])) {
        // Validated
        // update Product
        if ($this->productModel->addProduct($data)) {
          flash('add_product', 'Thêm sản phẩm thành công thành công');
          redirect('manageproducts');
        } else {
          print_r($data);
          die('Something went wrong');
        }

      } else {
        // Load view with errors
        $this->view('manageproducts/addproduct', $data);
        echo $data["price_list_err"];
      }
    }
  }
  public function edit($productId){
    
    $data = [
      "productId" => $productId,
      "name"=>"",
      "description"=>"",
      "category"=>"",
      "image"=>"",
      "name_err"=>"",
      "image_err"=>"",
      "list_category"=>"", //need to fetch
      "price_list"=> [], //array of id size, price, quality
      "price_list_err"=>""
    ];
    if($this->productModel->getAllCategory()){
      $data["list_category"] = $this->productModel->getAllCategory();
    }
    if($_SERVER['REQUEST_METHOD'] != 'POST'){
      $productToEdit = $this->productModel->getProductToEditById($productId);
      $data["productId"] =  $productId;
      $data["name"] = $productToEdit["name_product"];
      $data["description"] = $productToEdit["description"];
      $data["category"] = $productToEdit["id_category"];
      $data["image"] = $productToEdit["image"];
      $data["price_list"] = $productToEdit["size_price_quality"]; //array of id size, price, quality
      $this->view("manageproducts/edit",$data);
    }
    else{ //Post method
      //get default image 
      $productToEdit = $this->productModel->getProductToEditById($productId);
      $data["image"] = $productToEdit["image"];
      // Sanitize POST data
      $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
      // var_dump($_POST);
      //get size/price/quality
      if(!isset($_POST["sizeM"]) && !isset($_POST["sizeL"])){
        $data["price_list_err"] = "Vui lòng chọn size cho sản phẩm";
      }else{
        if(isset($_POST["sizeM"])){
          if(!isset($_POST["qualityM"])  || empty($_POST["qualityM"]) ){
            $data["price_list_err"] = "Vui lòng chọn số lượng cho sản phẩm size M";
          }elseif(!isset($_POST["priceM"]) || empty($_POST["priceM"])){
            $data["price_list_err"] = "Vui lòng chọn giá cho sản phẩm size M";
          }else{
            array_push($data["price_list"], ["idsize" => $_POST["sizeM"],"quality"=> $_POST["qualityM"], "price"=> $_POST["priceM"]]);
          }
        }
        if(isset($_POST["sizeL"])){
          if(!isset($_POST["qualityL"]) || empty($_POST["qualityL"])){
            $data["price_list_err"] = "Vui lòng chọn số lượng cho sản phẩm size L";
          }elseif(!isset($_POST["priceL"]) || empty($_POST["priceL"])){
            $data["price_list_err"] = "Vui lòng chọn giá cho sản phẩm size L";
          }else{
            array_push($data["price_list"], ["idsize" => $_POST["sizeL"],"quality"=> $_POST["qualityL"], "price"=> $_POST["priceL"]]);
          }
        }
      }
      $data["name"] = trim($_POST["name"]);
      $data["description"] = trim($_POST["description"]);
      $data["category"] = trim($_POST["category"]);

      if (isset($_FILES['image']) && $_FILES['image']['name'] != "") {
        $ext = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
        $filename = pathinfo($_FILES['image']['name'], PATHINFO_FILENAME);
        $uploaddir = "img/product/" . $filename . uniqid(rand(), true). ".".$ext ;
        if ($ext != 'gif' && $ext != 'png' && $ext != 'jpg' && $ext != 'jpeg') {
          $data["image_err"] = "Sai định dạng ảnh (.jpg, .jpeg, .png, .gif)";
        } else if ($_FILES['image']['size'] > 5242880) {
          $data["image_err"] = "Vượt kích thước cho phép (5MB)";
        } else {
          if (move_uploaded_file($_FILES['image']['tmp_name'], $uploaddir)) {
            $data['image'] = URLROOT . $uploaddir;
          }
        }
      }
      
      if (empty($data['name'])) {
        $data['name_err'] = 'Hãy nhập tên sản phẩm';
      }
      if (empty($data['image'])) {
        $data['image_err'] = 'Hãy chọn ảnh cho sản phẩm';
      }
      
      // Make sure errors are empty
      if (empty($data['name_err']) && empty($data['image_err']) && empty($data['price_list_err'])) {
        // Validated
        // update Product
        if ($this->productModel->updateProduct($data)) {
          flash('update_product', 'Cập nhật sản phẩm '.$data["name"] .' thành công');
          redirect('manageproducts');
        } else {
          // print_r($data);
          die('Something went wrong');
        }

      } else {
        // Load view with errors
        $this->view('manageproducts/edit', $data);
        // echo $data["price_list_err"];
      }
    }
  }
  public function delete($productId){
    $product = $this->productModel->getProductById($productId);
    $product_name = $product["name"];
    if($this->productModel->deleteProductById($productId)){
      flash("delete_product", 'Xóa sản phẩm ' . $product_name .' thành công');
      redirect('manageproducts');
    }else{
      flash("delete_product", 'Xóa sản phẩm ' . $product_name .'không thành công', 'alert-danger');
      redirect('manageproducts');
    }
  }
}
