
$(document).ready(function () {
    $("#current_pwd").keyup(function () {
        var current_pwd = $("#current_pwd").val();

        // Clear previous messages
        $('#verifyCurrentPwd').html("");

        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: 'post',
            url: '/admin/check-current-password',
            data: { current_pwd: current_pwd },
            success: function (resp) {
                if (resp == "false") {
                    $('#verifyCurrentPwd').html("Current Password is Incorrect!");
                } else if (resp == "true") {
                    $('#verifyCurrentPwd').html("Current Password is Correct!");
                }
            },
            error: function (xhr, status, error) {
                console.error(xhr);
                console.error(status);
                console.error(error);
                alert('Error: ' + status);
            }
        });
    });


    // Confirm the deletion of CMS Page, SubAdmin, or Category
    $(document).on("click", ".confirmDelete", function () {
        var name = $(this).attr('name');

        if (confirm('Are you sure to delete this ' + name + '?')) {
            return true;
        } else {
            return false;
        }
    });

    // Update Cms Page Status
    $(document).on("click", ".updateCmsPageStatus", function () {
        var status = $(this).children("i").attr("status");
        var page_id = $(this).attr("page_id");

        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: 'post',
            url: '/admin/update-cms-page-status',
            data: { status: status, page_id: page_id },
            success: function (resp) {
                if (resp.status == 0) {
                    $("#page-" + page_id).html("<i class='fas fa-toggle-off' style='color:grey' status='Inactive'></i>");
                } else if (resp.status == 1) {
                    $("#page-" + page_id).html("<i class='fas fa-toggle-on' style='color:#3f6ed3'  status='Active'></i>");
                }
            },
            error: function () {
                alert("Error");
            }
        });
    });






    // Update Category Status
    $(document).on("click", ".updateCategoriesStatus", function () {
        var $categorie = $(this);
        var status = $(this).find("i").data("status");
        var category_id = $(this).data("category-id");
        $.ajax({

            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: "POST",
            url: '/admin/update-category-status',
            data: { status: status, category_id: category_id },
            success: function (resp) {
                if (resp.status == 0) {
                    $("#category-" + category_id).html("<i class='fas fa-toggle-off' style='color:grey' data-status='Inactive'></i>");
                } else if (resp.status == 1) {
                    $("#category-" + category_id).html("<i class='fas fa-toggle-on' style='color:#3f6ed3' data-status='Active'></i>");
                }
            },
            error: function () {
                alert("Error");
            }
        });
    });


    $('.confirmDeleteArray').on('click', function (event) {
        event.preventDefault();
        var $deleteLink = $(this);
        var imageName = $deleteLink.attr('url-attr'); // Use data() instead of attr()
        var categoryId = $deleteLink.attr('catid'); // Use data() instead of attr()

        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: "http://127.0.0.1:8000/admin/add-edit-category/" + categoryId + "/delete-image/" + imageName,
            method: 'DELETE',
            data: {},
            success: function (response) {
                console.log(response);
                // Assuming the response contains a success message
                if (response.success) {
                    $deleteLink.closest('div').remove();
                } else {
                    console.error(response.message);
                }
            },
            error: function (xhr, status, error) {
                console.error(xhr);
                console.error(status);
                console.error(error);
                alert('Error: ' + status);
            }
        });
    });

    var selectedCategoryId;
    var selectedSubcategoryId; // Declare variable for subcategory ID

    $('#category_name').on('change', function () {
        selectedCategoryId = $(this).val();
        if (selectedCategoryId) {
            $.ajax({
                type: 'GET',
                url: '/admin/get-subcategories/' + selectedCategoryId,
                success: function (data) {
                    $('#sub_category_name').html('<option value="">Select Sub Category</option>');
                    if (data.length > 0) {
                        $.each(data, function (key, value) {
                            $('#sub_category_name').append('<option value="' + value.id + '">' + value.category_name + '</option>');
                        });
                    } else {
                        console.log("No sub-categories found for the selected category.");
                    }
                    $('#sub_category_name').trigger('change');
                },
                error: function (xhr, status, error) {
                    console.error(xhr);
                    console.error(status);
                    console.error(error);
                    alert('Error: ' + status);
                }
            });
        } else {
            $('#sub_category_name').html('<option value="">Select Sub Category</option>');
            $('#sub_category_name').trigger('change');
        }
    });

    $('#sub_category_name').on('change', function () {
        // Update the selectedSubcategoryId whenever sub_category_name changes
        selectedSubcategoryId = $(this).val();
        $('#hidden_subcategory_id').val(selectedSubcategoryId);
    });

    // Add a submit event to the form
    $('#productForm').on('submit', function () {
        // Before submitting the form, update the hidden input with the selectedSubcategoryId
        $('#hidden_subcategory_id').val(selectedSubcategoryId);
    });


    $('.confirmDeleteArrayI').on('click', function (event) {
        event.preventDefault();
        var $deleteLink = $(this);
        var imageName = $deleteLink.attr('url-attr');
        var productId = $deleteLink.attr('protid');
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: "http://127.0.0.1:8000/admin/add-edit-product/" + productId + "/delete-image/" + imageName,
            method: 'DELETE',
            data: {},
            success: function (response) {
                console.log(response);
                if (response.success) {
                    // Assuming the link is directly within the div to be removed
                    $deleteLink.closest('div').remove();
                    alert('Image deleted successfully.');
                } else {
                    console.error(response.message);
                    alert('Error deleting image.');
                }
            },
            error: function (xhr, status, error) {
                console.error(xhr);
                console.error(status);
                console.error(error);
                alert('Error: ' + status);
            }
        });
    });
    $('.category-item').on('click', function () {
        var categoryId = $(this).data('category');

        // Assuming you have a route or endpoint to fetch products by category
        var url = 'http://127.0.0.1:8000/products-by-category/' + categoryId;

        // Perform an AJAX request to fetch products
        $.ajax({
            url: url,
            method: 'GET',
            dataType: 'json',
            success: function (response) {
                // Handle the response, e.g., display the products
                console.log(response);
                // You can customize the handling based on your application's requirements
                window.location.href = 'http://127.0.0.1:8000/allpro?category=' + categoryId;
            },
            error: function (xhr, status, error) {
                console.error(xhr);
                console.error(status);
                console.error(error);
                alert('Error fetching products: ' + status);
            }
        });
    });
    $('.btn-success').on('click', function () {
        // Find the closest category-item div
        var $categoryItem = $(this).closest('.category-item');

        // Get the category ID from the data attribute
        var categoryId = $categoryItem.data('category');

        // Redirect to the new page with the category ID as a parameter
        window.location.href = 'http://127.0.0.1:8000/allpro?category=' + categoryId;
    });


    $(document).on("click", ".updateProductStatus", function () {
        var status = $(this).children("i").attr("status");
        var product_id = $(this).attr("product_id");
    
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: 'post',
            url: '/admin/update-product-status',
            data: { status: status, product_id: product_id },
            success: function (resp) {
                if (resp.status == 0) {
                    $("#product-"+product_id).html("<i class='fas fa-toggle-off' style='color:grey' status='Inactive'></i>");
                } else if (resp.status == 1) {
                    $("#product-"+product_id).html("<i class='fas fa-toggle-on' style='color:#3f6ed3' status='Active'></i>");
                }
    
                // Optionally, you can update other parts of your UI or perform additional actions
                // ...
    
                // alert("Product status updated successfully!");
            },
            error: function () {
                alert("Error updating product status");
            }
        });
    });
    


});