<div class="form-group row d-flex justify-content-center mt-5">
            <div class="col-md-4 d-flex justify-content-center">
                @if(count($form->firmas->where('tipo', 'Superior'))<=0)
                <button type="button" class="btn btn-primary mr-4" data-toggle="modal" data-target="#modal_a"> 
                    {{ __('Autorizar') }}
                </button>
                <!-- Modal Autorizar-->
                <div class="modal fade" id="modal_a" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Aceptar</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                            </div>
                            <div class="modal-body">
                                    <textarea id="obs_a" name="obs_a" type="text" class="form-control" placeholder="Observaciones (Opcional)" style="white-space: nowrap;">

                                    </textarea>
                            </div>
                            <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                                    <button type="submit" class="btn btn-primary" id="aceptado" name="aceptado" value="Aceptado">Aprobar</button>
                            </div>
                        </div>
                    </div>
                </div>
                <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#modal_r">
                    {{ __('Rechazar') }}
                </button>
                <!-- Modal Rechazar-->
                <div class="modal fade" id="modal_r" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Rechazar</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <textarea id="obs_r" name="obs_r" type="text" class="form-control" placeholder="Observaciones" style="white-space: nowrap;">

                                </textarea>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                                <button type="submit" class="btn btn-danger" id="rechazado" name="rechazado" value="Rechazado">Rechazar</button>
                            </div>
                        </div>
                    </div>
                </div>
                @endif
            </div>
            <div class="col-md-4 d-flex justify-content-center">
                @if(count($form->firmas->where('tipo', 'RRHH'))<=0)
                <button type="button" class="btn btn-primary mr-4" data-toggle="modal" data-target="#modal_arrhh"> 
                    {{ __('Autorizar como RRHH') }}
                </button>

                <!-- Modal Autorizar-->
                <div class="modal fade" id="modal_arrhh" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Aprobar como RRHH</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <textarea id="obs_a_rrhh" name="obs_a_rrhh" type="text" class="form-control" placeholder="Observaciones (Opcional)" style="white-space: nowrap;">

                                </textarea>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                                <button type="submit" class="btn btn-primary" id="aceptadorrhh" name="aceptadorrhh" value="Aceptado_RRHH">Aprobar como RRHH</button>
                            </div>
                        </div>
                    </div>
                </div>
                <button type="button" class="btn btn-danger"  data-toggle="modal" data-target="#modal_rrrhh">
                    {{ __('Rechazar como RRHH') }}
                </button>
                <!-- Modal Rechazar-->
                <div class="modal fade" id="modal_rrrhh" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Rechazar</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <textarea id="obs_r_rrhh" name="obs_r_rrhh" type="text" class="form-control" placeholder="Observaciones" style="white-space: nowrap;">

                                </textarea>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                                <button type="submit" class="btn btn-danger" id="rechazadorrhh" name="rechazadorrhh" value="Rechazado_RRHH">Rechazar como RRHH</button>
                            </div>
                        </div>
                    </div>
                </div>
                @endif
            </div>

            <div class="col-md-4 d-flex justify-content-center">
                @if(count($form->firmas->where('tipo', 'Contabilidad'))<=0)
                <button type="button" class="btn btn-primary mr-4" data-toggle="modal" data-target="#modal_aconta"> 
                    {{ __('Autorizar como Contabilidad') }}
                </button>

                <!-- Modal Autorizar-->
                <div class="modal fade" id="modal_aconta" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Aprobar como Contabilidad</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <textarea id="obs_a_conta" name="obs_a_conta" type="text" class="form-control" placeholder="Observaciones (Opcional)" style="white-space: nowrap;">

                                </textarea>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                                <button type="submit" class="btn btn-primary" id="aceptadoconta" name="aceptadoconta" value="Aceptado_conta">Aprobar como Contabilidad</button>
                            </div>
                        </div>
                    </div>
                </div>
                <button type="button" class="btn btn-danger"  data-toggle="modal" data-target="#modal_rconta">
                    {{ __('Rechazar como Contabilidad') }}
                </button>
                <!-- Modal Rechazar-->
                <div class="modal fade" id="modal_rconta" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Rechazar</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <textarea id="obs_r_conta" name="obs_r_conta" type="text" class="form-control" placeholder="Observaciones" style="white-space: nowrap;">

                                </textarea>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                                <button type="submit" class="btn btn-danger" id="rechazadoconta" name="rechazadoconta" value="Rechazado_conta">Rechazar como Contabilidad</button>
                            </div>
                        </div>
                    </div>
                </div>
                @endif
            </div>
        </div>
