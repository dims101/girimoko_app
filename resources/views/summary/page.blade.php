  


<div class="row">

    <div class="col-sm-3">        
        <div class="card">
            <div class="card-header card-header-info">   
                <h5 class="card-title text-center">DDS 1</h5> 
            </div>                        
            <div class="card-body">
                <div class="progress mx-auto" data-value='70'>
                <span class="progress-left">
                    <span class="progress-bar border-warning"></span>
                </span>
                <span class="progress-right">
                    <span class="progress-bar border-warning"></span>
                </span>
                <div class="progress-value w-100 h-100 rounded-circle d-flex align-items-center justify-content-center">
                    <div class="h2 font-weight-bold mt-4 ml-2">70<sup class="small">%</sup></div>
                </div>
                </div>
                
                <p class="card-text text-center font-weight-bold mt-3">TAMBUN</p>  

                <div class="text-right">
                    <a href="/detail/tambun" class="btn btn-round btn-primary">Detail</a>
                </div>
                
            </div>
        </div>
    </div>

    <div class="col-sm-3">        
        <div class="card">
            <div class="card-header card-header-info">   
                <h5 class="card-title text-center">DDS 2</h5> 
            </div>                        
            <div class="card-body">
                <div class="progress mx-auto" data-value='60'>
                <span class="progress-left">
                    <span class="progress-bar border-warning"></span>
                </span>
                <span class="progress-right">
                    <span class="progress-bar border-warning"></span>
                </span>
                <div class="progress-value w-100 h-100 rounded-circle d-flex align-items-center justify-content-center">
                    <div class="h2 font-weight-bold mt-4 ml-2">60<sup class="small">%</sup></div>
                </div>
                </div>
                
                <p class="card-text text-center font-weight-bold mt-3">BANDUNG</p>  

                <div class="text-right">
                    <a href="/detail/bandung" class="btn btn-round btn-primary">Detail</a>
                </div>
                
            </div>
        </div>
    </div>

    <div class="col-sm-3">        
        <div class="card">
            <div class="card-header card-header-info">   
                <h5 class="card-title text-center">DDS 3</h5> 
            </div>                        
            <div class="card-body">
                <div class="progress mx-auto" data-value='80'>
                <span class="progress-left">
                    <span class="progress-bar border-warning"></span>
                </span>
                <span class="progress-right">
                    <span class="progress-bar border-warning"></span>
                </span>
                <div class="progress-value w-100 h-100 rounded-circle d-flex align-items-center justify-content-center">
                    <div class="h2 font-weight-bold mt-4 ml-2">80<sup class="small">%</sup></div>
                </div>
                </div>
                
                <p class="card-text text-center font-weight-bold mt-3">PEMALANG</p>  

                <div class="text-right">
                    <a href="/detail/pemalang" class="btn btn-round btn-primary">Detail</a>
                </div>
                
            </div>
        </div>
    </div>

    <div class="col-sm-3">        
        <div class="card">
            <div class="card-header card-header-info">   
                <h5 class="card-title text-center">DDS 3</h5> 
            </div>                        
            <div class="card-body">
                <div class="progress mx-auto" data-value='75'>
                <span class="progress-left">
                    <span class="progress-bar border-warning"></span>
                </span>
                <span class="progress-right">
                    <span class="progress-bar border-warning"></span>
                </span>
                <div class="progress-value w-100 h-100 rounded-circle d-flex align-items-center justify-content-center">
                    <div class="h2 font-weight-bold mt-4 ml-2">75<sup class="small">%</sup></div>
                </div>
                </div>
                
                <p class="card-text text-center font-weight-bold mt-3">SEMARANG</p>  

                <div class="text-right">
                    <a href="/detail/semarang" class="btn btn-round btn-primary">Detail</a>
                </div>
                
            </div>
        </div>
    </div>

    <div class="col-sm-3">        
        <div class="card">
            <div class="card-header card-header-info">   
                <h5 class="card-title text-center">DDS 3</h5> 
            </div>                        
            <div class="card-body">
                <div class="progress mx-auto" data-value='82'>
                <span class="progress-left">
                    <span class="progress-bar border-warning"></span>
                </span>
                <span class="progress-right">
                    <span class="progress-bar border-warning"></span>
                </span>
                <div class="progress-value w-100 h-100 rounded-circle d-flex align-items-center justify-content-center">
                    <div class="h2 font-weight-bold mt-4 ml-2">82<sup class="small">%</sup></div>
                </div>
                </div>
                
                <p class="card-text text-center font-weight-bold mt-3">SOLO</p>  

                <div class="text-right">
                    <a href="/detail/solo" class="btn btn-round btn-primary">Detail</a>
                </div>
                
            </div>
        </div>
    </div>

</div>



<script class="">
    $(function() {

        $(".progress").each(function() {

            var value = $(this).attr('data-value');
            var left = $(this).find('.progress-left .progress-bar');
            var right = $(this).find('.progress-right .progress-bar');

            if (value > 0) {
                if (value <= 50) {
                right.css('transform', 'rotate(' + percentageToDegrees(value) + 'deg)')
                } else {
                right.css('transform', 'rotate(180deg)')
                left.css('transform', 'rotate(' + percentageToDegrees(value - 50) + 'deg)')
                }
            }

        })

        function percentageToDegrees(percentage) {

        return percentage / 100 * 360

        }

    });
</script>