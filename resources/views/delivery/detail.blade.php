@extends('layouts.app', [
  'activePage' => 'delivery', 
  'titlePage' => __('DDS Delivery Report')
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
        <h4 class="card-title"><span>{{$awbs->dds}}</span> - <span>{{$awbs->depo}} ({{$awbs->rayon}})</span></h4>
      </div>
      <div class="card-body">
      <div class="row">
      <div class="col-md-6">
          <div class="card-body mt-1">
              <table class="table-borderless">
              <tr>
                <td><h5 class="card-subtitle text-muted  ">{{__(" Nomor AWB")}}</h5></td>
                <td><h5 class="card-subtitle text-muted  ">&nbsp;{{__(":")}}&nbsp;</h5></td>
                <td><h5 class="card-subtitle text-muted  ">{{$awbs->no_awb}}</h5></td>
              </tr>
              <tr><td></td></tr><tr><td></td></tr><tr><td></td></tr>
              <tr>
                <td><h5 class="card-subtitle text-muted  ">{{__(" Nama Dealer")}}</h5></td>
                <td><h5 class="card-subtitle text-muted  ">&nbsp;{{__(":")}}&nbsp;</h5></td>
                <td><h5 class="card-subtitle text-muted  ">{{$awbs->nama_dealer}}</h5></td>
              </tr>
              <tr><td></td></tr><tr><td></td></tr><tr><td></td></tr>
              <tr>
                <td><h5 class="card-subtitle text-muted  ">{{__(" Tanggal Kirim")}}</h5></td>
                <td><h5 class="card-subtitle text-muted  ">&nbsp;{{__(":")}}&nbsp;</h5></td>
                <td><h5 class="card-subtitle text-muted  ">{{date("l, d-m-Y", strtotime($awbs->tanggal_ds))}}</h5></td>
              </tr>
              </table>
          </div>
      </div>

      <div class="col-md-6">
          <div class="card-body mt-1">
              <table class="table-borderless">
              <tr>
                <td><h5 class="card-subtitle text-muted  ">{{__(" Tanggal Terima")}}</h5></td>
                <td><h5 class="card-subtitle text-muted  ">&nbsp;{{__(":")}}&nbsp;</h5></td>
                <td><h5 class="card-subtitle text-muted  ">{{$awbs->tanggal_terima != null ? date("l, d-m-Y", strtotime($awbs->tanggal_terima)) : "-"}}</h5></td>
              </tr>
              <tr><td></td></tr><tr><td></td></tr><tr><td></td></tr>
              <tr>
                <td><h5 class="card-subtitle text-muted  ">{{__(" Waktu Terima")}}</h5></td>
                <td><h5 class="card-subtitle text-muted  ">&nbsp;{{__(":")}}&nbsp;</h5></td>
                <td><h5 class="card-subtitle text-muted  ">{{$awbs->waktu_terima != null ? $awbs->waktu_terima : "-"}}</h5></td>
              </tr>
              <tr><td></td></tr><tr><td></td></tr><tr><td></td></tr>
              <tr>
                <td><h5 class="card-subtitle text-muted  ">{{__(" Penerima")}}</h5></td>
                <td><h5 class="card-subtitle text-muted  ">&nbsp;{{__(":")}}&nbsp;</h5></td>
                <td><h5 class="card-subtitle text-muted  ">{{$awbs->penerima !=   null ? $awbs->penerima : "-"}}</h5></td>
              </tr>
              </table>
          </div>
      </div>

      </div>
      </div> 

      <div class="card-body table-responsive">
        <table class="table table-hover">
        <!-- <table class="table table-borderless"> -->
          <thead class="text-primary">
            <th>No.</th>
            <th>No. Performa</th>
            <th>TotalKoli</th>
            <th>Tipe Produk</th>
            <th>Keterangan</th>
          </thead>
          <tbody>
          @if(count($proformas) != null)
            @foreach ($proformas as $proforma)
              <tr>
                <td>{{$loop->iteration}}</td>
                <td>{{$proforma->no_proforma}}</td>
                <td>{{$proforma->koli}}</td>
                <td>{{$proforma->ripe}}</td>
                <td>{{$proforma->keterangan}}</td>
              </tr>
            @endforeach
          @else
            <tr>
              <td colspan="5"><center>AWB sedang dikirim</center></td>
            </tr>
          @endif
          </tbody>
        </table>
      </div>
      <div class="text-right pb-3 pr-4">
          <a href="/delivery" class="btn btn-round btn-warning">Kembali</a>
      </div>
    </div>
  </div> 
</div>  
@endsection