<?php
  class Pages extends Controller {
    public function __construct(){
      $this->InfoWebModel = $this->model('InfoWeb');
    }
    
    public function index(){
      $data = [];
      $this->view('pages/index', $data);
    }

    public function about(){
      $data = [
        'title' => 'About Us',
        'description' => 'App to share posts with other users'
      ];

      $this->view('pages/about', $data);
    }
    public function service(){
      $data = []; // change here
      $this->view('pages/service', $data);
    }
    // public function product(){
    //   $data = []; // change here
    //   $this->view('pages/product', $data);
    // }
    public function contact(){
      $data = []; // change here
      $this->view('pages/contact', $data);
    }
  }