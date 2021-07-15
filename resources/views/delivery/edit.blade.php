@extends('layouts.app' ,[
  'activePage' => 'delivery', 
  'titlePage' => __('Edit data AWB')
  ])

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header card-header-primary row">
                    <div class="col-md-6">
                        <h4 class="card-title"><span>{{ __('Edit data') }}</span></h4>
                    </div>
                    
                </div>

                <div class="card-body">
                    @if (session('message')) 
                        <div class="alert alert-success" role="alert">
                            {{ session('message') }}
                        </div>
                    @endif  
                    <form method="POST" action="/delivery/store" enctype="multipart/form-data">
                    @method('put')
                    @csrf
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group row">
                                <div class="col-md-4 col-form-label text-md-left">
                                    <label for="no_awb" class="">{{ __('No AWB') }}</label>
                                </div>
                                <div class="col-md-6">
                                    <input value="{{$awbs->no_awb}}" id="no_awb" type="text" class="form-control @error('no_awb') is-invalid @enderror" disabled>

                                    @error('no_awb')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-md-4 col-form-label text-md-left">
                                    <label for="nama_dealer" class="">{{ __('Nama Dealer') }}</label>
                                </div>
                                <div class="col-md-6">
                                    <input value="{{$nama_dealer}}" id="nama_dealer" type="text" class="form-control @error('nama_dealer') is-invalid @enderror" disabled>

                                    @error('nama_dealer')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-md-4 col-form-label text-md-left">
                                    <label for="no_kendaraan" class="">{{ __('No. Kendaraan') }}</label>
                                </div>
                                <div class="col-md-6">
                                    <input value="{{$pengiriman->no_kendaraan}}" id="no_kendaraan" type="text" class="form-control" name="no_kendaraan" required autofocus>
                                </div>                                
                                    @error('no_kendaraan')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                            </div> 
                            
                            <div class="row ml-1">
                                <div class="col-md-4 col-form-label text-md-left">
                                    <label for="foto" class="">{{ __('Foto AWB') }}</label>
                                </div>
                                <div class="col-md-6 text-md-right">                                
                                    @if($pengiriman->foto_awb<>null)
                                    <a href="/bukti_awb/{{$pengiriman->foto_awb}}" target="_blank">
                                    <img src="/bukti_awb/{{$pengiriman->foto_awb}}" alt="" class="img-thumbnail">
                                    </a>
                                    @endif
                                    <input name="foto_awb" id="foto" type="file" class="form-control" >
                                </div>                                
                                    @error('foto')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                            </div> 
                            
                        </div>
                        <div class="col-md-6">
                            <div class="form-group row">
                                <div class="col-md-4 col-form-label text-md-left">
                                    <label for="tgl_kirim" class="">{{ __('Tanggal Kirim') }}</label>
                                </div>
                                <div class="col-md-6">
                                    <input value="{{date('d/m/Y', strtotime($awbs->tanggal_ds))}}" id="tgl_kirim" type="text" class="form-control @error('tgl_kirim') is-invalid @enderror" disabled>

                                    @error('tgl_kirim')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            
                            <div class="form-group row">
                                <div class="col-md-4 col-form-label text-md-left">
                                    <label for="tanggal_terima" class="">{{ __('Tanggal Terima') }}</label>
                                </div>
                                <div class="col-md-6">
                                    <input value="{{$pengiriman->tanggal_terima}}" id="tanggal_terima" type="date" class="form-control @error('tanggal_terima') is-invalid @enderror" name="tanggal_terima" disabled >

                                    @error('tanggal_terima')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-md-4 col-form-label text-md-left">
                                    <label for="waktu_terima" class="">{{ __('Waktu Terima') }}</label>
                                </div>
                                <div class="col-md-6">
                                    <input value="{{$pengiriman->waktu_terima}}" id="waktu_terima" type="time" class="form-control" name="waktu_terima" DISABLED >
                                </div>                                
                                    @error('waktu_terima')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                            </div>   
                            
                            <div class="form-group row">
                                <div class="col-md-4 col-form-label text-md-left">
                                    <label for="penerima" class="">{{ __('Penerima') }}</label>
                                </div>
                                <div class="col-md-6">
                                    <input value="{{$pengiriman->penerima}}" id="penerima" type="text" class="form-control" name="penerima" required >
                                </div>                                
                                    @error('penerima')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                            </div> 

                            <div class="form-group row">
                                <div class="col-md-4 col-form-label text-md-left">
                                    <label for="keterangan" class="">{{ __('Keterangan') }}</label>
                                </div>
                                <div class="col-md-6">
                                    <textarea  id="keterangan" type="text" class="form-control" name="keterangan" required >{{$awbs->keterangan}}</textarea>
                                </div>                                
                                    @error('keterangan')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                            </div> 
                            
                            <div class="row">
                                <div class="col-md-10">
                                    <div class="form-group row mb-2 text-left">
                                        <div class="col-md-12 offset-md-5">
                                            @if($pengiriman->id != null)
                                            <input type="hidden" name="id" value="{{$pengiriman->id}}">
                                            <input type="hidden" name="no_awb" value="{{$awbs->no_awb}}">
                                            <input type="hidden" name="kode_dealer" value="{{$awbs->kode_dealer}}">
                                            <button type="submit" class="btn btn-success">
                                                {{ __('Simpan') }}
                                            </button>
                                            @endif
                                            <a href="/delivery/detail/{{$awbs->no_awb}}" class="btn btn-warning">Kembali</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
</div>
@endsection
