@extends('layouts.app', [
  'activePage' => 'dealer', 
  'titlePage' => __('Dealer')
  ])

  @section('content')
  @if (session('status')) 
  <div class="alert alert-success" role="alert">
      {{ session('status') }}
  </div>
  @endif   

<div class="content">
  <div class="container-fluid">
    <div class="card">
      <div class="card-header card-header-primary">
        <h4 class="card-title"><span>Tambah Dealer</span></h4>
      </div>

    <div class="card-body">
    <br>
    <form method="POST" action="dealer/store">
    @csrf
    <div class="row">
        <div class="col-md-6">
            <div class="form-group row">
            <div class="col-md-4 col-form-label">
                <label for="kode_dealer" class="">{{ __('Kode Dealer') }}</label>
            </div>
            <div class="col-md-6">
                <input id="kode_dealer" type="text" class="form-control @error('kode_dealer') is-invalid @enderror" name="kode_dealer" value="{{ old('kode_dealer') }}" required autocomplete="kode_dealer" autofocus>
                @error('kode_dealer')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            </div>

            <div class="form-group row">
            <div class="col-md-4 col-form-label">
                <label for="nama_dealer" class="">{{ __('Nama Dealer') }}</label>
            </div>
            <div class="col-md-6">
                <input id="nama_dealer" type="text" class="form-control @error('nama_dealer') is-invalid @enderror" name="nama_dealer" value="{{ old('nama_dealer') }}" required autocomplete="nama_dealer">
                @error('nama_dealer')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            </div>   

            <div class="form-group row">
            <div class="col-md-4 col-form-label">
                <label for="alamat" class="">{{ __('Alamat') }}</label>
            </div>
            <div class="col-md-6">
                <textarea id="alamat" type="text" class="form-control @error('alamat') is-invalid @enderror" name="alamat" value="{{ old('alamat') }}" required autocomplete="alamat"></textarea>
                @error('alamat')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            </div>

            <div class="form-group row">
            <div class="col-md-4 col-form-label">
                <label for="provinsi" class="">{{ __('Provinsi') }}</label>
            </div>
            <div class="col-md-6">
                <input id="provinsi" type="text" class="form-control @error('provinsi') is-invalid @enderror" name="provinsi" value="{{ old('provinsi') }}" required autocomplete="provinsi">
                @error('provinsi')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            </div>

            <div class="form-group row">
            <div class="col-md-4 col-form-label">
                <label for="kota" class="">{{ __('Kota') }}</label>
            </div>
            <div class="col-md-6">
                <input id="kota" type="text" class="form-control @error('kota') is-invalid @enderror" name="kota" value="{{ old('kota') }}" required autocomplete="kota">
                @error('kota')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group row">
            <div class="col-md-4 col-form-label">
                <label for="kodepos" class="">{{ __('Kode Pos') }}</label>
            </div>
            <div class="col-md-6">
                <input id="kodepos" type="number" class="form-control @error('kodepos') is-invalid @enderror" name="kodepos" value="{{ old('kodepos') }}" required autocomplete="kodepos">
                @error('kodepos')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            </div>

            <div class="form-group row">
            <div class="col-md-4 col-form-label">
                <label for="dds" class="">{{ __('DDS') }}</label>
            </div>
            <div class="col-md-6">
                <select name="dds" id="dds"  class="form-control @error('dds') is-invalid @enderror" required>
                    <option value="">--Pilih--</option>
                    @foreach($dds as $d)
                    <option value="{{$d->dds}}">{{$d->dds}}</option>
                    @endforeach
                </select>
                @error('dds')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            </div>

            <div class="form-group row">
            <div class="col-md-4 col-form-label">
                <label for="depo" class="">{{ __('Depo') }}</label>
            </div>
            <div class="col-md-6">
                <select name="depo" id="depo"  class="form-control @error('depo') is-invalid @enderror" required>
                    <option value="">--Pilih--</option>
                    @foreach($depo as $d)
                    <option value="{{$d->depo}}">{{$d->depo}}</option>
                    @endforeach
                </select>
                @error('depo')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            </div>

            <div class="form-group row">
            <div class="col-md-4 col-form-label">
                <label for="rayon" class="">{{ __('Rayon') }}</label>
            </div>
            <div class="col-md-6">
            <select name="rayon" id="rayon"  class="form-control @error('rayon') is-invalid @enderror" required>
                    <option value="">--Pilih--</option>
                    @foreach($rayon as $d)
                    <option value="{{$d->rayon}}">{{$d->rayon}}</option>
                    @endforeach
                </select>
                @error('rayon')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            </div>
        </div>
    </div>
    <div class="form-group row mb-2 text-right">
      <div class="col-md-6 offset-md-5">
          <button type="submit" class="btn btn-success">
              {{ __('Simpan') }}
          </button>
          <a href="/dealer" class="btn btn-warning">Kembali</a>
      </div>
    </div>
    </form>
    
    </div>

    </div>
  </div>
</div>


    <!-- Optional JavaScript; choose one of the two! -->

    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js" integrity="sha384-JEW9xMcG8R+pH31jmWH6WWP0WintQrMb4s7ZOdauHnUtxwoG2vI5DkLtS3qm9Ekf" crossorigin="anonymous"></script>

    <!-- Option 2: Separate Popper and Bootstrap JS -->
    <!--
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.1/dist/umd/popper.min.js" integrity="sha384-SR1sx49pcuLnqZUnnPwx6FCym0wLsk5JZuNx2bPPENzswTNFaQU1RDvt3wT4gWFG" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.min.js" integrity="sha384-j0CNLUeiqtyaRmlzUHCPZ+Gy5fQu0dQ6eZ/xAww941Ai1SxSY+0EQqNXNE6DZiVc" crossorigin="anonymous"></script>
    -->
    @endsection