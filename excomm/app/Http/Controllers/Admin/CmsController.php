<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\AdminsRole;
use App\Models\Cmspage;             
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
class CmsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        Session::put('page','cms-pages');    
        $CmsPages = Cmspage::get()->toArray();
        // dd($cmsPages);
        $cmspagesModuleCount = AdminsRole::where(['subadmin_id'=>Auth::guard('admin')->user()->id,'module'=>'cms_pages'])->count();
        $pagesModule=array();
        if (Auth::guard('admin')->user()->type=="admin"){
            $pagesModule['view_access']=1;
            $pagesModule['edit_access']=1;
            $pagesModule['full_access']=1;
        }else if($cmspagesModuleCount==0){
            $message="This feature is restricted for you";
            return redirect('admin/dashboard')->with('error_massage',$message);
        }else{
            $pagesModule=AdminsRole::where(['subadmin_id'=>Auth::guard('admin')->user()->id,'module'=>'cms_pages'])->first()->toArray();
        }

        return view('admin.pages.cms_pages')->with(compact('CmsPages','pagesModule'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Cmspage $cmspage)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, $id = null)
    {
        // Use model binding to directly retrieve the CMSPage instance
        $cmspage = $id ? CMSPage::findOrFail($id) : new CMSPage();

        $title = $id ? "Edit CMS Page" : "Add CMS Page";

        if ($request->isMethod('post')) {
            $data = $request->all();

            $rules = [
                'title' => 'required',
                'url' => 'required',
                'description' => 'required',
            ];

            $customMessages = [
                'title.required' => 'Page Title is required',
                'url.required' => 'Page URL is required',
                'description.required' => 'Page Description is required',
            ];

            $this->validate($request, $rules, $customMessages);

            // Update CMSPage attributes
            $cmspage->fill($data);
            $cmspage->status = 1; // Assuming you want to set status to 1
            $cmspage->save();

            $message = $id ? 'CMS Page updated successfully' : 'CMS Page added successfully';

            return redirect('admin/cms-pages')->with('success_message', $message);
        }

        return view('admin.pages.add_edit_cmspage', compact('title', 'cmspage'));
    }



    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Cmspage $cmspage)
    {
        if ($request->ajax()) {
            $data = $request->all();
            if ($data['status'] == "Active") {
                $status = 0;
            } else {
                $status = 1;
            }
            Cmspage::where('id', $data['page_id'])->update(['status' => $status]);
            return response()->json(['status' => $status, 'page_id' => $data['page_id']]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        CmsPage::where('id', $id) ->delete();
        return redirect()->back()->with('success_message','CMS Page deleted successfully!');
    }
}
/***
 * 
 * <?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Categorie;
use Illuminate\Support\Facades\Session;
use App\Models\AdminsRole;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CategoryController extends Controller
{
    public function categories()
    {
        Session::put('page', 'categories'); // Update the session key for categories
        $categories = Categorie::get()->toArray(); // Fetch categories from the Category model

        $categoriesModuleCount = AdminsRole::where([
            'subadmin_id' => Auth::guard('admin')->user()->id,
            'module' => 'categories'
        ])->count();

        $categoriesModule = [];

        if (Auth::guard('admin')->user()->type == "admin") {
            $categoriesModule['view_access'] = 1;
            $categoriesModule['edit_access'] = 1;
            $categoriesModule['full_access'] = 1;
        } else if ($categoriesModuleCount == 0) {
            $message = "This feature is restricted for you";
            return redirect('admin/dashboard')->with('error_massage', $message);
        } else {
            $categoriesModule = AdminsRole::where([
                'subadmin_id' => Auth::guard('admin')->user()->id,
                'module' => 'categories'
            ])->first()->toArray();
        }

        return view('admin.categories.categories')->with(compact('categories', 'categoriesModule'));
    }

    public function edit(Request $request, $id = null)
    {
        $category = $id ? Categorie::findOrFail($id) : new Categorie();

        $title = $id ? "Edit Category" : "Add Category";

        if ($request->isMethod('post')) {
            $data = $request->all();

            $rules = [
                'category_name' => 'required',
                'url' => 'required',
                'description' => 'required',
            ];

            $customMessages = [
                'category_name.required' => 'Category Name is required',
                'url.required' => 'Category URL is required',
                'description.required' => 'Category Description is required',
            ];

            $this->validate($request, $rules, $customMessages);

            $category->fill($data);
            $category->save();

            $message = $id ? 'Category updated successfully' : 'Category added successfully';

            return redirect('admin/categories')->with('success_message', $message);
        }

        return view('admin.categories.add_edit_category', compact('title', 'category'));
    }

    public function update(Request $request, Categorie $category)
    {
        if ($request->ajax()) {
            $data = $request->all();
            $status = $data['status'] == "Active" ? 0 : 1;
            Categorie::where('id', $data['category_id'])->update(['status' => $status]);
            return response()->json(['status' => $status, 'category_id' => $data['category_id']]);
        }
    }

    public function destroy($id)
    {
        Categorie::where('id', $id)->delete();
        return redirect()->back()->with('success_message', 'Category deleted successfully!');
    }
}





namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Categorie;
use Illuminate\Support\Facades\Session;
use App\Models\AdminsRole;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

 */