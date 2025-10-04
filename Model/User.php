<?php

namespace Model;

use Core\Container;
use mysqli;

class User
{
    protected Container $container;
    protected mysqli $db;

    public function __construct(Container $container)
    {
        $this->container = $container;
        $this->db = $container->get('db'); // Get the mysqli instance from the container
    }

    public function findByEmail(string $email): ?array
    {
        $statement = $this->db->prepare("SELECT u.*, r.nama_role AS role FROM user u JOIN role_user ru ON u.iduser = ru.iduser JOIN role r ON ru.idrole = r.idrole WHERE u.email = ?");
        $statement->bind_param("s", $email);
        $statement->execute();
        $result = $statement->get_result();
        $user = $result->fetch_assoc();
        $statement->close();

        return $user ?: null;
    }

    public function getAllWithRoles(): array
    {
        $query = "SELECT u.iduser as id, u.nama as Nama, GROUP_CONCAT(r.nama_role SEPARATOR ', ') AS Role
                  FROM user u
                  JOIN role_user ru ON u.iduser = ru.iduser
                  JOIN role r ON ru.idrole = r.idrole
                  GROUP BY u.iduser, u.nama";
        $result = $this->db->query($query);

        $users = [];
        while ($row = $result->fetch_object()) {
            $users[] = $row;
        }

        return $users;
    }

    public function find($id): ?\stdClass
    {
        // Get user data
        $user_stmt = $this->db->prepare("SELECT * FROM user WHERE iduser = ?");
        $user_stmt->bind_param("i", $id);
        $user_stmt->execute();
        $user_result = $user_stmt->get_result();
        $user = $user_result->fetch_object();
        $user_stmt->close();
    
        if (!$user) {
            return null;
        }
    
        // Get user role IDs
        $role_stmt = $this->db->prepare("SELECT idrole, idrole_user FROM role_user WHERE iduser = ?");
        $role_stmt->bind_param("i", $id);
        $role_stmt->execute();
        $role_result = $role_stmt->get_result();
        $user_roles = [];
        $user_role_ids = [];
        while ($row = $role_result->fetch_assoc()) {
            $user_roles[] = $row;
            $user_role_ids[] = $row['idrole'];
        }
        $role_stmt->close();
    
        $user->roles = $user_roles;
        $user->role_ids = $user_role_ids;
    
        // Get all roles
        $all_roles_result = $this->db->query("SELECT idrole, nama_role FROM role");
        $all_roles = [];
        while ($row = $all_roles_result->fetch_object()) {
            $all_roles[] = $row;
        }
    
        // Combine into a single object
        $data = new \stdClass();
        $data->user = $user;
        $data->all_roles = $all_roles;
        
        return $data;
    }

    public function update($id, $data)
    {
        $this->db->begin_transaction();

        try {
            if (isset($data['password'])) {
                $stmt = $this->db->prepare("UPDATE user SET nama = ?, email = ?, password = ? WHERE iduser = ?");
                $stmt->bind_param("sssi", $data['nama'], $data['email'], $data['password'], $id);
            } else {
                $stmt = $this->db->prepare("UPDATE user SET nama = ?, email = ? WHERE iduser = ?");
                $stmt->bind_param("ssi", $data['nama'], $data['email'], $id);
            }
            $stmt->execute();
            $stmt->close();

            if (isset($data['roles'])) {
                // Get current roles
                $role_stmt = $this->db->prepare("SELECT idrole FROM role_user WHERE iduser = ?");
                $role_stmt->bind_param("i", $id);
                $role_stmt->execute();
                $result = $role_stmt->get_result();
                $current_role_ids = [];
                while ($row = $result->fetch_assoc()) {
                    $current_role_ids[] = $row['idrole'];
                }
                $role_stmt->close();
    
                $submitted_roles = $data['roles'] ?? [];
    
                // Roles to add
                $roles_to_add = array_diff($submitted_roles, $current_role_ids);
                if (!empty($roles_to_add)) {
                    $stmt = $this->db->prepare("INSERT INTO role_user (iduser, idrole) VALUES (?, ?)");
                    foreach ($roles_to_add as $role_id) {
                        $stmt->bind_param("ii", $id, $role_id);
                        $stmt->execute();
                    }
                    $stmt->close();
                }
    
                // Roles to delete
                $roles_to_delete = array_diff($current_role_ids, $submitted_roles);
                if (!empty($roles_to_delete)) {
                    $stmt = $this->db->prepare("DELETE FROM role_user WHERE iduser = ? AND idrole = ?");
                    foreach ($roles_to_delete as $role_id) {
                        $stmt->bind_param("ii", $id, $role_id);
                        $stmt->execute();
                    }
                    $stmt->close();
                }
            }

            $this->db->commit();
        } catch (\mysqli_sql_exception $exception) {
            $this->db->rollback();
            throw $exception;
        }
    }

    public function getAll(): array
    {
        $query = "SELECT iduser AS id, nama AS Nama, email AS Email FROM user";
        $result = $this->db->query($query);

        $users = [];
        while ($row = $result->fetch_object()) {
            $users[] = $row;
        }

        return $users;
    }
    
    public function add($data)
    {
        // Insert user data
        $stmt = $this->db->prepare("INSERT INTO user (nama, email, password) VALUES (?, ?, ?)");
        $password = password_hash($data['password'], PASSWORD_DEFAULT);
        $stmt->bind_param("sss", $data['nama'], $data['email'], $password);
        $stmt->execute();
        $stmt->close();
    }

    public function getAllRoles(): array
    {
        $all_roles_result = $this->db->query("SELECT idrole, nama_role as nama FROM role");
        $all_roles = [];
        while ($row = $all_roles_result->fetch_object()) {
            $all_roles[] = $row;
        }
        return $all_roles;
    }

    public function getAllDokter(): array
    {
        $query = "SELECT u.iduser, u.nama, ru.idrole_user FROM user u
                  JOIN role_user ru ON u.iduser = ru.iduser
                  JOIN role r ON ru.idrole = r.idrole
                  WHERE r.nama_role = 'dokter'";
        $result = $this->db->query($query);

        $dokters = [];
        while ($row = $result->fetch_object()) {
            $dokters[] = $row;
        }

        return $dokters;
    }

    public function getRolesForUser(int $userId): array
    {
        $stmt = $this->db->prepare("SELECT r.nama_role FROM role_user ru JOIN role r ON ru.idrole = r.idrole WHERE ru.iduser = ?");
        $stmt->bind_param("i", $userId);
        $stmt->execute();
        $result = $stmt->get_result();
        $roles = [];
        while ($row = $result->fetch_assoc()) {
            $roles[] = $row['nama_role'];
        }
        $stmt->close();
        return $roles;
    }

    public function delete($id): void
    {
        $stmt = $this->db->prepare("DELETE FROM user WHERE iduser = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $stmt->close();
    }
}