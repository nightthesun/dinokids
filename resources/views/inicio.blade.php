@extends('layouts.app')
@section('static', 'statick-side')
@section('content') 
@include('layouts.sidebar', ['hide'=>'0'])
 <h1> en construccion </h1>



<!--aqui viene el codigo -->
@endsection
@section('mis_scripts')
<script type="text/javascript">
    $(window).on('load',function(){
        $('#myModal').modal('show');
    });
</script>
@endsection