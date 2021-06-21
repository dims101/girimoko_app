<script src="{{ asset('js') }}/highcharts.js"></script>
<script src="{{ asset('js') }}/modules/data.js"></script>
<script src="{{ asset('js') }}/modules/drilldown.js"></script>
<script src="{{ asset('js') }}/modules/exporting.js"></script>
<script src="{{ asset('js') }}/modules/export-data.js"></script>
<script src="{{ asset('js') }}/modules/accessibility.js"></script>

<script>

Highcharts.chart('container-2', {
  
  chart: {
    height: 190,
    type: 'pie',
    
  },
  title: {
    text: ''
  },
  subtitle: {
    text: ''
  },
  accessibility: {
    announceNewData: {
      enabled: true
    },
    point: {
      valueSuffix: '%'
    }
  },

  plotOptions: {
    series: {
      dataLabels: {
        enabled: true,
        format: '<b>{point.name}</b><br><span style="font-size:14px">{point.y} %</span></b> <br/>',
        // format: '<b>{point.name}</b><br>{point.y}</b> %<br/>',
        distance: -35
      }
    }
  },

  tooltip: {
    headerFormat: '<span style="font-size:11px">{series.name}</span><br>',
    pointFormat: '<span style="color:{point.color}">{point.name}</span>: <b>{point.y}</b> %<br/>'
  },

  series: [
    {
      name: "AWB",
      colorByPoint: true,
      data: [
        {
          name: "Terkirim",
          y: {{$data['terkirim']}},
        },
        {
          name: "Belum <br>terkirim",
          y: {{$data['tertunda']}},
        }
      ]
    }
  ]
});
</script>




<script>

    Highcharts.chart('container-3', {
  chart: {
    height: 190,
    type: 'column'
  },
  title: {
    text: 'AWB Terkirim'
  },
  subtitle: {
    text: ''
  },
  accessibility: {
    announceNewData: {
      enabled: true
    }
  },
  xAxis: {
    type: 'category'
  },
  yAxis: {
    title: {
      text: 'Jumlah'
    }

  },
  legend: {
    enabled: false
  },
  plotOptions: {
    series: {
      borderWidth: 0,
      dataLabels: {
        enabled: true,
        format: '{point.y} %'
      }
    }
  },

  tooltip: {
    headerFormat: '<span style="font-size:11px">{series.name}</span><br>',
    pointFormat: '<span style="color:{point.color}">{point.name}</span>: <b>{point.y} %</b>'
  },

  series: [
    {
      name: "Total AWB",
      colorByPoint: true,
      data: [
        {
          name: "DDS1 Tambun",
          y: <?=$awb_dds[0]?>,
          drilldown: "DDS1 Tambun"
        },
        {
          name: "DDS2 Bandung",
          y: <?=$awb_dds[1]?>,
          drilldown: "DDS2 Bandung"
        },
        {
          name: "DDS3 Purwokerto",
          y: <?=$awb_dds[2]?>,
          drilldown: "DDS3 Purwokerto"
        },
        {
          name: "DDS3 Semarang",
          y: <?=$awb_dds[3]?>,
          drilldown: "DDS3 Semarang"
        },
        {
          name: "DDS3 Solo",
          y: <?=$awb_dds[4]?>,
          drilldown: "DDS3 Solo"
        }
        
      ]
    }
  ],
  drilldown: {
    series: [
      {
      }
       
    ]
  }
});
</script>



<script>

    Highcharts.chart('container', {
  chart: {
    type: 'column'
  },
  title: {
    text: 'AWB yang Belum Terkirim Bulan ini'
  },
  subtitle: {
    text: ''
  },
  accessibility: {
    announceNewData: {
      enabled: true
    }
  },
  xAxis: {
    type: 'category'
  },
  yAxis: {
    title: {
      text: 'Jumlah'
    }

  },
  legend: {
    enabled: false
  },
  plotOptions: {
    series: {
      borderWidth: 0,
      dataLabels: {
        enabled: true,
        format: '{point.y}'
      }
    }
  },

  tooltip: {
    headerFormat: '<span style="font-size:11px">{series.name}</span><br>',
    pointFormat: '<span style="color:{point.color}">{point.name}</span>: <b>{point.y}</b>'
  },

  series: [
    {
      name: "Total AWB",
      colorByPoint: true,
      data: <?=$data['awb_tertunda']?>
    }
  ],
  drilldown: {
    series: [
      {
      }
       
    ]
  }
});

</script>

