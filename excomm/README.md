if ($request->hasFile('image')) {
    $image = $request->file('image');
    $imageName = time() . '_' . $image->getClientOriginalName();
    $image->storeAs('uploads', $imageName, 'public'); // Update storage path
    $category->category_image = 'storage/uploads/' . $imageName; // Update category_image field
}


if ($request->hasFile('image')) {
                $image = $request->file('image');
                $imageName = time() . '_' . $image->getClientOriginalName();
                $image->storeAs('images', $imageName, 'public');
                $category->category_image = 'storage/images/' . $imageName; // Update category_image field
            }



             <div class="form-group">
            <label for="images">Images</label>
            <input type="file" class="form-control" id="images" name="images[]" multiple>
            <small class="text-muted">You can select multiple images by holding down the Ctrl (Windows) or Command (Mac) key while selecting.</small>
        </div>


        /////////////////////////////////////////////for multipal img////////////////////////////////////////////////////////////////////
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

        // Handle multiple images
        if ($request->hasFile('images')) {
            $images = $request->file('images');
            $imagePaths = [];

            foreach ($images as $image) {
                $imageName = time() . '_' . $image->getClientOriginalName();
                $image->storeAs('images', $imageName, 'public');
                $imagePaths[] = 'storage/images/' . $imageName;
            }

            $category->category_image = $imagePaths;
        }

        $category->save();

        $message = $id ? 'Category updated successfully' : 'Category added successfully';

        return redirect('admin/categories')->with('success_message', $message);
    }

    return view('admin.categories.add_edit_category', compact('title', 'category'));
}



jeson////////////////////



if ($request->hasFile('images')) {
                $imagePaths = [];
                foreach ($request->file('images') as $image) {
                    $imageName = time() . '_' . $image->getClientOriginalName();
                    $image->storeAs('images', $imageName, 'public');
                    $imagePaths[] = 'storage/images/' . $imageName;
                }
                //print_r($imagePaths);
              //  print_r(json_encode($imagePaths)); die;
                $category->category_image = json_encode($imagePaths);
            }


                        <div>
                                        @if(!empty($category['category_image']))
                                        @php
                                        $imagePaths = json_decode( $category['category_image']);
                                        @endphp


                                        @foreach($imagePaths as $image)

                                        
                                        <div>
                                            <img style="width: 100px;" src="{{ asset($image) }}">
                                            <!-- <a style='color: #3f6ed3;' class="confirmDelete" name="Category" title="Delete Category Image" href="{{ url('admin/delete-category-image/'.$category['id'].'/'.$image) }}"><i class="fas fa-trash"></i></a> -->
                                        </div>
                                        @endforeach
                                        @endif
                                    </div>


                                    &nbsp;&nbsp;
/////////////////////////////////////////delete/////////////////////////////////////////////////////////////////
 public function deleteImage($categoryId, $imageName)
    {
        
        $category = Categorie::find($categoryId);
        
        if ($category) {
            
            $categoryImages = $category->category_image;
            $in=json_decode($categoryImages,true);
            // dd($in);
            $index = array_search($imageName, $in);

            
            // dd($index);
            // die('hare');
            if ($index !== false) {
                unset($categoryImages[$index]);
    
                // Reindex the array to avoid gaps in the keys
                $categoryImages = array_values($categoryImages);
    
                // Save the updated category
                $category->category_image = $categoryImages;
                $category->save();
    
                // Delete the image file from storage
                Storage::disk('public')->delete('images/' . $imageName);
    
                return response()->json(['success' => true, 'message' => 'Image deleted successfully']);
            } else {
                return response()->json(['success' => false, 'message' => 'Image not found']);
            }
        } else {
            return response()->json(['success' => false, 'message' => 'Category not found']);
        }
    }