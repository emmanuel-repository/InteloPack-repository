<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <router-link to="/empleado/spa/bienvenida" class="brand-link navbar-danger">
        <img src="{{url('static/imagenes_intelo/intelo_logo_40x40.png')}}" alt="AdminLTE Logo"
            class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light">InteloPack</span>
    </router-link>
    <div class="sidebar">
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="{{url('static/dist/img/placeholder-icons-160x160.png')}}" class="img-circle elevation-2"
                    alt="User Image">
            </div>
            <div class="info">
                <a href="#" class="d-block">{{Auth::user()->nombre_empleado}}</a>
                <a href="#" class="d-block" style="font-size: 14px;">
                    <b>No. de Empleado:</b> {{Auth::user()->no_empleado}}
                </a>
            </div>
        </div>
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <li class="nav-item">
                    <router-link tag="a" to="/empleado/spa/paquete_repartidor" class="nav-link">
                        <i class="fas fa-box-open nav-icon"></i>
                        <p>Generar Paquete</p>
                    </router-link>
                </li>
                <li class="nav-item">
                    <router-link tag="a" to="/empleado/spa/entrega_paquete" class="nav-link">
                        <i class="fas fa-people-carry nav-icon"></i>
                        <p>Entregar Paquete</p> 
                    </router-link>
                </li>
            </ul>
        </nav>
    </div>
</aside>
