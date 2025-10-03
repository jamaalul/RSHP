<?php

namespace Model;

use Core\Container;
use mysqli;

class KodeTindakanTerapi
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
                        ktt.idkode_tindakan_terapi as id, 
                        ktt.kode, 
                        ktt.deskripsi_tindakan_terapi as deskripsi, 
                        k.nama_kategori as kategori, 
                        kk.nama_kategori_klinis as kategori_klinis
                  FROM kode_tindakan_terapi ktt
                  JOIN kategori k ON ktt.idkategori = k.idkategori
                  JOIN kategori_klinis kk ON ktt.idkategori_klinis = kk.idkategori_klinis";
        
        $result = $this->db->query($query);

        $data = [];
        while ($row = $result->fetch_object()) {
            $data[] = $row;
        }

        return $data;
    }
}