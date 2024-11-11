@extends('front.site.layout')
@section("content")

    <script src="https://cdn.jsdelivr.net/npm/heic2any@latest/dist/heic2any.min.js"></script>

    @if(session()->has('success'))
        <div class="alert alert-success" role="alert">
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-hidden="true">×</button>
            <i class="fa fa-check-circle-o me-2" aria-hidden="true"></i>
            {{session()->get("success")}}
        </div>
    @endif
    @if(isset($post))
        <form style="margin-top: 15px;" class="newpost-page" id="edit_from" method="post" action="{{route('edit_post')}}" enctype="multipart/form-data">
            @csrf
            {{--<input class="upload-file" type="file" id="filenameedit" name="filename" style="display: none;">
            <label for="filenameedit">
                <img class="upload-img" src="{{url('storage/posts/'.$post->media)}}" alt="">
            </label>--}}
            <input type="hidden" name="post_id" value="{{$post->id}}">

            <div id="ready_to_upload" style="display: none;font-size: 14px;text-align: center;color: #a52834;font-weight: bold;margin-top: 15px;"></div>
            @php $desc = $post->desc; @endphp
            <textarea name="caption" id="caption-addnew-post" cols="30" rows="8" placeholder="توضیحات...">
            {{$desc}}
        </textarea>

            <ul id="new_post_alert" class="alert alert-danger" style="font-size: 14px;list-style-type: none;display: none;margin-top: 10px;">

            </ul>

            <button class="publish-button" type="submit" >
                <svg width="20" height="20" viewBox="0 0 23 23" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path opacity="0.5" d="M16.2915 8.62691C18.3759 8.63841 19.5048 8.73137 20.2408 9.46737C21.0832 10.3097 21.0832 11.6648 21.0832 14.375V15.3333C21.0832 18.0445 21.0832 19.3995 20.2408 20.2419C19.3994 21.0833 18.0433 21.0833 15.3332 21.0833H7.6665C4.95634 21.0833 3.6003 21.0833 2.75888 20.2419C1.9165 19.3986 1.9165 18.0445 1.9165 15.3333V14.375C1.9165 11.6648 1.9165 10.3097 2.75888 9.46737C3.49488 8.73137 4.6238 8.63841 6.70817 8.62691" stroke="white" stroke-width="1.4375" stroke-linecap="round"/>
                    <path d="M11.5 14.375V1.91666M11.5 1.91666L14.375 5.27083M11.5 1.91666L8.625 5.27083" stroke="white" stroke-width="1.4375" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
                <span>انتشار</span>
            </button>
        </form>
    @else
        <form style="margin-top: 15px;" class="newpost-page" id="upload-form" method="post" action="#?" enctype="multipart/form-data">
            <input type="hidden" name="_csrf_token" value="{{ csrf_token() }}">
            <input class="upload-file" type="file" id="filename" name="filename" style="display: none;">
            <label for="filename">
                <img class="upload-img"  src="./svg/upload.png" alt="">
            </label>
            <div class="progress progress-bar-info progress-bar-striped active" style="display:none">
                <div class="progress-bar" role="progressbar" aria-valuenow="0"
                     aria-valuemin="0" aria-valuemax="100" style="width:0%">
                    0%
                </div>
            </div>

            <div id="ready_to_upload" style="display: none;font-size: 14px;text-align: center;color: rgba(35,199,0,0.93);font-weight: bold;margin-top: 15px;"></div>
        </form>


        <form style="margin-top: 15px;" class="newpost-page" id="upload-form" method="post" action="{{route('new_post')}}" enctype="multipart/form-data" >
            @csrf
            <input type="hidden" name="media_file_name">
            <input type="hidden" name="media_file_type">
            <input type="hidden" name="storage_url" value="{{url('storage/posts/')}}">
            <input type="hidden" name="UplodePostMedia" value="{{route("UplodePostMedia")}}">

            <textarea name="caption" id="caption-addnew-post" cols="30" rows="8" placeholder="توضیحات..."></textarea>

            <ul id="new_post_alert" class="alert alert-danger" style="font-size: 14px;list-style-type: none;display: none;margin-top: 10px;">

            </ul>

            <button class="publish-button" type="submit" disabled="disabled" style="opacity:0.4">
                <svg width="20" height="20" viewBox="0 0 23 23" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path opacity="0.5" d="M16.2915 8.62691C18.3759 8.63841 19.5048 8.73137 20.2408 9.46737C21.0832 10.3097 21.0832 11.6648 21.0832 14.375V15.3333C21.0832 18.0445 21.0832 19.3995 20.2408 20.2419C19.3994 21.0833 18.0433 21.0833 15.3332 21.0833H7.6665C4.95634 21.0833 3.6003 21.0833 2.75888 20.2419C1.9165 19.3986 1.9165 18.0445 1.9165 15.3333V14.375C1.9165 11.6648 1.9165 10.3097 2.75888 9.46737C3.49488 8.73137 4.6238 8.63841 6.70817 8.62691" stroke="white" stroke-width="1.4375" stroke-linecap="round"/>
                    <path d="M11.5 14.375V1.91666M11.5 1.91666L14.375 5.27083M11.5 1.91666L8.625 5.27083" stroke="white" stroke-width="1.4375" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
                <span>انتشار</span>
            </button>
        </form>
    @endif
    <div id="progress-container">
        <div id="progress-bar"></div>
    </div>
    <div id="response"></div>

@endsection
