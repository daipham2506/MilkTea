<?php
class Products extends Controller
{
  public function __construct()
  {
    $this->productModel = $this->model('Product');
  }
  public function index()
  {
    $category = [];
    if ($this->productModel->getAllCategory()) {
      $category = $this->productModel->getAllCategory();
    }
    //old
    // if($this->productModel->getProductByCategory(3)){
    //   $product = $this->productModel->getProductByCategory(3);
    // }
    // if($this->productModel->getCategoryById(3)){
    //   $categoryWithId = $this->productModel->getCategoryById(3);
    //   $row = $categoryWithId->fetch_assoc(); // array
    // }
    // $data = [
    //     "category" => $category,
    //     "categoryWithId"=> $row,
    //     "product" => $product
    // ];
    //old
    if ($this->productModel->getAllProductWithCategory()) {
      $product_list = $this->productModel->getAllProductWithCategory();
    }
    $data = [
      "category" => $category,
      "productWithCategory" => $product_list
    ];
    $this->view("products/index", $data);
  }
  public function category($categoryId)
  {
    $category = [];
    if ($this->productModel->getAllCategory()) {
      $category = $this->productModel->getAllCategory();
    }
    $product = [];
    if ($this->productModel->getProductByCategory($categoryId)) {
      $product = $this->productModel->getProductByCategory($categoryId);
    }
    if ($this->productModel->getCategoryById($categoryId)) {
      $categoryWithId = $this->productModel->getCategoryById($categoryId);
      $row = $categoryWithId->fetch_assoc(); // array
    }
    $data = [
      "categoryWithId" => $row,
      "category" => $category,
      "product" => $product
    ];
    $this->view('products/category', $data);
  }
  public function detail($productId)
  {
    $data = [];
    $product = [];
    $review = [];
    $avgStar = 0;
    if ($this->productModel->getProductById($productId)) {
      $product  = $this->productModel->getProductById($productId);
    }
    if ($this->productModel->getAllReviewByProductId($productId)) {
      $review  = $this->productModel->getAllReviewByProductId($productId);
    }
    if ($this->productModel->getAverageStarByProductId($productId)) {
      $avgStar  = $this->productModel->getAverageStarByProductId($productId);
    }
    $data = [
      "product" => $product,
      "review" => $review,
      "avgStar" => $avgStar
    ];
    $this->view('products/detail', $data);
  }
  public function addReview()
  {
    $data = [];
    if (isset($_POST["rating-value"])) {
      $rating_value = $_POST["rating-value"];
      $content = "";
      if (isset($_POST["rating-content"])) {
        $content = $_POST["rating-content"];
      }
      $productId = $_POST["productId"];
      $userId = $_POST["userId"];
    }
    $data = [
      "rating_value" => $rating_value,
      "content" => $content,
      "productId" => $productId,
      "userId" => $userId
    ];
    if ($this->productModel->addReview($data)) {
      flash('addReview_success', 'Thêm đánh giá thành công');
      redirect('products/detail/' . $productId);
    } else {
      flash('addReview_success', 'Thêm đánh giá không thành công', 'alert-danger');
      redirect('products/detail/' . $productId);
    }
  }
  public function deleteReview($reviewId, $userId, $productId)
  {
    if ($this->productModel->deleteReview($reviewId, $userId)) {
      flash("delete_review", "Xóa đánh giá thành công");
      redirect('products/detail/' . $productId);
    } else {
      flash("delete_review", "Xóa đánh giá không thành công", 'alert-danger');
      redirect('products/detail/' . $productId);
    }
  }

  public function listproductsearch()
  {
    $name_key = "";
    $page_no = 1;
    if (isset($_GET["name_key"])) {
      $name_key = $_GET["name_key"];
    }
    if (isset($_GET["pageno"])) {
      $page_no = $_GET["pageno"];
    }
    // echo $name_key;
    $listProductSearch = $this->productModel->getListProductByNameKey($name_key);

    $listProduct = [];

    foreach ($listProductSearch as $item) {
      $rs_price = $this->productModel->getPriceByProductIdMinh($item["id"]);
      $list_price = [];
      while ($row = $rs_price->fetch_assoc()) {
        array_push($list_price, $row);
      }
      $item["price_list"] = $list_price;
      array_push($listProduct, $item);
    }

    $numProductPerPage = 6;
    $numOfProduct = count($listProduct);
    $totalPage = ceil($numOfProduct /  $numProductPerPage);
    $offset = ($page_no - 1) * $numProductPerPage;

    $newListProduct = array_slice($listProduct, $offset, $numProductPerPage);
    $data = [
      "listProductSearch" => $newListProduct,
      "name_key" => $name_key,
      "totalPage" => $totalPage
    ];
    $this->view("products/listproductsearch", $data);
  }

  public function addtocart($productId)
  {
    $userId = $_SESSION['user_id'];
    if (isset($_POST['addToCart'])) {
      $quantity = $_POST['quantity'];
      $sizeId = $_POST['size'];
      if ($this->productModel->haveProductInCart($productId, $sizeId, $userId)) {
        $this->productModel->increaseQuantityInCart($productId, $sizeId, $quantity, $userId);
      } else {
        $this->productModel->addtocart($productId, $sizeId, $quantity, $userId);
      }
    }
    redirect('products/detail/' . $productId);
  }

  public function addOneToCart($productId)
  {
    $userId = $_SESSION['user_id'];
    $sizeId = $_GET['size'];
    if ($this->productModel->haveProductInCart($productId, $sizeId, $userId)) {
      $this->productModel->increaseQuantityInCart($productId, $sizeId, 1, $userId);
    } else {
      $this->productModel->addtocart($productId, $sizeId, 1, $userId);
    }
    if (isset($_SERVER["HTTP_REFERER"])) {
      header("Location: " . $_SERVER["HTTP_REFERER"]);
    } else {
      redirect("products");
    }
  }
}
