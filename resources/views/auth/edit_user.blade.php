@extends('layouts.app' ,[
  'activePage' => 'register', 
  'titlePage' => __('Edit User')
  ])

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header card-header-primary row">
                    <div class="col-md-6">
                        <h4 class="card-title"><span>{{ __('Edit User') }}</span></h4>
                    </div>
                    
                </div>

                <div class="card-body">
                    <!-- @if (session('message')) 
                        <div class="alert alert-success" role="alert">
                            {{ session('message') }}
                        </div>
                    @endif   -->
                    <form method="POST" action="/user/{{$user->id}}" enctype="multipart/form-data">
                    @method('patch')
                    @csrf 
                        <div class="form-group row">
                            <div class="col-md-4 col-form-label text-md-right">
                                <label for="name" class="">{{ __('Name') }}</label>
                            </div>
                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ $user->name }}" required autocomplete="name" autofocus>

                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-md-4 col-form-label text-md-right">
                                <label for="username" class="">{{ __('Username') }}</label>
                            </div>
                            <div class="col-md-6">
                                <input id="username" type="text" class="form-control @error('username') is-invalid @enderror" name="username" value="{{ $user->username }}" required autocomplete="username">

                                @error('username')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-md-4 col-form-label text-md-right">
                                <label for="telepon" class="">{{ __('Telepon') }}</label>
                            </div>
                            <div class="col-md-6">
                                <input id="telepon" type="text" class="form-control @error('telepon') is-invalid @enderror" name="telepon" value="{{ $user->telepon }}" required autocomplete="telepon">

                                @error('telepon')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-md-4 col-form-label text-md-right">
                                <label for="password" class="">{{ __('Password') }}</label>
                            </div>
                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password"  required autocomplete="new-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-md-4 col-form-label text-md-right">
                                <label for="password-confirm" class="">{{ __('Confirm Password') }}</label>
                            </div>
                            <div class="col-md-6">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation"  required autocomplete="new-password">
                            </div>
                        </div>                        

                        <div class="form-group row">
                            <label for="level" class="col-md-4 col-form-label text-md-right">{{ __('Level') }}</label>

                            <div class="col-md-6">

                                <select name="level" id="level" class="form-control @error('level') is-invalid @enderror">
                                    <option value="">--Pilih Level--</option>
                                    @if(auth()->user()->level == "Super Admin")
                                    <option value="super_admin">Super Admin</option>
                                    <option value="admin">Admin</option>
                                    @endif
                                    @if(auth()->user()->level == "admin" or auth()->user()->level == "Super Admin")
                                    <option value="user">User - Yamaha</option>
                                    <option value="driver">Driver</option>
                                    @endif
                                </select>                                

                                @error('level')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row mb-2 text-right">
                            <div class="col-md-6 offset-md-5">
                                <button type="submit" class="btn btn-warning">
                                    {{ __('Update') }}
                                </button>
                                
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection