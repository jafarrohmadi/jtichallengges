@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('OUTPUT') }}</div>

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif
                        <div class="row">
                            <div class="col-md-6">
                                <table class="table table-bordered">
                                    <thead>
                                    <tr>
                                        <th scope="col">Ganjil</th>
                                    </tr>
                                    </thead>
                                    <tbody class="odd">
                                    <tr>
                                        <th>1</th>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="col-md-6">
                                <table class="table table-bordered col-md-6">
                                    <thead>
                                    <tr>
                                        <th scope="col">Genap</th>
                                    </tr>
                                    </thead>
                                    <tbody class="even">
                                    <tr>
                                        <th>1</th>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <button class="btn btn-info" type="button"  id="edit">Edit</button>
                                <button class="btn btn-danger" id="delete">Delete</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal -->
        <div class="modal flex-column" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Edit Number</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form>
                            <input type="hidden" name="id" id="id">
                            <div class="form-group row">
                                <label for="email">{{ __('No Handphone') }}</label>
                                <div class="col-md-12">
                                    <input id="phone_number" type="number"
                                           class="form-control @error('phone_number') is-invalid @enderror"
                                           name="phone_number" value="{{ old('phone_number') }}" required
                                           autocomplete="off" autofocus id="phone_number">
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
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://js.pusher.com/7.0/pusher.min.js"></script>
    <script type="application/javascript">
        Pusher.logToConsole = true;

        var pusher = new Pusher('ebfe980b53bbc40fa31b', {
            cluster: 'ap1'
        });

        var channel = pusher.subscribe('my-reload');
        channel.bind("reload-data", function(data) {
            getData()
            playSound('{{asset('sound/horse.mp3')}}')
        });

        function playSound(url) {
            const audio = new Audio(url);
            audio.play();
        }

        function getData() {
            var request = new XMLHttpRequest()

            request.open('GET', '{{url('/api/phone')}}', true)
            request.onload = function () {
                // Begin accessing JSON data here
                var data = JSON.parse(this.response)
                var even, odd
                if (request.status >= 200 && request.status < 400) {
                    data = data.data
                    for (let i = 0; i < data.length; i++) {
                        if (data[i]['phone_number'] % 2 == 0) {
                            even = even + '<tr> <th><input type="radio" name="phone" value="'+ data[i]["id"]+ '" data-id="'+ data[i]["id"]+ '" data-phone_number="'+ data[i]["phone_number"]+ '" data-provider="'+ data[i]["provider"]+ '">' + data[i]["phone_number"] + '</th></tr>'
                        } else {
                            odd = odd + '<tr> <th><input type="radio" name="phone" value="'+ data[i]["id"]+ '" data-id="'+ data[i]["id"]+ '" data-phone_number="'+ data[i]["phone_number"]+ '" data-provider="'+ data[i]["provider"]+ '">' + data[i]["phone_number"] + '</th></tr>'
                        }
                    }
                    $('.even').html(even)
                    $('.odd').html(odd)
                } else {
                    console.log('error')
                }
            }

            request.send()
        }

        getData()

        $('#edit').click(function () {
            $('#phone_number').val($("input[type='radio']:checked").data('phone_number'))
            $("#provider").val($("input[type='radio']:checked").data('provider'))
            $("#id").val($("input[type='radio']:checked").data('id'))
            $('#exampleModal').modal("show");
        });

        $('form').submit(function (event) {
            event.preventDefault()
            var postForm = {
                'phone_number': $('#phone_number').val(),
                'provider': $('#provider').val(),
                '_method' : 'PUT'
            };

            $.ajax({
                type: 'POST',
                url: '{{url('/api/phone')}}/' + $('#id').val() ,
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
                        $('#exampleModal').modal('hide');
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

        $('#delete').click(function () {
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        type: 'DELETE',
                        url: '{{url('/api/phone')}}/' + $("input[type='radio']:checked").val(),
                        dataType: 'json',
                        success: function (data) {
                            Swal.fire(
                                'Deleted!',
                                'Your file has been deleted.',
                                'success'
                            )
                        }
                    });

                }
            })
        })

    </script>
@endsection
