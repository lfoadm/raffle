@extends('layouts.app')

@section('content')
<div class="container py-5">
    <h1 class="mb-4">Pagamento via PIX</h1>
    
    
    <div class="card text-center">
        <div class="card-header mt-6">
            <h1>Pagamento com PIX: EFETUADO COM SUCESSO</h1>
            
        </div>
        <div class="card-body text-center">
            <a class="btn btn-success btn-sm" href="{{ route('raffles.index') }}">Meus bilhetes</a>
        </div>
    </div>
</div>
@endsection
