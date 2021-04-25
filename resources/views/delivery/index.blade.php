
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
      <div class="card-header card-header-warning">
        <h4 class="card-title"><span>DDS</span> Delivery <span>Report</span></h4>
      </div>
      <div class="card-body row">

     
        <form class="navbar-form col-sm-6">
          <div class="input-group no-border">
            <input value="" type="text" name="search" class="form-control col-sm-10" placeholder="Masukan kata kunci pencarian" id="search">
            <button type="submit" class="btn btn-white btn-round btn-just-icon">
            <i class="material-icons">search</i>
            <div class="ripple-container"></div>
            </button> 
          </div>                          
        </form> 
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        <h5 class="title text-right mt-2">Filter :&nbsp;&nbsp;</h5>
        <div class="col-sm-4 row filter container text-right">
          <!-- <div class="row filter container"> -->
            <select  name="tahun" id="tahun" class="form-control col-sm-3">
            <option value="">- Dealer -</option>                                             
            </select>
            <select name="plant" id="plant" class="form-control col-sm-3">
            <option value="">- DDS -</option>      
            </select>
            <select name="status" id="status" class="form-control col-sm-3">
            <option value="">- Status -</option>                        
                                  
            </select>
          <!-- </div> -->
          <!-- <label for="">Tahun</label>
          <label for="">Status</label>
          <label for="">Plant</label> -->
      </div>
      
      </div>    
      <div class="card-body table-responsive">
        <table class="table table-hover">
        <!-- <table class="table table-borderless"> -->
          <thead class="text-danger">
            <th>No.</th>
            <th>AWB</th>
            <th>Dealer</th>
            <th>Kode</th>
            <th>DDS</th>
            <th>Status</th>   
            <th>Detail</th>
          </thead>
          <tbody>
            <!-- <tr class="">
              <td>1</td>
              <td>5123</td>
              <td>Tomang</td>
              <td>6749837927</td>
              <td>DDS 1</td>
              <td>Terkirim</td>    
              <td>
                <div class="">
                    <a href="/delivery/detail" class="badge badge-round badge-primary"><i class="material-icons">pending</i></a>
                </div>
              </td>
            </tr> -->
            @foreach ($awbs as $awb)
              <tr>
                <td>{{$loop->iteration}}</td>
                <td>{{$awb->no_awb}}</td>
                <td>{{$awb->kode_dealer}}</td>
                <td>{{$awb->nama_dealer}}</td>
                <td>{{$awb->dds}}</td>
                <td>
                  @if ($awb->status == 1)
                    AWB telah sampai
                  @else
                    AWB sedang dikirim
                  @endif
                </td>
                <td>
                  <div class="">
                      <a href="/delivery/detail/{{$awb->no_awb}}" class="badge badge-round badge-primary"><i class="material-icons">pending</i></a>
                  </div>
                </td>
              </tr>
            @endforeach
            
          </tbody>
        </table>
      </div>
      
    </div>
  </div> 
</div>  
@endsection