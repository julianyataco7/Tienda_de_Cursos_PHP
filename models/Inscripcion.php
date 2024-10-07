<?php
class Inscripcion {
    public $id;
    public $alumno_id;
    public $curso_id;

    public function __construct($id, $alumno_id, $curso_id) {
        $this->id = $id;
        $this->alumno_id = $alumno_id;
        $this->curso_id = $curso_id;
    }

   
}
?>
