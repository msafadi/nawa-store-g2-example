<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CategoriesController extends Controller
{
    public function index()
    {
        // SQL: SELECT * FROM categories WHERE parent_id = 1 ORDER BY name
        // Return Collection object (array)
        $categories = DB::table('categories')
            ->orderBy('parent_id')
            ->orderBy('name', 'ASC')    
            ->get();

        return view('dashboard.categories.index', [
            'categories' => $categories,
        ]);
    }
}
