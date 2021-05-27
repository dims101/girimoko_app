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
          <i class="material-icons">manage_search</i>
          <h4 class="card-title">&nbsp;&nbsp;Total AWB : <span>{{$awbs['total']}}</span>&nbsp;</h4> <h4> | Ontime : <span>{{$awbs['ontime']}}</span> | Delay : <span>{{$awbs['delay']}} </span> | Belum terkirim : <span>{{$awbs['belum_terkirim']}}</span></h4>             
      </div>
      <div class="card-body">
        
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