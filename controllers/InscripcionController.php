<?php
require_once '../config.php'; 
require_once '../services/InscripcionServices.php'; 


$inscripcionController = new InscripcionController($conn);


if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['alumno_id']) && isset($_POST['curso_id'])) {
    $alumno_id = intval($_POST['alumno_id']);
    $curso_id = intval($_POST['curso_id']);
    $inscripcionController->inscribirAlumno($alumno_id, $curso_id);
} else {
    http_response_code(400); 
    echo json_encode(['error' => 'Parámetros inválidos.']);
    exit;
}

class InscripcionController {
    private $conn; 

   
    public function __construct($connection) {
        $this->conn = $connection;
    }

  
    public function inscribirAlumno($alumno_id, $curso_id) {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
           
            if (!InscripcionServices::verificarCupo($this->conn, $curso_id)) {
                http_response_code(400); 
                echo json_encode(['error' => 'No hay cupo disponible en el curso.']);
                exit;
            }

           
            if (!InscripcionServices::verificarLimiteInscripciones($this->conn, $alumno_id)) {
                http_response_code(400); 
                echo json_encode(['error' => 'El alumno ha alcanzado el límite de inscripciones.']);
                exit;
            }

           
            if (InscripcionServices::inscribir($this->conn, $alumno_id, $curso_id)) {
                echo json_encode(['success' => 'Inscripción realizada con éxito.']);
            } else {
                http_response_code(500); 
                echo json_encode(['error' => 'Error al inscribir al alumno.']);
            }
        } else {
            http_response_code(405); 
            echo json_encode(['error' => 'Método no permitido. Solo se aceptan solicitudes POST.']);
            exit;
        }
    }
}


