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
                  <td class="text-center">{{$data['rayon'][$i]}}</td>
                  <td class="text-center">{{$data['ontime'][$i]}}</td>
                  <td class="text-center">{{$data['delay1'][$i]}}</td>
                  <td class="text-center">{{$data['delay2'][$i]}}</td>
                  <td class="text-center">{{$data['delay3'][$i]}}</td>
                  <td class="text-center">{{$data['delay4'][$i]}}</td>
                  <td class="text-center">{{$data['tunda'][$i]}}</td>
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
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">New message</h5>
        type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form>
          <div class="form-group">
            <label for="recipient-name" class="col-form-label">Recipient:</label>
            <input type="text" class="form-control" id="recipient-name">
          </div>
          <div class="form-group">
            <label for="message-text" class="col-form-label">Message:</label>
            <textarea class="form-control" id="message-text"></textarea>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Send message</button>
      </div>
    </div>
  </div>
</div>
<script type="text/javascript">
//   $('#exampleModal').on('click', function (event) {
//   var button = $(event.relatedTarget) // Button that triggered the modal
//   var recipient = a.data('whatever') // Extract info from data-* attributes
//   // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
//   // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
//   var modal = $(this)
//   modal.find('.modal-title').text('New message to ' + recipient)
//   modal.find('.modal-body input').val(recipient)
// })
$('#exampleModal').on('show.bs.modal', function () {
  alert('me') 
});
</script>
@endsection