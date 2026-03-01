<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Doctor Domicilio - Sistema Clínico')</title>
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    
    <!-- FullCalendar -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/fullcalendar@5.10.1/main.min.css">
    
    <!-- SweetAlert2 -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    
    <!-- Estilos personalizados -->
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    
    @stack('styles')
</head>
<body>
    <div class="app-container">
        <!-- SIDEBAR (Menú lateral) -->
        <aside class="sidebar">
            <div class="sidebar-header">
                <i class="fas fa-stethoscope"></i>
                <h2>Doctor <span>Domicilio</span></h2>
            </div>
            
            <nav class="sidebar-nav">
                @php
                    use App\Models\Paciente;
                    $ultimosPacientes = Paciente::orderBy('created_at', 'desc')->limit(5)->get();
                @endphp
                
                <ul>
                    <li>
                        <a href="{{ route('dashboard') }}" class="{{ request()->routeIs('dashboard') ? 'active' : '' }}">
                            <i class="fas fa-home"></i> Dashboard
                        </a>
                    </li>
                    
                    <li>
                        <a href="{{ route('pacientes.index') }}" class="{{ request()->routeIs('pacientes.*') ? 'active' : '' }}">
                            <i class="fas fa-users"></i> Pacientes
                        </a>
                    </li>
                    
                    <li class="menu-divider">MÓDULOS MÉDICOS</li>
                    
                    <!-- Dropdown Historias Clínicas -->
                    <li class="dropdown-container">
                        <a href="#" class="dropdown-toggle" onclick="toggleDropdown(event, 'historias-dropdown')">
                            <i class="fas fa-notes-medical"></i> Historias Clínicas 
                            <i class="fas fa-chevron-right toggle-icon"></i>
                        </a>
                        <div class="dropdown-menu" id="historias-dropdown">
                            <div class="dropdown-header">
                                <i class="fas fa-clock"></i> Últimos pacientes
                            </div>
                            @forelse($ultimosPacientes as $p)
                                <a href="{{ route('historias.index', $p->id) }}" class="dropdown-item">
                                    <i class="fas fa-user-circle"></i>
                                    {{ $p->nombre }} {{ $p->apellido }}
                                </a>
                            @empty
                                <div class="dropdown-item empty-state">
                                    <i class="fas fa-exclamation-circle"></i> No hay pacientes
                                </div>
                            @endforelse
                            <div class="dropdown-divider"></div>
                            <a href="{{ route('pacientes.index') }}" class="dropdown-item ver-todos">
                                <i class="fas fa-search"></i> Ver todos los pacientes
                            </a>
                        </div>
                    </li>

                    <!-- Dropdown Historias Pediátricas -->
                    <li class="dropdown-container">
                        <a href="#" class="dropdown-toggle" onclick="toggleDropdown(event, 'pediatricas-dropdown')">
                            <i class="fas fa-child"></i> Historias Pediátricas 
                            <i class="fas fa-chevron-right toggle-icon"></i>
                        </a>
                        <div class="dropdown-menu" id="pediatricas-dropdown">
                            <div class="dropdown-header">
                                <i class="fas fa-clock"></i> Últimos pacientes
                            </div>
                            @forelse($ultimosPacientes as $p)
                                <a href="{{ route('historias.index', $p->id) }}" class="dropdown-item">
                                    <i class="fas fa-user-circle"></i>
                                    {{ $p->nombre }} {{ $p->apellido }}
                                </a>
                            @empty
                                <div class="dropdown-item empty-state">
                                    <i class="fas fa-exclamation-circle"></i> No hay pacientes
                                </div>
                            @endforelse
                            <div class="dropdown-divider"></div>
                            <a href="{{ route('pacientes.index') }}" class="dropdown-item ver-todos">
                                <i class="fas fa-search"></i> Ver todos los pacientes
                            </a>
                        </div>
                    </li>

                    <!-- Dropdown Recetas -->
                    <li class="dropdown-container">
                        <a href="#" class="dropdown-toggle" onclick="toggleDropdown(event, 'recetas-dropdown')">
                            <i class="fas fa-prescription"></i> Recetas Médicas 
                            <i class="fas fa-chevron-right toggle-icon"></i>
                        </a>
                        <div class="dropdown-menu" id="recetas-dropdown">
                            <div class="dropdown-header">
                                <i class="fas fa-clock"></i> Últimos pacientes
                            </div>
                            @forelse($ultimosPacientes as $p)
                                <a href="{{ route('recetas.create', $p->id) }}" class="dropdown-item">
                                    <i class="fas fa-user-circle"></i>
                                    {{ $p->nombre }} {{ $p->apellido }}
                                </a>
                            @empty
                                <div class="dropdown-item empty-state">
                                    <i class="fas fa-exclamation-circle"></i> No hay pacientes
                                </div>
                            @endforelse
                            <div class="dropdown-divider"></div>
                            <a href="{{ route('pacientes.index') }}" class="dropdown-item ver-todos">
                                <i class="fas fa-search"></i> Ver todos los pacientes
                            </a>
                        </div>
                    </li>

                    <!-- Dropdown Laboratorio -->
                    <li class="dropdown-container">
                        <a href="#" class="dropdown-toggle" onclick="toggleDropdown(event, 'laboratorio-dropdown')">
                            <i class="fas fa-flask"></i> Órdenes de Laboratorio 
                            <i class="fas fa-chevron-right toggle-icon"></i>
                        </a>
                        <div class="dropdown-menu" id="laboratorio-dropdown">
                            <div class="dropdown-header">
                                <i class="fas fa-clock"></i> Últimos pacientes
                            </div>
                            @forelse($ultimosPacientes as $p)
                                <a href="{{ route('laboratorio.orden.create', $p->id) }}" class="dropdown-item">
                                    <i class="fas fa-user-circle"></i>
                                    {{ $p->nombre }} {{ $p->apellido }}
                                </a>
                            @empty
                                <div class="dropdown-item empty-state">
                                    <i class="fas fa-exclamation-circle"></i> No hay pacientes
                                </div>
                            @endforelse
                            <div class="dropdown-divider"></div>
                            <a href="{{ route('pacientes.index') }}" class="dropdown-item ver-todos">
                                <i class="fas fa-search"></i> Ver todos los pacientes
                            </a>
                        </div>
                    </li>

                    <!-- Dropdown Consentimientos -->
                    <li class="dropdown-container">
                        <a href="#" class="dropdown-toggle" onclick="toggleDropdown(event, 'consentimientos-dropdown')">
                            <i class="fas fa-file-signature"></i> Consentimientos 
                            <i class="fas fa-chevron-right toggle-icon"></i>
                        </a>
                        <div class="dropdown-menu" id="consentimientos-dropdown">
                            <div class="dropdown-header">
                                <i class="fas fa-clock"></i> Últimos pacientes
                            </div>
                            @forelse($ultimosPacientes as $p)
                                <a href="{{ route('consentimientos.create', $p->id) }}" class="dropdown-item">
                                    <i class="fas fa-user-circle"></i>
                                    {{ $p->nombre }} {{ $p->apellido }}
                                </a>
                            @empty
                                <div class="dropdown-item empty-state">
                                    <i class="fas fa-exclamation-circle"></i> No hay pacientes
                                </div>
                            @endforelse
                            <div class="dropdown-divider"></div>
                            <a href="{{ route('pacientes.index') }}" class="dropdown-item ver-todos">
                                <i class="fas fa-search"></i> Ver todos los pacientes
                            </a>
                        </div>
                    </li>
                    
                    <li class="menu-divider">ADMINISTRACIÓN</li>
                    
                    <!-- Dropdown Boletas -->
                    <li class="dropdown-container">
                        <a href="#" class="dropdown-toggle" onclick="toggleDropdown(event, 'boletas-dropdown')">
                            <i class="fas fa-file-invoice"></i> Boletas / Facturas 
                            <i class="fas fa-chevron-right toggle-icon"></i>
                        </a>
                        <div class="dropdown-menu" id="boletas-dropdown">
                            <div class="dropdown-header">
                                <i class="fas fa-clock"></i> Últimos pacientes
                            </div>
                            @forelse($ultimosPacientes as $p)
                                <a href="{{ route('boletas.create', $p->id) }}" class="dropdown-item">
                                    <i class="fas fa-user-circle"></i>
                                    {{ $p->nombre }} {{ $p->apellido }}
                                </a>
                            @empty
                                <div class="dropdown-item empty-state">
                                    <i class="fas fa-exclamation-circle"></i> No hay pacientes
                                </div>
                            @endforelse
                            <div class="dropdown-divider"></div>
                            <a href="{{ route('pacientes.index') }}" class="dropdown-item ver-todos">
                                <i class="fas fa-search"></i> Ver todos los pacientes
                            </a>
                        </div>
                    </li>

                    <li>
                        <a href="{{ route('calendario.index') }}" class="{{ request()->routeIs('calendario.*') ? 'active' : '' }}">
                            <i class="fas fa-calendar-alt"></i> Calendario
                        </a>
                    </li>
                    
                    <li class="menu-divider"></li>
                    
                    <li>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <a href="{{ route('logout') }}" onclick="event.preventDefault(); this.closest('form').submit();">
                                <i class="fas fa-sign-out-alt"></i> Cerrar Sesión
                            </a>
                        </form>
                    </li>
                </ul>
            </nav>
            
            <div class="sidebar-footer">
                <p>Bienvenido, <strong>{{ Auth::user()->nombre }}</strong></p>
                <p style="font-size: 0.8rem; opacity: 0.7;">{{ Auth::user()->rol }}</p>
            </div>
        </aside>
        
        <!-- CONTENIDO PRINCIPAL -->
        <main class="main-content">
            <!-- Top Bar -->
            <header class="top-bar">
                <button class="menu-toggle" id="menuToggle">
                    <i class="fas fa-bars"></i>
                </button>
                <div class="top-bar-title">
                    <h1>@yield('page-title', 'Dashboard')</h1>
                </div>
                <div class="top-bar-actions">
                    <span class="date-display"><i class="far fa-calendar-alt"></i> {{ now()->format('d/m/Y') }}</span>
                </div>
            </header>
            
            <!-- Contenedor para el contenido dinámico -->
            <div class="content-wrapper">
                @if(session('success'))
                    <script>
                        Swal.fire({
                            icon: 'success',
                            title: '¡Éxito!',
                            text: '{{ session('success') }}',
                            timer: 3000,
                            showConfirmButton: false
                        });
                    </script>
                @endif
                
                @if(session('error'))
                    <script>
                        Swal.fire({
                            icon: 'error',
                            title: '¡Error!',
                            text: '{{ session('error') }}',
                            timer: 3000,
                            showConfirmButton: false
                        });
                    </script>
                @endif
                
                @yield('content')
            </div>
        </main>
    </div>
    
    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.10.1/main.min.js"></script>
    <script src="{{ asset('js/main.js') }}"></script>
    
    <script>
        // Función para toggle de dropdowns
        function toggleDropdown(event, dropdownId) {
            event.preventDefault();
            
            // Cerrar otros dropdowns abiertos
            document.querySelectorAll('.dropdown-container.active').forEach(container => {
                if (container.querySelector('.dropdown-menu').id !== dropdownId) {
                    container.classList.remove('active');
                }
            });
            
            // Toggle el dropdown actual
            const container = event.currentTarget.closest('.dropdown-container');
            container.classList.toggle('active');
        }

        // Cerrar dropdowns al hacer clic fuera
        document.addEventListener('click', function(event) {
            if (!event.target.closest('.dropdown-container')) {
                document.querySelectorAll('.dropdown-container.active').forEach(container => {
                    container.classList.remove('active');
                });
            }
        });

        // Toggle menú móvil
        document.getElementById('menuToggle')?.addEventListener('click', function() {
            document.querySelector('.sidebar').classList.toggle('active');
        });
    </script>
    
    @stack('scripts')
</body>
</html>