<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Form</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</head>

<body>

    <div class="container">

        <form action="{{route('test')}}" method="post" class="form">
            @csrf

            <div class="form-group">
                <label for="name">Name</label>
                <input required type="text" name="name" id="name" class="form-control">
            </div>

            <div class="form-group">
                <label for="item">item</label>
                <input required type="item" name="item" id="item" class="form-control">
            </div>

            <div class="form-group">
                <label for="price">price</label>
                <input required type="price" name="price" id="price" class="form-control">
            </div>

            <!-- bootstrap dropdown -->
            <div class="form-group">
                <label for="category">Category</label>
                <select required name="category" id="category" class="form-control">
                    <option value="1" selected>Veg</option>
                    <option value="0">Non Veg</option>
                </select>
            </div>

            <!-- Submit Button -->
            <div class="form-group mt-3">
                <button type="submit" class="btn btn-primary">Submit</button>
            </div>

        </form>

    </div>

</body>

</html>
