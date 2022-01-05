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
    
  <div class="container">
    <div class="card">
      <div class="card-header card-header-warning row">         
          <div class="col-md-8">
            <table style="margin-bottom:-1em;margin-top:-1em" class="table table-sm">
                <tr>
                  <td><i class="material-icons">manage_search</i></td>
                  <td class="h4">Total Proforma : {{$proformas['total']}}</td>
                  <td class="h4">Ontime : {{$proformas['ontime']}}</td>
                  <td class="h4">Delay : {{$proformas['delay']}}</td>
                  <td class="h4">Sedang dikirim : {{$proformas['belum_terkirim']}}</td>
                </tr>
            </table>
          </div>
      </div>
      <div class="card-body">
      <form action="/summary" method="get" class="form form-inline">
              <label for="" class="card-subtitle mr-2">Filter</label>
            <select name="bulan" class="ml-2 form-control form-control mb-2 mr-sm-2">
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
            <select class="ml-2 form-control form-control mb-2 mr-sm-2" name="tahun" id="">
              <option value="">-- Tahun --</option>
              <option value="2021"<?=request()->get('tahun') == "2021" ? 'selected' : '' ?>>2021</option>
              <option value="2022"<?=request()->get('tahun') == "2022" ? 'selected' : '' ?>>2022</option>
            </select>
            <button  type="submit" class="btn btn-sm btn-warning ml-2 mb-2">Ubah</button>
            <a style="margin-top:0px" href="/summary" class="ml-2 btn btn-sm btn-success">Bulan ini</a>
          </form>
      </div>                       
    </div>   
  </div>  

  <div class="container" id="mydata">
    @include('summary.page')
  </div>
       
<script>
  $(document).ready(function(){
    var str=  $("#search").val();
	  
			$.get( "{{ url('/pengiriman/search?cari=') }}"+str, function( data ) {
			$( "#mydata" ).html( data );  
	    });
      
    });

  $(document).ready(function(){
	$("#search").keyup(function(){
	  var str=  $("#search").val();
    var tahun=  $("#tahun").val();
    var plant= $("#plant").val();
    var status= $("#status").val();
	  
			$.get( "{{ url('/pengiriman/search?cari=') }}"+str+"&&"+"tahun="+tahun+"&&"+"plant="+plant+"&&"+"status="+status, function( data ) {
			$( "#mydata" ).html( data );  
	    });
	  
	});  
  }); 

  $(document).ready(function(){
	$(".filter").click(function(){
	  var str=  $("#tahun").val();
	  var str1=  $("#plant").val();
    var str2=  $("#status").val();
    var cari=  $("#search").val();
	  
		$.get( "{{ url('/pengiriman/filter?tahun=') }}"+str+"&&"+"plant="+str1+"&&"+"status="+str2+"&&"+"cari="+cari, function( data ) {
			$( "#mydata" ).html( data );  
	  });
	  
	});  
  }); 
  

  

$(document).ready(function(){
 
//   $(document).on('click', '#.filter', function(){
//     var str=  $("#tahun").val();
// 	  var str1=  $("#plant").val();
//     var str2=  $("#status").val();
//   fetch_data(str, str1, str2);
//  });

$(document).on('click', '.pagination a', function(event){
 event.preventDefault(); 
 var page = $(this).attr('href').split('page=')[1];
 var tahun =$("#tahun").val();
 var plant= $("#plant").val();
 var status= $("#status").val();
 var str=  $("#search").val();
 fetch_data(page, tahun, plant, status, str);
});

function fetch_data(page,tahun, plant, status, str)
{
 $.ajax({
  url:"/pagination/fetch_data?page="+page+"&tahun="+tahun+"&plant="+plant+"&status="+status+"&cari="+str,
  success:function(data)
  {
   $('#mydata').html(data);
  }
 });
}


});

</script>
@endsection