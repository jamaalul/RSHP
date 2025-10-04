<?php

namespace Model;

use Core\Container;
use mysqli;

class Pet
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
        $query = "SELECT p.idpet AS id, p.nama AS Nama, p.tanggal_lahir AS 'Tanggal Lahir', rh.nama_ras AS Ras, jh.nama_jenis_hewan AS Jenis
                  FROM pet p
                  JOIN ras_hewan rh ON p.idras_hewan = rh.idras_hewan
                  JOIN jenis_hewan jh ON rh.idjenis_hewan = jh.idjenis_hewan";
        $result = $this->db->query($query);

        $pets = [];
        while ($row = $result->fetch_object()) {
            $pets[] = $row;
        }

        return $pets;
    }

    public function find($id): ?\stdClass
    {
        $stmt = $this->db->prepare("SELECT * FROM pet WHERE idpet = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $pet = $result->fetch_object();
        $stmt->close();

        return $pet ?: null;
    }

    public function create($data): bool
    {
        $stmt = $this->db->prepare("INSERT INTO hewan (idpemilik, idras, nama, tgl_lahir) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("iiss", $data['idpemilik'], $data['idras'], $data['nama'], $data['tgl_lahir']);
        $success = $stmt->execute();
        $stmt->close();
        return $success;
    }

    public function add($data): bool
    {
        $stmt = $this->db->prepare("INSERT INTO pet (nama, tanggal_lahir, warna_tanda, jenis_kelamin, idpemilik, idras_hewan) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssii", $data['nama'], $data['tanggal_lahir'], $data['warna_tanda'], $data['jenis_kelamin'], $data['idpemilik'], $data['idras_hewan']);
        $success = $stmt->execute();
        $stmt->close();
        return $success;
    }

    public function update($id, $data): bool
    {
        $stmt = $this->db->prepare("UPDATE pet SET nama = ?, tanggal_lahir = ?, warna_tanda = ?, jenis_kelamin = ?, idpemilik = ?, idras_hewan = ? WHERE idpet = ?");
        $stmt->bind_param("ssssiii", $data['nama'], $data['tanggal_lahir'], $data['warna_tanda'], $data['jenis_kelamin'], $data['idpemilik'], $data['idras_hewan'], $id);
        $success = $stmt->execute();
        $stmt->close();
        return $success;
    }

    public function delete($id): bool
    {
        $stmt = $this->db->prepare("DELETE FROM hewan WHERE idhewan = ?");
        $stmt->bind_param("i", $id);
        $success = $stmt->execute();
        $stmt->close();
        return $success;
    }

    public function getAllWithOwner(): array
    {
        $query = "SELECT h.idpet AS id, h.nama AS Nama, h.tanggal_lahir AS 'Tanggal Lahir',
                         rh.nama_ras AS Ras, jh.nama_jenis_hewan AS Jenis,
                         p.nama AS Pemilik
                  FROM pet h
                  JOIN ras_hewan rh ON h.idras_hewan = rh.idras_hewan
                  JOIN jenis_hewan jh ON rh.idjenis_hewan = jh.idjenis_hewan
                  JOIN pemilik pem ON h.idpemilik = pem.idpemilik
                  JOIN user p ON pem.iduser = p.iduser";
        $result = $this->db->query($query);

        $pets = [];
        while ($row = $result->fetch_object()) {
            $pets[] = $row;
        }

        return $pets;
    }
}