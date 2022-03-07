
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
            @if(!request()->get('keyword'))
            <input type="text" name="keyword" class="form-control col-sm-10" placeholder="Masukan nomor proforma" id="search">
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
                  <option value="01" <?=request()->get('bulan') == "01" ? 'selected' : '' ?> >Januari</option>  
                  <option value="02" <?=request()->get('bulan') == "02" ? 'selected' : '' ?> >Februari</option>  
                  <option value="03" <?=request()->get('bulan') == "03" ? 'selected' : '' ?> >Maret</option>  
                  <option value="04" <?=request()->get('bulan') == "04" ? 'selected' : '' ?> >April</option>                                      
                  <option value="05" <?=request()->get('bulan') == "05" ? 'selected' : '' ?> >Mei</option>                                      
                  <option value="06" <?=request()->get('bulan') == "06" ? 'selected' : '' ?> >Juni</option>                                      
                  <option value="07" <?=request()->get('bulan') == "07" ? 'selected' : '' ?> >Juli</option>                                      
                  <option value="08" <?=request()->get('bulan') == "08" ? 'selected' : '' ?> >Agustus</option>                                      
                  <option value="09" <?=request()->get('bulan') == "09" ? 'selected' : '' ?> >September</option>                                      
                  <option value="10" <?=request()->get('bulan') == "10" ? 'selected' : '' ?> >Oktober</option>                                      
                  <option value="11" <?=request()->get('bulan') == "11" ? 'selected' : '' ?> >November</option>                                      
                  <option value="12" <?=request()->get('bulan') == "12" ? 'selected' : '' ?> >Desember</option>                                      
                </select>
                <select name="tahun" id="tahun" class="form-control col-sm-3">
                  <option value="">-- Tahun --</option>              
                  <option value="2020" @if (request()->get('tahun') == 2020) selected @endif>2020</option>                 
                  <option value="2021" @if (request()->get('tahun') == 2021) selected @endif>2021</option>                 
                  <option value="2022" @if (request()->get('tahun') == 2022) selected @endif>2022</option>                 
                  <option value="2023" @if (request()->get('tahun') == 2023) selected @endif>2023</option>                 
                </select>
                <select name="dds" id="dds" class="form-control col-sm-3">
                  <option value="">-- DDS --</option>   
                  <option value="DDS 1 Tambun">DDS 1 Tambun</option>   
                  <option value="DDS 2 Tambun">DDS 2 Tambun</option>   
                  <option value="DDS 2 Bandung">DDS 2 Bandung</option>   
                  <option value="DDS 3 Pemalang">DDS 3 Pemalang</option>   
                  <option value="DDS 3 Semarang">DDS 3 Semarang</option>   
                  <option value="DDS 3 Solo">DDS 3 Solo</option>   
                </select>
                <select name="status" id="status" class="form-control col-sm-3">
                  <option value="" <?=request()->get('status') == null ? 'selected' : '' ?> >-- Status --</option>     
                  <option value="0" <?=request()->get('status') == "0" ? 'selected' : '' ?> >On Time</option>     
                  <option value="1" <?=request()->get('status') == "1" ? 'selected' : '' ?> >Delay 1h</option>     
                  <option value="2" <?=request()->get('status') == "2" ? 'selected' : '' ?> >Delay 2h</option>     
                  <option value="3" <?=request()->get('status') == "3" ? 'selected' : '' ?> >Delay 3h</option>     
                  <option value="4" <?=request()->get('status') == "4" ? 'selected' : '' ?> >Delay >3h</option>     
                  <option value="delay" <?=request()->get('status') == "delay" ? 'selected' : '' ?>>Belum terkirim</option>     
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
            <th>Proforma</th>
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
                  <td colspan="8"><h4>Data tidak ditemukan.</h4></td>
                </tr>
              </tbody>
            @else
              @foreach ($awbs as $awb)
              <tbody>
                <tr>
                  <td>{{$awb->no_proforma}}</td>
                  <td>{{$awb->kode_dealer}}</td>
                  <td>{{$awb->nama_dealer}}</td>
                  <td>{{$awb->tanggal_ds}}</td>
                  <td>{{$awb->dds}}</td>
                  <td>
                    @if ($awb->status <> null)
                      <span class="badge badge-success">Awb has arrived</span>                           
                      @if ($awb->total_koli - $awb->koli == 0)
                        <br>
                        <span class="badge badge-info">Completed</span>  
                      @else
                        <br>
                        <span class="badge badge-danger">Not Completed</span>  
                      @endif              
                    @else
                      <span class="badge badge-warning">Awb on delivery</span>
                    @endif
                    
                  </td>
                  <td>
                    <div class="">
                        <a href="/delivery/detail/{{$awb->no_proforma}}" class="badge badge-round badge-primary"><i class="material-icons">pending</i></a>
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