<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Edit post</title>
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

        img {
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

</style>

<body style="font-family: Roboto-Bold;">
    <div class="center">
        <h1>Edit post</h1>
        <form action="/edit-post/{{$post->id}}" method="post" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <input  style="margin-bottom:1%;" type="text" name="title" placeholder="Post title" maxlength="255" value="{{$post->title}}"><br>
            <textarea name="body" placeholder="Post content..." cols="40" rows="8" maxlength="255">{{$post->body}}</textarea><br>
            @if($post->image !== null)
                <?php
                    $extension = pathinfo('uploads/users/'.$post->image, PATHINFO_EXTENSION);
                    $imageExtensions = ['jpg', 'jpeg', 'png', 'bmp', 'tiff'];
                    $videoExtensions = ['mp4', 'ogg', 'webm'];
            
                    if (in_array($extension, $imageExtensions)) {
                        echo '<img src="' . asset('uploads/users/' . $post->image) . '" alt="Current image"><br>';
                    } elseif (in_array($extension, $videoExtensions)) {
                        echo '<video controls class="videoInsert">
                                <source src="' . asset('uploads/users/' . $post->image) . '" alt="Current video">
                                Your browser does not support HTML5 video.
                            </video><br>';
                    }
                ?>
            @endif
            <label for="image">Image/video: </label>
            <input type="file" name="image" accept="video/mp4, video/ogg, video/webm, image/png, image/jpeg, image/jpg, image/bmp, image/tiff"></br>
            <button style="margin-top:1%;">Save changes</button>
        </form>
            <button style="margin-top: 1%" onclick="history.back()">Back</button>
        
    </div>
</body>
</html>
