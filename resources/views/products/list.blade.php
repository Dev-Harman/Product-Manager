<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>LARAVEL PROJECT</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>

<body>
    <div class="bg-dark">
        <h1 class="text-white py-4 text-center">Laravel Project</h1>
    </div>
    {{-- button class --}}
    <div class="container">
        <div class="row justify-content-center mt-4">
            <div class="col-md-10 d-flex justify-content-end">
                <a href="{{ route('products.create') }}" class="btn btn-dark">Create</a>

            </div>
        </div>
        {{-- bootstrap success class --}}
        <div class="row d-flex justify-content-center">
            @if (Session::has('success'))
            <div class="col-md-10">
                <div class="alert alert-success my-2">
                    {{ Session::get('success') }}
                </div>
                @endif
                <div class="col-md-10">
                </div>
                {{-- table start for dashboard --}}
                <div class="col-md-10">
                    <div class="card border-0 shadow-lg my-3">
                        <div class="card-header bg-dark">
                            <h3 class="text-white">Products</h3>

                        </div>
                        <div class="card-body">
                            {{-- heading --}}
                            <table class="table">
                                <tr>
                                    <th>ID</th>
                                    <th>Image</th>
                                    <th>Name</th>
                                    <th>Size</th>
                                    <th>Price</th>
                                    <th>Created at</th>
                                    <th>Action</th>
                                </tr>
                                {{-- end heading --}}
                                @if ($products->isNotEmpty())
                                @foreach ($products as $product)
                                <tr>
                                    <td>{{ $product->id }}</td>
                                    <td>
                                        @if ($product->image != '')
                                        <img width="50" src="{{ asset('uploads/products/' . $product->image) }}" alt>
                                        @endif
                                    </td>
                                    <td>{{ $product->name }}</td>
                                    <td>{{ $product->sku }}</td>
                                    <td>RS- {{ $product->price }}</td>
                                    <td>{{
                                        \Carbon\Carbon::parse($product->created_at)->format('d M, Y')
                                        }}</td>
                                    <td>
                                        <a href="{{ route('products.edit', $product->id) }}"
                                            class="btn btn-dark m-2">Edit</a>
                                        <a href="#" onclick="deleteProduct({{ $product->id }});"
                                            class="btn btn-danger m-2">Delete</a>
                                        {{-- form start --}}
                                        <form id="delete-product-form-{{ $product->id }}"
                                            action="{{ route('products.destroy', $product->id) }}" method="post">
                                            @csrf
                                            @method('delete')
                                        </form>
                                        {{-- form end --}}
                                    </td>
                                </tr>
                                @endforeach
                                @endif
                            </table>
                            {{-- table end --}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
            </script>
</body>

</html>
{{-- javascript class call onclick function in delete button --}}
<script>
    function deleteProduct(id) {
        if (confirm("ARE YOU SURE TO DELETE PRODUCT ????????????????????????????????")) {
            document.getElementById("delete-product-form-" + id).submit();
        }
    }
</script>