@extends('layouts.app', [
  'activePage' => 'dealer', 
  'titlePage' => __('Dealer')
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
        <div class="row">
            <div class="col-md-6">
            <h4 class="card-title"><span>Data Dealer</span></h4>
            </div>
            <div class="col-md-6 text-right">
                <a  href="/add-dealer" class="btn btn-sm btn-success"><i class="material-icons">add</i> Tambah Dealer</a>
            </div>
        </div>
        
      </div>

    <div class="card-body">
    <div class="card-body table-responsive">
      <table class='table table-hover'>
			<thead class="text-primary">
				<tr>
					<th>No</th>
					<th>Kode</th>
					<th>Nama Dealer</th>
					<th>Alamat</th>
          <th>Kota</th>
          <th>Pos</th>
          <th>DDS</th>
          <th>Depo</th>
          <th>Rayon</th>
          <th>Opsi</th>
				</tr>
			</thead>
			<tbody>
      @php 
        $i=1 
      @endphp
      @foreach($dealer as $d)
				<tr>
					<td>{{ $i++ }}</td>
					<td>{{$d->kode_dealer}}</td>
					<td>{{$d->nama_dealer}}</td>
					<td>{{$d->alamat}}</td>
          <td>{{$d->kota}}</td>
          <td>{{$d->kodepos}}</td>
          <td>{{$d->dds}}</td>
          <td>{{$d->depo}}</td>
          <td>{{$d->rayon}}</td>
          <td>
          <div class="">
            <a href="dealer/{{ $d->id }}/edit" class="badge badge-sm badge-round badge-info"><i class="material-icons">drive_file_rename_outline</i></a>
            <form action="dealer/{{ $d->id }}" method="post" >    
              @method('delete')
              @csrf  
              <!-- <a href="dealer/{{ $d->id }}" class="badge badge-round badge-danger" onclick="return confirm('Yakin menghapus?');"><i class="material-icons" >delete_outline</i></a> -->
              <button type="submit" name="submit" class="badge badge-sm badge-round badge-danger" onclick="return confirm('Yakin menghapus?');"><i class="material-icons" >delete_outline</i></button>
            </form>          
          </div>
          </td>
				</tr>
      @endforeach
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