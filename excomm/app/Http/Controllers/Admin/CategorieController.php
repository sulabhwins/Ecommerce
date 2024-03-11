<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Categorie;
use Illuminate\Support\Facades\Session;
use App\Models\AdminsRole;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class CategorieController extends Controller
{
    public function categories()
    {
        Session::put('page', 'categories');

        $categories = Categorie::with('parentcategory')->get()->toArray();
        //   dd($categories);
        $categoriesModuleCount = AdminsRole::where([
            'subadmin_id' => Auth::guard('admin')->user()->id,
            'module' => 'admin_category'
        ])->count();

        $pagesModule = [];

        if (Auth::guard('admin')->user()->type == "admin") {
            $pagesModule['view_access'] = 1;
            $pagesModule['edit_access'] = 1;
            $pagesModule['full_access'] = 1;
        } else if ($categoriesModuleCount == 0) {
            $message = "This feature is restricted for you";
            return redirect('admin/dashboard')->with('error_message', $message);
        } else {
            $pagesModule = AdminsRole::where([
                'subadmin_id' => Auth::guard('admin')->user()->id,
                'module' => 'admin_category'
            ])->first()->toArray();
        }

        return view('admin.categories.categories')->with(compact('categories', 'pagesModule'));
    }


    public function edit(Request $request, $id = null)
    {
        $category = $id ? Categorie::findOrFail($id) : new Categorie();
        $allCategories = Categorie::all();
    
        $title = $id ? "Edit Category" : "Add Category";
    
        if ($request->isMethod('post')) {
            $data = $request->all();
    
            $rules = [
                'category_name' => 'required',
                'url' => 'required',
                'description' => 'required',
                // 'parent_id' => 'nullable|exists:categories,id',
            ];
    
            $customMessages = [
                'category_name.required' => 'Category Name is required',
                'url.required' => 'Category URL is required',
                'description.required' => 'Category Description is required',
                // 'parent_id.exists' => 'Selected parent category does not exist.',
            ];
    
            $this->validate($request, $rules, $customMessages);
    
            // Check if old images should be deleted
            if ($id && $request->has('delete_old_images') && $request->input('delete_old_images') == 1) {
                $oldImages = json_decode($category->category_image, true);
    
                foreach ($oldImages as $oldImage) {
                    // Delete the old image file
                    Storage::delete('images/' . $oldImage);
                }
    
                // Clear the category_image field in the database
                $category->category_image = null;
            }
    
            $category->fill($data);
    
            // Update the parent_id
            // $category->parent_id = $data['parent_id'];
            $category->parent_id = $data['parent_id'] ?: null;
    
            if ($request->hasFile('category_image')) {
                $image = $request->file('category_image');
                $imageName = time() . '_' . $image->getClientOriginalName();
                $image->storeAs('images', $imageName, 'public');
                $category->category_image = $imageName;
            }
    
            $category->save();
    
            $message = $id ? 'Category updated successfully' : 'Category added successfully';
    
            return redirect('admin/categories')->with('success_message', $message);
        }
    
        return view('admin.categories.add_edit_category', compact('title', 'category', 'allCategories'));
    }
    



    public function update(Request $request, Categorie $categories)
    {
        if ($request->ajax()) {
            $data = $request->all();
            if ($data['status'] == "Active") {
                $status = 0;
                } else {
                $status = 1;
                }
                Categorie::where('id', $data['category_id'])->update(['status' => $status]);
                return response()->json(['status' => $status,'categorie' => $categories->id]);
                // dd($categories);
            }

            return response()->json(['error' => 'Missing status in data']);
        }

    
    // category_id


    public function destroy($id)
    {
        Categorie::where('id', $id)->delete();
        return redirect()->back()->with('success_message', 'Category deleted successfully!');
    }

    public function deleteImage($categoryId, $imageName)
    {
        // dd($imageName);
        $category = Categorie::find($categoryId);

        if ($category) {
            $categoryImages = json_decode($category->category_image, true);
            $index = array_search($imageName, $categoryImages);

            if ($index !== false) {
                unset($categoryImages[$index]);
                $categoryImages = array_values($categoryImages);
                $category->category_image = json_encode($categoryImages);
                $category->save();
                Storage::disk('public')->delete('images/' . $imageName);


                return response()->json(['success' => true, 'message' => 'Image deleted successfully']);
            } else {
                return response()->json(['success' => false, 'message' => 'Image not found']);
            }
        } else {
            return response()->json(['success' => false, 'message' => 'Category not found']);
        }
    }
}
