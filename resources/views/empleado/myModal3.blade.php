<!-- Modal -->
<div class="modal fade" id="myModal3{{ $cpu->id }}" tabindex="-1" role="dialog" aria-labelledby="modalTitle" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <form action="{{ route('computadoras.cambio', $cpu->id) }}" method="post">
			@csrf
      <div class="modal-content" style="width: 150%">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Traspaso {{ $cpu->id }}</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div class="d-flex flex-row">
            <select class="form-select" multiple aria-label="multiple select example" name="id_empleado" required>
              {{-- <option selected>Seleccionar empleado</option> --}}
              @foreach ($todos as $todo)
              @if ($todo->paterno != $empleado->paterno)
              <option value="{{ $todo->id }}">{{ $todo->paterno }} {{ $todo->materno }}, {{ $todo->nombre }}</option>
              @endif
              @endforeach
            </select>
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary">Guardar</button>
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
        </div>
      </div>
    </form>
  </div>
</div>