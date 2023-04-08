@extends('layouts.app')

@section('content')
    <section class="section">
        <div class="section-header">
            <h3 class="page__heading">Agregar nuevo registro de UF</h3>
        </div>
        <div class="section-body">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-body">
                                @if ($errors->any())
                                <div class="alert alert-dark alert-dismissible fade show" role="alert">
                                    <strong>¡Revise los campos!</strong>                        
                                        @foreach ($errors->all() as $error)                                    
                                            <span class="badge badge-danger">{{ $error }}</span>
                                        @endforeach                        
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                @endif
    
                                <form id="create-form" data-action="{{ route('indicators.store') }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <div class="row">
                                        <div class="col-xs-12 col-sm-12 col-md-12">
                                            <div class="form-group">
                                                <label for="value">Valor de UF el día de hoy</label>
                                                <input type="number" name="value" id="value" class="form-control" step="0.01" onChange="format"  pattern="[0-9]+([\.][0-9]+)?" required/>
                                            </div>
                                        </div>
                                        <div class="pt-3 col-xs-12 col-sm-12 col-md-12">
                                            <button type="submit" class="btn btn-primary">Guardar</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('scripts')
    <script>
        function format(event) {
            this.value = parseFloat(this.value).toFixed(2);
        }
    </script>
@endsection