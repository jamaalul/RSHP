<?php

namespace Model;

use Core\Container;
use mysqli;

class Kategori
{
    protected Container $container;
    protected mysqli $db;
    public $idkategori;
    public $nama_kategori;

    public function __construct(Container $container)
    {
        $this->container = $container;
        $this->db = $container->get('db');
    }

    public function getAll(): array
    {
        $query = "SELECT idkategori as id, nama_kategori as nama FROM kategori";
        $result = $this->db->query($query);

        $kategori = [];
        while ($row = $result->fetch_object()) {
            $kategori[] = $row;
        }

        return $kategori;
    }
}