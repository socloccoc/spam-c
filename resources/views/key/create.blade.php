@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Crontab setting</div>
                    <div class="card-body">
                        @include('errors.errorlist')
                        <form method="POST" action="{{ route('spam.update', $setting['id']) }}">
                            <input name="_method" type="hidden" value="PUT">
                            @csrf
                            <div class="form-group">
                                <label for="cookie">Cookie</label>
                                <input type="text" class="form-control" id="cookie" name="cookie" placeholder="Cookie"
                                       value="{{ isset($setting['cookie']) ? $setting['cookie'] : '' }}">
                            </div>
                            <div class="form-group">
                                <label for="time_once">Số giờ chạy một lần</label><br>
                                <label for="time_once" style="color: red">vd: chọn 1H thì cứ một giờ job sẽ chạy 1
                                    lần</label>
                                <select id="time_once" name="time_once" class="form-control">
                                    @forelse(config('constants.hours') as $index => $hour)
                                        <option {{ isset($setting['time_once']) && $setting['time_once'] == $index ? 'selected' : '' }} value="{{ $index }}">{{ $hour }}</option>
                                    @empty
                                    @endforelse
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="card_number">Số thẻ muốn nạp</label><br/>
                                <label for="card_number" style="color: red">* Hệ thống sẽ tự động tạo thẻ, bạn chỉ cần
                                    nhập số lượng mình muốn</label>
                                <input type="text" class="form-control" id="card_number" name="card_number"
                                       placeholder="1"
                                       value="{{ isset($setting['card_number']) ? $setting['card_number'] : '' }}">
                            </div>
                            <div class="form-group">
                                <label for="time_request">Thời gian nạp giữa các thẻ</label>
                                <select id="time_request" name="time_request" class="form-control">
                                    @forelse(config('constants.time_request') as $index => $time)
                                        <option {{ isset($setting['time_request']) && $setting['time_request'] == $index ? 'selected' : '' }} value="{{ $index }}">{{ $time }}</option>
                                    @empty
                                    @endforelse
                                </select>
                            </div>
                            <div class="form-group">
                                <label class="switch">
                                    <input name="status"
                                           type="checkbox" {{ isset($setting['status']) && $setting['status'] == 1 ? 'checked' : '' }}>
                                    <span class="slider round"></span>
                                </label>
                            </div>
                            <div class="col-md-12 text-right" style="padding: 0px">
                                <button type="submit" class="btn btn-primary spam-card">Save</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
