@extends('layouts.app', [
  'activePage' => 'summary', 
  'titlePage' => __('Summary')
  ])

@section('content')        
@if (session('status'))
  <div class="alert alert-success" role="alert">
      {{ session('status') }}
  </div>
@endif    
@if($detail<>null)     
<div class="content">
  <div class="container-fluid">
    <div class="card">
      <div class="card-header card-header-primary">
        <h4 class="card-title"><span>{{$detail->dds}}</span> - <span>{{$detail->depo}}</span></h4>
      </div>
      <div class="card-body row">
     
        <!-- <form class="navbar-form col-sm-6">
          <div class="input-group no-border">
            <input value="" type="text" name="search" class="form-control col-sm-10" placeholder="Masukan kata kunci pencarian" id="search">
            <button type="submit" class="btn btn-white btn-round btn-just-icon">
            <i class="material-icons">search</i>
            <div class="ripple-container"></div>
            </button> 
          </div>                          
        </form>  -->
        <!-- &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        <h5 class="title text-right mt-2">Filter :&nbsp;&nbsp;</h5>
        <div class="col-sm-4 row filter container text-right"> -->
          <!-- <div class="row filter container"> -->
            <!-- <select  name="tahun" id="tahun" class="form-control col-sm-3">
            <option value="">- Rayon -</option>                                             
            </select>
            <select name="plant" id="plant" class="form-control col-sm-3">
            <option value="">- Delay -</option>      
            </select>
            <select name="status" id="status" class="form-control col-sm-3">
            <option value="">- Status -</option>                        
                                  
            </select> -->
          <!-- </div> -->
          <!-- <label for="">Tahun</label>
          <label for="">Status</label>
          <label for="">Plant</label> -->
      <!-- </div> -->
      
      </div>    
      <div class="card-body table-responsive">
        <table class="table table-hover table-striped">
        <!-- <table class="table table-borderless"> -->
          <thead class="text-primary">
            <th class="text-center">No.</th>
            <th class="text-center">Rayon</th>
            <th class="text-center">Ontime</th>
            <th class="text-center">Delay 1 hari</th>
            <th class="text-center">Delay 2 hari</th>
            <th class="text-center">Delay 3 hari</th>
            <th class="text-center">Delay >3 hari</th>
            <th class="text-center">Belum terkirim</th>
            <th class="text-center">Total Proforma</th>
          </thead>
          <tbody>
          @for ($i=0;$i<$count;$i++)
              <tr>
                  <td class="text-center">{{$i+1}}</td>
                  <td class="text-center"><a href="/summary/{{$detail->dds}}/{{$detail->depo}}/{{$data['rayon'][$i]}}?bulan=<?=request()->get('bulan')?>&tahun=<?=request()->get('tahun')?>">{{$data['rayon'][$i]}}</a></td>
                  <td class="text-center">{{$data['ontime'][$i]}} / {{$data['all'][$i] != 0 ? round($data['ontime'][$i]/$data['all'][$i]*100,1).'%' : '0%'}}</td>
                  <td class="text-center">{{$data['delay1'][$i]}} / {{$data['all'][$i] != 0 ? round($data['delay1'][$i]/$data['all'][$i]*100,1).'%' : '0%'}}</td>
                  <td class="text-center">{{$data['delay2'][$i]}} / {{$data['all'][$i] != 0 ? round($data['delay2'][$i]/$data['all'][$i]*100,1).'%' : '0%'}}</td>
                  <td class="text-center">{{$data['delay3'][$i]}} / {{$data['all'][$i] != 0 ? round($data['delay3'][$i]/$data['all'][$i]*100,1).'%' : '0%'}}</td>
                  <td class="text-center">{{$data['delay4'][$i]}} / {{$data['all'][$i] != 0 ? round($data['delay4'][$i]/$data['all'][$i]*100,1).'%' : '0%'}}</td>
                  <td class="text-center">{{$data['tunda'][$i]}} / {{$data['all'][$i] != 0 ? round($data['tunda'][$i]/$data['all'][$i]*100,1).'%' : '0%'}}</td>
                  <td class="text-center">{{$data['all'][$i]}}</td>
              </tr>
          
          @endfor
          
          </tbody>
        </table>
      </div>
      <div class="text-right pb-3 pr-4">
          <a href="/summary" class="btn btn-round btn-warning">Kembali</a>
      </div>
    </div>
  </div> 
</div>  

@else
    <div class="row">
        <div class="col-md-12">
            <div class="card">
              <div class="card-header card-header-primary">
                <h4 class="card-title"><span>Tidak</span> Ada <span>Data</span></h4>
              </div>
                <div class="card-body mt-2 text-center">
                    <label for="" class="card-title">Data Tidak Ditemukan</label>
                </div>
            </div>
        </div>
    </div>
    
@endif 

@endsection