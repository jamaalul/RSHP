<?php

namespace Model;

use Core\Container;
use mysqli;

class Pemilik
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
        $query = "SELECT p.idpemilik AS id, u.nama AS Nama, p.no_wa AS 'Nomor HP', p.alamat AS Alamat
                  FROM pemilik p 
                  JOIN user u ON p.iduser = u.iduser";
        $result = $this->db->query($query);

        $pemilik = [];
        while ($row = $result->fetch_object()) {
            $pemilik[] = $row;
        }

        return $pemilik;
    }

    public function find($id): ?\stdClass
    {
        $stmt = $this->db->prepare("SELECT p.*, u.nama, u.email FROM pemilik p JOIN user u ON p.iduser = u.iduser WHERE p.idpemilik = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $pemilik = $result->fetch_object();
        $stmt->close();

        return $pemilik ?: null;
    }

    public function create($data): bool
    {
        $stmt = $this->db->prepare("INSERT INTO pemilik (iduser, no_hp, alamat) VALUES (?, ?, ?)");
        $stmt->bind_param("iss", $data['iduser'], $data['no_hp'], $data['alamat']);
        $success = $stmt->execute();
        $stmt->close();
        return $success;
    }

    public function update($id, $data): void
    {
        // Update pemilik table
        $stmt = $this->db->prepare("UPDATE pemilik SET no_wa = ?, alamat = ? WHERE idpemilik = ?");
        $stmt->bind_param("ssi", $data['no_wa'], $data['alamat'], $id);
        $stmt->execute();
        $stmt->close();

        // Update user table
        $stmt = $this->db->prepare("UPDATE user SET nama = ?, email = ? WHERE iduser = ?");
        $stmt->bind_param("ssi", $data['nama'], $data['email'], $data['iduser']);
        $stmt->execute();
        $stmt->close();
    }

    public function delete($id): bool
    {
        $stmt = $this->db->prepare("DELETE FROM pemilik WHERE idpemilik = ?");
        $stmt->bind_param("i", $id);
        $success = $stmt->execute();
        $stmt->close();
        return $success;
    }

    public function getAllUsers(): array
    {
        $query = "SELECT iduser, nama FROM user";
        $result = $this->db->query($query);

        $users = [];
        while ($row = $result->fetch_object()) {
            $users[] = $row;
        }

        return $users;
    }
}