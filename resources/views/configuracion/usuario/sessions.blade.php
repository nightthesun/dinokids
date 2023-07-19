@extends('layouts.app')
 
@section('content')
<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col">
            <table class="table table-bordered">
                <thead>
                <tr>
                    <th scope="col">Navegador</th>
                    <th scope="col">IP</th>
                    <th scope="col">Ultima actividad</th>
                    <th scope="col">Cerrar</th>
                </tr>
                </thead>
                <tbody>
                    @foreach($sessions as $session)
                    <tr>
                        <td>{{ $session->user_agent }}</td>
                        <td>{{ $session->ip_address }}</td>
                        <td>{{ \Carbon\Carbon::createFromTimeStamp($session->last_activity)->diffForhumans() }}</td>
                        <td class="text-center">
                        <button type="button" name="button" class="btn btn-danger delete-session" data-id="{{$session->id}}">x</button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
 
@section('js')
<script type="text/javascript">
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});
$(".delete-session").click(function(){
    var id = $(this).data("id");
    $.ajax({
        url: "{{route('session.delete')}}",
        type: 'POST',
        data: {            
            "id": id,
        },        
        success: function (){            
            location.reload();
        }
    });
});
</script>
@endsection