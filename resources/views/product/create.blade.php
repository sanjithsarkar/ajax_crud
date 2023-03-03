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

    <title>Hello, world!</title>
</head>

<body>

    <div class="container">
        <div class="card">
            <div class="card-header">
                <div class="d-flex justify-content-center">
                    <h3><strong>Add Product</strong></h3>
                </div>
            </div>

            <div class="card-body">
                <form action="#" method="POST" id="product_form">
                    <div class="row d-flex justify-content-center">
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-body">
                                    <div class="form-group">
                                        <label for="exampleFormControlInput1" class="form-label">Product Name</label>
                                        <input type="text" class="form-control" id="name"
                                            placeholder="Product Name" name="name">
                                            @error('name')
                                            <div class="alert alert-danger mt-3">{{ $message }}</div>
                                            @enderror
                                            
                                    </div>
                                    <div class="form-group mt-3">
                                        <label for="Price" class="form-label">Price</label>
                                        <input type="text" class="form-control" id="price"
                                            placeholder="Product Price" name="price">
                                    </div>

                                    <div class="mt-3">
                                        <button type="submit" class="btn btn-info">Submit</button>
                                    </div>

                                    <div class="d-flex justify-content-center">
                                        <div>
                                            <button class="btn btn-success"><a href="{{ url('/')}}" style="color: #fff; text-decoration: none">Products</a></button>
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

        $('#product_form').on('submit', function(event) {

            event.preventDefault();
            var name = $('#name').val();
            var price = $('#price').val();

            var request = $.ajax({
                url: '/store/product',
                type: "POST",
                data: {
                    name: name,
                    price: price,
                    _token: "{{ csrf_token() }}"
                },
                dataType: "json",

                success: function(data) {
                    console.log(data)

                    // Start Message 
                    const Toast = Swal.mixin({
                        toast: true,
                        position: 'top-end',

                        showConfirmButton: false,
                        timer: 3000
                    })
                    if ($.isEmptyObject(data.error)) {
                        Toast.fire({
                            type: 'success',
                            icon: 'success',
                            title: 'Product Inserted Successfully!!',
                        })

                        $("#product_form")[0].reset();
                    } else {
                        Toast.fire({
                            type: 'error',
                            icon: 'error',
                            title: data.error
                        })
                    }
                    // End Message
                }
            })
        })
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
