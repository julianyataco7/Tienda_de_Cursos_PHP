<?php
require_once '../config.php';
require_once '../services/AlumnoServices.php';


$alumnoController = new AlumnoController($conn);


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action'])) {
        if ($_POST['action'] === 'validar') {
            $alumnoController->iniciarSesion();
        } elseif ($_POST['action'] === 'registrar') {
            $alumnoController->registrarAlumno();
        }
    }
} elseif ($_SERVER['REQUEST_METHOD'] === 'GET') {
    if (isset($_GET['action']) && $_GET['action'] === 'obtener') {
        $alumnoController->obtenerAlumnos();
    } elseif (isset($_GET['action']) && $_GET['action'] === 'buscar' && isset($_GET['id'])) {
        $alumnoController->buscarAlumnoPorId();
    }
}

class AlumnoController
{
    private $alumnoService;

    public function __construct($connection)
    {
        $this->alumnoService = new AlumnoServices($connection);
    }

    public function registrarAlumno()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nombre = $_POST['nombre'];
            $email = $_POST['email'];

            $ultimo_alumno_id = $this->alumnoService->registrarAlumno($nombre, $email);

            if ($ultimo_alumno_id) {
                header("Location: ../views/CursoView.php?alumno_id=$ultimo_alumno_id");
                exit;
            } else {
                die('Error al registrar el alumno');
            }
        }
    }

    public function iniciarSesion()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nombre = $_POST['nombre'];
            $email = $_POST['email'];

            $alumnoId = $this->alumnoService->obtenerIdAlumnoPorNombreYEmail($nombre, $email);
            if ($alumnoId !== null) {
                header("Location: ../views/CursoView.php?alumno_id=$alumnoId");
            } else {
                echo "No se encontró ningún alumno con ese nombre y email.";
            }
        }
    }

    public function obtenerAlumnos()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            $alumnos = $this->alumnoService->obtenerAlumnos();
            header('Content-Type: application/json');
            echo json_encode($alumnos);
            exit;
        }
    }

    // Nuevo método para buscar un alumno por ID
    public function buscarAlumnoPorId()
    {
        if (isset($_GET['id'])) {
            $id = $_GET['id'];
            $alumno = $this->alumnoService->obtenerAlumnoPorId($id);

            if ($alumno) {
                header('Content-Type: application/json');
                echo json_encode($alumno);
            } else {
                echo json_encode(['mensaje' => 'Alumno no encontrado.']);
            }
            exit;
        } else {
            echo json_encode(['mensaje' => 'ID no proporcionado.']);
            exit;
        }
    }
}
