@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Home &nbsp;&nbsp;&nbsp;<a href="dashboard">Go to Dashboard.</a> </div>
                

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    You are logged in!<br><br>
                    <a href="twitter">Go to Twitter background.</a><br><br>
                    <a href="facebook">Go to Facebook background.</a><br><br>
                    <a href="instagram">Go to Instagram background.</a><br><br>
                    <a href="youtube">Go to Youtube background.</a><br><br>
                    <a href="web">Go to Web background.</a><br><br>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
