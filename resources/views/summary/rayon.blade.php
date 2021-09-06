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
      <form class="navbar-form col-sm-6" action="/summary/{{$dds}}/{{$depo}}/{{$rayon}}/cari" method="get">
                
        <div class="input-group no-border mt-2">
          @if(!request()->get('keyword'))
          <input type="text" name="keyword" class="form-control col-sm-10" placeholder="     Masukan kata kunci pencarian" id="search">
          @else
          <input type="text" name="keyword" value="{{request()->keyword}}"class="form-control col-sm-10" placeholder="Masukan kata kunci pencarian" id="search">
          @endif
          <input type="hidden" name="bulan" value=" <?=request()->get('bulan')?>">
          <input type="hidden" name="tahun" value=" <?=request()->get('tahun')?>">
          <button type="submit" class="btn btn-white btn-round btn-just-icon">
          <i class="material-icons">search</i>
          <div class="ripple-container"></div>
          </button> 
        </div>                          
      </form> 
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
              <td>{{$d->nama_dealer}}</td>
              <td >{{$d->alamat}}</td>
              <td class="text-center">
                @if ($d->status == null)
                  AWB on Delivery
                @elseif ($d->status == 0)
                  Ontime
                @elseif ($d->status == 1)
                  Delay 1 hari
                @elseif ($d->status == 2)
                  Delay 2 hari
                @elseif ($d->status == 3)
                  Delay 3 hari
                @else 
                  Delay >3 hari
                @endif
              </td>
              <td class="text-center">{{$d->keterangan}}</td>
            </tr>
            @endforeach
          </tbody>
        </table>
        {{$detail->links()}}
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