<?php
class Products extends Controller
{
  public function __construct()
  {
    $this->productModel = $this->model('Product');
  }
  public function index() {
    $category = [];
    if($this->productModel->getAllCategory()){
        $category = $this->productModel->getAllCategory();
    }
    if($this->productModel->getProductByCategory(3)){
      $product = $this->productModel->getProductByCategory(3);
    }
    if($this->productModel->getCategoryById(3)){
      $categoryWithId = $this->productModel->getCategoryById(3);
      $row = $categoryWithId->fetch_assoc(); // array
    }
    $data = [
        "category" => $category,
        "categoryWithId"=> $row,
        "product" => $product
    ];
    $this->view("products/category", $data);
  }
  public function category($categoryId){
    $category = [];
    if($this->productModel->getAllCategory()){
      $category = $this->productModel->getAllCategory();
    }
    if($this->productModel->getProductByCategory($categoryId)){
      $product = $this->productModel->getProductByCategory($categoryId);
    }
    if($this->productModel->getCategoryById($categoryId)){
      $categoryWithId = $this->productModel->getCategoryById($categoryId);
      $row = $categoryWithId->fetch_assoc(); // array
    }
    $data=[
      "categoryWithId"=> $row,
      "category" => $category,
      "product" => $product
    ];
    $this->view('products/category', $data);
  }
}
