<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Grupo;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;

class ReporteExcelController extends Controller
{
    public function generarReporte(Request $request)
    {
        $request->validate([
            'planteles' => 'required|array|min:1'
        ]);

        $plantelesIds = $request->input('planteles');

        // Fetch groups and relationships
        $grupos = Grupo::whereIn('plantel_id', $plantelesIds)
            ->with(['plantel', 'curso', 'cursoIcategro', 'listaAlumnos.student', 'especialidadOcupacional', 'campoFormacion'])
            ->get();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // --- ROW 1: MEGA HEADERS ---
        $sheet->mergeCells('A1:M1');
        $sheet->setCellValue('A1', 'Datos del grupo');

        $sheet->mergeCells('N1:X1');
        $sheet->setCellValue('N1', 'Datos del alumno');

        $sheet->mergeCells('Y1:AE1');
        $sheet->setCellValue('Y1', 'Datos del alumno en grupo');

        $sheet->mergeCells('AF1:AT1');
        $sheet->setCellValue('AF1', 'Grupos vulnerables del alumno');

        $sheet->mergeCells('AU1:AY1');
        $sheet->setCellValue('AU1', 'Discapacidades del alumno');

        // Styles for Row 1
        $styleHeader1 = [
            'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
            'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER, 'vertical' => Alignment::VERTICAL_CENTER],
            'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => '000000']],
        ];
        $sheet->getStyle('A1:AY1')->applyFromArray($styleHeader1);

        // --- ROW 2: COLUMN HEADERS ---
        $columnas = [
            // Datos del grupo
            'A' => 'Centro de Capacitación', 'B' => 'ID del grupo', 'C' => 'Clave del grupo', 'D' => 'Estatus del grupo', 'E' => 'Campo de formación profesional', 'F' => 'Especialidad', 'G' => 'Nombre del Curso', 'H' => 'Tipo de servicio', 'I' => 'Tipo de capacitación', 'J' => 'Fecha de inicio', 'K' => 'Fecha de término', 'L' => 'Días', 'M' => 'Horas',
            // Datos del alumno
            'N' => 'ID del alumno', 'O' => 'Nombre', 'P' => 'Apellido 1', 'Q' => 'Apellido 2', 'R' => 'CURP', 'S' => 'Sexo', 'T' => 'Matricula', 'U' => 'Fecha de nacimiento', 'V' => 'CP', 'W' => 'Email', 'X' => 'Teléfono',
            // Datos del alumno en grupo
            'Y' => 'Edad', 'Z' => 'Escolaridad', 'AA' => 'Calificación', 'AB' => 'Estatus Alumno', 'AC' => 'Tipo Documento', 'AD' => 'Folio', 'AE' => 'Fecha captura',
            // Grupos vulnerables
            'AF' => 'Mujeres jefas de familia', 'AG' => 'Adolescentes', 'AH' => 'Personas jóvenes', 'AI' => 'Adultos Mayores', 'AJ' => 'Personas con discapacidad', 'AK' => 'Personas de la diversidad sexual', 'AL' => 'Personas migrantes refugiados y solociantes de asilo', 'AM' => 'Personas en situación de calle', 'AN' => 'Personas privadas de la libertad', 'AO' => 'Personas residentes en instituciones de asistencia social', 'AP' => 'Personas afrodescendientes', 'AQ' => 'Personas indígnas o pertenecientes a una etnia', 'AR' => 'Minorías religiosas', 'AS' => 'Personas desempleadas', 'AT' => 'Poblaciones marginadas',
            // Discapacidades
            'AU' => 'Para ver', 'AV' => 'Para oir', 'AW' => 'Para hablar', 'AX' => 'Motriz', 'AY' => 'Mental',
        ];

        foreach ($columnas as $col => $title) {
            $sheet->setCellValue($col . '2', $title);
        }

        // Styles for Row 2
        $styleHeader2 = [
            'font' => ['color' => ['rgb' => '000000']],
            'alignment' => [
                'horizontal' => Alignment::HORIZONTAL_CENTER, 
                'vertical' => Alignment::VERTICAL_CENTER,
                'wrapText' => true
            ],
            'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => '808080']], // Gray background
            'borders' => [
                'allBorders' => ['borderStyle' => Border::BORDER_THIN],
            ],
        ];
        $sheet->getStyle('A2:AY2')->applyFromArray($styleHeader2);

        // Set row 2 height to accommodate wrapped text
        $sheet->getRowDimension(2)->setRowHeight(40);

        // --- MAPPINGS ---
        $vulnerablesMap = [
            'MUJERES JEFAS DE FAMILIA' => 'AF',
            'ADOLESCENTES' => 'AG',
            'PERSONAS JÓVENES' => 'AH',
            'ADULTOS MAYORES' => 'AI',
            'PERSONAS CON DISCAPACIDAD' => 'AJ',
            'PERSONAS DE LA DIVERSIDAD SEXUAL' => 'AK',
            'PERSONAS MIGRANTES, REFUGIADOS Y SOLICITANTES DE ASILO' => 'AL',
            'PERSONAS EN SITUACIÓN DE CALLE' => 'AM',
            'PERSONAS PRIVADAS DE LA LIBERTAD' => 'AN',
            'PERSONAS RESIDENTES EN INSTITUCIONES DE ASISTENCIA SOCIAL' => 'AO',
            'PERSONAS AFRODESCENDIENTES' => 'AP',
            'PERSONAS INDÍGENAS O PERTENECIENTES A ALGUNA ETNIA' => 'AQ',
            'MINORÍAS RELIGIOSAS' => 'AR',
            'PERSONAS DESEMPLEADAS' => 'AS',
            'POBLACIONES MARGINADAS' => 'AT'
        ];

        $discapacidadesMap = [
            'PARA VER' => 'AU',
            'PARA OIR' => 'AV',
            'PARA HABLAR' => 'AW',
            'MOTRIZ' => 'AX',
            'MENTAL' => 'AY'
        ];

        // --- ROW 3 AND BEYOND: THE DATA ---
        $rowNum = 3;
        foreach ($grupos as $grupo) {
            $centroCapacitacion = $grupo->plantel ? $grupo->plantel->name : 'N/A';
            $idGrupo = $grupo->id;
            $claveGrupo = $grupo->numero_grupo ?? 'N/A';
            $estatusGrupo = $grupo->estatus;
            $campoFormacion = $grupo->campoFormacion ? $grupo->campoFormacion->name : 'N/A';
            $especialidad = $grupo->especialidadOcupacional ? $grupo->especialidadOcupacional->name : 'N/A';
            $nombreCurso = $grupo->nombre_curso;
            $tipoServicio = $grupo->tipo_servicio;
            $tipoCapacitacion = $grupo->modalidad ?? $grupo->modalidad_ce ?? 'N/A';
            $fechaInicio = $grupo->fecha_inicio ? \Carbon\Carbon::parse($grupo->fecha_inicio)->format('d/m/Y') : 'N/A';
            $fechaTermino = $grupo->fecha_termino ? \Carbon\Carbon::parse($grupo->fecha_termino)->format('d/m/Y') : 'N/A';
            $dias = $grupo->duracion_dias;
            $horas = $grupo->duracion_horas;

            foreach ($grupo->listaAlumnos as $alumnoPivot) {
                $student = $alumnoPivot->student;
                if (!$student) continue;

                // Datos del grupo
                $sheet->setCellValue('A'.$rowNum, $centroCapacitacion);
                $sheet->setCellValue('B'.$rowNum, $idGrupo);
                $sheet->setCellValue('C'.$rowNum, $claveGrupo);
                $sheet->setCellValue('D'.$rowNum, $estatusGrupo);
                $sheet->setCellValue('E'.$rowNum, $campoFormacion);
                $sheet->setCellValue('F'.$rowNum, $especialidad);
                $sheet->setCellValue('G'.$rowNum, $nombreCurso);
                $sheet->setCellValue('H'.$rowNum, $tipoServicio);
                $sheet->setCellValue('I'.$rowNum, $tipoCapacitacion);
                $sheet->setCellValue('J'.$rowNum, $fechaInicio);
                $sheet->setCellValue('K'.$rowNum, $fechaTermino);
                $sheet->setCellValue('L'.$rowNum, $dias);
                $sheet->setCellValue('M'.$rowNum, $horas);

                // Datos del alumno
                $sheet->setCellValue('N'.$rowNum, $student->id);
                $sheet->setCellValue('O'.$rowNum, $student->name);
                $sheet->setCellValue('P'.$rowNum, $student->lastname1);
                $sheet->setCellValue('Q'.$rowNum, $student->lastname2);
                $sheet->setCellValue('R'.$rowNum, $student->curp);
                $sheet->setCellValue('S'.$rowNum, $student->sexo);
                $sheet->setCellValue('T'.$rowNum, $student->matricula);
                $sheet->setCellValue('U'.$rowNum, $student->fecha_nacimiento);
                $sheet->setCellValue('V'.$rowNum, $student->zip_code);
                $sheet->setCellValue('W'.$rowNum, $student->email);
                $sheet->setCellValue('X'.$rowNum, $student->phone1);

                // Datos del alumno en grupo
                $sheet->setCellValue('Y'.$rowNum, $student->edad);
                $sheet->setCellValue('Z'.$rowNum, $alumnoPivot->escolaridad);
                $sheet->setCellValue('AA'.$rowNum, $alumnoPivot->calificacion);
                $sheet->setCellValue('AB'.$rowNum, $alumnoPivot->student_status);
                $sheet->setCellValue('AC'.$rowNum, $alumnoPivot->doc_type);
                $sheet->setCellValue('AD'.$rowNum, $alumnoPivot->folio);
                $sheet->setCellValue('AE'.$rowNum, $alumnoPivot->created_at ? $alumnoPivot->created_at->format('d/m/Y') : '');

                // Vulnerables
                $vs = $alumnoPivot->grupos_vulnerables ?? [];
                foreach ($vulnerablesMap as $key => $col) {
                    if (in_array(strtoupper($key), array_map('strtoupper', $vs))) {
                        $sheet->setCellValue($col.$rowNum, 'X');
                    }
                }

                // Discapacidades
                $ds = $alumnoPivot->discapacidades ?? [];
                foreach ($discapacidadesMap as $key => $col) {
                    if (in_array(strtoupper($key), array_map('strtoupper', $ds))) {
                        $sheet->setCellValue($col.$rowNum, 'X');
                    }
                }

                $rowNum++;
            }
        }

        // Apply borders for all data rows
        if ($rowNum > 3) {
            $sheet->getStyle('A3:AY'.($rowNum - 1))->applyFromArray([
                'borders' => [
                    'allBorders' => ['borderStyle' => Border::BORDER_THIN],
                ],
                'alignment' => [
                    'vertical' => Alignment::VERTICAL_CENTER,
                ]
            ]);
        }

        // Auto-size columns A to AY
        for ($i = 'A'; $i !== 'AZ'; $i++) {
            $sheet->getColumnDimension($i)->setAutoSize(true);
        }

        $writer = new Xlsx($spreadsheet);
        $fileName = 'Reporte_Alumnos_Grupos_' . date('Ymd_His') . '.xlsx';
        
        return response()->streamDownload(function() use ($writer) {
            $writer->save('php://output');
        }, $fileName, [
            'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            'Cache-Control' => 'max-age=0'
        ]);
    }
}
