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

    public function add(array $data): void
    {
        // Add to user table
        $stmt = $this->db->prepare("INSERT INTO user (nama, email, password) VALUES (?, ?, ?)");
        //- create a default password, since it's not in the form
        $password = password_hash('password', PASSWORD_DEFAULT);
        $stmt->bind_param("sss", $data['nama'], $data['email'], $password);
        $stmt->execute();
        $iduser = $this->db->insert_id;
        $stmt->close();

        // Add to pemilik table
        $stmt = $this->db->prepare("INSERT INTO pemilik (iduser, no_wa, alamat) VALUES (?, ?, ?)");
        $stmt->bind_param("iss", $iduser, $data['no_wa'], $data['alamat']);
        $stmt->execute();
        $stmt->close();
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
        // Find the pemilik to get the associated user id
        $pemilik = $this->find($id);
        if (!$pemilik) {
            return false;
        }
        $iduser = $pemilik->iduser;

        // Delete from pemilik table
        $stmt = $this->db->prepare("DELETE FROM pemilik WHERE idpemilik = ?");
        $stmt->bind_param("i", $id);
        $success1 = $stmt->execute();
        $stmt->close();

        // Delete from user table
        $stmt = $this->db->prepare("DELETE FROM user WHERE iduser = ?");
        $stmt->bind_param("i", $iduser);
        $success2 = $stmt->execute();
        $stmt->close();

        return $success1 && $success2;
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