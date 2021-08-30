@extends('layouts.app', [
  'activePage' => 'summary', 
  'titlePage' => __('Daftar proforma')
  ])

@section('content')        
@if (session('status'))
  <div class="alert alert-success" role="alert">
      {{ session('status') }}
  </div>
@endif    
@if(count($detail) <> 0)     
<div class="content">
  <div class="container-fluid">
    <div class="card">
      <div class="card-header card-header-primary">
        <h4 class="card-title"><span>{{$dds}}</span> - <span>{{$depo}}</span> - <span>{{$rayon}}</span></h4>
      </div>
      <div class="card-body row">
           
      </div>    
      <div class="card-body table-responsive">
        <table class="table table-hover table-striped">
        <!-- <table class="table table-borderless"> -->
          <thead class="text-primary">
            <th class="text-center">No. Proforma</th>
            <th class="text-center">No. AWB</th>
            <th class="text-center">Dealer</th>
            <th class="text-center">Alamat</th>
            <th class="text-center">Status</th>
            <th class="text-center">Keterangan</th>
          </thead>
          <tbody>
            @foreach ($detail as $d)
            <tr>
              <td class="text-center">{{$d->no_proforma}}</td>
              <td class="text-center">{{$d->no_awb}}</td>
              <td class="text-center">{{$d->dealer}}</td>
              <td >{{$d->alamat}}</td>
              <td class="text-center">{{$d->status == null ? 'Sedang dikirim' : 'Telah diterima'}}</td>
              <td class="text-center">{{$d->keterangan}}</td>
            </tr>
            @endforeach
          </tbody>
        </table>
      </div>
      <div class="text-right pb-3 pr-4">
          <a href="{{ url()->previous() }}" class="btn btn-round btn-warning">Kembali</a>
      </div>
    </div>
  </div> 
</div>  

@else
    <div class="row">
        <div class="col-md-12">
            <div class="card">
              <div class="card-header card-header-primary">
                <h4 class="card-title"><span>{{$dds}}</span> - <span>{{$depo}}</span> - <span>{{$rayon}}</span></h4>
              </div>
                <div class="card-body mt-2 text-center">
                    <label for="" class="card-title">Data Tidak Ditemukan</label>
                </div>
                <div class="text-right pb-3 pr-4">
                    <a href="{{ url()->previous() }}" class="btn btn-round btn-warning">Kembali</a>
                </div>
            </div>
        </div>
    </div>
    
@endif 

@endsection