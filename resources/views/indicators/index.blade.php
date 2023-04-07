@extends('layouts.app')

@section('content')
<section class="section">
    <h1 class="title text-center pt-5 px-2">{{ $title }}</h1>
    <h3 class="fw-bold text-center px-2">Datos históricos</h3>
        <div class="section-body">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="text-end pb-2">
                                    <a class="btn btn-warning" href="{{route('create')}}""><i class="fas fa-plus"></i> Nuevo</a>
                                </div>
                                <div class="mt-2">
                                    <table class="table table-striped mt-2 border">
                                        <thead style="background-color:#6777ef">
                                            <th style="display: none;">ID</th>
                                            <th class="text-white text-center">Fecha</th>
                                            <th class="text-white text-center">Código</th>
                                            <th class="text-white text-center">Unidad de medida</th>
                                            <th class="text-white text-center">Valor</th>
                                            <th class="text-white text-center">Fuente</th>
                                            <th class="text-white text-center">Acciones</th>
                                        </thead>
                                        <tbody>
                                            @foreach ($ufs as $uf)
                                            @php
                                                $newDate = strtotime($uf->date);
                                            @endphp
                                            <tr>
                                                <td style="display: none;">{{ $uf->id }}</td>
                                                <td class="text-center">{{ date('d-m-Y', $newDate);}}</td>
                                                <td class="text-center">{{ $uf->symbol }}</td>
                                                <td class="text-center">{{ $uf->currency }}</td>
                                                <td class="text-center">{{ $uf->value }}</td>
                                                <td class="text-center">{{ $uf->source }}</td>
                                                <td class="text-center">
                                                    <form action="" method="POST">
                                                        <a class="btn btn-info" href=""><i class="fa fa-pen"></i></a>
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger"><i class="fa fa-trash"></i></button>
                                                    </form>
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                    <div class="pagination justify-content-end">
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
@endsection