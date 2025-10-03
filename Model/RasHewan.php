<?php

namespace Model;

use Core\Container;
use mysqli;

class RasHewan
{
    protected Container $container;
    protected mysqli $db;

    public function __construct(Container $container)
    {
        $this->container = $container;
        $this->db = $container->get('db'); // Get the mysqli instance from the container
    }

    public function getAll(): array{
        $query = "SELECT r.idras_hewan as id, r.nama_ras as Nama, j.nama_jenis_hewan as Jenis
                  FROM ras_hewan r
                  JOIN jenis_hewan j ON r.idjenis_hewan = j.idjenis_hewan";
        $result = $this->db->query($query);

        $ras = [];
        while ($row = $result->fetch_object()) {
            $ras[] = $row;
        }

        return $ras;
    }
    public function addRas($idjenis_hewan, $nama_ras)
    {
        $stmt = $this->db->prepare("INSERT INTO ras_hewan (idjenis_hewan, nama_ras) VALUES (?, ?)");
        $stmt->bind_param("is", $idjenis_hewan, $nama_ras);
        $success = $stmt->execute();
        $stmt->close();
        return $success;
    }
    public function findRasHewan($id)
    {
        $stmt = $this->db->prepare("SELECT idras_hewan as id, nama_ras, idjenis_hewan FROM ras_hewan WHERE idras_hewan = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $ras = $result->fetch_object();
        $stmt->close();
        return $ras;
    }

    public function updateRasHewan($id, $nama_ras, $idjenis_hewan)
    {
        $stmt = $this->db->prepare("UPDATE ras_hewan SET nama_ras = ?, idjenis_hewan = ? WHERE idras_hewan = ?");
        $stmt->bind_param("sii", $nama_ras, $idjenis_hewan, $id);
        $success = $stmt->execute();
        $stmt->close();
        return $success;
    }
}