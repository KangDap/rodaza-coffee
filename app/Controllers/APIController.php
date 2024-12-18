<?php

namespace App\Controllers;

helper('auth');
use Myth\Auth\Models\UserModel;
use App\Models\CategoriesModel;
use App\Models\FeedbacksModel;
use App\Models\OrderItemsModel;
use App\Models\OrdersModel;
use App\Models\ProductsModel;
use CodeIgniter\RESTful\ResourceController;

class APIController extends ResourceController
{
    protected $categoryModel;
    protected $productModel;
    protected $orderModel;
    protected $orderItemModel;
    protected $feedbackModel;
    protected $userModel;

    public function __construct()
    {
        $this->categoryModel = new CategoriesModel();
        $this->productModel = new ProductsModel();
        $this->orderModel = new OrdersModel();
        $this->orderItemModel = new OrderItemsModel();
        $this->feedbackModel = new FeedbacksModel();
        $this->userModel = new UserModel();
    }

    public function index()
    {
        $categories = $this->categoryModel->findAll();
        $response = [];

        foreach ($categories as $category) {
            $products = $this->productModel
                ->where('category_id', $category['category_id'])
                ->findAll();

            $response[] = [
                'category' => $category['category_name'],
                'products' => $products,
            ];
        }

        return $this->respond($response);
    }

    public function allProducts(){
        $products = $this->productModel->findAll();
        $response = [
            'products' => $products
        ];

        return $this->respond($response);
    }
    
    public function productsByCategory($categoryId)
    {
        $category = $this->categoryModel->find($categoryId);
        if (!$category) {
            return $this->failNotFound('Category not found');
        }

        $products = $this->productModel->where('category_id', $categoryId)->findAll();

        $response = [
            'category' => $category['category_name'],
            'products' => $products,
        ];

        return $this->respond($response);
    }

    public function allOrders(){
    $orders = $this->orderModel->findAll();
    $response = [];
    
    foreach ($orders as $order) {
        $orderItems = $this->orderItemModel
            ->where('order_id', $order['order_id'])
            ->findAll();
        
        $user = $this->userModel
            ->where('id', $order['user_id'])
            ->first();

        $products = [];

        foreach ($orderItems as $orderItem) {
            $product = $this->productModel
                ->where('product_id', $orderItem['product_id'])
                ->first();
            
            if ($product) {
                $products[] = $product;
            }
        }

        $response[] = [
            'order' => $order,
            'orderItems' => $orderItems,
            'products' => $products,
            'user' => $user
        ];
    }

    return $this->respond($response);
}

    public function allFeedbacks(){
        $feedbacks = $this->feedbackModel->findAll();
        $response = [
            'feedbacks' => $feedbacks
        ];

        return $this->respond($response);
    }

    public function orderHistory($id = null){
        if ($id !== null) {
            $orderHistory = $this->orderModel->where('user_id', $id)->findAll();
        } 
        else {
            $orderHistory = $this->orderModel->where('user_id', user()->id)->findAll();
        }
        
        if (!$orderHistory) {
            return $this->failNotFound('No order history found for the user.');
        }

        $response = [
            'orderHistory' => $orderHistory
        ];

        return $this->respond($response);
    }
}
