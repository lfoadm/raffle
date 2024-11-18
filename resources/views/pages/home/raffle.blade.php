@extends('layouts.app')
@section('content')
<!--begin::Team Section-->
<div class="py-10 py-lg-20">
    <!--begin::Container-->
    <div class="container">
        
        {{ $raffle }}
        <br><hr>
        {{ $rraffles }}
        
    </div>
    <!--end::Container-->
</div>
<!--end::Team Section-->
@endsection