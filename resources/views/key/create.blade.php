@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Key Generate</div>
                    <div class="card-body">
                        @include('errors.errorlist')
                        <form method="POST" action="{{ route('spam.update', $setting['id']) }}">
                            <input name="_method" type="hidden" value="PUT">
                            @csrf
                            <div class="form-group">
                                <label for="cookie">Cookie</label>
                                <input type="text" class="form-control" id="cookie" name="cookie" placeholder="Cookie" value="{{ isset($setting['cookie']) ? $setting['cookie'] : '' }}">
                            </div>
                            <div class="form-group">
                                <label for="time_once">Mấy giờ chạy một lần</label>
                                <select id="time_once" name="time_once" class="form-control">
                                    @forelse(config('constants.hours') as $index => $hour)
                                        <option {{ isset($setting['time_once']) && $setting['time_once'] == $index ? 'selected' : '' }} value="{{ $index }}">{{ $hour }}</option>
                                    @empty
                                    @endforelse
                                </select>
                            </div>
                            {{--<div class="form-group">--}}
                            {{--<label for="tel">Loại thẻ</label>--}}
                            {{--<select id="tel" name="tel" class="form-control">--}}
                            {{--<option value="1">Viettel</option>--}}
                            {{--<option value="2">Mobiphone</option>--}}
                            {{--<option value="4">Vinaphone</option>--}}
                            {{--</select>--}}
                            {{--</div>--}}
                            {{--<div class="form-group">--}}
                            {{--<label for="app">Loại thẻ</label>--}}
                            {{--<select name="amount" id="amount" class="form-control">--}}
                            {{--<option value="10000">10.000</option>--}}
                            {{--<option value="20000">20.000</option>--}}
                            {{--<option value="30000">30.000</option>--}}
                            {{--<option value="50000">50.000</option>--}}
                            {{--<option value="100000">100.000</option>--}}
                            {{--<option value="200000">200.000</option>--}}
                            {{--<option value="500000">500.000</option>--}}
                            {{--<option value="1000000">1.000.000</option>--}}
                            {{--</select>--}}
                            {{--</div>--}}
                            <div class="form-group">
                                <label for="card_number">Số lần nạp thẻ</label>
                                <input type="text" class="form-control" id="card_number" name="card_number"
                                       placeholder="1"
                                       value="{{ isset($setting['card_number']) ? $setting['card_number'] : '' }}">
                            </div>
                            <div class="form-group">
                                <label for="time_request">Thời gian giữa các thẻ</label>
                                <select id="time_request" name="time_request" class="form-control">
                                    @forelse(config('constants.time_request') as $index => $time)
                                        <option {{ isset($setting['time_request']) && $setting['time_request'] == $index ? 'selected' : '' }} value="{{ $index }}">{{ $time }}</option>
                                    @empty
                                    @endforelse
                                </select>
                            </div>
                            <div class="col-md-12 text-right" style="padding: 0px">
                                <button type="submit" class="btn btn-primary spam-card">Spam card</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-md-4 spam-alert" style="max-width: 500px; overflow: auto">
                <div class="alert alert-success">
                    Messages
                </div>
            </div>
        </div>
    </div>
@endsection
@section('javascript')
    <script>
        // $(document).ready(function () {
        //     $(document).ready(function () {
        //         $('.spam-card').on('click', function () {
        //             $('.spam-alert').html('');
        //             var times = $('#times').val();
        //             for (var i = 0; i < 1; i++) {
        //                 spamAjax();
        //             }
        //         });
        //     });
        //
        //     function spamAjax() {
        //         var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
        //         var cookie = $('#cookie').val();
        //         var tel = $('#tel').val();
        //         var amount = $('#amount').val();
        //         $.ajax({
        //             url: '/ajax/spamCard',
        //             type: 'POST',
        //             data: {_token: CSRF_TOKEN, cookie: cookie, tel: tel, amount: amount},
        //             dataType: 'JSON',
        //             success: function (data) {
        //                 console.log(data);
        //                 $('.spam-alert').append('<div class="alert alert-success">' + data.msg + '</div>');
        //             }
        //         });
        //     }
        // });
    </script>
@endsection