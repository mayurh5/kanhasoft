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
                <h2 class="text-center">Dashboard</h2>
                <div class="text-center">

                    <label>Select User </label>
                    <select class="form-control" id="user" name="get_user">
                        @if(!empty($get_user))
                        @foreach($get_user as $c_key => $user)
                        @php
                        echo '
                        <option value="'.$user['id'].'">'.$user['name'].'</option>
                        ';
                        @endphp
                        @endforeach
                        @endif
                    </select>
                </div>
            </div>
        </div>
        <br>
        <div class="row">
            <div class="col-md-3">
                <div class="card-group">
                    <div class="img" id="img-container"></div>
                </div>
            </div>
        </div>
    

</body>

</html>

<script>

$('body').on("change", "#user",function(e){
    e.preventDefault();
    filter();
});

function filter(){

var formData = new FormData();
formData.append('id' , $("#user option:selected").val());

$.ajax({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    },
    type:'POST',
    url:"image",
    data:formData,
    processData: false,
    contentType: false,
    success: function(response) {
        console.log(response);
        var html = '';
        if(response.success == '1'){
            all_images_data=response.data;
            $('#img-container').html('');
            if(response.data.length > 0){
                response.data.forEach(element => {
                //   html +=   '<img src=" '+(element.image_name == null  ? '/no-image.svg' : '/images/'+element.image_name+'')+' " data-id='+element.id+' class="image_popup" style= "height:150px; width:100%; object-fit:cover;">';
             
                html += '<div class="card">';
                html += '<img src="'+(element.image_name == null  ? '/no-image.svg' : '/images/'+element.image_name+'')+'" class="card-img-top" alt="...">';
                html += '  </div>';
                });
                $('#img-container').append(html);
            }
            else{
                var html = '';
                html +=  '<p class="text-bold-1000"> <b>No data found.</b>  </p>';
               
                $('#img-container').append(html);
               
            }
        }
    },
    error:function(jqXHR, textStatus, ex){ 
       
    console.log(jqXHR.responseText);
       
    }
});
}

filter();
</script>