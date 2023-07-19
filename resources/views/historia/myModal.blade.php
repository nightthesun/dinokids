<!-- Modal -->
<div class="modal fade" id="myModal{{ $historia->empleado->id }}" tabindex="-1" role="dialog" aria-labelledby="modalTitle" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Datos del Empleado</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="form-group">
          <strong>Nombre:</strong>
          {{ $historia->empleado->nombre }}
        </div>
        <div class="form-group">
          <strong>Paterno:</strong>
          {{ $historia->empleado->paterno }}
        </div>
        <div class="form-group">
          <strong>Materno:</strong>
          {{ $historia->empleado->materno }}
        </div>
        <div class="form-group">
          <strong>C.I.:</strong>
          {{ $historia->empleado->ci }}
        </div>
        <div class="form-group">
          <strong>Area:</strong>
          {{ $historia->empleado->area }}
        </div>
        <div class="form-group">
          <strong>Cargo:</strong>
          {{ $historia->empleado->cargo }}
        </div>
        <div class="form-group">
          <strong>Sucursal:</strong>
          {{ $historia->empleado->sucursal }}
        </div>
        <div class="form-group">
          <strong>IP:</strong>
          {{ $historia->empleado->ip }}
        </div>
        <div class="form-group">
          <strong>Modificado por:</strong>
          {{ Auth::user()->name }}
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>
