@extends('layouts.app')

@section('content')
<section class="section">
    <h1 class="title text-center pt-5 px-2">{{ $title }}</h1>
    <h3 class="fw-bold text-center px-2">Mantenedor de datos históricos</h3>
    <div class="section-body">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="pb-2 d-flex">
                                <p class="me-auto my-auto">Datos obtenidos de: {{$source}}</p>
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
                                                <button type="submit" class="btn btn-info updateUF" value="{{$uf->id}}"><i class="fa fa-pen"></i></button>
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
        </div>
    </div>
</section>
<!-- MODAL DE FORM -->
<div class="modal fade" id="createModal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-primary">
                <h4 id="modalTitle2" class="text-center text-white m-auto fw-bold">NUEVO REGISTRO</h4>
            </div>
            <div class="modal-body">
                <div class="pb-3" id="errors"></div>
                <form id="create-form" data-action="{{ route('indicators.store') }}" method="POST" enctype="multipart/form-data">
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
<!-- MODAL DE CONFIRMACIÓN -->
<div class="modal fade" id="confirmModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="modalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body">
                    <br><br>
                    <h1 id="modalTitle" class="text-center m-auto" style="color: #00ADCB;">¡Registro completado!</h1>
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
<!-- MODAL DE CONFIRMACIÓN ELIMINACIÓN-->
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
@endsection

@section('scripts')
    <script>
        function format(event) {
            this.value = parseFloat(this.value).toFixed(2);
        }
        function successInsert() {
            $('#createModal').hide();
            $('#confirmModal').modal({ backdrop: "static" });
            $('#confirmModal').modal('show');
        }
    </script>
@endsection