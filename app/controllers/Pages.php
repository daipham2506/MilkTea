<?php
  class Pages extends Controller {
    public function __construct(){
      $this->postModel = $this->model('Post');
    }
    
    public function index(){
      $numPost = 3;
      $listNewPost = $this->postModel->getRecentlyPost($numPost);
      $data = [
        'title' => 'SharePosts',
        'description' => 'Simple social network built on the TraversyMVC PHP framework',
        'listNewPost' => $listNewPost
      ];
     
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