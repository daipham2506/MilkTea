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
  public function detail($productId){
    $data = [];
    $product =[];
    $review = [];
    $avgStar = 0;
    if($this->productModel->getProductById($productId)){
      $product  = $this->productModel->getProductById($productId);
    }
    if($this->productModel->getAllReviewByProductId($productId)){
      $review  = $this->productModel->getAllReviewByProductId($productId);
    }
    if($this->productModel->getAverageStarByProductId($productId)){
      $avgStar  = $this->productModel->getAverageStarByProductId($productId);
    }
    $data = [
      "product" => $product,
      "review" => $review,
      "avgStar"=>$avgStar
    ];
    $this->view('products/detail', $data);
  }
  public function addReview(){
    $data = [];
    if(isset($_POST["rating-value"])){
      $rating_value = $_POST["rating-value"];
      $content = "";
      if(isset($_POST["rating-content"])){
        $content = $_POST["rating-content"];
      }
      $productId = $_POST["productId"];
      $userId = $_POST["userId"];
    }
    $data = [
      "rating_value" => $rating_value,
      "content" =>$content,
      "productId"=>$productId,
      "userId"=>$userId
    ];
    if($this->productModel->addReview($data)){
      flash('addReview_success', 'Thêm đánh giá thành công');
      redirect('products/detail/'.$productId);
    }
  }
}
