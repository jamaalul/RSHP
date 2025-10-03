<?php

namespace Model;

use Core\Container;
use mysqli;

class KategoriKlinis
{
    protected Container $container;
    protected mysqli $db;
    public $idkategori_klinis;
    public $nama_kategori_klinis;

    public function __construct(Container $container)
    {
        $this->container = $container;
        $this->db = $container->get('db');
    }

    public function getAll(): array
    {
        $query = "SELECT idkategori_klinis as id, nama_kategori_klinis as nama FROM kategori_klinis";
        $result = $this->db->query($query);

        $kategoriKlinis = [];
        while ($row = $result->fetch_object()) {
            $kategoriKlinis[] = $row;
        }

        return $kategoriKlinis;
    }
}