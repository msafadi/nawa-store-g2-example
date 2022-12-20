<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CategoriesController extends Controller
{
    public function index()
    {
        // SQL:
        // SELECT categories.*, parents.name as parent_name FROM categories
        // LEFT JOIN categories as parents ON parents.id = categories.parent_id

        // Return Collection object (array)
        $categories = Category::query()
            ->leftJoin('categories as parents', 'parents.id', '=', 'categories.parent_id')
            ->select([
                'categories.*',
                'parents.name as parent_name',
            ])
            ->orderBy('categories.parent_id')
            ->orderBy('categories.name', 'ASC')    
            ->get();

        return view('dashboard.categories.index', [
            'categories' => $categories,
            'status' => session('status'),
        ]);
    }

    public function create()
    {
        $parents = Category::orderBy('name')->get();
        return view('dashboard.categories.create', [
            'parents' => $parents,
        ]);
    }

    public function store(Request $request)
    {
        // $category = new Category($request->all());
        // $category->name = $request->name;
        // $category->slug = $request->input('slug');
        // $category->parent_id = $request->post('parent_id');
        // $category->save();

        // Mass assignment
        $category = Category::create( $request->all() );

        // PRG - Post Redirect Get + Flash Message
        return redirect()
            ->route('dashboard.categories.index')  // Redirest to this route
            ->with('status', "Category ({$category->name}) Created!"); // Adds flash message
    }

    public function edit($id)
    {

        $category = Category::findOrFail($id);
        
        // SELECT * FROM categories WHERE
        // id <> $id AND (parent_id <> $id OR parent_id IS NULL)
        $parents = Category::where('id', '<>', $id)
            ->where(function($query) use ($id) {
                $query->whereNull('parent_id')
                      ->orWhere('parent_id', '<>', $id);
            })
            ->orderBy('name')
            ->get();
        
        return view('dashboard.categories.edit', [
            'category' => $category,
            'parents' => $parents,
        ]);
    }

    public function update(Request $request, $id)
    {
        $category = Category::findOrFail($id);
        // $category->name = $request->name;
        // $category->save();

        $category->update( $request->all() );

        return redirect()
            ->route('dashboard.categories.index')  // Redirest to this route
            ->with('status', "Category ({$category->name}) Updated!");
    }

    public function destroy($id)
    {
        //Category::where('id', '=', $id)->delete();
        Category::destroy($id);

        // $category = Category::findOrFail($id);
        // $category->delete();

        return redirect()
            ->back()  // Redirest to this route
            ->with('status', "Category Deleted!");
    }
}
