@extends('layouts.app', [
  'activePage' => 'dashboard', 
  'titlePage' => __('Halaman Utama')
  ])

  @section('content')  
  <div class="content">
  <div class="container-fluid">
    <!-- <div class="card">
    <div class="card-body">
        @if (session('status'))
            <div class="alert alert-success" role="alert">
                {{ session('status') }}
            </div>
        @endif
        <div class="containter">
         Halaman di akses oleh (<span>{{ Auth::user()->name}}</span>).
        </div>                    
    </div>
    </div> -->
    <div class="row">
        <div class="col-lg-4 col-md-6 col-sm-6">
          <div class="card card-stats">
            <div class="card-header card-header-success card-header-icon">
              <div class="card-icon">
                <i class="material-icons">content_paste</i>
                <!-- <i class="material-icons">content_copy</i> -->
              </div>
              <p class="card-title">Total AWB</p>           
            </div>
            <div class="card-body">
                <div class="green">
                    <div class="progress ml-5" style="background-color: orangered;">
                    <div class="inner">
                        <div class="text-center">
                            <p class="teks"  style="color: white; font-size: 5em; ">20</p>
                            <p class="teks2" style="color: white; font-size: 2em;">Item</p>
                        </div>
                        <!-- <div class="glare"></div> -->
                    </div>
                    </div>
                </div>
            </div>
            <div class="card-footer">
              <div class="stats">
                <i class="material-icons">repeat_one</i>
                <a href="#">Total dalam 1 hari</a>
              </div>
            </div>
          </div>
        </div>


        <div class="col-lg-4 col-md-6 col-sm-6">
          <div class="card card-stats">
            <div class="card-header card-header-danger card-header-icon">
              <div class="card-icon">
                <i class="material-icons">assessment</i>
              </div>
              <p class="card-title">AWB terkirim VS Tertunda</p>
            </div>
            <div class="card-body">                
                <figure class="highcharts-figure">
                    <div id="container-2"></div>
                </figure>
            </div>
            <div class="card-footer">
              <div class="stats">
                <i class="material-icons">bar_chart</i> Grafik Perbandingan
              </div>
            </div>
          </div>
        </div>


        <div class="col-lg-4 col-md-6 col-sm-6">
          <div class="card card-stats">
            <div class="card-header card-header-primary card-header-icon">
              <div class="card-icon">
                <i class="material-icons">app_registration</i>
              </div>
              <p class="card-title">Persentase AWB Terkirim</p>             
            </div>
            <div class="card-body">
                <div class="green">
                    <div class="progress ml-5">
                    <div class="inner">
                        <div class="percent" style="font-size: 5em;"><span>30</span>%</div>
                        <div class="water"></div>
                        <div class="glare"></div>
                    </div>
                    </div>
                </div>
            </div>
            <div class="card-footer">
              <div class="stats">
                <i class="material-icons">content_copy</i> Berdasarkan DDS
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="card">
        <div class="card-header card-header-warning row">         
            <i class="material-icons">local_shipping </i>
            <h4 class="card-title">&nbsp;&nbsp;{{ __('AWB Belum Terkirim') }}</h4>             
        </div>
        <div class="card-body">
        <figure class="highcharts-figure">
            <div id="container"></div>
        </figure>              
        </div>
        <div class="card-footer">
          <div class="stats">
            <i class="material-icons">content_copy</i> Berdasarkan DDS
          </div>
        </div>
      </div>
  </div>
</div>

@include('dashboard.rumus')


@endsection