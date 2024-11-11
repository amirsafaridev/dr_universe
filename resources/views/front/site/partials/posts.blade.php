@foreach($posts as $post)
    @if($post instanceof \App\Models\Post)
    <div class="post-detail-1 post-detail" id="post_{{$post->id}}" data-p="{{$post->id}}" data-viewed="false">
        <div class="sec1">
            <div class="sec1-1 post_menu" id="post_menu_{{$post->id}}" data-p="{{$post->id}}">
                <a href="#?" class="post-actions-bar" post-id="{{$post->id}}">
                    <svg width="21" height="21" viewBox="0 0 21 21" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <circle cx="11.3714" cy="10.8571" r="1.37143" fill="#2E2E2E"/>
                        <circle cx="11.3714" cy="16.3429" r="1.37143" fill="#2E2E2E"/>
                        <circle cx="11.3714" cy="5.37143" r="1.37143" fill="#2E2E2E"/>
                    </svg>

                </a>
                @if($currentUser->id == $post->user->id )
                    <div class="actions-bar-box" id="actions-bar-box-{{$post->id}}">
                        <a href="{{route("edit_post_page",["id"=>$post->id])}}">
                            <svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" width="15" height="15" viewBox="0 0 30 30">
                                <path d="M24,11l2.414-2.414c0.781-0.781,0.781-2.047,0-2.828l-2.172-2.172c-0.781-0.781-2.047-0.781-2.828,0L19,6L24,11z M17,8	L5.26,19.74c0,0,0.918-0.082,1.26,0.26c0.342,0.342,0.06,2.58,0.48,3s2.644,0.124,2.963,0.443c0.319,0.319,0.297,1.297,0.297,1.297	L22,13L17,8z M4.328,26.944l-0.015-0.007C4.213,26.97,4.111,27,4,27c-0.552,0-1-0.448-1-1c0-0.111,0.03-0.213,0.063-0.313	l-0.007-0.015L4,23l1.5,1.5L7,26L4.328,26.944z"></path>
                            </svg>
                            ویرایش
                        </a>
                        <a href="{{route("delete_post",["id"=>$post->id])}}">
                            <svg xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" width="15" height="15" viewBox="0 0 24 24">
                                <path d="M 10.806641 2 C 10.289641 2 9.7956875 2.2043125 9.4296875 2.5703125 L 9 3 L 4 3 A 1.0001 1.0001 0 1 0 4 5 L 20 5 A 1.0001 1.0001 0 1 0 20 3 L 15 3 L 14.570312 2.5703125 C 14.205312 2.2043125 13.710359 2 13.193359 2 L 10.806641 2 z M 4.3652344 7 L 5.8925781 20.263672 C 6.0245781 21.253672 6.877 22 7.875 22 L 16.123047 22 C 17.121047 22 17.974422 21.254859 18.107422 20.255859 L 19.634766 7 L 4.3652344 7 z"></path>
                            </svg>
                            حذف
                        </a>
                    </div>
                @endif
            </div>
            <div class="sec1-2">
                <a href="{{ route('profile_page', ['username' => $post->user->username]) }}">
                    {!! $post->user->username_with_blue_tick !!}
                </a>
                <img src="{{url('storage/profiles/'.$post->user->profile)}}" alt="">
            </div>
        </div>
        <div class="sec2">
            @if($post->media_type == "photo")
                <img src="{{url('storage/posts/'.$post->media)}}" alt=""/>
            @endif
            @if($post->media_type == "video")
                <video oncontextmenu="return false;" playsinline preload="auto" autoplay  muted disablePictureInPicture id="video-tag-{{$post->id}}" src="{{url('storage/posts/'.$post->media."#t=1")}}">
                    <source data-src="{{url('storage/posts/'.$post->media)}}">
                </video>
                <img src="{{url('assets/img/play.png')}}" class="video-play-icon" style="z-index: 0 !important;">

            @endif
                @if($post->media_type == "video/quicktime")
                    <video oncontextmenu="return false;" playsinline preload="auto" autoplay  muted disablePictureInPicture id="video-tag-{{$post->id}}" src="{{url('storage/posts/'.$post->media."#t=1")}}">

                        <source data-src="{{url('storage/posts/'.$post->media)}}" type="video/quicktime">
                    </video>
                    <img src="{{url('assets/img/play.png')}}" class="video-play-icon" style="z-index: 0 !important;">

                @endif
            @if($post->media_type == "link")
                <video oncontextmenu="return false;" playsinline preload="auto" autoplay  muted disablePictureInPicture id="video-tag-{{$post->id}}" src="{{$post->media}}">
                    <source data-src="{{$post->media}}">
                </video>
                <img src="{{url('assets/img/play.png')}}" class="video-play-icon" style="z-index: 0 !important;">

            @endif
        </div>
        <div class="sec3">
            <div class="sec3-1 save_post" id="post_save_{{$post->id}}" data-p="{{$post->id}}">
                <svg
                    @if(isSavedByUser($post->id))
                        class="saved"
                    @endif
                    width="26" height="26" viewBox="0 0 26 26" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path
                        @if(isSavedByUser($post->id))
                            class="saved"
                        @endif
                        d="M10.5387 7.28205C10.3755 7.28205 10.219 7.34689 10.1036 7.46229C9.98818 7.5777 9.92334 7.73423 9.92334 7.89744C9.92334 8.06065 9.98818 8.21717 10.1036 8.33258C10.219 8.44799 10.3755 8.51282 10.5387 8.51282H15.4618C15.625 8.51282 15.7815 8.44799 15.8969 8.33258C16.0124 8.21717 16.0772 8.06065 16.0772 7.89744C16.0772 7.73423 16.0124 7.5777 15.8969 7.46229C15.7815 7.34689 15.625 7.28205 15.4618 7.28205H10.5387Z"
                        fill="black"/>
                    <path
                        @if(isSavedByUser($post->id))
                            class="saved"
                        @endif
                        fill-rule="evenodd" clip-rule="evenodd"
                        d="M12.9532 4C11.2523 4 9.91241 4 8.86544 4.14195C7.79056 4.288 6.93313 4.59487 6.25949 5.2759C5.58667 5.9561 5.28472 6.8201 5.14031 7.90318C5 8.96082 5 10.3138 5 12.0336V16.2166C5 17.4539 5 18.4328 5.07877 19.1705C5.15672 19.8991 5.32328 20.5563 5.80082 20.9961C6.18318 21.3489 6.66728 21.5705 7.18421 21.6304C7.82995 21.7042 8.43303 21.3957 9.0279 20.9739C9.62933 20.5489 10.3588 19.9032 11.2794 19.0892L11.3089 19.063C11.7356 18.6855 12.0244 18.4312 12.2656 18.2539C12.4987 18.0841 12.6406 18.0226 12.7604 17.9979C12.9186 17.9668 13.0814 17.9668 13.2396 17.9979C13.3594 18.0226 13.5022 18.0841 13.7344 18.2539C13.9756 18.4304 14.2644 18.6855 14.6911 19.063L14.7214 19.0892C15.6412 19.9032 16.3707 20.5489 16.9721 20.9748C17.567 21.3957 18.1701 21.7042 18.8158 21.6304C19.3325 21.5709 19.8169 21.3488 20.1992 20.9961C20.6759 20.5563 20.8433 19.8991 20.9212 19.1705C21 18.4328 21 17.4539 21 16.2166V12.0336C21 10.3138 21 8.96 20.8597 7.90318C20.7153 6.8201 20.4133 5.9561 19.7405 5.2759C19.0669 4.59487 18.2094 4.288 17.1346 4.14195C16.0876 4 14.7477 4 13.0468 4H12.9532ZM7.13333 6.14154C7.54113 5.72964 8.09497 5.48923 9.03036 5.36205C9.98462 5.23241 11.2408 5.23077 12.9992 5.23077C14.7575 5.23077 16.0137 5.23241 16.968 5.36205C17.9034 5.48923 18.4572 5.72964 18.865 6.14154C19.2736 6.55426 19.5124 7.11631 19.6388 8.06564C19.7668 9.03221 19.7684 10.3032 19.7684 12.0804V16.1772C19.7684 17.4622 19.7676 18.3762 19.697 19.0392C19.6232 19.7202 19.4894 19.9754 19.3647 20.0911C19.1727 20.2675 18.9315 20.3783 18.6755 20.407C18.5114 20.4258 18.2373 20.3627 17.6827 19.9705C17.1428 19.5873 16.4626 18.9875 15.5058 18.1407L15.4845 18.1218C15.0841 17.7682 14.7526 17.4753 14.4597 17.2603C14.1536 17.0371 13.8451 16.8648 13.4816 16.7918C13.1632 16.7277 12.8352 16.7277 12.5167 16.7918C12.1532 16.8656 11.8439 17.0371 11.5387 17.2611C11.2457 17.4745 10.9143 17.7682 10.5138 18.1218L10.4925 18.1407C9.5358 18.9875 8.85559 19.5873 8.31569 19.9705C7.76103 20.3627 7.48697 20.4258 7.32287 20.407C7.06544 20.3774 6.82407 20.2668 6.63364 20.0911C6.50892 19.9754 6.37436 19.7202 6.30215 19.0392C6.23077 18.3754 6.22995 17.4622 6.22995 16.1772V12.0796C6.22995 10.3032 6.23159 9.03221 6.35959 8.06564C6.48595 7.11631 6.72472 6.55426 7.13333 6.14154Z"
                        fill="black"/>
                </svg>

            </div>
            <div class="sec3-2">
                <button style="border: none; padding: 0; background: none;"
                        type="button" class="start-conversation-btn" data-bs-toggle="modal"
                        data-bs-target="#userListModal"
                        data-post-link="{{ route('profile_page', ['username' => $post->user->username, 'post_id' => $post->id]) }}"
                        data-media-url="{{ $post->media }}"
                        data-media-type="{{ $post->media_type }}"
                        data-media-id="{{ $post->id }}">
                    <!--<i class="fas fa-send" style="font-size: 20px"></i>-->
                          <img src="{{ asset('img/uil_telegram-alt-1.svg') }}">
                </button>

                <!-- Modal برای لیست کاربران -->
{{--                <div class="modal fade" id="userListModal" tabindex="-1" aria-labelledby="userListModalLabel" aria-hidden="true">--}}
{{--                    <div class="modal-dialog">--}}
{{--                        <div class="modal-content">--}}
{{--                            <div class="modal-header">--}}
{{--                                <h5 class="modal-title" id="userListModalLabel">یک کاربر را برای ارسال پست انتخاب کنید</h5>--}}
{{--                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>--}}
{{--                            </div>--}}
{{--                            <div class="modal-body">--}}
{{--                                <ul class="list-group">--}}
{{--                                    @forelse ($users as $user)--}}
{{--                                        <li class="list-group-item">--}}
{{--                                            <a href="#" class="send-post-link"--}}
{{--                                               data-user-id="{{ $user->id }}">--}}
{{--                                                {{ $user->username }}--}}
{{--                                            </a>--}}
{{--                                        </li>--}}
{{--                                    @empty--}}
{{--                                        <li class="list-group-item">No users found.</li>--}}
{{--                                    @endforelse--}}
{{--                                </ul>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}
                <div style="cursor: pointer;" class="share_post" data-p="{{$post->id}}" id="share_post_{{$post->id}}"  data-share-link="{{route("profile_page",["username"=>$post->user->username,"post_id"=>$post->id]).'#post_'.$post->id}}">
                    <svg width="26" height="26" viewBox="0 0 26 26" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M17.1194 3.70391C17.023 3.61357 16.9024 3.55339 16.7723 3.53076C16.6422 3.50813 16.5083 3.52405 16.3871 3.57655C16.2659 3.62905 16.1627 3.71585 16.0902 3.82625C16.0178 3.93665 15.9792 4.06584 15.9792 4.19791V7.16191C15.7853 7.16624 15.5594 7.17816 15.3075 7.20091C14.476 7.27782 13.3488 7.48582 12.1788 8.01612C9.79442 9.09674 7.34392 11.4687 6.77517 16.4445C6.75968 16.5807 6.7859 16.7184 6.85037 16.8394C6.91484 16.9603 7.01452 17.0589 7.13622 17.122C7.25792 17.1851 7.39591 17.2098 7.53194 17.1928C7.66797 17.1758 7.79563 17.1179 7.89804 17.0267C10.2462 14.9392 12.4464 14.0405 14.0384 13.6581C14.6573 13.5059 15.2898 13.4157 15.9266 13.3889L15.9792 13.3873V16.3854C15.9792 16.5175 16.0178 16.6467 16.0902 16.7571C16.1627 16.8675 16.2659 16.9543 16.3871 17.0068C16.5083 17.0593 16.6422 17.0752 16.7723 17.0526C16.9024 17.0299 17.023 16.9697 17.1194 16.8794L23.6194 10.7857C23.6869 10.7223 23.7408 10.6458 23.7776 10.5608C23.8144 10.4759 23.8334 10.3843 23.8334 10.2917C23.8334 10.1991 23.8144 10.1074 23.7776 10.0225C23.7408 9.9375 23.6869 9.86099 23.6194 9.79766L17.1194 3.70391ZM16.5783 8.52691L16.5891 8.52799H16.5902C16.6842 8.53729 16.7787 8.52679 16.8685 8.49716C16.9582 8.46753 17.0408 8.41943 17.1109 8.35596C17.1809 8.29248 17.2369 8.21504 17.2752 8.12861C17.3135 8.04219 17.3333 7.9487 17.3333 7.85416V5.76062L22.1661 10.2917L17.3333 14.8227V12.7292C17.3333 12.3879 17.0874 12.1008 16.7402 12.0575H16.7386L16.7364 12.057L16.731 12.0564L16.7158 12.0548C16.6419 12.0476 16.5679 12.0421 16.4938 12.0385C16.2891 12.0289 16.0842 12.0278 15.8795 12.0353C15.3563 12.0537 14.6174 12.1274 13.722 12.3419C12.2704 12.6902 10.4184 13.4095 8.42563 14.8622C9.23054 11.5689 11.0598 10.01 12.7373 9.24949C13.7345 8.79774 14.7063 8.61682 15.4321 8.54966C15.7939 8.51607 16.0907 8.51174 16.2939 8.51499C16.3888 8.51643 16.4836 8.5204 16.5783 8.52691ZM6.63542 4.33332C5.73755 4.33332 4.87645 4.69 4.24157 5.32489C3.60668 5.95978 3.25 6.82087 3.25 7.71874V19.3646C3.25 20.2624 3.60668 21.1235 4.24157 21.7584C4.87645 22.3933 5.73755 22.75 6.63542 22.75H18.2813C19.1791 22.75 20.0402 22.3933 20.6751 21.7584C21.31 21.1235 21.6667 20.2624 21.6667 19.3646V18.1458C21.6667 17.9663 21.5953 17.794 21.4684 17.6671C21.3414 17.5401 21.1692 17.4687 20.9896 17.4687C20.81 17.4687 20.6378 17.5401 20.5108 17.6671C20.3838 17.794 20.3125 17.9663 20.3125 18.1458V19.3646C20.3125 19.9033 20.0985 20.42 19.7176 20.8009C19.3366 21.1818 18.82 21.3958 18.2813 21.3958H6.63542C6.0967 21.3958 5.58004 21.1818 5.19911 20.8009C4.81817 20.42 4.60417 19.9033 4.60417 19.3646V7.71874C4.60417 7.18002 4.81817 6.66336 5.19911 6.28243C5.58004 5.9015 6.0967 5.68749 6.63542 5.68749H11.1042C11.2837 5.68749 11.456 5.61616 11.5829 5.48918C11.7099 5.3622 11.7812 5.18998 11.7812 5.01041C11.7812 4.83083 11.7099 4.65862 11.5829 4.53164C11.456 4.40466 11.2837 4.33332 11.1042 4.33332H6.63542Z"
                            fill="black"/>
                    </svg>
                </div>
                <div class="comment_post" data-p="{{$post->id}}" id="comment_post_{{$post->id}}">
                    <svg width="26" height="26" viewBox="0 0 26 26" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M2 6.90625C2 5.87025 2.41155 4.87668 3.14411 4.14411C3.87668 3.41155 4.87025 3 5.90625 3H19.9688C21.0048 3 21.9983 3.41155 22.7309 4.14411C23.4634 4.87668 23.875 5.87025 23.875 6.90625V14.7188C23.875 15.2317 23.774 15.7397 23.5777 16.2136C23.3813 16.6875 23.0936 17.1182 22.7309 17.4809C22.3682 17.8436 21.9375 18.1313 21.4636 18.3277C20.9897 18.524 20.4817 18.625 19.9688 18.625H14.0125L9.22656 22.8125C9.00511 23.0061 8.73259 23.1318 8.44157 23.1746C8.15056 23.2174 7.85338 23.1755 7.58557 23.0539C7.31775 22.9322 7.09063 22.736 6.93137 22.4887C6.77211 22.2414 6.68745 21.9535 6.6875 21.6594V18.625H5.90625C4.87025 18.625 3.87668 18.2134 3.14411 17.4809C2.41155 16.7483 2 15.7548 2 14.7188V6.90625ZM5.90625 4.5625C5.28465 4.5625 4.68851 4.80943 4.24897 5.24897C3.80943 5.68851 3.5625 6.28465 3.5625 6.90625V14.7188C3.5625 15.3404 3.80943 15.9365 4.24897 16.376C4.68851 16.8156 5.28465 17.0625 5.90625 17.0625H8.25V21.5906L13.425 17.0625H19.9688C20.5904 17.0625 21.1865 16.8156 21.626 16.376C22.0656 15.9365 22.3125 15.3404 22.3125 14.7188V6.90625C22.3125 6.28465 22.0656 5.68851 21.626 5.24897C21.1865 4.80943 20.5904 4.5625 19.9688 4.5625H5.90625Z"
                            fill="black"/>
                    </svg>
                </div>
                <div class="like_post" data-p="{{$post->id}}" id="like_post_{{$post->id}}">
                    <svg width="26" height="26" viewBox="0 0 26 26" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path
                            @if(isLikedByUser($post->id))
                                class="liked"
                            @endif
                            d="M13.2266 21.0581L4.55232 13.201C-0.161965 8.4867 6.76803 -0.56473 13.2266 6.75813C19.6852 -0.56473 26.5838 8.51813 21.9009 13.201L13.2266 21.0581Z"
                            stroke="black" stroke-width="1.57143" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </div>
            </div>
        </div>
        <div class="sec4">
            <div class="view-num-main">
                <span id="post_comments_num_{{$post->id}}">{{count($post->comments)}}</span>
                <svg width="18" height="18" viewBox="0 0 25 25" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path
                        d="M2 6.90625C2 5.87025 2.41155 4.87668 3.14411 4.14411C3.87668 3.41155 4.87025 3 5.90625 3H19.9688C21.0048 3 21.9983 3.41155 22.7309 4.14411C23.4634 4.87668 23.875 5.87025 23.875 6.90625V14.7188C23.875 15.2317 23.774 15.7397 23.5777 16.2136C23.3813 16.6875 23.0936 17.1182 22.7309 17.4809C22.3682 17.8436 21.9375 18.1313 21.4636 18.3277C20.9897 18.524 20.4817 18.625 19.9688 18.625H14.0125L9.22656 22.8125C9.00511 23.0061 8.73259 23.1318 8.44157 23.1746C8.15056 23.2174 7.85338 23.1755 7.58557 23.0539C7.31775 22.9322 7.09063 22.736 6.93137 22.4887C6.77211 22.2414 6.68745 21.9535 6.6875 21.6594V18.625H5.90625C4.87025 18.625 3.87668 18.2134 3.14411 17.4809C2.41155 16.7483 2 15.7548 2 14.7188V6.90625ZM5.90625 4.5625C5.28465 4.5625 4.68851 4.80943 4.24897 5.24897C3.80943 5.68851 3.5625 6.28465 3.5625 6.90625V14.7188C3.5625 15.3404 3.80943 15.9365 4.24897 16.376C4.68851 16.8156 5.28465 17.0625 5.90625 17.0625H8.25V21.5906L13.425 17.0625H19.9688C20.5904 17.0625 21.1865 16.8156 21.626 16.376C22.0656 15.9365 22.3125 15.3404 22.3125 14.7188V6.90625C22.3125 6.28465 22.0656 5.68851 21.626 5.24897C21.1865 4.80943 20.5904 4.5625 19.9688 4.5625H5.90625Z"
                        fill="#949494"></path>
                </svg>
            </div>
            <div class="h-divider"></div>
            <div class="view-num-main">
                <span id="post_view_num_{{$post->id}}">{{$post->views}}</span>
                <svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd" clip-rule="evenodd"
                          d="M9.08413 6.24526C8.33124 6.24526 7.60919 6.54434 7.07682 7.07671C6.54444 7.60908 6.24536 8.33114 6.24536 9.08402C6.24536 9.83691 6.54444 10.559 7.07682 11.0913C7.60919 11.6237 8.33124 11.9228 9.08413 11.9228C9.83701 11.9228 10.5591 11.6237 11.0914 11.0913C11.6238 10.559 11.9229 9.83691 11.9229 9.08402C11.9229 8.33114 11.6238 7.60908 11.0914 7.07671C10.5591 6.54434 9.83701 6.24526 9.08413 6.24526ZM7.38087 9.08402C7.38087 8.63229 7.56032 8.19906 7.87974 7.87964C8.19916 7.56021 8.63239 7.38076 9.08413 7.38076C9.53586 7.38076 9.96909 7.56021 10.2885 7.87964C10.6079 8.19906 10.7874 8.63229 10.7874 9.08402C10.7874 9.53576 10.6079 9.96899 10.2885 10.2884C9.96909 10.6078 9.53586 10.7873 9.08413 10.7873C8.63239 10.7873 8.19916 10.6078 7.87974 10.2884C7.56032 9.96899 7.38087 9.53576 7.38087 9.08402Z"
                          fill="#949494"/>
                    <path fill-rule="evenodd" clip-rule="evenodd"
                          d="M9.08408 2.46025C5.66697 2.46025 3.36492 4.50719 2.0288 6.243L2.00534 6.27403C1.70254 6.66692 1.42472 7.02801 1.23622 7.45496C1.0341 7.91295 0.946289 8.41181 0.946289 9.08403C0.946289 9.75625 1.0341 10.2551 1.23622 10.7131C1.42547 11.1401 1.70329 11.5019 2.00534 11.894L2.02956 11.9251C3.36492 13.6609 5.66697 15.7078 9.08408 15.7078C12.5012 15.7078 14.8032 13.6609 16.1394 11.9251L16.1628 11.894C16.4656 11.5019 16.7434 11.1401 16.9319 10.7131C17.1341 10.2551 17.2219 9.75625 17.2219 9.08403C17.2219 8.41181 17.1341 7.91295 16.9319 7.45496C16.7427 7.02801 16.4649 6.66692 16.1628 6.27403L16.1386 6.243C14.8032 4.50719 12.5012 2.46025 9.08408 2.46025ZM2.92964 6.93565C4.16204 5.33308 6.16962 3.59575 9.08408 3.59575C11.9985 3.59575 14.0054 5.33308 15.2385 6.93565C15.5716 7.36715 15.7654 7.62453 15.8933 7.9137C16.0129 8.18471 16.0864 8.51552 16.0864 9.08403C16.0864 9.65254 16.0129 9.98335 15.8933 10.2544C15.7654 10.5435 15.5708 10.8009 15.2393 11.2324C14.0046 12.835 11.9985 14.5723 9.08408 14.5723C6.16962 14.5723 4.1628 12.835 2.92964 11.2324C2.59656 10.8009 2.40276 10.5435 2.27483 10.2544C2.15522 9.98335 2.08179 9.65254 2.08179 9.08403C2.08179 8.51552 2.15522 8.18471 2.27483 7.9137C2.40276 7.62453 2.59807 7.36715 2.92964 6.93565Z"
                          fill="#949494"/>
                </svg>
            </div>
            <div class="h-divider"></div>
            <div class="like-num-main">
                <span id="post_like_num_{{$post->id}}">{{count($post->likes)}}</span>
                <svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path
                        d="M9.23888 15.0746L3.09881 9.5129C-0.23819 6.1759 4.6672 -0.231134 9.23888 4.95233C13.8106 -0.231134 18.6937 6.19815 15.379 9.5129L9.23888 15.0746Z"
                        stroke="#949494" stroke-width="1.11233" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
            </div>
        </div>
        <div class="container_post">
                <?php
                $desc = managePostDescHashtagsAndMentions($post->desc)
                ?>
            <div class="text @if(strlen($desc) > 200) vertical_ellipsis_text_3line @endif"
                 id="post_text_{{$post->id}}">
                    <?php

                    echo $desc;
                    ?>
            </div>
                <?php
                if (strlen($desc) > 201) {
                    echo '<span data-p="' . $post->id . '" id="post_text_expander_' . $post->id . '" class="text-primary small mx-1 post_text_expander">بیشتر</span>';
                }
                ?>
        </div>
        @if(count($post->comments) > 2)
            <div class="see-all-comment" data-p="{{$post->id}}">
                <div>
                    <span>مشاهده {{count($post->comments)}} کامنت</span>
                </div>
            </div>
        @endif

        <div class="comment-main" @if($post->comments->count() == 0) style="display: none;" @endif>
            @foreach($post->two_comments as $comment)
                @if($loop->index == 2)
                    @break
                @endif
                    <?php
                    $text = managePostDescHashtagsAndMentions($comment->text);
                    ?>

                <div class="comment-1 comment">
                    <img class="profile" src="{{url('storage/profiles/'.$comment->user->profile)}}" alt="">
                    <span class="comment_username">{{$comment->user->username}}</span>
                    <div class="the_comment_text">{{$comment->text}}</div>
                </div>
            @endforeach
        </div>
        <div class="divider"></div>
    </div>
    @elseif($post instanceof \App\Models\Advert)
        <div class="advertisement">
            <img  src="{{ url('storage/'. $post->media_path) }}" alt="Advertisement Image" style="    max-width: 100%;
    height: auto;
    width: 100%;
    object-fit: cover;
    margin: 0px 0 30px 0;">
        </div>
    @endif
@endforeach




