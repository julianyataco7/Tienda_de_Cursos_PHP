<?php
require_once '../config.php'; 
class InscripcionServices {

   
    public static function verificarCupo($conn, $curso_id) {
        $sql = "SELECT COUNT(*) AS inscriptos FROM inscripciones WHERE curso_id = ?";
        $stmt = $conn->prepare($sql); 
        $stmt->bind_param('i', $curso_id); 
        $stmt->execute(); 
        $result = $stmt->get_result(); 
        $row = $result->fetch_assoc(); 

        return $row['inscriptos'] < 10; 
    }


    public static function verificarLimiteInscripciones($conn, $alumno_id) {
        $sql = "SELECT COUNT(*) AS inscripciones FROM inscripciones WHERE alumno_id = ?";
        $stmt = $conn->prepare($sql); 
        $stmt->bind_param('i', $alumno_id); 
        $stmt->execute(); 
        $result = $stmt->get_result(); 
        $row = $result->fetch_assoc(); 

        return $row['inscripciones'] < 2; 
    }

 
    public static function inscribir($conn, $alumno_id, $curso_id) {
        $sql = "INSERT INTO inscripciones (alumno_id, curso_id) VALUES (?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('ii', $alumno_id, $curso_id); 

        if ($stmt->execute()) {
            return true; 
        } else {
          
            die('Error en la ejecución de la consulta: ' . $stmt->error);
        }
    }
}
?>
