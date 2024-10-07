<?php
require_once '../config.php'; 
require_once '../models/Curso.php'; 

class CursoServices {

    // Método para obtener todos los cursos
    /*public static function obtenerCursos($conn) {
        $sql = "SELECT * FROM cursos"; // Consulta para obtener todos los cursos
        $result = $conn->query($sql); // Ejecuta la consulta

        $cursos = []; // Inicializa un array para almacenar los cursos

        // Recorre cada fila del resultado y crea un objeto Curso
        while ($row = $result->fetch_assoc()) {
            $cursos[] = new Curso($row['id'], $row['nombre'], $row['costo'], $row['cupo_maximo']);
        }

        return $cursos; // Retorna el array de cursos
    }
    */

   
    public static function obtenerMatriculadosPorCurso($conn) {
        $sql = "CALL sp_MatriculadosxCurso()"; 
        $result = $conn->query($sql); 

        $matriculados = []; 

        if ($result) {
           
            while ($row = $result->fetch_assoc()) {
                $matriculados[] = [
                    'id' => $row['ID'],
                    'curso' => $row['CURSO'],                
                    'matriculados' => $row['MATRICULADOS'],  
                    'costo' => $row['COSTO'],                
                    'cupo_maximo' => $row['CUPO_MAXIMO']     
                ];
            }
            $result->free(); 
        } else {
           
            echo "Error en la consulta: " . $conn->error;
        }

        return $matriculados; 
    }


    public static function obtenerCursosPorAlumnoId($conn, $alumno_id) {
        $sql = "CALL sp_cursos_obtenidos(?)"; 
        $stmt = $conn->prepare($sql); 

        if ($stmt) {
            $stmt->bind_param("i", $alumno_id); 
            $stmt->execute(); 
            $result = $stmt->get_result(); 

            $cursos = []; 

            if ($result) {
                
                while ($row = $result->fetch_assoc()) {
                    $cursos[] = [
                        'curso' => $row['CURSO'],                
                        'matriculados' => $row['MATRICULADOS'],  
                        'costo' => $row['COSTO'],                
                        'cupo_maximo' => $row['CUPO_MAXIMO']     
                    ];
                }
                $result->free(); 
            } else {
                
                echo "Error en la consulta: " . $conn->error;
            }

            $stmt->close(); 
            return $cursos; 
        } else {
            
            echo "Error en la preparación de la consulta: " . $conn->error;
            return []; 
        }
    }
}
?>
