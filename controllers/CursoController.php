<?php
require_once '../config.php'; // Asegúrate de que la conexión a la base de datos está configurada correctamente
require_once '../models/Curso.php'; // Asegúrate de que la clase Curso está definida aquí
require_once '../services/CursoServices.php'; // Asegúrate de incluir tu archivo de servicios

// Instanciar el controlador
$cursoController = new CursoController($conn);

// Procesar la solicitud GET para obtener los cursos o matriculados por curso
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    // Verifica si se está solicitando el endpoint para obtener cursos por alumno ID
    if (isset($_GET['id'])) {
        // Llamada a la API para obtener cursos por alumno ID
        $cursoController->apiObtenerCursosPorAlumnoId($_GET['id']);
    } elseif (isset($_GET['action']) && $_GET['action'] === 'matriculados') {
        // Llamada a la API para obtener matriculados por curso
        $cursoController->apiObtenerMatriculadosPorCurso();
    } else {
        // Llamada a la vista HTML para mostrar cursos
        $cursoController->verCursos();
    }
}


class CursoController {
    private $conn; 

 
    public function __construct($connection) {
        $this->conn = $connection;
    }

 
    public function verCursos() {
        
        $cursos = CursoServices::obtenerMatriculadosPorCurso($this->conn);
        
        if (empty($cursos)) {
            echo "No hay cursos matriculados.";
        } else {
            echo "Cursos matriculados:";
            print_r($cursos); 
        }


        require_once '../views/cursosView.php';
    }

    // Método para obtener todos los cursos en formato JSON (API)
    /* public function apiObtenerCursos() {
        $cursos = CursoServices::obtenerCursos($this->conn);
        header('Content-Type: application/json'); // Establece el tipo de contenido a JSON
        echo json_encode($cursos); // Devuelve la lista de cursos en formato JSON
        exit;
    }
    */

    
    public function apiObtenerMatriculadosPorCurso() {
        $matriculados = CursoServices::obtenerMatriculadosPorCurso($this->conn);
        header('Content-Type: application/json'); 
        echo json_encode($matriculados); 
        exit;
    }

    
    public function apiObtenerCursosPorAlumnoId($alumno_id) {
        
        if (!is_numeric($alumno_id)) {
            http_response_code(400); 
            echo json_encode(['error' => 'ID de alumno inválido.']);
            exit;
        }

        $cursos = CursoServices::obtenerCursosPorAlumnoId($this->conn, $alumno_id);
        header('Content-Type: application/json'); 
        echo json_encode($cursos); 
        exit;
    }
}
?>
