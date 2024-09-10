<?php
// classes/Puesto.php
require_once '../config/conexion.php';

class Puesto {
    private $db;

    public function __construct() {
        $this->db = new DBConnection();
    }

    public function obtenerPuestos() {
        $query = $this->db->conn->query("SELECT * FROM puestos");
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>
