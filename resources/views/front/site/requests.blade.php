@extends('front.site.layout')

@section('content')
    <div class="container" style="padding: 0 !important;">
{{--        <h2>درخواست‌های دنبال کردن</h2>--}}

        @if ($followRequests->isEmpty())
            <div class="alert alert-light text-center" role="alert">
                درخواستی وجود ندارد
            </div>
        @else
            <table class="table">
                <thead>
                <tr>
                    <th>کاربر درخواست‌دهنده</th>
                    <th style="    text-align: center;
    padding-right: 20px;">عملیات</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($followRequests as $request)
                    <tr>
                        <td style="vertical-align: middle;">

                            <img src="{{ url('storage/profiles/' . ($request->requester->profile ?? 'default.jpg')) }}" alt="Profile Picture" class="profile-pic" style="object-fit: cover;width: 40px; height: 40px; border-radius: 50%;">
                            {!! $request->requester->username_with_blue_tick !!}

                        </td>
                        <td style="text-align: end;">
                            <form action="{{ route('follow.requests.respond') }}" method="POST" style="display:inline;">
                                @csrf
                                <input type="hidden" name="request_id" value="{{ $request->id }}">
                                <button type="submit" name="action" value="accept" class="btn btn-primary">قبول</button>
                                <button type="submit" name="action" value="reject" class="btn btn-light m-1">رد</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        @endif
    </div>
@endsection
