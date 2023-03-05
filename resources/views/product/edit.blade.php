<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
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
                                        <span class=" btn-outline-danger" id="error-name"></span>

                                    </div>
                                    <div class="form-group mt-3">
                                        <label for="Price" class="form-label">Price</label>
                                        <input type="text" class="form-control" id="price"
                                            placeholder="Product Price" name="price">
                                        <span id="error-price"></span>
                                    </div>

                                    <div class="form-group mt-3">
                                        <label for="Image" class="form-label">Image</label>
                                        <input type="file" class="form-control" name="image" id="image">
                                        <span id="error-image"></span>
                                    </div>


                                    <div class="mt-3">
                                        <button type="submit" class="btn btn-info">Submit</button>
                                    </div>

                                    <div class="d-flex justify-content-center">
                                        <div>
                                            <button class="btn btn-success"><a href="{{ url('/') }}"
                                                    style="color: #fff; text-decoration: none">Products</a></button>
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
</body>
</html>