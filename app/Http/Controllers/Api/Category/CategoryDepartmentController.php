<?php

namespace App\Http\Controllers\Api\Category;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryDepartmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        $category= Category::findOrFail($id);
        $department = $category->products;
        return $this->sendResponse($department, ['en'=>' Departments List','ar'=>'ثائمة الاقسام']);
    }

}
