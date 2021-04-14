@extends('layouts.app', [
  'activePage' => 'pengiriman', 
  'titlePage' => __('Monitoring Pengiriman')
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
        <h4 class="card-title"><span>DDS1</span> - <span">Tambun</span></h4>
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
            <option value="">- Rayon -</option>                                             
            </select>
            <select name="plant" id="plant" class="form-control col-sm-3">
            <option value="">- Delay -</option>      
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
            <th>Rayon</th>
            <th>AWB</th>
            <th>Ontime</th>
            <th>Delay 1 hari</th>
            <th>Delay 2 hari</th>
            <th>Delay 3 hari</th>
            <th>Delay >3 hari</th>
          </thead>
          <tbody>
            <tr>
              <td>1</td>
              <td>Jakarta 1</td>
              <td>5123</td>
              <td>300/td>
              <td>50</td>
              <td>20</td>
              <td>10</td>
              <td>8</td>
            </tr>
            <tr>
              <td>2</td>
              <td>Jakarta 2</td>
              <td>4502</td>
              <td>215/td>
              <td>40</td>
              <td>11</td>
              <td>18</td>
              <td>6</td>
            </tr>
            <tr>
              <td>3</td>
              <td>JTangerang</td>
              <td>2121</td>
              <td>125/td>
              <td>45</td>
              <td>22</td>
              <td>13</td>
              <td>5</td>
            </tr>
          </tbody>
        </table>
      </div>
      <div class="text-right pb-3 pr-4">
          <a href="/pengiriman" class="btn btn-round btn-warning">Kembali</a>
      </div>
    </div>
  </div> 
</div>  
@endsection