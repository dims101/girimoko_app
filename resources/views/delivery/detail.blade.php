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
        <h4 class="card-title"><span>DDS1</span> - <span>Tambun</span></h4>
      </div>
      <div class="card-body">
      <div class="col-md-4">
          <div class="card-body mt-1">
              <table class="table-borderless">
              <tr>
                <td><h6 class="card-subtitle text-muted  ">{{__(" Nomor AWB")}}</h6></td>
                <td><h6 class="card-subtitle text-muted  ">&nbsp;{{__(":")}}&nbsp;</h6></td>
                <td><h6 class="card-subtitle text-muted  ">{{__(" ")}}</h6></td>
              </tr>
              <tr>
                <td><h6 class="card-subtitle text-muted  ">{{__(" Tanggal Kirim")}}</h6></td>
                <td><h6 class="card-subtitle text-muted  ">&nbsp;{{__(":")}}&nbsp;</h6></td>
                <td><h6 class="card-subtitle text-muted  ">{{__(" ")}}</h6></td>
              </tr>
              <tr>
                <td><h6 class="card-subtitle text-muted  ">{{__(" Tanggal Terima")}}</h6></td>
                <td><h6 class="card-subtitle text-muted  ">&nbsp;{{__(":")}}&nbsp;</h6></td>
                <td><h6 class="card-subtitle text-muted  ">{{__(" ")}}</h6></td>
              </tr>
              <tr>
                <td><h6 class="card-subtitle text-muted  ">{{__(" Rayon")}}</h6></td>
                <td><h6 class="card-subtitle text-muted  ">&nbsp;{{__(":")}}&nbsp;</h6></td>
                <td><h6 class="card-subtitle text-muted  ">{{__(" ")}}</h6></td>
              </tr>
              <tr>
                <td><h6 class="card-subtitle text-muted  ">{{__(" Penerima")}}</h6></td>
                <td><h6 class="card-subtitle text-muted  ">&nbsp;{{__(":")}}&nbsp;</h6></td>
                <td><h6 class="card-subtitle text-muted  ">{{__(" ")}}</h6></td>
              </tr>
              </table>
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
            <tr>
              <td>1</td>
              <td>3076377</td>
              <td>3</td>
              <td>YGP</td>
              <td></td>
            </tr>
            <tr>
              <td>2</td>
              <td>3076068</td>
              <td>1</td>
              <td>YGP</td>
              <td></td>
            </tr>
            <tr>
              <td>3</td>
              <td>3074158</td>
              <td>2</td>
              <td>YGP</td>
              <td></td>
            </tr>
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