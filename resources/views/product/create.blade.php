<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>


    <title>Hello, world!</title>
</head>

<body>

    <div class="container">

        {{----------------------------------  Header ------------------------}}

        <div class="card">
            <div class="card-header">
                <div class="row">
                    <nav class="navbar navbar-expand-lg navbar-light bg-light">
                        <ul class="navbar-nav mr-auto">
                            <li class="nav-item active">
                              <a class="nav-link" href="{{ route('home')}}">Home</a>
                            </li>
                            <li class="nav-item active">
                              <a class="nav-link" href="{{ route('tasks.index')}}">Task</a>
                            </li>
                          </ul>
                    </nav>
                </div>
            </div>
        </div>
        
        <div class="card">
            <div class="card-header">
                <div class="d-flex justify-content-center">
                    <h3><strong>Add Product</strong></h3>
                </div>
            </div>

            <div class="card-body">
                <form action="#" method="POST"  id="product_form" enctype="multipart/form-data">
                    @csrf
                    <div class="row d-flex justify-content-center">
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-body">
                                    <div class="form-group">
                                        <label for="exampleFormControlInput1" class="form-label">Product Name</label>
                                        <input type="text" class="form-control" id="name"
                                            placeholder="Product Name" name="name">
                                        <span class="btn-outline-danger" id="error-name"></span>

                                    </div>
                                    <div class="form-group mt-3">
                                        <label for="Price" class="form-label">Price</label>
                                        <input type="text" class="form-control" id="price"
                                            placeholder="Product Price" name="price">
                                        <span class="btn-outline-danger" id="error-price"></span>
                                    </div>

                                    <div class="form-group mt-3">
                                        <label for="Image" class="form-label">Image</label>
                                        <input type="file" class="form-control" name="image" id="image">
                                        <span class="btn-outline-danger" id="error-image"></span>
                                    </div>


                                    <div class="mt-3">
                                        <button type="submit" class="btn btn-info">Submit</button>
                                    </div>

                                    <div class="d-flex justify-content-center">
                                        <div>
                                            <span class="btn btn-success"><a href="{{ url('/') }}"
                                                    style="color: #fff; text-decoration: none">Products</a></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script type="text/javascript">
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        // $('#product_form').on('submit', function(event) {

        //     event.preventDefault();
        //     var name = $('#name').val();
        //     var price = $('#price').val();

        //     var request = $.ajax({
        //         url: '/store/product',
        //         type: "POST",
        //         data: {
        //             name: name,
        //             price: price,
        //             _token: "{{ csrf_token() }}"
        //         },
        //         dataType: "json",

        //         success: function(data) {
        //             console.log(data)

        //             $('#error-name').text('');
        //             $('#error-price').text('');

        //             if (data.errors) {
        //                 if (data.errors.name) {
        //                     $('#error-name').text(data.errors.name[0]);
        //                 }

        //                 if (data.errors.price) {
        //                     $('#error-price').text(data.errors.price[0]);
        //                 }
        //             } else {
        //                 // Start Message 
        //                 const Toast = Swal.mixin({
        //                     toast: true,
        //                     position: 'top-end',

        //                     showConfirmButton: false,
        //                     timer: 3000
        //                 })

        //                 Toast.fire({
        //                         type: 'success',
        //                         icon: 'success',
        //                         title: 'Product Updated Successfully!!',
        //                     })

        //                     $("#product_form")[0].reset();

        //             }


        //         }
        //     })
        // })


        // Insert data with image using ajax

        $('#product_form').submit(function(e) {
            e.preventDefault();

            var formData = new FormData(this);

            $.ajax({
                url: '/store/product',
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

                        if (data.errors.image) {
                            $('#error-price').text(data.errors.image[0]);
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

                            $("#product_form")[0].reset();

                    }

                },
                error: function(xhr, textStatus, error) {
                    console.log(xhr.statusText);
                    console.log(textStatus);
                    console.log(error);
                }
            });
        });


        //----------------------------  PDF Upload-----------------------

        // function submitForm() {
        //     event.preventDefault(); // prevent default form submission behaviors
        //     let formData = new FormData();
        //     formData.append('name', document.getElementById("name").value); // append input values to FormData object
        //     formData.append('price', document.getElementById("price").value);
        //     formData.append('image', document.getElementById("image").files[0]);
        //     formData.append("_token", "{{ csrf_token() }}"); // add CSRF token for security
        //     // send AJAX request
        //     axios.post('/store/product', formData)
        //         .then(response => {
        //             console.log(response.data);
        //         })
        //         .catch(error => {
        //             console.log(error.response.data);
        //         });
        // }

    </script>




    <script>
        @if (Session::has('message'))
            var type = "{{ Session::get('alert-type', 'info') }}"
            switch (type) {
                case 'info':
                    toastr.info(" {{ Session::get('message') }} ");
                    break;

                case 'success':
                    toastr.success(" {{ Session::get('message') }} ");
                    break;

                case 'warning':
                    toastr.warning(" {{ Session::get('message') }} ");
                    break;

                case 'error':
                    toastr.error(" {{ Session::get('message') }} ");
                    break;
            }
        @endif
    </script>

    <!-- Optional JavaScript; choose one of the two! -->

    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
    </script>



    <!-- Option 2: Separate Popper and Bootstrap JS -->
    <!--
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"
        integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js"
        integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous">
    </script>
    -->
</body>

</html>
