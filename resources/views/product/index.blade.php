<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.min.css" />

    <link href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script>
    <script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


    <title>Ajax Crud Project!</title>
</head>

<body>

    <div class="container">
        <div class="card">
            <div class="card-header">
                <div class="row d-flex justify-content-center">
                    <div class="col-md-8">
                        <h3><strong>Product List</strong></h3>
                    </div>
                    <div class="col-md-4">
                        <div>
                            <span class="btn btn-success"><a href="{{ route('products.create') }}"
                                    style="color: #fff; text-decoration: none">Add Product</a></span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <table class="table table-bordered data-table" id="dataTable">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>product_name</th>
                            <th>price</th>
                            <th>File</th>
                            <th width="280px">Action</th>
                        </tr>
                    </thead>
                    <tbody id="myTable">
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="modal fade" id="ajaxModel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="modelHeading"></h4>
                </div>
                <div class="modal-body">
                    <form id="myForm" name="myForm" class="form-horizontal">
                        @csrf
                        <input type="hidden" name="product_id" id="product_id">
                        <div class="form-group">
                            <label for="name" class="col-sm-2 control-label">Name</label>
                            <div class="col-sm-12">
                                <input type="text" class="form-control" id="name" name="name"
                                    placeholder="Enter Name" value="" maxlength="50" required="">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-2 control-label">Details</label>
                            <div class="col-sm-12">
                                <textarea id="price" name="price" required="" placeholder="Enter Details" class="form-control"></textarea>
                            </div>
                        </div>


                        <div class="form-group">
                            <label class="col-sm-2 control-label">Image</label>
                            <div class="col-sm-12">
                                <input type="file" class="form-control" id="image" name="image">
                                <img src="" id="pimage" class="img-thumbnail mt-2" style="max-height: 100px;">
                            </div>
                            
                        </div>
                        

                        <div class="col-sm-offset-2 col-sm-10">
                            <button type="submit" class="btn btn-primary" id="saveBtn" value="create">Save changes
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>


    {{-- display selected image for editing --}}
     
    <script type="text/javascript">
        $(document).ready(function(){
            $('#image').change(function(e){
                var reader = new FileReader();
                reader.onload = function(e){
                    $('#pimage').attr('src', e.target.result);
                }
                reader.readAsDataURL(e.target.files['0']);
            })
        })
    </script>

    <script>
        $(function() {

            // ----------------------  token 

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });




            // ---------------------- View data using by Datatable 

            var table = $('.data-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('products.index') }}",
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex'
                    },
                    {
                        data: 'name',
                        name: 'name'
                    },
                    {
                        data: 'price',
                        name: 'price'
                    },
                    {data: 'image', name: 'image', render: function(data, type, full, meta) {
                        return '<img src="' + data + '" class="img-thumbnail" width="50">';
                    }},
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    },
                ]
            });



            // ---------------------- view data with modal form for Edit


            $('body').on('click', '.editProduct', function() {
                var product_id = $(this).data('id');
                $.get("{{ route('products.index') }}" + '/' + product_id + '/edit', function(data) {
                    $('#modelHeading').html("Edit Product");
                    $('#saveBtn').val("edit-user");
                    $('#ajaxModel').modal('show');
                    $('#product_id').val(data.id);
                    $('#name').val(data.name);
                    $('#price').val(data.price);
                    $('#pimage').attr('src', '/app/' + data.image);
                });

            });






            // ---------------------- Update data with modal

            // $('#saveBtn').click(function(e) {
            //     e.preventDefault();


            //     var name = $('#name').val();
            //     var price = $('#price').val();

            //     // product_id input with hidden 
            //     var id = $('#product_id').val();

            //     $.ajax({
            //         //data: $('#productForm').serialize(),
            //         url: "/update/product/" + id,
            //         type: "POST",
            //         dataType: 'json',
            //         data: {
            //             name: name,
            //             price: price,
            //             _token: "{{ csrf_token() }}"
            //         },
            //         success: function(data) {

            //             console.log(data)

            //             // Start Message 
            //             const Toast = Swal.mixin({
            //                 toast: true,
            //                 position: 'top-end',

            //                 showConfirmButton: false,
            //                 timer: 3000
            //             })
            //             if ($.isEmptyObject(data.error)) {
            //                 Toast.fire({
            //                     type: 'success',
            //                     icon: 'success',
            //                     title: 'Product Updated Successfully!!',
            //                 })


            //                 // form reset, close modal & table refresh

            //                 $('#productForm').trigger("reset");
            //                 $('#ajaxModel').modal('hide');
            //                 table.draw();
            //             } else {
            //                 Toast.fire({
            //                     type: 'error',
            //                     icon: 'error',
            //                     title: data.error
            //                 })
            //             }
            //             // End Message

            //         },

            //         //--------------- Error Message

            //         error: function(data) {
            //             console.log('Error:', data);
            //             $('#saveBtn').html('Save Changes');
            //         }
            //     });
            // });



        // ---------------------- Update data with image
            
        $('#saveBtn').click(function(e) {
            e.preventDefault();

            var formElement = document.getElementById("myForm");
            var formData = new FormData(formElement);

            var id = $('#product_id').val();

            $.ajax({
                url: "/update/product/" + id,
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function(data) {
                    console.log(data);
                    $('#error-name').text('');
                    $('#error-price').text('');
                    $('#error-image').text('');

                    if (data.errors) {
                        if (data.errors.name) {
                            $('#error-name').text(data.errors.name[0]);
                        }

                        if (data.errors.price) {
                            $('#error-price').text(data.errors.price[0]);
                        }

                        if (data.errors.price) {
                            $('#error-image').text(data.errors.image[0]);
                        }

                    } else {
                        // Start Message 
                        const Toast = Swal.mixin({
                            toast: true,
                            position: 'top-end',

                            showConfirmButton: false,
                            timer: 3000
                        })

                        Toast.fire({
                                type: 'success',
                                icon: 'success',
                                title: 'Product Updated Successfully!!',
                            })

                            $('#productForm').trigger("reset");
                             $('#ajaxModel').modal('hide');
                             table.draw();

                    }

                },
                error: function(xhr, textStatus, error) {
                    console.log(xhr.statusText);
                    console.log(textStatus);
                    console.log(error);
                }
            });
        });




            // -----------------------------  Delete Product


            $('body').on('click', '.deleteProduct', function() {
                var id = $(this).data('id');
                    confirm("Are You sure want to delete !");
                $.ajax({
                    type: "DELETE",
                    url: '/delete/product/' + id,
                    data:{_token: "{{ csrf_token() }}"},
                    success: function(data) {
                        table.draw()
                    },
                    error: function(data) {
                        console.log('Error:', data);
                    }
                });
            })


        });
    </script>
</body>

</html>
