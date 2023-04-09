@extends('layouts.app')

@section('content')
<section class="section">
    <h1 class="title text-center pt-5 px-2">{{ $title }}</h1>
    <h3 class="fw-bold text-center px-2 pb-3">Mantenedor de datos históricos</h3>
    <div class="section-body">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="pb-2 d-flex">
                                <p class="me-auto my-auto">Datos obtenidos de: <a href="https://{{$source}}" target="_newblank">{{$source}}</a></p>
                                <button class="btn btn-warning" onclick="createUF()"><i class="fas fa-plus"></i> Nuevo</button>
                            </div>
                            <div class="table-responsive mt-2">
                                <table class="table table-striped mt-2 border">
                                    <thead style="background-color:#6777ef">
                                        <th style="display: none;">ID</th>
                                        <th class="text-white text-center fw-bold">Fecha</th>
                                        <th class="text-white text-center fw-bold">Valor en {{$currency}}</th>
                                        <th class="text-white text-center fw-bold">Acciones</th>
                                    </thead>
                                    <tbody>
                                        @foreach ($ufs as $uf)
                                        @php
                                            $newDate = strtotime($uf->date);
                                        @endphp
                                        <tr>
                                            <td style="display: none;">{{ $uf->id }}</td>
                                            <td class="text-center">{{ date('d-m-Y', $newDate);}}</td>
                                            <td class="text-center">{{ $uf->value }}</td>
                                            <td class="text-center">
                                                <button type="submit" class="btn btn-warning" onclick="showUF({{$uf->id}})"><i class="fa fa-eye"></i></button>
                                                <button type="submit" class="btn btn-info" onclick="editUF({{$uf->id}})"><i class="fa fa-pen"></i></button>
                                                <button type="submit" class="btn btn-danger deleteUF" value="{{$uf->id}}"><i class="fa fa-trash"></i></button>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                <div class="pagination d-flex flex-wrap">
                                    {!! $ufs->links() !!}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row py-5">
                <h2 class="fw-bold text-center px-2 pb-3">Gráfica en el tiempo</h2>
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-6 my-auto">
                                <div class="form-group pb-5">
                                    <label for="date_range">Seleccione intervalo:</label>
                                    <input type="text" name="dateRange" id="dateRange" class="form-control">
                                </div>
                            </div>
                        </div>
                        <div class="container mb-5">
                            <div id="chart" class=" d-none w-100" style="height:400px;"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- MODAL DE FORM DE CREACIÓN Y EDICIÓN -->
<div class="modal fade" id="createModal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h4 id="modalTitle2" class="text-center text-white m-auto fw-bold">NUEVO REGISTRO</h4>
            </div>
            <div class="modal-body">
                <div class="pb-3" id="errors"></div>
                <form id="create-form">
                    @csrf
                    <input type="hidden" name="updateId" id="updateId">
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-outline">
                                <input type="number" name="value" id="value" class="form-control" step="0.01" onChange="format"  pattern="[0-9]+([\.][0-9]+)?" required/>
                                <label class="form-label" for="value">Valor de UF el día de hoy</label>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12 pt-4">
                            <div class="form-outline">
                                <input type="date" name="date" id="date" class="form-control" min="1967-01-20" required>
                                <label class="form-label" for="birthday">Fecha</label>
                            </div>
                        </div>
                        <div class="pt-4 pb-2 col-xs-12 col-sm-12 col-md-12">
                            <button type="submit" class="btn btn-block btn-primary" id="btnSave">GUARDAR</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- MODAL DE MENSAJE DE CONFIRMACIÓN -->
<div class="modal fade" id="confirmModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="modalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body">
                    <br><br>
                    <h1 id="modalTitle" class="text-center m-auto" style="color: #00ADCB;">¡REGISTRO CREADO!</h1>
                    <br><br>
                    <div class="container px-3">
                        <p id="modalInfo" class="text-center" style="font-size: 16px;">El registro se ha ingresado exitosamente en la base de datos.</p>
                    </div>
                </div>
                <div class="modal-footer mb-3">
                    <a href="#" type="button" class="btn btn-primary rounded-pill px-5 m-auto" onclick="location.reload()">OK</a>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- MODAL DE CONFIRMACIÓN DE ELIMINACIÓN-->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h4 class="modal-title m-auto text-white" id="deleteModal">AVISO DE ELIMINACIÓN</h4>
                <button type="button" class="btn-close btn-close-white" data-mdb-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center">
                <p class="m-auto">¿Está seguro que desea eliminar permanentemente este registro?</p>
            </div>
            <div class="modal-footer d-flex justify-content-center">
                <button type="button" class="btn btn-outline-primary" data-mdb-dismiss="modal">No</button>
                <button id="idToDelete" onclick="deleteUF();" type="button" class="btn btn-primary" data-mdb-dismiss="modal">Sí</button>
            </div>
        </div>
    </div>
