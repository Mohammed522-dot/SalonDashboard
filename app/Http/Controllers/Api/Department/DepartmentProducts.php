<?php

namespace App\Http\Controllers\Api\Department;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProductsCollection;
use App\Models\Department;
use Illuminate\Http\Request;

class DepartmentProducts extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Department $department)
    { 
        $products = $department->products()->with('departments')->get();
        return $this->sendResponse(new ProductsCollection($products), ['en'=>' Products List','ar'=>'ثائمة المننجات']);

    }

}
