<?php
require_once '../config.php';
require_once '../models/Alumno.php';

class AlumnoServices {

    private $conn;

    public function __construct($connection) {
        $this->conn = $connection;
    }

    public function obtenerAlumnos() {
        $sql = "SELECT * FROM alumnos";
        $result = $this->conn->query($sql);
        $alumnos = [];
    
        while ($row = $result->fetch_assoc()) {
            $alumnos[] = $row; 
        }
        
        return $alumnos;
    }

    public function registrarAlumno($nombre, $email) {
       
        $stmt = $this->conn->prepare("INSERT INTO alumnos (nombre, email) VALUES (?, ?)");
        if ($stmt === false) {
            die('Error en la preparación de la consulta: ' . $this->conn->error);
        }


        $stmt->bind_param('ss', $nombre, $email);

        
        if ($stmt->execute()) {
           
            return $this->conn->insert_id;
        } else {
           
            die('Error en la ejecución de la consulta: ' . $stmt->error);
        }
    }

    public function obtenerAlumnoPorId($id) {
        $stmt = $this->conn->prepare("SELECT * FROM alumnos WHERE id = ?");
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }

    public function obtenerIdAlumnoPorNombreYEmail($nombre, $email) {
        $stmt = $this->conn->prepare("SELECT id FROM alumnos WHERE nombre = ? AND email = ?");
        $stmt->bind_param('ss', $nombre, $email);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
    
        // Retorna el ID si existe, de lo contrario retorna null
        return $row ? $row['id'] : null; 
    }
    
}

// Instanciar el servicio en tu controlador
// $alumnoService = new AlumnoService($conn);
?>
