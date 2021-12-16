@extends('layouts.app', [
  'activePage' => 'tracking', 
  'titlePage' => __('Tracking AWB')
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
        <h4 class="card-title"><span>Tracking AWB</span></h4>
      </div>

    <div class="card-body">   
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    @if (Session::has('message'))
                      <div class="alert alert-success" role="alert">
                          {{Session::get('message')}}
                      </div>
                    @endif
                    <div class="row g-3 align-items-center">
                        <div class="col-auto">
                        </div>
                        <div class="col-auto">
                            <input type="text" id="ds" class="form-control" aria-describedby="passwordHelpInline" placeholder="Silahkan Masukan DS" name="track">
                        </div>
                        <div class="col-auto">
                            <button id="update" class="btn btn-sm btn-success" type="button" data-bs-toggle="modal" data-bs-target="#staticBackdrop">Track</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    </div>
  </div>
</div>
<!-- Modal -->
<div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="staticBackdropLabel">Daftar AWB dalam Delivery Sheet</h5>
        
      </div>
      <div class="modal-body">
        <div class="row">
            <div class="col-sm-12">
            <table class="table table-sm table-hover table-striped" id="myTable"> 
                <thead class="table-secondary">
                    <tr>
                        <td>No</td>
                        <td>Tanggal</td>
                        <td>AWB</td>
                        <td>Kode</td>
                        <td>Dealer</td>
                        <td>DDS</td>
                        <td>Lokasi terakhir</td>
                    </tr>
                </thead>
                <tbody>
                
                </tbody>
            </table>
            </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
        <form action="/updatelokasi" method='post'>
            @csrf
            <input type="hidden" name="ds" id="update-ds">
            <button type="submit" id="tracking" class="btn btn-primary">Update lokasi</button>
        </form>
      </div>
    </div>
  </div>
</div>
<script>
    $('#update').on('click', function(event) {
        let ds = document.getElementById("ds").value;
        $('#update-ds').val(ds);
        // alert(dds);
        // Kirim gambar dalam bentuk base64
        $.ajax({
            url: '/tracking/update',
            type: 'POST',
            dataType: 'json',
            data: {
                _token: "{{ csrf_token() }}",
                ds: $('#ds').val()
            },
            success: function(response) {
                if(Object.keys(response).length === 0){    
                  $('#myTable > tbody').empty();
                  $('#myTable > tbody:last-child').append('<tr ><td colspan="7" class="text-center">Tidak ada data!</td></tr>'); 
                  document.getElementById("tracking").disabled = true;
                } else {
                  //fungsi ada di sini
                  $('#myTable > tbody').empty();
                  var i=1;
                  $.each(response, function (index,value) {
                  $('#myTable > tbody:last-child').append('<tr><td>'+i+'</td><td>'+value['tanggal_ds']+'</td><td>'+value['no_awb']+'</td><td>'+value['kode_dealer']+'</td><td>'+value['nama_dealer']+'</td><td>'+value['dds']+'</td><td>'+value['lokasi']+'</td></tr>'); 
                  i++;
                  });
                  document.getElementById("tracking").disabled = false;
                }
                
            },
            error: function(jqXHR, status, err){
                alert(jqXHR.responseText);
                  // alert('Delivery sheet tidak ditemukan!');
            }
        });
        
    });

</script>

    <!-- Optional JavaScript; choose one of the two! -->

    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js" integrity="sha384-JEW9xMcG8R+pH31jmWH6WWP0WintQrMb4s7ZOdauHnUtxwoG2vI5DkLtS3qm9Ekf" crossorigin="anonymous"></script>

    <!-- Option 2: Separate Popper and Bootstrap JS -->
    <!--
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.1/dist/umd/popper.min.js" integrity="sha384-SR1sx49pcuLnqZUnnPwx6FCym0wLsk5JZuNx2bPPENzswTNFaQU1RDvt3wT4gWFG" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.min.js" integrity="sha384-j0CNLUeiqtyaRmlzUHCPZ+Gy5fQu0dQ6eZ/xAww941Ai1SxSY+0EQqNXNE6DZiVc" crossorigin="anonymous"></script>
    -->
    @endsection