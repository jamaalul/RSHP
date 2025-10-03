<?php

namespace Model;

use Core\Container;
use mysqli;

class JenisHewan
{
    protected Container $container;
    protected mysqli $db;

    public function __construct(Container $container)
    {
        $this->container = $container;
        $this->db = $container->get('db'); // Get the mysqli instance from the container
    }

    public function getAll(): array
    {
        $query = "SELECT idjenis_hewan as id, nama_jenis_hewan as Nama FROM jenis_hewan";
        $result = $this->db->query($query);

        $jenis = [];
        while ($row = $result->fetch_object()) {
            $jenis[] = $row;
        }

        return $jenis;
    }

    public function getAllwithRas(): array
    {
        $query = "SELECT 
                    rh.nama_ras,
                    jh.idjenis_hewan as id, 
                    jh.nama_jenis_hewan as Nama,
                    rh.idras_hewan
                FROM jenis_hewan jh
                LEFT JOIN ras_hewan rh ON jh.idjenis_hewan = rh.idjenis_hewan
                ORDER BY jh.nama_jenis_hewan, rh.nama_ras";
        
        $result = $this->db->query($query);
        $data = [];

        while ($row = $result->fetch_assoc()) {
            $jenisId = $row['id'];
            if (!isset($data[$jenisId])) {
                $data[$jenisId] = [
                    'id' => $row['id'],
                    'Nama' => $row['Nama'],
                    'ras' => []
                ];
            }

            if ($row['idras_hewan']) {
                $data[$jenisId]['ras'][] = [
                    'idras_hewan' => $row['idras_hewan'],
                    'nama_ras' => $row['nama_ras']
                ];
            }
        }
        return array_values($data);
    }
    public function findJenisHewan($id)
    {
        $stmt = $this->db->prepare("SELECT idjenis_hewan as id, nama_jenis_hewan as nama FROM jenis_hewan WHERE idjenis_hewan = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $jhewan = $result->fetch_object();
        $stmt->close();
        return $jhewan;
    }

    public function updateJenisHewan($id, $nama_jenis_hewan)
    {
        $stmt = $this->db->prepare("UPDATE jenis_hewan SET nama_jenis_hewan = ? WHERE idjenis_hewan = ?");
        $stmt->bind_param("si", $nama_jenis_hewan, $id);
        $success = $stmt->execute();
        $stmt->close();
        return $success;
    }
}