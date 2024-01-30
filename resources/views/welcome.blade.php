<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Noass Posts</title>
        <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
        <script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>
        <script src="{{ asset('public/js/app.js') }}" defer></script>
    </head>
    <style>

        @font-face {
            font-family: Roboto-Bold;
            src: url('/fonts/Roboto-Bold.ttf');
        }

        button {
            font-family: Roboto-Bold;
			color: #ffffff;
			background-color: #2d63c8;
			font-size: 14px;
			border: 0px solid #000000;
			padding: 10px 12px;
			cursor: pointer
		}
		button:hover {
			color: #2d63c8;
			background-color: #ffffff;
		}

        button.delete {
            font-family: Roboto-Bold;
			color: #ffffff;
			background-color: rgb(219, 70, 70);
			font-size: 14px;
			border: 0px solid #000000;
			padding: 10px 12px;
			cursor: pointer
		}
		button.delete:hover {
			color: rgb(219, 70, 70);
			background-color: #ffffff;
		}

        body{
            background-color: rgb(223, 221, 255);
        }

        div.box {
            word-wrap: break-word;
            text-align:left;
        }

        .center{
            margin: auto;
            text-align: center;
            min-width:343px;
            width: 50%;
        }

        img.post {
            min-width:290px;
            width: 35%;
            height: 35%; 
            object-fit: contain;
        }

        p{
            font-size: 18px;
            line-height: 20px
        }

        .videoInsert {
            min-width:290px;
            width: 70%;
            height: 70%; 
            object-fit: contain;
        }

        footer{
            margin: auto;
            bottom: 0;
            width: 95%;
            text-align: center;
            padding: 5px;
            color: #000;
            min-height:50px;
        }

    </style>
    <body style="font-family: Roboto-Bold;">
           
        <div class="center">
        @auth
            <p>You are logged in as <span style="color:CornflowerBlue;"><u>{{ auth()->user()->name }}</u></span>.</p>
            <form action="/logout" method="post">
                @csrf
                <button style="margin-bottom:2%;">Log out</button>
            </form>

            <div style="border: 3px solid black;">
                <h2>Write a new post</h2>
                <form action="/create-post" method="post" enctype="multipart/form-data">
                    @csrf
                    <input style="margin-bottom:1%;" type="text" name="title" placeholder="Post title" maxlength="255"></br>
                    <textarea name="body" placeholder="Post content..." cols="40" rows="8" maxlength="255"></textarea></br>
                    <label for="image">Image/Video: </label>
                    <input type="file" name="image" accept="video/mp4, video/ogg, video/webm, image/png, image/jpeg, image/jpg, image/bmp, image/tiff"></br>
                    <button style="margin:1%;">Create post</button>
                </form>
            </div>

            <div style="border: 3px solid black; margin-top:10% ">
                <h2>All posts</h2>
                @foreach ($posts as $post)
                    <div class="box" style="background-color:Thistle; padding:10px; margin:10px; border: 3px double black; overflow:hidden; zoom:1;">
                        <h2>{{ $post['title'] }} <span style="color: grey">(by: {{$post->user->name}})</span></h2>
                        <p>{{ $post['body'] }}</p>
                        @if($post->image !== null)
                            <?php
                                $extension = pathinfo('uploads/users/'.$post->image, PATHINFO_EXTENSION);
                                $imageExtensions = ['jpg', 'jpeg', 'png', 'bmp', 'tiff'];
                                $videoExtensions = ['mp4', 'ogg', 'webm'];
                        
                                if (in_array($extension, $imageExtensions)) {
                                    echo '<img class="post" src="' . asset('uploads/users/' . $post->image) . '" alt=""><br>';
                                } elseif (in_array($extension, $videoExtensions)) {
                                    echo '<video controls class="videoInsert">
                                            <source src="' . asset('uploads/users/' . $post->image) . '">
                                                Your browser does not support HTML5 video.
                                        </video>';
                                }
                            ?>
                        @endif
                        <div>
                            <a href="#" class="like"><img type="image" src="public/assets/thumb.png" style="min-width:20px; width: 2%; height: 2%; object-fit: contain;"  alt=""></a> {{ $post['likes'] }}
                            <a href="#" class="dislike"><img type="image" src="public/assets/thumb.png" style="transform: scaleY(-1); min-width:20px; width: 2%; height: 2%; object-fit: contain;" alt=""></a> {{ $post['dislikes'] }}   
                        </div>
                        @if (auth()->user()->id == $post['user_id'])
                            <p style="text-align: right;"><a href="/edit-post/{{$post->id}}">Edit</a></p>
                            <form action="/delete-post/{{$post->id}}" method="post">
                                @csrf
                                @method('DELETE')
                                <button class="delete" style="float: right;" onclick="return confirm('Are you sure you want to delete this post?')">Delete</button>
                            </form>
                        @endif
                        <br><p style="color:rgb(142, 133, 202);  float: left;">{{ $post['created_at'] }}</p>
                    </div>
                @endforeach
            </div>
            </div>
            <footer>
                <p><a href="">noass.sbs</a> | Noass Posts | noass</p>
                <p><a href="#">^ Back to top ^</a></p>
            </footer>
        </div>
        @else
        <h1 class="center"><u>Noass Posts</u></h1>
        <div class="center" style="margin-top: 40%">
            <div style="border: 3px double black;">
                <h2 style="margin: 1%">Register</h2>
                <form action="/register" method="post">
                    @csrf
                    <input name="name" type="text" placeholder="Username" >
                    <input name="email" type="text" placeholder="E-mail">
                    <input name="password" type="password" placeholder="Password"></br>
                    <button style="margin: 1%">Register</button>
                </form>
            </div>
            <div style="border: 3px double black; margin-top:10%">
                <h2 style="margin: 1%">Log in</h2>
                <form action="/login" method="post">
                    @csrf
                    <input name="loginName" type="text" placeholder="Username">
                    <input name="loginPassword" type="password" placeholder="Password"></br>
                    <button style="margin: 1%">Log in</button>
                </form>
            </div>
            
        </div>
        <footer>
            <p><a href="">noass.sbs</a> | Noass Posts | noass</p>
        </footer>
        @endauth
        <script>
            var token = '{{ Session::token() }}';
            var urlLike = '{{ route('like') }}';
            var urlDislike = '{{ route('dislike') }}';
        </script>
    </body>
</html>
