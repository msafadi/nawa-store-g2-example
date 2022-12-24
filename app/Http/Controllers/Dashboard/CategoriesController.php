<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryRequest;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Illuminate\Support\Str;

class CategoriesController extends Controller
{
    public function index(Request $request)
    {
        // SQL:
        // SELECT categories.*, parents.name as parent_name FROM categories
        // LEFT JOIN categories as parents ON parents.id = categories.parent_id

        // Return Collection object (array)
        $categories = Category::query()
            //->parent()
            ->search($request->query())
            ->leftJoin('categories as parents', 'parents.id', '=', 'categories.parent_id')
            ->select([
                'categories.*',
                'parents.name as parent_name',
            ])
            ->orderBy('categories.parent_id')
            ->orderBy('categories.name', 'ASC')    
            ->get();

        $parents = Category::pluck('name', 'id');

        return view('dashboard.categories.index', [
            'categories' => $categories,
            'parents' => $parents,
        ]);
    }

    public function create()
    {
        $parents = Category::orderBy('name')->pluck('name', 'id');

        return view('dashboard.categories.create', [
            'category' => new Category(),
            'parents' => $parents,
        ]);
    }

    public function store(Request $request)
    {
        $data = $this->validateRequest($request);
        if (!$data['slug']) {
            $data['slug'] = Str::slug($data['name']);
        }

        if ($request->hasFile('image')) {
            $file = $request->file('image'); // return UploadedFile object
            $path = $file->store('/media', 'public'); // store in public disk
            $data['image_path'] = $path;
        }

        // $category = new Category($request->all());
        // $category->name = $request->name;
        // $category->slug = $request->input('slug');
        // $category->parent_id = $request->post('parent_id');
        // $category->save();

        // Mass assignment
        $category = Category::create( $data );

        // PRG - Post Redirect Get + Flash Message
        return redirect()
            ->route('dashboard.categories.index')  // Redirest to this route
            ->with('success', "Category ({$category->name}) Created!"); // Adds flash message
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
            ->pluck('name', 'id');
        
        return view('dashboard.categories.edit', [
            'category' => $category,
            'parents' => $parents,
        ]);
    }

    public function update(CategoryRequest $request, $id)
    {
        $category = Category::findOrFail($id);
        // $category->name = $request->name;
        // $category->save();

        //$data = $this->validateRequest($request, $id);
        $data = $request->validated();
        if (!$data['slug']) {
            $data['slug'] = Str::slug($data['name']);
        }

        $old = false;
        if ($request->hasFile('image')) {
            $file = $request->file('image'); // return UploadedFile object
            $path = $file->store('/media', 'public'); // store in public disk
            // $file->getClientOriginalName();
            // $file->getClientOriginalExtension();
            // $file->getSize();
            // $file->getMimeType(); // image/png
            $data['image_path'] = $path;

            $old = $category->image_path;
        }
        
        $category->update( $data );
        if ($old) {
            Storage::disk('public')->delete($old);
        }

        return redirect()
            ->route('dashboard.categories.index')  // Redirest to this route
            ->with('success', "Category ({$category->name}) Updated!")
            ->with('info', 'Category data changed!');
    }

    public function destroy($id)
    {
        //Category::where('id', '=', $id)->delete();
        //Category::destroy($id);

        $category = Category::findOrFail($id);
        $category->delete();

        // if ($category->image_path) {
        //     Storage::disk('public')->delete($category->image_path);
        // }

        return redirect()
            ->back()  // Redirest to this route
            ->with('success', "Category Deleted!")
            ->with('warning', 'You deleted a category');
    }

    protected function validateRequest(Request $request, $id = 0)
    {
        $rules = [
            'name' => 'required|string|max:255',
            'slug' => "nullable|string|unique:categories,slug,$id",
            'parent_id' => 'nullable|int|exists:categories,id',
            'image' => [
                'nullable',
                'image',
                'max:200',
                //'dimensions:min_width=300,min_height=300,max_width=800,max_height=300',
                Rule::dimensions()->minWidth(300)->minHeight(300)->maxWidth(1400)->maxHeight(1400),
            ]
        ];
        $messages = [
            'required' => ':attribute is required!!',
            'slug.required' => 'You must eneter a URL slug!',
        ];

        return $request->validate($rules, $messages);
    }

    public function trash()
    {
        $categories = Category::onlyTrashed()->get();
        return view('dashboard.categories.trash', [
            'categories' => $categories,
        ]);
    }

    public function restore($id)
    {
        $category = Category::onlyTrashed()->findOrFail($id);
        $category->restore();

        return redirect()->route('dashboard.categories.index')
            ->with('success', 'Caregory restored!');
    }

    public function forceDelete($id)
    {
        $category = Category::onlyTrashed()->findOrFail($id);
        $category->forceDelete();

        return redirect()->route('dashboard.categories.index')
            ->with('success', 'Caregory deleted forever!');
    }

}
