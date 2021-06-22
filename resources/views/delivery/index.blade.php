
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

     
        <form class="navbar-form col-sm-6" action="/delivery/cari" method="get">
                
          <div class="input-group no-border">
            @if(!request()->filled('keyword'))
            <input type="text" name="keyword" class="form-control col-sm-10" placeholder="Masukan kata kunci pencarian" id="search">
            @else
            <input type="text" name="keyword" value="{{request()->keyword}}"class="form-control col-sm-10" placeholder="Masukan kata kunci pencarian" id="search">
            @endif
            <button type="submit" class="btn btn-white btn-round btn-just-icon">
            <i class="material-icons">search</i>
            <div class="ripple-container"></div>
            </button> 
          </div>                          
        </form> 
        <!-- &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; -->
        <h5 class="title mt-2 col-sm-1">Filter :&nbsp;&nbsp;</h5>
            <div class="col-sm-4 row filter container">        
              <!-- <div class="row filter container"> -->
              <form action="/delivery" method="get">
              
                <div class="row">
                <select  name="bulan" id="bulan" class="form-control col-sm-3">
                  <option value="">-- Bulan --</option>  
                  <option value="01"@if (request()->filled('bulan') == 01) selected @endif >Januari</option>  
                  <option value="02" @if (request()->filled('bulan') == 02) selected @endif >Februari</option>  
                  <option value="03" @if (request()->filled('bulan') == 03) selected @endif >Maret</option>  
                  <option value="04" @if (request()->filled('bulan') == 04) selected @endif >April</option>  
                  <option value="05" @if (request()->filled('bulan') == 05) selected @endif >Mei</option> 
                  <option value="06" @if (request()->filled('bulan') == 06) selected @endif >Juni</option>  
                  <option value="07" @if (request()->filled('bulan') == 07) selected @endif >Juli</option>  
                  <option value="08" @if (request()->filled('bulan') == 08) selected @endif >Agustus</option>
                  <option value="09" @if (request()->filled('bulan') == 09) selected @endif >September</option>
                  <option value="10" @if (request()->filled('bulan') == 10) selected @endif >Oktober</option>  
                  <option value="11" @if (request()->filled('bulan') == 11) selected @endif >November</option>  
                  <option value="12" @if (request()->filled('bulan') == 12) selected @endif >Desember</option>                                         
                </select>
                <select name="tahun" id="tahun" class="form-control col-sm-3">
                  <option value="">-- Tahun --</option>                 
                  <option value="2018" @if (request()->filled('tahun') == 2018) selected @endif>2018</option>                 
                  <option value="2019" @if (request()->filled('tahun') == 2019) selected @endif>2019</option>                 
                  <option value="2020" @if (request()->filled('tahun') == 2020) selected @endif>2020</option>                 
                  <option value="2021" @if (request()->filled('tahun') == 2021) selected @endif>2021</option>                 
                </select>
                <select name="dds" id="dds" class="form-control col-sm-3">
                  <option value="">-- DDS --</option>   
                  <option value="DDS 1">DDS 1</option>   
                </select>
                <select name="status" id="status" class="form-control col-sm-3">
                  <option value="">-- Status --</option>     
                  <option value="0" @if (request()->filled('tahun') == 0) selected @endif>On Time</option>     
                  <option value="1" @if (request()->filled('tahun') == 1) selected @endif>Delay 1h</option>     
                  <option value="2" @if (request()->filled('tahun') == 2) selected @endif>Delay 2h</option>     
                  <option value="3" @if (request()->filled('tahun') == 3) selected @endif>Delay 3h</option>     
                  <option value="4" @if (request()->filled('tahun') == 4) selected @endif>Delay >3h</option>     
                  <option value="delay">Belum terkirim</option>     
                </select>   
                <div class="col-sm-12 text-right">
                  <button type="submit" class="btn btn-sm btn-primary">Filter</button>
                  <a href="/delivery" class="btn btn-sm btn-danger">Clear</a>                
                </div>
                </div>
                </form>     
                
          </div>  
      </div>    
      <div class="card-body table-responsive">
        <table class="table table-hover">
        <!-- <table class="table table-borderless"> -->
          <thead class="text-danger">
            <th>AWB</th>
            <th>Kode</th>
            <th>Dealer</th>
            <th>Tanggal DS</th>
            <th>DDS</th>
            <th>Status</th>   
            <th>Detail</th>
          </thead>
          
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
            @if (count($awbs) == null)
              <tbody>
                <tr class="text-center">
                  <td colspan="6"><h4>Data tidak ditemukan.</h4></td>
                </tr>
              </tbody>
            @else
              @foreach ($awbs as $awb)
              <tbody>
                <tr>
                  <td>{{$awb->no_awb}}</td>
                  <td>{{$awb->kode_dealer}}</td>
                  <td>{{$awb->nama_dealer}}</td>
                  <td>{{$awb->tanggal_ds}}</td>
                  <td>{{$awb->dds}}</td>
                  <td>
                    @if ($awb->status <> null)
                      <span class="badge badge-success">AWB telah sampai</span>                   
                    @else
                      <span class="badge badge-warning">AWB sedang dikirim</span>
                    @endif
                  </td>
                  <td>
                    <div class="">
                        <a href="/delivery/detail/{{$awb->no_awb}}" class="badge badge-round badge-primary"><i class="material-icons">pending</i></a>
                    </div>
                  </td>
                </tr>
              @endforeach
            @endif
            
          </tbody>
        </table>
        {{$awbs->links()}}
      </div>
      
    </div>
  </div> 
</div>  

<script>
// $(document).ready(function(){
//     var str=  $("#search").val();
	  
// 			$.get( "{{ url('/delivery/search?cari=') }}"+str, function( data ) {
// 			$( "#mydata" ).html( data );  
// 	    });
      
//     });

//   $(document).ready(function(){
// 	$("#search").keyup(function(){
// 	  var str=  $("#search").val();
//     var bulan=  $("#bulan").val();
//     var tahun= $("#tahun").val();
//     var dds= $("#dds").val();
//     var status= $("#status").val();
	  

// 		$.get( "{{ url('/delivery/search?cari=') }}"+str+"&&"+"bulan="+bulan+"&&"+"tahun="+tahun+"&&"+"status="+status, function( data ) {
// 			$( "#mydata" ).html( data );  
// 	    });
	  
// 	});  
//   }); 


// $(document).ready(function(){
// 	$(".filter").click(function(){
// 	  var str=  $("#dealer").val();
// 	  var str1=  $("#dds").val();
//     var str2=  $("#status").val();
   
	  
// 		$.get( "{{ url('/delivery/filter?dealer=') }}"+str+"&&"+"dds="+str1+"&&"+"status="+str2, function( data ) {
// 			$( "#mydata" ).html( data );  
// 	  });
	  
// 	});  
//   }); 
</script>
@endsection