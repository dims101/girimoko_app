
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
            <input type="text" name="keyword" class="form-control col-sm-10" placeholder="Masukan kata kunci pencarian" id="search">
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
                  <option value="01">Januari</option>  
                  <option value="02">Februari</option>  
                  <option value="03">Maret</option>  
                  <option value="04">April</option>  
                  <option value="05">Mei</option> 
                  <option value="06">Juni</option>  
                  <option value="07">Juli</option>  
                  <option value="08">Agustus</option>
                  <option value="09">September</option>
                  <option value="10">Oktober</option>  
                  <option value="11">November</option>  
                  <option value="12">Desember</option>                                         
                </select>
                <select name="tahun" id="tahun" class="form-control col-sm-3">
                  <option value="">-- Tahun --</option>                 
                  <option value="2018">2018</option>                 
                  <option value="2019">2019</option>                 
                  <option value="2020">2020</option>                 
                  <option value="2021">2021</option>                 
                </select>
                <select name="dds" id="dds" class="form-control col-sm-3">
                  <option value="">-- DDS --</option>   
                  <option value="DDS 1">DDS 1</option>   
                </select>
                <select name="status" id="status" class="form-control col-sm-3">
                  <option value="0">-- Status --</option>     
                  <option value="1">On Time</option>     
                  <option value="2">Delay 1h</option>     
                  <option value="3">Delay 2h</option>     
                  <option value="4">Delay 3h</option>     
                  <option value="5">Delay >3h</option>     
                  <option value="">Belum terkirim</option>     
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