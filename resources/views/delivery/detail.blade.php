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
        <div class="row">
          <div class="col-md-6">
            <h4 class="card-title"><span>{{$awbs->dds}}</span> - <span>{{$awbs->depo}} ({{$awbs->rayon}})</span></h4>          
          </div>
          <div class="col-md-6 text-right">
              <h5 class="card-title">{{$awbs->status == null ? 'Sedang dikirim' : 'Telah diterima' }}</h5>
          </div>
        </div>
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
            <th>Total Koli</th>
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
      <!-- Button trigger modal -->
          <button type="button" class="btn btn-round btn-primary" data-toggle="modal" data-target="#exampleModal">
            Lihat bukti Awb
          </button>
          <a href="/delivery" class="btn btn-round btn-warning">Kembali</a>
      </div>
    </div>
  </div> 
</div>  
<!-- BaseModal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">{{$awbs->no_awb}} - {{$awbs->nama_dealer}}</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body text-center">
        @if(empty($awbs->foto_awb))
          <img src="{{asset('bukti_awb')}}/default-image.jpg" class="img-fluid" alt="">
        @else
          <img src="{{asset('bukti_awb')}}/{{$awbs->foto_awb}}" class="img-fluid" alt="">
        @endif
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-round btn-warning" data-dismiss="modal">Tutup</button>
      </div>
    </div>
  </div>
</div>
<script>
  $('#myModal').on('shown.bs.modal', function () {
  $('#myInput').trigger('focus')
})
</script>
@endsection