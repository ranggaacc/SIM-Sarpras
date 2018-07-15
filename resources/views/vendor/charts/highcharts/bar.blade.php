<script type="text/javascript">
    $(function () {
        var {{ $model->id }} = new Highcharts.Chart({
            colors: [
                @foreach($model->colors as $c)
                    "{{ $c }}",
                @endforeach
            ],
            chart: {
                renderTo:  "{{ $model->id }}",
                @include('charts::_partials.dimension.js2')
                plotBackgroundColor: null,
                plotBorderWidth: null,
                plotShadow: false,
                type: 'column'
            },
            @if($model->title)
                title: {
                    text:  "{!! $model->title !!}"
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
                series: {
                    colorByPoint: true,
                },
                bar: {
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
            }],            
            xAxis: {
                title: {
                    text: "{!! $model->x_axis_title !!}"
                },
                categories: [
                    @foreach($model->labels as $label)
                         "{!! $label !!}",
                    @endforeach
                ],
            },
            yAxis: {
                title: {
                    text: "{!! $model->y_axis_title === null ? $model->element_label : $model->y_axis_title !!}"
                },
            },
            legend: {
                @if(!$model->legend)
                    enabled: false,
                @endif
            },
            series: [{
                name: "{!! $model->element_label !!}",
                data: [
                    @foreach($model->values as $dta)
                        {{ $dta }},
                    @endforeach
                ]
            }]
        })
    });
</script>

@if(!$model->customId)
    @include('charts::_partials.container.div')
@endif
