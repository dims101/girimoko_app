@extends('layouts.app', [
  'activePage' => 'dashboard', 
  'titlePage' => __('Import AWB')
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
        <h4 class="card-title"><span>Import AWB</span></h4>
      </div>

    <div class="card-body row">
      <form method="post" action="/awb/import" enctype="multipart/form-data">
        @csrf
        <div class="card-body row ml-2">
          <input type="file" name="file" required="required">
            <button type="submit" class="btn btn-warning">Import</button>
        </div>          
      </form>

      
      <div class="card-body table-responsive">
      <table class='table table-hover'>
			<thead class="text-primary">
				<tr>
					<th>No</th>
					<th>No Awb</th>
					<th>No DDS</th>
					<th>Kode Dealer</th>
          <th>Tanggal DDS</th>
          <th>Status</th>
          <th>keterangan</th>
          <th>Id Pengiriman</th>
				</tr>
			</thead>
			<tbody>
			
				<tr>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
				</tr>
			
			</tbody>
		</table>
    </div>



    </div>
    </div>
  </div>
</div>


    <!-- Optional JavaScript; choose one of the two! -->

    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js" integrity="sha384-JEW9xMcG8R+pH31jmWH6WWP0WintQrMb4s7ZOdauHnUtxwoG2vI5DkLtS3qm9Ekf" crossorigin="anonymous"></script>

    <!-- Option 2: Separate Popper and Bootstrap JS -->
    <!--
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.1/dist/umd/popper.min.js" integrity="sha384-SR1sx49pcuLnqZUnnPwx6FCym0wLsk5JZuNx2bPPENzswTNFaQU1RDvt3wT4gWFG" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.min.js" integrity="sha384-j0CNLUeiqtyaRmlzUHCPZ+Gy5fQu0dQ6eZ/xAww941Ai1SxSY+0EQqNXNE6DZiVc" crossorigin="anonymous"></script>
    -->
    @endsection