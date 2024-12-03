@extends('layouts.app')
@section('content')

<h1>Pagamento via Pix</h1>
    <form action="#" method="POST">
        @csrf
        <label>Valor (R$):</label>
        <input type="number" name="transaction_amount" step="0.01" required>
        <br>
        <label>Email:</label>
        <input type="email" name="payer_email" required>
        <br>
        <label>CPF:</label>
        <input type="text" name="payer_cpf" minlength="11" maxlength="11" required>
        <br>
        <button type="submit">Gerar QR Code</button>
    </form>

@endsection