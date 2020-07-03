<?php
class ManageProducts extends Controller
{
  public function __construct()
  {
    $this->productModel = $this->model('Product');
  }
  
}
