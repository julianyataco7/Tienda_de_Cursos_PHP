<?php
class Curso {
    public $id;
    public $nombre;
    public $costo;
    public $cupo_maximo;
    public $cantidad_matriculados;

    public function __construct($id, $nombre, $costo, $cupo_maximo, $cantidad_matriculados) {
        $this->id = $id;
        $this->nombre = $nombre;
        $this->costo = $costo;
        $this->cupo_maximo = $cupo_maximo;
        $this->cantidad_matriculados = $cantidad_matriculados; 
    }
}

?>
