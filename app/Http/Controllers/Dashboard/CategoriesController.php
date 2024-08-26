<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryRequest;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class CategoriesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $request = request();
        // $query = Category::query();
        // Select a.*, b.name as parent_id
        // From Categories as a
        // Left Join Categories as b On b.id = a.parent_id
        $categories = Category::with('parent')
            /*leftJoin('categories as parents', 'parents.id', '=', 'categories.parent_id')
            ->select([
                'categories.*',
                'parents.name as parent_name'
            ])*/
//            ->select('categories.*')
//            ->selectRaw('(SELECT COUNT(*) FROM products WHERE  category_id = categories.id) as products_count')
//            ->addselect(DB::raw('(SELECT COUNT(*) FROM products WHERE category_id = categories.id) as products_count'))
            ->withCount([
                'products as products_number' => function($query) {
                $query->where('status', '=','active');
                }
            ])
            ->filter($request->query())
            ->orderBy('categories.name')
            //      ->onlyTrashed()          // Field Deleted Only
            //      ->withTrashed()
            //     ->latest()               // Scope local
            ->paginate(); // Return Collection object
        // Test Scope Local
        // $categories = Category::status('archived')->active()->paginate();

        return view('dashboard.categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $parents = Category::all();
        $category = new Category();
        return view('dashboard.categories.create', compact('parents', 'category'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        /*
        $request->input('name');
        $request->post('name');
        $request->get('name');
        $request['name'];

        $request->all(); // return array of all input data
        $request->only(['name', 'parent_id']);
        $request->except(['name', 'parent_id']);

        $category = new Category( $request->all() );
        $category->save();
        */
        $clean_data = $request->validate(Category::rules(), [
            'name.unique' => 'This name is already exists!',
            'required' => 'This field (:attribute) is required!',
        ]);

        // Request merge
        $request->merge([
            'slug' => Str::slug($request->post('name'))
        ]);

        $data = $request->except('image');
        $data['image'] = $this->uploadImage($request);

        // Mass assignment
        $category = Category::create($data);

        // PRG
        return Redirect::route('dashboard.categories.index')->with('success', 'Category Created!');

    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        return view('dashboard.categories.show', compact('category'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        try {
            $category = Category::findOrFail($id);
        } catch (\Exception $e) {
            return Redirect::route('dashboard.categories.index')->with('info', 'Record not found!');
        }

        $category = Category::findOrFail($id);
        // Select * From categories where id <> $id
        // AND (parent_id IS NULL OR parent_id <> $id)
        $parents = Category::where('id', '<>', $id)
            ->where(function ($query) use ($id) {
                $query->whereNull('parent_id')
                    ->orwhere('parent_id', '<>', $id);
            })
            ->get();

        return view('dashboard.categories.edit', compact('category', 'parents'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CategoryRequest $request, string $id)
    {
        // $request->validate(Category::rules($id));

        $category = Category::findOrFail($id);
        $old_image = $category->image;
        $data = $request->except('image');

        $new_image = $this->uploadImage($request);

        if ($new_image) {
            $data['image'] = $new_image;
        }

        $category->update($data);
        // $category->fill($request->all())->save();

        if ($old_image && $new_image) {
            Storage::disk('public')->delete($old_image);
        }
        return Redirect::route('dashboard.categories.index')->with('success', 'Category Updated!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        // Category::where('id', '=', $id)->delete();
       // $category = Category::findOrFail($id);
        $category->delete();

        //   if ($category->image) {
        //       Storage::disk('public')->delete($category->image);
        //   }

        // Category::destroy($id);

        return Redirect::route('dashboard.categories.index')->with('success', 'Category Deleted!');
    }

    protected function uploadImage(Request $request)
    {
        if (!$request->hasFile('image')) {
            return;
        }
        $file = $request->file('image');   // Uploaded File Object
        //     $file->move(public_path('images'),
        //     $file->getClientOriginalName());
        //     $file->getSize():
        //     $file->getClientOriginalExtension();
        //     $file->getMimeType();   // image/png

        $path = $file->store('uploads', [
            'disk' => 'public'
        ]);
        return $path;
    }

    public function trash()
    {
        $categories = Category::onlyTrashed()->paginate();
        return view('dashboard.categories.trash', compact('categories'));
    }

    public function restore(Request $request, $id)
    {
        $category = Category::onlyTrashed()->findOrFail($id);
        $category->restore();
        return Redirect::route('dashboard.categories.trash')->with('success', 'Category Restored!');
    }

    public function forceDelete($id)
    {
        $category = Category::onlyTrashed()->findOrFail($id);
        $category->forceDelete();

        if ($category->image) {
            Storage::disk('public')->delete($category->image);
        }
        return redirect()->route('dashboard.categories.trash')->with('success', 'Category Deleted Permanently!');
    }

}
