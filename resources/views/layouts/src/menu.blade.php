<div class="deznav">
    <div class="deznav-scroll">
        <ul class="metismenu" id="menu">
            <li><a href="/" class="ai-icon" aria-expanded="false">
                    <i class="flaticon-381-settings-2"></i>
                    <span class="nav-text">Realizar Venta</span>
                </a>
            </li>
            <li><a class="has-arrow ai-icon" href="javascript:void()" aria-expanded="false">
                    <i class="flaticon-381-controls-3"></i>
                    <span class="nav-text">Configuracion</span>
                </a>
                <ul aria-expanded="false">
                    <li><a href="{{ route('sedes') }}">Sedes</a></li>
                    <li><a href="{{ route('users') }}">Usuarios</a></li>
                    <li><a href="{{ route('categorias') }}">Categorias</a></li>
                    <li><a href="{{ route('productos') }}">Productos</a></li>
                    <li><a href="{{ route('clientes') }}">Clientes</a></li>
                    <li><a href="{{ route('roles') }}">Roles</a></li>
                </ul>
            </li>
            <li><a class="has-arrow ai-icon" href="javascript:void()" aria-expanded="false">
                <i class="flaticon-381-controls-3"></i>
                <span class="nav-text">Reportes</span>
            </a>
            <ul aria-expanded="false">
                <li><a href="{{ route('ventas') }}">Ventas</a></li>
            </ul>
        </li>
        </ul>
    </div>
</div>
