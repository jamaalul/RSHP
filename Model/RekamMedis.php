<?php

namespace Model;

use Core\Container;
use mysqli;

class RekamMedis
{
    protected Container $container;
    protected mysqli $db;

    public function __construct(Container $container)
    {
        $this->container = $container;
        $this->db = $container->get('db');
    }

    public function getAll(): array
    {
        $query = "SELECT 
                        rm.idrekam_medis as id,
                        rm.created_at as 'Tanggal',
                        p.nama as 'Pet',
                        u.nama as 'Dokter',
                        rm.diagnosa as 'Diagnosa'
                  FROM rekam_medis rm
                  JOIN pet p ON rm.idpet = p.idpet
                  JOIN role_user ru ON rm.dokter_pemeriksa = ru.idrole_user
                  JOIN user u ON ru.iduser = u.iduser
                  ORDER BY rm.created_at DESC";
        
        $result = $this->db->query($query);

        $data = [];
        while ($row = $result->fetch_object()) {
            $data[] = $row;
        }

        return $data;
    }

    public function find($id): ?\stdClass
    {
        $stmt = $this->db->prepare("SELECT * FROM rekam_medis WHERE idrekam_medis = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $rekam_medis = $result->fetch_object();
        $stmt->close();

        return $rekam_medis ?: null;
    }

    public function add(array $data): int
    {
        $stmt = $this->db->prepare("INSERT INTO rekam_medis (created_at, anamnesa, temuan_klinis, diagnosa, idpet, dokter_pemeriksa, idreservasi_dokter) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $created_at = date('Y-m-d H:i:s');
        $stmt->bind_param("ssssiii", $created_at, $data['anamnesa'], $data['temuan_klinis'], $data['diagnosa'], $data['idpet'], $data['dokter_pemeriksa'], $data['idreservasi_dokter']);
        $stmt->execute();
        $newId = $this->db->insert_id;
        $stmt->close();
        return $newId;
    }

    public function update(int $id, array $data): bool
    {
        $stmt = $this->db->prepare("UPDATE rekam_medis SET anamnesa = ?, temuan_klinis = ?, diagnosa = ?, idpet = ?, dokter_pemeriksa = ?, idreservasi_dokter = ? WHERE idrekam_medis = ?");
        $stmt->bind_param("sssiiii", $data['anamnesa'], $data['temuan_klinis'], $data['diagnosa'], $data['idpet'], $data['dokter_pemeriksa'], $data['idreservasi_dokter'], $id);
        $success = $stmt->execute();
        $stmt->close();
        return $success;
    }

    public function delete(int $id): bool
    {
        $stmt = $this->db->prepare("DELETE FROM rekam_medis WHERE idrekam_medis = ?");
        $stmt->bind_param("i", $id);
        $success = $stmt->execute();
        $stmt->close();
        return $success;
    }
}