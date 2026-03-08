@extends('layouts.app')

@section('page-title', 'Historia Clínica General')
@section('title', 'Historia Clínica')

@section('content')
<div class="dashboard-card" style="max-width: 1200px; margin: 0 auto;">
    <div class="card-header">
        <h3><i class="fas fa-notes-medical"></i> Historia Clínica General #{{ $historia->id }}</h3>
        <a href="{{ route('historias.index', $historia->paciente->id) }}" class="btn-add">
            <i class="fas fa-arrow-left"></i> Volver
        </a>
    </div>
    <div class="card-body" style="background: #fff;">
        <!-- ESTILOS ESPECÍFICOS PARA LA HISTORIA CLÍNICA -->
        <style>
            .historia-container {
                font-family: 'Helvetica', Arial, sans-serif;
                color: #000;
                margin: 0;
                padding: 20px;
                font-size: 12px;
                background: #fff;
            }
            
            /* Cabecera */
            .header-table { width: 100%; border-collapse: collapse; margin-bottom: 10px; }
            .header-table td { vertical-align: top; }
            .logo { width: 180px; }
            .contact-info { text-align: center; font-weight: bold; font-size: 11px; }
            .clinic-box { 
                border: 1px solid #000; 
                width: 150px; 
                height: 60px; 
                text-align: center; 
                float: right;
            }
            .clinic-box-title { border-bottom: 1px solid #000; padding: 3px; font-size: 10px; }
            .clinic-box-content { padding: 5px; font-size: 12px; font-weight: bold; }
            
            /* Especialidades */
            .specialties { 
                text-align: center; 
                font-size: 8px; 
                font-weight: bold; 
                border-top: 2px solid #000; 
                border-bottom: 2px solid #000; 
                padding: 5px 0; 
                margin-bottom: 15px; 
            }

            /* Título Principal */
            .main-title-container { text-align: center; margin-bottom: 20px; }
            .main-title { 
                display: inline-block; 
                border: 3px double #000; 
                padding: 5px 15px; 
                font-size: 18px; 
                font-weight: bold; 
                border-radius: 5px;
            }

            /* Secciones y Filas */
            .section { margin-bottom: 15px; }
            .section-title { font-weight: bold; font-size: 13px; font-style: italic; margin-bottom: 8px; }
            
            .row { display: table; width: 100%; margin-bottom: 8px; }
            .col { display: table-cell; vertical-align: bottom; }
            
            /* Líneas para escribir */
            .line { border-bottom: 1px solid #000; display: inline-block; width: 100%; min-height: 18px; padding: 0 5px; }
            .line-with-text { border-bottom: 1px solid #000; padding: 0 5px; min-height: 18px; width: 100%; }
            
            .label { font-weight: bold; font-style: italic; white-space: nowrap; padding-right: 5px; }
            
            /* Listas y áreas de texto */
            .list-item { margin-bottom: 5px; display: flex; align-items: center; }
            .list-label { display: inline-block; width: 150px; font-style: italic; }
            .full-line { border-bottom: 1px solid #000; min-height: 20px; margin-bottom: 8px; width: 100%; padding: 2px 5px; }

            /* Tablas de datos */
            .data-table { width: 100%; border-collapse: collapse; margin-top: 5px; }
            .data-table td { padding: 2px 0; }
            
            /* Firma */
            .signature-box { text-align: center; margin-top: 40px; }
            .signature-line { border-top: 1px solid #000; display: inline-block; width: 250px; padding-top: 5px; font-style: italic; font-size: 11px; }
            
            /* Valor dinámico */
            .dynamic-value { font-weight: normal; padding-left: 5px; }
        </style>

        <div class="historia-container">
            <!-- CABECERA CON LOGO Y DATOS DE LA CLÍNICA -->
            <table class="header-table">
                <tr>
                    <td style="width: 30%;">
                        <img src="{{ public_path('img/logo.png') }}" class="logo" alt="Doctor Domicilio" onerror="this.style.display='none'">
                        <div style="font-size: 16px; font-weight: bold; color: #1a365d;">Doctor Domicilio</div>
                    </td>
                    <td style="width: 40%;" class="contact-info">
                        Atención Médica en Casa<br>
                        Citas: Whatsapp: 973643675<br>
                        <div style="background-color: #333; color: #fff; display: inline-block; padding: 2px 5px; margin-top: 5px; border-radius: 3px;">
                            EDIFICIO EMPRESARIAL AMAUTA CONSULTORIO 901
                        </div>
                    </td>
                    <td style="width: 30%;">
                        <div class="clinic-box">
                            <div class="clinic-box-title">Nº HISTORIA CLINICA</div>
                            <div class="clinic-box-content">{{ $historia->id }}</div>
                        </div>
                    </td>
                </tr>
            </table>

            <!-- ESPECIALIDADES -->
            <div class="specialties">
                MEDICINA - PEDIATRÍA - GINECOLOGIA - OTORRINOLARINGOLOGÍA - CIRUGÍA MENOR - EMERGENCIA<br>
                ODONTOLOGÍA INTEGRAL - PSIQUIATRÍA - OBSTETRICIA - UROLOGÍA - PLANIFICACIÓN FAMILIAR<br>
                PREVENCIÓN DE CÁNCER DE MAMAS Y CUELLO UTERINO - OTRAS ESPECIALIDADES<br>
                ECOGRAFÍA - LABORATORIO CLÍNICO
            </div>

            <!-- TÍTULO PRINCIPAL -->
            <div class="main-title-container">
                <div class="main-title">HISTORIA CLINICA</div>
            </div>

            <!-- SECCIÓN I: FILIACIÓN -->
            <div class="section">
                <div class="row">
                    <div class="col" style="width: 70%;"><span class="section-title">I. <span style="margin-left: 10px;">FILIACION:</span></span></div>
                    <div class="col" style="width: 30%;">
                        <div style="display: flex; align-items: center;">
                            <span class="label">Fecha:</span> 
                            <div class="line" style="text-align: center; margin-left: 5px;">{{ $historia->fecha->format('d/m/Y') }}</div>
                        </div>
                    </div>
                </div>
                
                <table class="data-table">
                    <tr>
                        <td style="width: 60px;" class="label">Nombre:</td>
                        <td style="border-bottom: 1px solid #000;">{{ $historia->paciente->nombre_completo }}</td>
                    </tr>
                </table>
                
                <table class="data-table" style="margin-top: 8px;">
                    <tr>
                        <td style="width: 40px;" class="label">Edad:</td>
                        <td style="border-bottom: 1px solid #000; width: 40%;">{{ $historia->paciente->edad }} años</td>
                        <td style="width: 60px; padding-left: 10px;" class="label">Teléfono:</td>
                        <td style="border-bottom: 1px solid #000;">{{ $historia->paciente->telefono ?? 'N/E' }}</td>
                    </tr>
                </table>

                <table class="data-table" style="margin-top: 8px;">
                    <tr>
                        <td style="width: 60px;" class="label">Domicilio:</td>
                        <td style="border-bottom: 1px solid #000;">{{ $historia->paciente->direccion ?? 'No especificado' }}</td>
                    </tr>
                </table>
            </div>

            <!-- SECCIÓN II: ANTECEDENTES -->
            <div class="section">
                <table style="width: 100%; margin-bottom: 5px;">
                    <tr>
                        <td style="width: 60%;"><span class="section-title">II. <span style="margin-left: 5px;">ANTECEDENTES:</span></span></td>
                        <td style="width: 10%;" class="label">Alergias:</td>
                        <td style="width: 30%; border-bottom: 1px solid #000; padding-left: 5px;">
                            {{ $historia->paciente->alergias ?? 'Ninguna' }}
                        </td>
                    </tr>
                </table>
                <div class="list-item">
                    <span class="list-label">- Médicos:</span> 
                    <span class="line" style="width: 80%; margin-left: 5px;">{{ $historia->antecedentes_personales ?? '' }}</span>
                </div>
                <div class="list-item">
                    <span class="list-label">- Gineco - Obstétricos:</span> 
                    <span class="line" style="width: 75%; margin-left: 5px;"></span>
                </div>
                <div class="list-item">
                    <span class="list-label">- Quirúrgicos:</span> 
                    <span class="line" style="width: 80%; margin-left: 5px;"></span>
                </div>
                <div class="list-item">
                    <span class="list-label">- Tratamiento previo:</span> 
                    <span class="line" style="width: 76%; margin-left: 5px;">{{ $historia->plan_tratamiento ?? '' }}</span>
                </div>
            </div>

            <!-- SECCIÓN III: ENFERMEDADES ACTUALES -->
            <div class="section">
                <div class="section-title">III. <span style="margin-left: 5px;">ENFERMEDADES ACTUALES:</span></div>
                <table style="width: 100%; border-collapse: collapse; margin-bottom: 5px;">
                    <tr>
                        <td style="width: 30px;" class="label">TE:</td>
                        <td style="border-bottom: 1px solid #000; width: 30%;"></td>
                        <td style="width: 30px; padding-left: 10px;" class="label">FI:</td>
                        <td style="border-bottom: 1px solid #000; width: 30%;"></td>
                        <td style="width: 20px; padding-left: 10px;" class="label">C:</td>
                        <td style="border-bottom: 1px solid #000;"></td>
                    </tr>
                </table>
                <table style="width: 100%; border-collapse: collapse;">
                    <tr>
                        <td style="width: 110px;" class="label">Signos, Síntomas:</td>
                        <td style="border-bottom: 1px solid #000; padding-left: 5px;">
                            {{ $historia->motivo_consulta ?? '' }}
                        </td>
                    </tr>
                </table>
                @if($historia->enfermedad_actual)
                <div class="full-line">{{ $historia->enfermedad_actual }}</div>
                @else
                <div class="full-line"></div>
                <div class="full-line"></div>
                @endif
            </div>

            <!-- SECCIÓN IV: EXAMEN FÍSICO -->
            <div class="section">
                <div class="section-title">IV. <span style="margin-left: 5px; text-decoration: underline;">EXAMEN FÍSICO:</span></div>
                <table style="width: 100%; border-collapse: collapse; margin-bottom: 10px;">
                    <tr>
                        <td style="width: 30px;" class="label">PA:</td>
                        <td style="border-bottom: 1px solid #000; width: 15%; padding-left: 5px;">{{ $historia->presion_arterial ?? '' }}</td>
                        <td style="width: 30px; padding-left: 10px;" class="label">FC:</td>
                        <td style="border-bottom: 1px solid #000; width: 15%; padding-left: 5px;">{{ $historia->frecuencia_cardiaca ?? '' }}</td>
                        <td style="width: 30px; padding-left: 10px;" class="label">T°</td>
                        <td style="border-bottom: 1px solid #000; width: 15%; padding-left: 5px;">{{ $historia->temperatura ?? '' }}</td>
                        <td style="width: 40px; padding-left: 10px;" class="label">PESO:</td>
                        <td style="border-bottom: 1px solid #000; width: 15%; padding-left: 5px;">{{ $historia->peso ?? '' }}</td>
                        <td style="width: 45px; padding-left: 10px;" class="label">TALLA:</td>
                        <td style="border-bottom: 1px solid #000; padding-left: 5px;">{{ $historia->talla ?? '' }}</td>
                    </tr>
                </table>
                <div class="full-line">{{ $historia->observaciones ?? '' }}</div>
                <div class="full-line"></div>
                <div class="full-line"></div>
                <div class="full-line"></div>
            </div>

            <!-- SECCIÓN V: DIAGNÓSTICO -->
            <div class="section">
                <div class="section-title" style="text-decoration: underline;">V. <span style="margin-left: 10px;">DIAGNOSTICO:</span></div>
                <div class="full-line">{{ $historia->diagnostico ?? '' }}</div>
                <div class="full-line"></div>
                <div class="full-line"></div>
            </div>

            <!-- SECCIÓN VI: TRATAMIENTO -->
            <div class="section">
                <div class="section-title" style="text-decoration: underline;">VI. <span style="margin-left: 10px;">TRATAMIENTO:</span></div>
                <table style="width: 100%; border-collapse: collapse;">
                    @php
                        $tratamientos = explode("\n", $historia->plan_tratamiento ?? '');
                    @endphp
                    @for($i = 1; $i <= 5; $i++)
                    <tr>
                        <td style="width: 20px; font-style: italic;">{{ $i }}.</td>
                        <td style="border-bottom: 1px solid #000; height: 22px; padding-left: 5px;">
                            {{ $tratamientos[$i-1] ?? '' }}
                        </td>
                    </tr>
                    @endfor
                </table>
            </div>

            <!-- PRÓXIMA CITA (si existe) -->
            @if($historia->proxima_cita)
            <div style="margin-top: 20px; padding: 10px; background: #d4edda; border-left: 5px solid #28a745;">
                <strong><i class="fas fa-calendar-check"></i> Próxima Cita:</strong> 
                {{ $historia->proxima_cita->format('d/m/Y') }}
            </div>
            @endif

            <!-- FIRMA DEL MÉDICO -->
            <div class="signature-box">
                <div class="signature-line">
                    Dr. {{ $historia->doctor->nombre ?? 'MEDICO TRATANTE' }}
                </div>
                <p style="margin-top: 5px; font-size: 11px;">CMP: _________________</p>
            </div>
        </div>
    </div>
</div>
@endsection