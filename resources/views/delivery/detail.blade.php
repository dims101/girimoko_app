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
            <h4 class="card-title"><span>{{$proformas->dds}}</span> - <span>{{$proformas->depo}} ({{$proformas->rayon}})</span></h4>          
          </div>
          <div class="col-md-6 text-right">
              <h5 class="card-title {{$iscomplete == 'Completed' ? 'badge badge-success' : 'badge badge-danger'}}">{{$iscomplete}}</h5>
          </div>
        </div>
      </div>
      <div class="card-body">
      <div class="row">
      <div class="col-md-6">
          <div class="card-body mt-1">
              <table class="table-borderless">
              <tr>
                <td><h5 class="card-subtitle text-muted  ">{{__(" Nomor Proforma")}}</h5></td>
                <td><h5 class="card-subtitle text-muted  ">&nbsp;{{__(":")}}&nbsp;</h5></td>
                <td><h5 class="card-subtitle text-muted  "></h5>{{$proformas->no_proforma}}</td>
              </tr>
              <tr><td></td></tr><tr><td></td></tr><tr><td></td></tr>
              <tr>
                <td><h5 class="card-subtitle text-muted  ">{{__(" Tipe Produk")}}</h5></td>
                <td><h5 class="card-subtitle text-muted  ">&nbsp;{{__(":")}}&nbsp;</h5></td>
                <td><h5 class="card-subtitle text-muted  "></h5>{{$proformas->tipe}}</td>
              </tr>
              <tr><td></td></tr><tr><td></td></tr><tr><td></td></tr>
              <tr>
                <td><h5 class="card-subtitle text-muted  ">{{__(" Total Koli")}}</h5></td>
                <td><h5 class="card-subtitle text-muted  ">&nbsp;{{__(":")}}&nbsp;</h5></td>
                <td><h5 class="card-subtitle text-muted  "></h5>{{$proformas->total_koli}}</td>
              </tr>
              <tr><td></td></tr><tr><td></td></tr><tr><td></td></tr>
              <tr>
                <td><h5 class="card-subtitle text-muted  ">{{__(" Dealer Tujuan")}}</h5></td>
                <td><h5 class="card-subtitle text-muted  ">&nbsp;{{__(":")}}&nbsp;</h5></td>
                <td><h5 class="card-subtitle text-muted  "></h5>{{$proformas->nama_dealer}}</td>
              </tr>
              </table>
          </div>
      </div>
      <div class="col-md-6">
          <div class="card-body mt-1">
              <table class="table-borderless">
              <tr>
                <td class="align-top"><h5 class="card-subtitle text-muted ">{{__(" Keterangan")}}</h5></td>
                <td class="align-top"><h5 class="card-subtitle text-muted  ">&nbsp;{{__(":")}}&nbsp;</h5></td>
                <td><h5 class="card-subtitle text-muted  "></h5>{{$proformas->keterangan}} ( No. Awb : {{$proformas->no_awb}} ) </td>
              </tr>
              </table>
          </div>
      </div>
      
      </div>
      </div> 

      <div class="card-body table-responsive">
        <table class="table table-hover">
        <!-- <table class="table table-borderless"> -->
          <thead class="text-primary text-center">
            <!-- <th>No.</th> -->
            <th>No. AWB</th> 
            <th>Jumlah Koli</th> 
            <th>Tanggal Kirim</th>
            <th>Tanggal Terima</th>
            <th>Penerima</th>
            <th>Status</th>
            <th>Keterangan</th>
          </thead>
          <tbody>
            @foreach ($awbs as $awb)
              <tr class="text-center">
                <td>{{$awb->no_awb}}</td>
                <td>{{$awb->koli}}</td>
                <td>{{$awb->tanggal_ds}}</td>
                <td>{{$awb->tanggal_terima}} - {{$awb->waktu_terima}}</td>
                <td>{{$awb->penerima}}</td>
                <td>
                  @if($awb->status == null)
                    Sedang Dikirim
                  @elseif ($awb->status == 0)
                    Ontime
                  @elseif ($awb->status == 1)
                    Delay 1 hari
                  @elseif ($awb->status == 2)
                    Delay 2 hari
                  @elseif ($awb->status == 3)
                    Delay 3 hari
                  @else 
                    Delay >3 hari
                  @endif                  
                </td>
                <td class="text-left">{{$awb->keterangan}}</td>
              </tr>
            @endforeach
          </tbody>
        </table>
      </div>
      
      <div class="text-right pb-3 pr-4">
          <a href="{{ url()->previous() }}" class="btn btn-warning">Kembali</a>
      </div>
    </div>
  </div> 
</div>  
<!-- BaseModal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel"></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body text-center">
          <img src="{{asset('bukti_awb')}}/default-image.jpg" class="img-fluid" alt="">
        
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-warning" data-dismiss="modal">Tutup</button>
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