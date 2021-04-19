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
        format: '<b>{point.name}</b><br><span style="font-size:15px">{point.y} %</span></b> <br/>',
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
          y: 6,
        },
        {
          name: "Tertunda",
          y: 14,
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
          y: 30,
          drilldown: "DDS1 Tambun"
        },
        {
          name: "DDS2 Bandung",
          y: 45,
          drilldown: "DDS2 Bandung"
        },
        {
          name: "DDS3 Purwokerto",
          y: 20,
          drilldown: "DDS3 Purwokerto"
        },
        {
          name: "DDS3 Semarang",
          y: 28,
          drilldown: "DDS3 Semarang"
        },
        {
          name: "DDS3 Solo",
          y: 25,
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
    text: 'AWB yang Belum Terkirim Tanggal Sebelumnya'
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
      data: [
        {
          name: "06/04/2021",
          y: 7,
          drilldown: "06/04/2021"
        },
        {
          name: "07/04/2021",
          y: 5,
          drilldown: "07/04/2021"
        },
        {
          name: "08/04/2021",
          y: 9,
          drilldown: "08/04/2021"
        },
        {
          name: "09/04/2021",
          y: 6,
          drilldown: "09/04/2021"
        },
        {
          name: "10/04/2021",
          y: 4,
          drilldown: "10/04/2021"
        },
        {
          name: "11/04/2021",
          y: 5,
          drilldown: "11/04/2021"
        },
        {
          name: "12/04/2021",
          y: 8,
          drilldown: "12/04/2021"
        },
        {
          name: "13/04/2021",
          y: 6,
          drilldown: "13/04/2021"
        },
        {
          name: "14/04/2021",
          y: 7,
          drilldown: "14/04/2021"
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