</div>
<!-- MODAL DE INFORMACIÓN -->
<div class="modal fade" id="infoModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="modalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-primary">
                    <h4 id="modalTitle2" class="text-center text-white m-auto fw-bold">MÁS INFORMACIÓN</h4>
                </div>
                <div class="modal-body">
                    <div class="row px-5 pt-2">
                        <div class="form-group">
                            <label for="nameUf"><b>Nombre</b></label>
                            <p id="nameUf"></p>
                        </div>
                        <div class="form-group">
                            <label for="symbolUf"><b>Código</b></label>
                            <p id="symbolUf"></p>
                        </div>
                        <div class="form-group">
                            <label for="currencyUf"><b>Unidad de medida</b></label>
                            <p id="currencyUf"></p>
                        </div>
                        <div class="form-group">
                            <label for="valueUf"><b>Valor</b></label>
                            <p id="valueUf"></p>
                        </div>
                        <div class="form-group">
                            <label for="dateUf"><b>Fecha</b></label>
                            <p id="dateUf"></p>
                        </div>
                        <div class="form-group">
                            <label for="sourceUf"><b>Fuente</b></label>
                            <p id="sourceUf"></p>
                        </div>
                    </div>
                </div>
                <div class="modal-footer mb-3">
                <button type="button" class="btn btn-primary" data-mdb-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
    <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js" defer></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js" defer></script>
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
    <script>
        function format(event) {
            this.value = parseFloat(this.value).toFixed(2);
        }



        function getIndicators() {
            let date = $('#dateRange').val();
            let dateArr = date.split(' - ');
            $.ajax({
                url: '{{route('indicators.getResultsByRangeDate')}}',
                type: 'POST',
                dataType: 'json',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {
                    start: dateArr[0],
                    end: dateArr[1],
                },
                success: function(response) {
                    $("#chart").removeClass('d-none');
                    generateChart(response.results);
                },
                error: function(xhr, status, error) {
                    console.log("error");
                    console.log(xhr);
                }
            });
        }

        function generateChart(results) {
            Highcharts.setOptions({
                lang: {
                        loading: 'Cargando...',
                        months: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
                        weekdays: ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'],
                        shortMonths: ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'],
                        exportButtonTitle: "Exportar",
                        printButtonTitle: "Importar",
                        rangeSelectorFrom: "Desde",
                        rangeSelectorTo: "Hasta",
                        rangeSelectorZoom: "Período",
                        downloadPNG: 'Descargar imagen PNG',
                        downloadJPEG: 'Descargar imagen JPEG',
                        downloadPDF: 'Descargar imagen PDF',
                        downloadSVG: 'Descargar imagen SVG',
                        printChart: 'Imprimir',
                        resetZoom: 'Reiniciar zoom',
                        resetZoomTitle: 'Reiniciar zoom',
                        thousandsSep: ",",
                        decimalPoint: '.'
                    }        
            });
            
            Highcharts.chart('chart', {
                chart: {
                    zoomType: 'xy'
                },
                title: {
                    text: 'VALOR HISTÓRICO'
                },
                yAxis: {
                    title: {
                        text: 'Valores'
                    }
                },
                legend: {
                    enabled: false
                },
                xAxis: {
                    title: {
                        text: 'Fecha'
                    },
                    type: 'datetime',
                    labels: { 
                        format: '{value:%d/%m/%y}',
                    }
                },
                tooltip:{
                    xDateFormat: '%A, %d/%m/%y',
				},
                series: [{
                    name: 'Valor',
                    data: results
                }]
            });
        }
        
        document.addEventListener('DOMContentLoaded', function () {
            
            $('#dateRange').daterangepicker({
                autoUpdateInput: false,
                "locale": {
                    "format": "DD/MM/YYYY",
                    "separator": " - ",
                    "applyLabel": "Aplicar",
                    "cancelLabel": "Cancelar",
                    "fromLabel": "Desde",
                    "toLabel": "Hasta",
                    "customRangeLabel": "Personalizar",
                    "daysOfWeek": [
                        "Do",
                        "Lu",
                        "Ma",
                        "Mi",
                        "Ju",
                        "Vi",
                        "Sa"
                    ],
                    "monthNames": [
                        "Enero",
                        "Febrero",
                        "Marzo",
                        "Abril",
                        "Mayo",
                        "Junio",
                        "Julio",
                        "Agosto",
                        "Septiembre",
                        "Octubre",
                        "Noviembre",
                        "Diciembre"
                    ],
                    "firstDay": 1
                },
            }, function(start, end, label) {
            });

            $('#dateRange').on('apply.daterangepicker', function(ev, picker) {
                $(this).val(picker.startDate.format('DD/MM/YYYY') + ' - ' + picker.endDate.format('DD/MM/YYYY'));
                getIndicators();
            });
        });
    </script>
@endsection