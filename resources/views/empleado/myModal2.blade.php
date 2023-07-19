<!-- Modal -->
<div class="modal fade" id="myModal2{{ $empleado->id }}" tabindex="-1" role="dialog" aria-labelledby="modalTitle" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <form action="{{ route('computadoras.store') }}" method="POST">
			@csrf
      <div class="modal-content" style="width: 150%">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Crear </h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div class="d-flex flex-row">
            <select class="form-select" aria-label="Default select example" name="tipo" required>
              <option selected>Tipo de Equipo</option>
              <option value="cpu">CPU</option>
              <option value="laptop">Laptop</option>
            </select>
            <input class="form-control" type="text" name="ip" id="" placeholder="IP" required>
            <select class="form-select" name="estado" aria-label="Default select example" required>
              <option selected>Funcional</option>
              <option value="si">Si</option>
              <option value="no">No</option>
            </select>
            <input class="d-none" type="number" name="id_empleado" id="id_empleado" value="{{ $empleado->id }}">
          </div>
          <div class="table-responsive">
            <table class="table table-striped table-hover" id="table">
              <thead class="thead">
                <tr>
                  <th>Tipo</th>
                  <th>Marca</th>
                  <th>Modelo</th>
                  <th>Caracteristicas</th>
                  <th>Estado</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td>
                    <input class="form-control" type="text" name="tipo2[]" placeholder="Tipo" required>
                  </td>
                  <td>
                    <input class="form-control" type="text" name="marca2[]" placeholder="Marca" required>
                  </td>
                  <td>
                    <input class="form-control" type="text" name="modelo2[]" placeholder="Modelo" required>
                  </td>
                  <td>
                    <input class="form-control" type="text" name="caracteristicas2[]" placeholder="Caracteristicas" required>
                  </td>
                  <td>
                    <input class="form-control" type="text" name="estado2[]" placeholder="Estado" required>
                  </td>
                </tr>
              </tbody>
            </table>
            <div class="form-group">
              <button type="button" class="btn btn-success mb-2" onclick="agregarFila()">Agregar Fila</button>
            </div>
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
<script>
  function agregarFila() {
    document.getElementById("table").insertRow(-1).innerHTML = `<td>
                    <input class="form-control" type="text" name="tipo2[]" placeholder="Tipo" required>
                  </td>
                  <td>
                    <input class="form-control" type="text" name="marca2[]" placeholder="Marca" required>
                  </td>
                  <td>
                    <input class="form-control" type="text" name="modelo2[]" placeholder="Modelo" required>
                  </td>
                  <td>
                    <input class="form-control" type="text" name="caracteristicas2[]" placeholder="Caracteristicas" required>
                  </td>
                  <td>
                    <input class="form-control" type="text" name="estado2[]" placeholder="Estado" required>
                  </td>`;
  }
</script>