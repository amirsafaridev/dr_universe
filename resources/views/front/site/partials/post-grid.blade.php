
@foreach($posts as $post)
    @if($post->media_type == "photo")
        <a href="{{route("profile_page",["username"=>$post->user->username,"post_id"=>$post->id]).'#post_'.$post->id}}" class="post-img"><img src="{{url('storage/posts/'.$post->media)}}" alt=""></a>
    @endif
    @if($post->media_type == "video")
        <a href="{{route("profile_page",["username"=>$post->user->username,"post_id"=>$post->id]).'#post_'.$post->id}}" class="post-img">
            <video class="user_posts_video" preload="auto"  disablePictureInPicture src="{{url('storage/posts/'.$post->media."#t=1")}}"
                   style="">
                <source data-src="{{url('storage/posts/'.$post->media)}}">
            </video>
            <img src="{{url('assets/img/play.png')}}" class="video-play-icon-grid">

        </a>
    @endif
@endforeach

