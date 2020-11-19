  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
      <!-- Brand Logo -->
      <a href="{{route('bienvenida.index')}}" class="brand-link navbar-danger">
          <img src="{{url('static/imagenes_intelo/intelo_logo_40x40.png')}}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
          <span class="brand-text font-weight-light">InteloPack</span>
      </a>
      <!-- Sidebar -->
      <div class="sidebar">
          <!-- Sidebar user panel (optional) -->
          <div class="user-panel mt-3 pb-3 mb-3 d-flex">
              <div class="image">
                  <img src="{{url('static/dist/img/placeholder-icons-160x160.png')}}" class="img-circle elevation-2" alt="User Image">
              </div>
              <div class="info">
                  <a href="#" class="d-block">{{Auth::user()->nombre_empleado}}</a>
                  <a href="#" class="d-block" style="font-size: 14px;">
                      <b>No. de Empleado:</b> {{Auth::user()->no_empleado}}
                  </a>
              </div>
          </div>
          <!-- Sidebar Menu -->
          <nav class="mt-2">
              <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                  @if(Auth::user()->tipo_empleado_id == "1")
                  <li class="nav-header pt-2">ADMINISTRACIÓN DE PAQUETERIA</li>
                  <li class="nav-item has-treeview">
                      <a href="#" class="nav-link">
                          <i class="fa fa-box nav-icon"></i>
                          <p>
                              Paqueteria
                              <i class="fas fa-angle-left right"></i>
                          </p>
                      </a>
                      <ul class="nav nav-treeview">
                          <li class="nav-item">
                              <a href="{{route('paquete.index')}}" class="nav-link">
                                  <i class="fas fa-box-open nav-icon"></i>
                                  <p>Generar Paquete</p>
                              </a>
                          </li>
                          <li class="nav-item">
                              <a href="{{route('gestion_paqueteria.index')}}" class="nav-link">
                                  <i class="fas fa-boxes nav-icon"></i>
                                  <p>Gestión de Paqueteria</p>
                              </a>
                          </li>
                          <li class="nav-item">
                              <a href="{{route('cargar_paquetes.index')}}" class="nav-link">
                                  <i class="fas fa-people-carry nav-icon"></i>
                                  <p>Carga de Paquetes</p>
                              </a>
                          </li>
                          <li class="nav-item">
                              <a href="{{route('descarga_paquetes.index')}}" class="nav-link">
                                  <i class="fas fa-truck-loading nav-icon"></i>
                                  <p>Descarga de Paquetes</p>
                              </a>
                          </li>
                          <li class="nav-item">
                              <a href="{{route('folios_recoleccion.index')}}" class="nav-link">
                                  <i class="fas fa-barcode nav-icon"></i>
                                  <p>Folios de Repartidor</p>
                              </a>
                          </li>
                      </ul>
                  </li>
                  {{-- Parte Administrativa  --}}
                  <li class="nav-header pt-2">ADMINISTRACIÓN</li>
                  <li class="nav-item">
                      <a href="{{route('cliente.index')}}" class="nav-link">
                          <i class="fa fa-user-cog nav-icon"></i>
                          <p>Cliente</p>
                      </a>
                  </li>
                  <li class="nav-item">
                      <a href="{{route('gestion_empleados.index')}}" class="nav-link">
                          <i class="fa fa-users nav-icon"></i>
                          <p>Empleados</p>
                      </a>
                  </li>
                  <li class="nav-item has-treeview">
                      <a href="#" class="nav-link">
                          <i class="nav-icon fas fa-truck"></i>
                          <p>
                              Transportes
                              <i class="fas fa-angle-left right"></i>
                          </p>
                      </a>
                      <ul class="nav nav-treeview">
                          <li class="nav-item">
                              <a href="{{route('transportes.index')}}" class="nav-link">
                                  <i class="fas fa-truck-moving nav-icon"></i>
                                  <p>Gestión Transportes</p>
                              </a>
                          </li>
                          <li class="nav-item">
                              <a href="{{route('transporte_empleado.index')}}" class="nav-link">
                                  <i class="far fa-address-book nav-icon"></i>
                                  <p>Asignar Transportes</p>
                              </a>
                          </li>
                      </ul>
                  </li>
                  <li class="nav-item">
                      <a href="{{route('socursal.index')}}" class="nav-link">
                          <i class="fa fa-building nav-icon"></i>
                          <p>Sucursal</p>
                      </a>
                  </li>
                  @elseif(Auth::user()->tipo_empleado_id == "2")
                  <li class="nav-header pt-2">ADMINISTRACIÓN DE PAQUETERIA</li>
                  {{-- <li class="nav-item has-treeview">
                      <a href="#" class="nav-link">
                          <i class="fa fa-box nav-icon"></i>
                          <p>
                              Paqueteria
                              <i class="fas fa-angle-left right"></i>
                          </p>
                      </a>
                      <ul class="nav nav-treeview"> --}}
                  <li class="nav-item">
                      <a href="{{route('paquete.index')}}" class="nav-link">
                          <i class="fas fa-box-open nav-icon"></i>
                          <p>Generar Paquete</p>
                      </a>
                  </li>
                  <li class="nav-item">
                      <a href="{{route('gestion_paqueteria.index')}}" class="nav-link">
                          <i class="fas fa-boxes nav-icon"></i>
                          <p>Gestion de Paqueteria</p>
                      </a>
                  </li>
                  <li class="nav-item">
                      <a href="{{route('cargar_paquetes.index')}}" class="nav-link">
                          <i class="fas fa-people-carry nav-icon"></i>
                          <p>Carga de Paquetes</p>
                      </a>
                  </li>
                  <li class="nav-item">
                      <a href="{{route('descarga_paquetes.index')}}" class="nav-link">
                          <i class="fas fa-truck-loading nav-icon"></i>
                          <p>Descarga de Paquetes</p>
                      </a>
                  </li>
                  <li class="nav-item">
                      <a href="{{route('folios_recoleccion.index')}}" class="nav-link">
                          <i class="fas fa-barcode nav-icon"></i>
                          <p>Folios de Repartidor</p>
                      </a>
                  </li>
                  {{-- </ul>
                  </li> --}}
                  {{-- Parte Administrativa  --}}
                  <li class="nav-header pt-2">ADMINISTRACIÓN</li>
                  <li class="nav-item">
                      <a href="{{route('cliente.index')}}" class="nav-link">
                          <i class="fa fa-user-cog nav-icon"></i>
                          <p>Cliente</p>
                      </a>
                  </li>
                  @elseif(Auth::user()->tipo_empleado_id == "3")
                  <li class="nav-header pt-2">ADMINISTRACIÓN DE PAQUETERIA</li>
                  <li class="nav-item">
                      <a href="{{route('paquete.index')}}" class="nav-link">
                          <i class="fas fa-box-open nav-icon"></i>
                          <p>Generar Paquete</p>
                      </a>
                  </li>
                  <li class="nav-item">
                      <a href="{{route('gestion_paqueteria.index')}}" class="nav-link">
                          <i class="fas fa-boxes nav-icon"></i>
                          <p>Gestion de Paqueteria</p>
                      </a>
                  </li>
                  <li class="nav-item">
                      <a href="{{route('cargar_paquetes.index')}}" class="nav-link">
                          <i class="fas fa-people-carry nav-icon"></i>
                          <p>Carga de Paquetes</p>
                      </a>
                  </li>
                  <li class="nav-item">
                      <a href="{{route('descarga_paquetes.index')}}" class="nav-link">
                          <i class="fas fa-truck-loading nav-icon"></i>
                          <p>Descarga de Paquetes</p>
                      </a>
                  </li>
                  <li class="nav-item">
                      <a href="{{route('folios_recoleccion.index')}}" class="nav-link">
                          <i class="fas fa-barcode nav-icon"></i>
                          <p>Folios de Repartidor</p>
                      </a>
                  </li>
                  @elseif(Auth::user()->tipo_empleado_id == "4")
                  <li class="nav-header pt-2">ADMINISTRACIÓN DE PAQUETERIA</li>
                  <li class="nav-item">
                      <a href="{{route('paquete_repartidor.index')}}" class="nav-link">
                          <i class="fas fa-box-open nav-icon"></i>
                          <p>Generar Paquete</p>
                      </a>
                  </li>
                  <li class="nav-item">
                      <a href="{{route('entrega_paquete.index')}}" class="nav-link">
                          <i class="fas fa-people-carry nav-icon"></i>
                          <p>Entregar Paquete</p>
                      </a>
                  </li>
                  @endif
              </ul>
          </nav>
          <!-- /.sidebar-menu -->
      </div>
      <!-- /.sidebar -->
  </aside>
