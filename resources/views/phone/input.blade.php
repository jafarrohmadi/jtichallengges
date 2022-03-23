@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">{{ __('DATA NO HANDPHONE') }}</div>

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif
                        <form>
                            <div class="form-group row">
                                <label for="email">{{ __('No Handphone') }}</label>
                                <div class="col-md-12">
                                    <input id="phone_number" type="number"
                                           class="form-control @error('phone_number') is-invalid @enderror"
                                           name="phone_number" value="{{ old('phone_number') }}" required
                                           autocomplete="off" autofocus>
                                    @error('phone_number')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <br>
                            <div class="form-group row">
                                <label for="email">{{ __('Provider') }}</label>
                                <div class="col-md-12">
                                    <select name="provider" id="provider" class="form-control">
                                        <option value="XL">XL</option>
                                        <option value="TELKOM">TELKOM</option>
                                        <option value="TRI">TRI</option>
                                        <option value="INDOSAT">INDOSAT</option>
                                    </select>
                                    @error('phone_number')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <br>
                            <button type="submit" class="btn btn-primary" id="save">
                                {{ __('Save') }}
                            </button>

                            <button type="button" class="btn btn-primary" id="auto">
                                {{ __('Auto') }}
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        $('form').submit(function (event) {
            event.preventDefault()
            var postForm = {
                'phone_number': $('input[name=phone_number]').val(),
                'provider': $('#provider').val()
            };

            $.ajax({
                type: 'POST',
                url: '{{url('/api/phone')}}',
                data: postForm,
                dataType: 'json',
                success: function (data) {
                    if(data.status == true){
                        new Noty({
                            type: 'success',
                            layout: 'topRight',
                            text: 'Success Input Data',
                            timeout: 5000
                        }).show();
                    }else{
                        new Noty({
                            type: 'error',
                            layout: 'topRight',
                            text: 'Nomor phone Sudah ada',
                            timeout: 5000
                        }).show();
                    }

                }
            });
            event.preventDefault();
        });

        $('#auto').click(function (){
            $.ajax({
                type: 'POST',
                url: '{{url('/api/phone/auto')}}',
                dataType: 'json',
                success: function (data) {
                    new Noty({
                        type: 'success',
                        layout: 'topRight',
                        text: 'Success Generate Data',
                        timeout: 5000
                    }).show();
                }
            });

        })
    </script>
@endsection
