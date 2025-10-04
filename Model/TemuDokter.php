<?php

namespace Model;

use Core\Container;
use mysqli;

class TemuDokter
{
    protected Container $container;
    protected mysqli $db;

    public function __construct(Container $container)
    {
        $this->container = $container;
        $this->db = $container->get('db');
    }

    public function getAllWithDetails(): array
    {
        $query = "SELECT 
                        td.idreservasi_dokter as id,
                        td.no_urut as 'No. Urut',
                        td.waktu_daftar as 'Waktu Daftar',
                        td.status as 'Status',
                        p.nama as 'Pet',
                        u.nama as 'Dokter'
                  FROM temu_dokter td
                  JOIN pet p ON td.idpet = p.idpet
                  JOIN role_user ru ON td.idrole_user = ru.idrole_user
                  JOIN user u ON ru.iduser = u.iduser
                  ORDER BY td.no_urut ASC";
        
        $result = $this->db->query($query);

        $data = [];
        while ($row = $result->fetch_object()) {
            $data[] = $row;
        }

        return $data;
    }

    public function add($data)
    {
        //- get today's date
        $today = date('Y-m-d');

        //- get the last `no_urut` for today
        $stmt = $this->db->prepare("SELECT MAX(CAST(no_urut AS UNSIGNED)) as max_urut FROM temu_dokter WHERE DATE(waktu_daftar) = ?");
        $stmt->bind_param("s", $today);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        $next_urut = ($row['max_urut'] ?? 0) + 1;
        $stmt->close();
        
        $waktu_daftar = date('Y-m-d H:i:s');
        $status = '1';

        $stmt = $this->db->prepare("INSERT INTO temu_dokter (idpet, idrole_user, no_urut, waktu_daftar, status) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("iiiss", $data['idpet'], $data['idrole_user'], $next_urut, $waktu_daftar, $status);
        $stmt->execute();
        $stmt->close();
    }

    public function findWithDetails($id): ?\stdClass
    {
        $stmt = $this->db->prepare("SELECT
                        td.idreservasi_dokter as id,
                        p.idpet,
                        ru.idrole_user as dokter_pemeriksa,
                        p.nama as pet_nama,
                        u.nama as dokter_nama
                  FROM temu_dokter td
                  JOIN pet p ON td.idpet = p.idpet
                  JOIN role_user ru ON td.idrole_user = ru.idrole_user
                  JOIN user u ON ru.iduser = u.iduser
                  WHERE td.idreservasi_dokter = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $data = $result->fetch_object();
        $stmt->close();

        return $data ?: null;
    }

    public function getAllWaiting(): array
    {
        $query = "SELECT
                        td.idreservasi_dokter as id,
                        p.nama as pet_nama,
                        u.nama as dokter_nama
                  FROM temu_dokter td
                  JOIN pet p ON td.idpet = p.idpet
                  JOIN role_user ru ON td.idrole_user = ru.idrole_user
                  JOIN user u ON ru.iduser = u.iduser
                  WHERE td.status = '1'
                  ORDER BY td.no_urut ASC";
        
        $result = $this->db->query($query);

        $data = [];
        while ($row = $result->fetch_object()) {
            $data[] = $row;
        }

        return $data;
    }
}