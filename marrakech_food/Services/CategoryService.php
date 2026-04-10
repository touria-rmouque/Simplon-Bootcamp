<?php
namespace Services;

use Models\Category;

class CategoryService {
    private $categoryModel;

    public function __construct() {
        $this->categoryModel = new Category();
    }

    public function getCategoriesList() {
        return $this->categoryModel->getAll();
    }
}