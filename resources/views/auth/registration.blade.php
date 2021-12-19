<!DOCTYPE html>
<html>

<head>
    <title>KanhaSoft</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <style>
    .show-multiple-image-preview img {
        padding: 6px;
        max-width: 100px;
    }
    </style>
</head>

<body>
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <h2 class="text-center">Registration Form</h2>
                <div class="text-center">
                    <form id="registration-form" action="{{ route('store') }}" method="POST" 
                        enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <input type="text" class="form-control" id="name" placeholder="Full Name" required
                                        name="name">
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="form-group">
                                    <input type="email" class="form-control" id="email" placeholder="Email" required
                                        name="email">
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="form-group">
                                    <input type="password" id="password" placeholder="Password" class="form-control"
                                        name="password" required>
                                    @if ($errors->has('password'))
                                    <span class="text-danger">{{ $errors->first('password') }}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="table-responsive">  
                            <table class="table table-bordered" id="dynamic_field">
                                <tr>
                                    <td><input type="file" name="image[0][subject]" accept="image/x-png, image/jpeg"
                                            class="form-control name_list" /></td>
                                    <td><button type="button" name="add" id="add" class="btn btn-success">Add
                                            More</button></td>
                                </tr>

                            </table>
                            </table>



                            <div class="col-md-12">
                                <button type="submit" class="btn btn-primary" id="submit">Submit</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
<script type="text/javascript">
    $(document).ready(function(e) {
        var i = 1;
        $('#add').click(function() {
            i++;
            $('#dynamic_field').append('<tr id="row' + i +
                '" class="dynamic-added"><td><input type="file" name="image['+i+'][subject]" accept="image/x-png, image/jpeg" class="form-control name_list" /></td><td><button type="button" name="remove" id="' +
                i + '" class="btn btn-danger btn_remove">X</button></td></tr>');
        });


        $(document).on('click', '.btn_remove', function() {
            var button_id = $(this).attr("id");
            $('#row' + button_id + '').remove();
        });
    });
    </script>