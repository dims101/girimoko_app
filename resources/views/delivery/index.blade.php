
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
     
        <form class="navbar-form col-md-6 form-inline" action="/delivery/cari" method="get">
          <div class="input-group col-md-3">
            <select name="type" id="type" class="form-control">
              <option value="no_proforma" <?=request()->get('type') == "no_proforma" ? 'selected' : '' ?>  >No. Proforma</option>
              <option value="no_awb" <?=request()->get('type') == "no_awb" ? 'selected' : '' ?>   >No AWB</option>
              <option value="kode_dealer" <?=request()->get('type') == "kode_dealer" ? 'selected' : '' ?>  >Kode Dealer</option>
              <option value="nama_dealer" <?=request()->get('type') == "nama_dealer" ? 'selected' : '' ?>  >Nama Dealer</option>
            </select>
          </div>
          
          <div class="input-group col-md-8">
            @if(!request()->get('keyword'))
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
        <h5 class="title mt-2 col-md-1 mt-4">Filter :&nbsp;&nbsp;</h5>
            <div class="col-sm-5 row filter container mt-3">        
              <!-- <div class="row filter container"> -->
              <form action="/delivery" method="get">
              
                <div class="row">
                <select  name="hari" id="hari" class="form-control col-sm-1 mr-2">
                  <option value="">-- Hari --</option>  
                  <option value="01" <?=request()->get('hari') == "01" ? 'selected' : '' ?> >01</option>  
                  <option value="02" <?=request()->get('hari') == "02" ? 'selected' : '' ?> >02</option>  
                  <option value="03" <?=request()->get('hari') == "03" ? 'selected' : '' ?> >03</option>  
                  <option value="04" <?=request()->get('hari') == "04" ? 'selected' : '' ?> >04</option>                                      
                  <option value="05" <?=request()->get('hari') == "05" ? 'selected' : '' ?> >05</option>                                      
                  <option value="06" <?=request()->get('hari') == "06" ? 'selected' : '' ?> >06</option>                                      
                  <option value="07" <?=request()->get('hari') == "07" ? 'selected' : '' ?> >07</option>                                      
                  <option value="08" <?=request()->get('hari') == "08" ? 'selected' : '' ?> >08</option>                                      
                  <option value="09" <?=request()->get('hari') == "09" ? 'selected' : '' ?> >09</option>                                      
                  <option value="10" <?=request()->get('hari') == "10" ? 'selected' : '' ?> >10</option>                                      
                  <option value="11" <?=request()->get('hari') == "11" ? 'selected' : '' ?> >11</option>                                      
                  <option value="12" <?=request()->get('hari') == "12" ? 'selected' : '' ?> >12</option>                                      
                  <option value="13" <?=request()->get('hari') == "13" ? 'selected' : '' ?> >13</option>                                      
                  <option value="14" <?=request()->get('hari') == "14" ? 'selected' : '' ?> >14</option>                                      
                  <option value="15" <?=request()->get('hari') == "15" ? 'selected' : '' ?> >15</option>                                      
                  <option value="16" <?=request()->get('hari') == "16" ? 'selected' : '' ?> >16</option>                                      
                  <option value="17" <?=request()->get('hari') == "17" ? 'selected' : '' ?> >17</option>                                      
                  <option value="18" <?=request()->get('hari') == "18" ? 'selected' : '' ?> >18</option>                                      
                  <option value="19" <?=request()->get('hari') == "19" ? 'selected' : '' ?> >19</option>                                      
                  <option value="20" <?=request()->get('hari') == "20" ? 'selected' : '' ?> >20</option>                                      
                  <option value="21" <?=request()->get('hari') == "21" ? 'selected' : '' ?> >21</option>                                      
                  <option value="22" <?=request()->get('hari') == "22" ? 'selected' : '' ?> >22</option>                                      
                  <option value="23" <?=request()->get('hari') == "23" ? 'selected' : '' ?> >23</option>                                      
                  <option value="24" <?=request()->get('hari') == "24" ? 'selected' : '' ?> >24</option>                                      
                  <option value="25" <?=request()->get('hari') == "25" ? 'selected' : '' ?> >25</option>                                      
                  <option value="26" <?=request()->get('hari') == "26" ? 'selected' : '' ?> >26</option>                                      
                  <option value="27" <?=request()->get('hari') == "27" ? 'selected' : '' ?> >27</option>                                      
                  <option value="28" <?=request()->get('hari') == "28" ? 'selected' : '' ?> >28</option>                                      
                  <option value="29" <?=request()->get('hari') == "29" ? 'selected' : '' ?> >29</option>                                      
                  <option value="30" <?=request()->get('hari') == "30" ? 'selected' : '' ?> >30</option>                                      
                  <option value="31" <?=request()->get('hari') == "31" ? 'selected' : '' ?> >31</option>                                      
                </select>
                <select  name="bulan" id="bulan" class="form-control col-sm-2 mr-2">
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
                <select name="tahun" id="tahun" class="form-control col-sm-2 mr-2">
                  <option value="">-- Tahun --</option>              
                  <option value="2020" @if (request()->get('tahun') == 2020) selected @endif>2020</option>                 
                  <option value="2021" @if (request()->get('tahun') == 2021) selected @endif>2021</option>                 
                  <option value="2022" @if (request()->get('tahun') == 2022) selected @endif>2022</option>                 
                  <option value="2023" @if (request()->get('tahun') == 2023) selected @endif>2023</option>                 
                </select>
                <select name="dds" id="dds" class="form-control col-sm-3 mr-2">
                  <option value="">-- DDS --</option>   
                  <option value="DDS 1 Tambun">DDS 1 Tambun</option>   
                  <option value="DDS 2 Tambun">DDS 2 Tambun</option>   
                  <option value="DDS 2 Bandung">DDS 2 Bandung</option>   
                  <option value="DDS 3 Pemalang">DDS 3 Pemalang</option>   
                  <option value="DDS 3 Semarang">DDS 3 Semarang</option>   
                  <option value="DDS 3 Solo">DDS 3 Solo</option>   
                </select>
                <select name="status" id="status" class="form-control col-sm-2 mr-2">
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
                      <!-- @if ($awb->total_koli - $awb->koli == 0)
                        <br>
                        <span class="badge badge-info">Completed</span>  
                      @else
                        <br>
                        <span class="badge badge-danger">Not Completed</span>  
                      @endif               -->
                    @else
                      <span class="badge badge-warning">Awb is on delivery</span>
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