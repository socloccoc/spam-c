@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Key Generate</div>
                    <div class="card-body">
                        <form>
                            <div class="form-group">
                                <label for="cookie">Cookie</label>
                                <input type="text" class="form-control" id="cookie" name="cookie" placeholder="Cookie">
                            </div>
                            <div class="form-group">
                                <label for="tel">Loại thẻ</label>
                                <select id="tel" name="tel" class="form-control">
                                    <option value="1">Viettel</option>
                                    <option value="2">Mobiphone</option>
                                    <option value="4">Vinaphone</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="app">Loại thẻ</label>
                                <select name="amount" id="amount" class="form-control">
                                    <option value="10000">10.000</option>
                                    <option value="20000">20.000</option>
                                    <option value="30000">30.000</option>
                                    <option value="50000">50.000</option>
                                    <option value="100000">100.000</option>
                                    <option value="200000">200.000</option>
                                    <option value="500000">500.000</option>
                                    <option value="1000000">1.000.000</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="times">Số lần nạp thẻ</label>
                                <input type="text" class="form-control" id="times" name="times" placeholder="1"
                                       value="1">
                            </div>
                            <div class="col-md-12 text-right" style="padding: 0px">
                                <button type="button" class="btn btn-primary spam-card">Spam card</button>
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
        $(document).ready(function () {
            $(document).ready(function () {
                $('.spam-card').on('click', function () {
                    $('.spam-alert').html('');
                    var times = $('#times').val();
                    for (var i = 0; i < 1; i++) {
                        spamAjax();
                    }
                });
            });

            function spamAjax() {
                var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
                var cookie = $('#cookie').val();
                var tel = $('#tel').val();
                var amount = $('#amount').val();
                $.ajax({
                    url: '/ajax/spamCard',
                    type: 'POST',
                    data: {_token: CSRF_TOKEN, cookie: cookie, tel: tel, amount: amount},
                    dataType: 'JSON',
                    success: function (data) {
                        console.log(data);
                        $('.spam-alert').append('<div class="alert alert-success">' + data.msg + '</div>');
                    }
                });
            }
        });
    </script>
@endsection