<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Facebook</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css"
          integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx"
            crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"
            integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
    @yield('styles')
    <link rel="stylesheet" href="{{asset('global.css')}}">
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css"
          integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous"/>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <meta name="meta_data" data-token="{{csrf_token()}}" data-user="{{auth()->check() ? auth()->id() : 0}}">
    <style>
        .redHeart {
            color : #3b5998;
        }
        .pressLove{
            font-size :25px;
        }
    </style>
</head>
<body style="background-color:white;">
@include('layout.nav')
@yield('content')
<script src="https://js.pusher.com/7.0/pusher.min.js"></script>
<script>
    var meta_data = $('meta[name="meta_data"]');
    var pusher = new Pusher('204da9bbd42c2bf9ee83', {
        cluster: 'mt1'
    });
    var channel = pusher.subscribe('blog');
    channel.bind('post', function(data) {
        var elem = $('.posts');
        if(meta_data.data('user') == data.user_id || elem.hasAttribute('page'))
            elem.prepend(data.data);


        toastr.success('New Post');
    });
    channel.bind('comment', function(data) {
        $('.posts').find(`[data-post=${data.post_id}]`).find('.comments').prepend(data.html);
        if(data.user_id == meta_data.data('user')){
            toastr.success('You Have a New Comment');
        }
    });
    channel.bind('likes', function(data) {
        $('.posts').find(`[data-post=${data.post_id}]`).find('.pressLove').text(data.count);

    });

</script>
@yield('scripts')
@stack('scripts')

<script>
    $('.postComment').click(function () {
        var text = $(this).parents('.form-group').find('textarea').val();
        var post_id = $(this).parents('.form-group').data('id');
        if (text == ''){
            return;
        }
        $.ajax({
            url : 'comment',
            method : 'post',
            data : {_token : meta_data.data('token'),text,post_id},
            success : function (data) {

            }
        });
    });

    $('.pressLove').click(function () {
        if(meta_data.data('user') == 0){
            toastr.error('Login First');
            return;
        }
        var elem = $(this).parents('.card');
        var data = {};
        data.post_id = elem.data('post');
        $.ajax({
            url : 'like',
            data,
            success : function (data) {
                elem.find('.pressLove').text(data.likes);
                if(elem.find('.pressLove').hasClass('redHeart')){
                    elem.find('.pressLove').removeClass('redHeart');
                }else{
                    elem.find('.pressLove').addClass('redHeart');
                }
            }
        });

    });
</script>
</body>
</html>
