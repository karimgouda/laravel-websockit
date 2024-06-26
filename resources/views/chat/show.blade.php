@extends('layouts.app')
@push('css')
    <style>
        #users-list li {
            cursor: pointer;
        }
    </style>
@endpush
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">Chat</div>

                    <div class="card-body">
                        <div class="row p-2">
                            <div class="col-10">
                                <div class="row">
                                    <div class="col-12 border rounded-lg p-3">
                                        <ul
                                            id="messages"
                                            class="list-unstyled overflow-auto"
                                            style="height: 45vh"
                                        >

                                        </ul>
                                    </div>
                                </div>
                                <form>
                                    <div class="row py-3">
                                        <div class="col-10">
                                            <input id="message" class="form-control" type="text">
                                        </div>
                                        <div class="col-2">
                                            <button id="send" type="submit" class="btn btn-primary btn-block">Send</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="col-2">
                                <p><strong>Online Now</strong></p>
                                <ul
                                    id="users-list"
                                    class="list-unstyled overflow-auto text-success"
                                    style="height: 45vh"
                                >
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        function greetUser(id)
        {
           window.axios.post('chat/greet/' + id);
        }
    </script>
@endpush
