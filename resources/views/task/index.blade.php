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

        {{----------------------------------- Task List ------------------------------}}

        <div class="card">
            <div class="card-header">
                <div class="row d-flex justify-content-center">
                    <div class="col-md-8">
                        <h3><strong>Task List</strong></h3>
                    </div>
                    <div class="col-md-4">
                        <div>
                            <span class="btn btn-success"><a href="{{ route('tasks.create') }}"
                                    style="color: #fff; text-decoration: none">Add Task</a></span>
                        </div>
                    </div>
                </div>
            </div>

        {{----------------------------------- Table Data ------------------------------}}
        
            <div class="card-body">
                <table class="table table-bordered data-table" id="dataTable">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Task Name</th>
                            <th>Description</th>
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

    <script>
        $(document).ready(function() {
            $('#dataTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('tasks.index') }}",
                columns: [{
                        data: 'id',
                        name: 'id'
                    },
                    {
                        data: 'name',
                        name: 'name'
                    },
                    {
                        data: 'description',
                        name: 'description'
                    },
                    {
                        data: 'image',
                        name: 'image',
                        render: function(data, type, full, meta) {
                            return "<img src='" + data + "' height='50px' />";
                        }
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false,
                        render: function (data, type, full, meta) {
                        return '<a href="{{ route("tasks.edit", ":id") }}" class="edit btn btn-primary btn-sm mr-2">Edit</a>'.replace(':id', full.id) +
                               '<a href="javascript:void(0)" data-id="' + full.id + '" class="delete btn btn-danger btn-sm deleteTask">Delete</a>';
                    }
                },
                ]
            });

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });


            $('body').on('click', '.deleteTask', function() {
                var id = $(this).data('id');
                    confirm("Are You sure want to delete !");
                $.ajax({
                    type: "DELETE",
                    url: '/delete/task/' + id,
                    data:{_token: "{{ csrf_token() }}"},
                    success: function(data) {
                        $('#dataTable').DataTable().ajax.reload();
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
