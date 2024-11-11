@auth

        <footer>
            <div class="footer-item">
                <div class="my-account-icons">
{{--                    @if (Auth::check() && Auth::id() === $user->id)--}}
{{--                        <div class="setting-btn">--}}
{{--                            <a href="{{ route('settings') }}" class="settings-btn">--}}
{{--                                      <img src="{{ asset('img/gear-svgrepo-com-1.svg') }}">--}}
{{--                                <!--<i class="fa fa-cog" style="font-size: 24px;"></i> <!-- استفاده از آیکون "تنظیمات" -->--}}
{{--                            </a>--}}
{{--                        </div>--}}
{{--                    @endif--}}
                    <div class="user-icon footer-icon">
                        <a href="{{route('profile_page')}}">
                            <svg width="31" height="31" viewBox="0 0 31 31" fill="none"
                                 xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M16 14C18.2091 14 20 12.2091 20 10C20 7.79086 18.2091 6 16 6C13.7909 6 12 7.79086 12 10C12 12.2091 13.7909 14 16 14Z"
                                    stroke="black" stroke-width="1.5"/>
                                <path
                                    d="M24 21.5C24 23.985 24 26 16 26C8 26 8 23.985 8 21.5C8 19.015 11.582 17 16 17C20.418 17 24 19.015 24 21.5Z"
                                    stroke="black" stroke-width="1.5"/>
                            </svg>
                        </a>
                    </div>

                    <div class="heart-icon footer-icon" style="display:block;">
                        <a href="{{route('notif_page')}}">

                            <svg width="31" height="31" viewBox="0 0 31 31" fill="none"
                                 xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M16.2266 24.0581L7.55232 16.201C2.83804 11.4867 9.76803 2.43527 16.2266 9.75813C22.6852 2.43527 29.5837 11.5181 24.9009 16.201L16.2266 24.0581Z"
                                    stroke="black" stroke-width="1.57143" stroke-linecap="round"
                                    stroke-linejoin="round"/>
                            </svg>
                        </a>
                    </div>

                    <div class="add-new-icon footer-icon">
                        <a href="{{route('new_post_page')}}">
                            <svg width="31" height="31" viewBox="0 0 31 31" fill="none"
                                 xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M15.5 3.14844C13.0571 3.14844 10.669 3.87284 8.63784 5.23005C6.60664 6.58726 5.02351 8.51631 4.08865 10.7733C3.15379 13.0302 2.90919 15.5137 3.38577 17.9097C3.86236 20.3056 5.03873 22.5065 6.76613 24.2339C8.49353 25.9613 10.6944 27.1376 13.0903 27.6142C15.4863 28.0908 17.9698 27.8462 20.2267 26.9114C22.4837 25.9765 24.4127 24.3934 25.77 22.3622C27.1272 20.331 27.8516 17.9429 27.8516 15.5C27.8477 12.2253 26.5452 9.08591 24.2296 6.77037C21.9141 4.45484 18.7747 3.15228 15.5 3.14844ZM15.5 26.3984C13.3445 26.3984 11.2374 25.7593 9.44516 24.5617C7.65292 23.3642 6.25604 21.6621 5.43116 19.6707C4.60629 17.6792 4.39046 15.4879 4.81098 13.3738C5.2315 11.2597 6.26947 9.31781 7.79365 7.79364C9.31782 6.26947 11.2597 5.23149 13.3738 4.81097C15.4879 4.39045 17.6792 4.60628 19.6707 5.43116C21.6621 6.25603 23.3642 7.65291 24.5617 9.44515C25.7593 11.2374 26.3984 13.3445 26.3984 15.5C26.3952 18.3895 25.246 21.1597 23.2028 23.2028C21.1597 25.246 18.3895 26.3952 15.5 26.3984ZM21.0703 15.5C21.0703 15.6927 20.9938 15.8775 20.8575 16.0138C20.7213 16.15 20.5365 16.2266 20.3438 16.2266H16.2266V20.3438C16.2266 20.5364 16.15 20.7213 16.0138 20.8575C15.8775 20.9938 15.6927 21.0703 15.5 21.0703C15.3073 21.0703 15.1225 20.9938 14.9862 20.8575C14.85 20.7213 14.7734 20.5364 14.7734 20.3438V16.2266H10.6563C10.4636 16.2266 10.2788 16.15 10.1425 16.0138C10.0062 15.8775 9.92969 15.6927 9.92969 15.5C9.92969 15.3073 10.0062 15.1225 10.1425 14.9862C10.2788 14.85 10.4636 14.7734 10.6563 14.7734H14.7734V10.6562C14.7734 10.4636 14.85 10.2787 14.9862 10.1425C15.1225 10.0062 15.3073 9.92969 15.5 9.92969C15.6927 9.92969 15.8775 10.0062 16.0138 10.1425C16.15 10.2787 16.2266 10.4636 16.2266 10.6562V14.7734H20.3438C20.5365 14.7734 20.7213 14.85 20.8575 14.9862C20.9938 15.1225 21.0703 15.3073 21.0703 15.5Z"
                                    fill="black"/>
                            </svg>
                        </a>
                    </div>




                    <div class="search-icon footer-icon" style="display:block;">
                        <a href="{{ route('search_page') }}">
                            <svg width="31" height="31" viewBox="0 0 31 31" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M14.3557 21.7114C18.4182 21.7114 21.7114 18.4182 21.7114 14.3557C21.7114 10.2933 18.4182 7 14.3557 7C10.2933 7 7 10.2933 7 14.3557C7 18.4182 10.2933 21.7114 14.3557 21.7114Z"
                                    stroke="black" stroke-width="1.35714" stroke-linecap="round" stroke-linejoin="round"/>
                                <path d="M24.6428 24.6429L19.5535 19.5536" stroke="black" stroke-width="1.35714"
                                      stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                        </a>
                    </div>

                    <div class="home-icon footer-icon">
                        <a href="{{route('home_page')}}">
                            <svg width="31" height="31" viewBox="0 0 31 31" fill="none"
                                 xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M13 21.9292V18.9292C13 18.3987 13.2107 17.89 13.5858 17.515C13.9609 17.1399 14.4696 16.9292 15 16.9292C15.5304 16.9292 16.0391 17.1399 16.4142 17.515C16.7893 17.89 17 18.3987 17 18.9292V21.9292M5 11.9292L14.732 7.06318C14.8152 7.02163 14.907 7 15 7C15.093 7 15.1848 7.02163 15.268 7.06318L25 11.9292"
                                    stroke="black" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                <path
                                    d="M23 14.9292V22.9292C23 23.4596 22.7893 23.9683 22.4142 24.3434C22.0391 24.7185 21.5304 24.9292 21 24.9292H9C8.46957 24.9292 7.96086 24.7185 7.58579 24.3434C7.21071 23.9683 7 23.4596 7 22.9292V14.9292"
                                    stroke="black" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                        </a>
                    </div>

{{--                    <div class="header-button-item">--}}
{{--                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: inline;">--}}
{{--                            @csrf--}}
{{--                            <button type="submit" onclick="return confirmLogout()" style="background: none; border: none; cursor: pointer;">--}}
{{--                                <i class="fa fa-sign-out" style="font-size:30px"></i>--}}
{{--                            </button>--}}
{{--                        </form>--}}
{{--                    </div>--}}

{{--                    <script>--}}
{{--                        function confirmLogout() {--}}
{{--                            return confirm('آیا مطمئن هستید که می‌خواهید خارج شوید؟');--}}
{{--                        }--}}
{{--                    </script>--}}


                </div>
            </div>
        </footer>

@endauth
