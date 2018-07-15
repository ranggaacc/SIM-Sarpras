<script type="text/javascript">
    $(function () {
        var {{ $model->id }} = new Highcharts.Chart({
            colors: [
                @foreach($model->colors as $c)
                    "{{ $c }}",
                @endforeach
            ],
            chart: {
                renderTo: "{{ $model->id }}",
                @include('charts::_partials.dimension.js2')
                plotBackgroundColor: null,
                plotBorderWidth: null,
                plotShadow: false,
                type: 'pie'
            },
            @if($model->title)
                title: {
                    text:  "{!! $model->title !!}",
                },
            @endif
            @if(!$model->credits)
                credits: {
                    enabled: false
                },
            @endif
         
            tooltip: {
                pointFormat: 
                    @if(isset($model->kondisi))
                        '{point.y} <b>Buah</strong><br>Kondisi Barang<br>B: {point.xx} | RR: {point.xy} | RB: {point.xz}'
                    @else
                        '{point.y} <b>Buah</strong><br>'
                    @endif
                // ({point.percentage:.1f}%)
            },
            plotOptions: {
                pie: {
                    allowPointSelect: true,
                    cursor: 'pointer',
                    dataLabels: {
                        enabled: true,
                        format: '<b>{point.name}</strong>: {point.y} Buah',
                        style: {
                            color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black'
                        }
                    }
                }
            },
            legend: {
                @if(!$model->legend)
                    enabled: false
                @endif
            },
            series: [{
                colorByPoint: true,
                data: [
                    @for($i = 0; $i < count($model->values); $i++)
                        {
                            name: "{!! $model->labels[$i] !!}",
                            y: {{ $model->values[$i] }},
                            @if(isset($model->kondisi))
                            xx: {{ $model->kondisi[$i][0] }},
                            xy: {{ $model->kondisi[$i][1] }},
                            xz: {{ $model->kondisi[$i][2] }},
                            @endif
                        },
                    @endfor
                ]
            }]
        })
    });
</script>

@if(!$model->customId)
    @include('charts::_partials.container.div')
@endif
