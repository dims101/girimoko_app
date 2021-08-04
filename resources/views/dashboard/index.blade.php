@extends('layouts.app', [
  'activePage' => 'dashboard', 
  'titlePage' => __('Dashboard')
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
      <div class="card">
        <div class="card-header card-header-info row">         
            <i class="material-icons mr-1">manage_search</i>
            <h4 class="card-title">Dashboard</h4>
        </div>
        <div class="card-body">
          <form action="/dashboard" method="get" class="form form-inline">
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
              <option value="2018" <?=request()->get('tahun') == "2018" ? 'selected' : '' ?>>2018</option>
              <option value="2019" <?=request()->get('tahun') == "2019" ? 'selected' : '' ?>>2019</option>
              <option value="2020"<?=request()->get('tahun') == "2020" ? 'selected' : '' ?>>2020</option>
              <option value="2021"<?=request()->get('tahun') == "2021" ? 'selected' : '' ?>>2021</option>
            </select>
            <button  type="submit" class="btn btn-sm btn-warning ml-2 mb-2">Ubah</button>
            <a style="margin-top:0px" href="/dashboard" class="ml-2 btn btn-sm btn-success">Bulan ini</a>
          </form>
        </div>                       
      </div>  
    <!-- <div class="col-lg-6 col-md-4 col-sm-4">
      <div class="card card-body">
        <label for="" class="card-title">Dashboard pada :</label>
        <form action="" class="form form-inline">
          <select name="bulan" class="form-control form-control mb-2 mr-sm-2">
            <option value="">--Bulan--</option>
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
        </form>
      </div>
    </div> -->
    <div class="row">
        <div class="col-lg-3 col-md-4 col-sm-4">
          <div class="card card-stats">
            <div class="card-header card-header-success card-header-icon">
              <div class="card-icon">
                <!-- <i class="material-icons">content_paste</i> -->
                <i class="material-icons">content_copy</i>
              </div>
              <p class="card-title">{{ __('Total AWB') }}</p>           
            </div>
            <div class="card-stats mt-3">
                <div class="green">
                    <div class="progress ml-5" style="background-color: orangered;">
                    <div class="inner">
                        <div class="text-center">
                            <p class="teks"  style="color: white; font-size: 3em; ">{{$data['total']}}</p>
                            <p class="teks2" style="color: white; font-size: 1.5em;">Item</p>
                        </div>
                        <!-- <div class="glare"></div> -->
                    </div>
                    </div>
                </div>
            </div>
            <div class="card-footer mt-4">
              <div class="stats">
                <i class="material-icons">repeat_one</i>
                <a href="#">Total bulan ini</a>
              </div>
            </div>
          </div>
        </div>

        <div class="col-lg-3 col-md-4 col-sm-4">
          <div class="card card-stats">
            <div class="card-header card-header-danger card-header-icon">
              <div class="card-icon">
                <i class="material-icons">app_registration</i>
              </div>
              <p class="card-title">{{ __('AWB Terkirim VS Sedang dikirim') }}</p>
            </div>
            <div class="">                
                <figure class="highcharts-figure">
                    <div id="container-2"></div>
                </figure>
            </div>
            <div class="card-footer">
              <div class="stats">
                <i class="material-icons">content_copy</i> Berdasarkan DDS
              </div>
            </div>
          </div>
        </div>


        <div class="col-lg-6 col-md-4 col-sm-4">
          <div class="card card-stats">
            <div class="card-header card-header-primary card-header-icon">
              <div class="card-icon">
                <i class="material-icons">assessment</i>
              </div>
              <p class="card-title">{{ __('Persentase AWB Terkirim') }}</p>             
            </div>
            <div class="">
              <figure class="highcharts-figure">
                  <div id="container-3"></div>
              </figure>              
            </div>
            <div class="card-footer">
              <div class="stats">
                <i class="material-icons">bar_chart</i> Grafik Perbandingan               
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
