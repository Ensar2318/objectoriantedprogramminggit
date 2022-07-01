<?php
session_start();
ob_start();
require_once 'dbconfig.php';
class crud
{

    private $db;
    private $dbhost = DBHOST;
    private $dbuser = DBUSER;
    private $dbpass = DBPWD;
    private $dbname = DBNAME;


    function __construct()
    {
        try {
            $this->db = new PDO('mysql:host=' . $this->dbhost . ';dbname=' . $this->dbname . ';charset=utf8', $this->dbuser, $this->dbpass);
        } catch (\Throwable $th) {
            die("Bağlantı başarısız : " . $th->getMessage());
        }
    }

    public function addValue($args)
    {
        $values = implode(",", array_map(function ($item) {
            return $item . "=?";
        }, array_keys($args)));

        return $values;
    }

    public function insert($table, $values, $options = [])
    {
        try {

            if (!empty($_FILES[$options['file_name']]['name'])) {

                $name_y = $this->imageUpload(
                    $_FILES[$options['file_name']]['name'],
                    $_FILES[$options['file_name']]['size'],
                    $_FILES[$options['file_name']]['tmp_name'],
                    $options['dir_key']
                );

                if (isset($name_y['error'])) {
                    throw new Exception($name_y['error']);
                }
                $values += [$options['file_name'] => $name_y];
            }

            if (isset($options['pass_key'])) {
                $values[$options['pass_key']] = md5($values[$options['pass_key']]);
            }

            unset($values[$options['insert_key']]);

            $stmt = $this->db->prepare("INSERT INTO $table set {$this->addValue($values)}");
            $update = $stmt->execute(array_values($values));
            if ($update) {
                return ['status' => TRUE];
            } else {
                return ['status' => FALSE];
            }
        } catch (\Throwable $th) {

            return ['status' => FALSE, 'error' => $th->getMessage()];
        }
    }

    public function update($table, $values, $options = [])
    {
        try {

            if (!empty($_FILES[$options['file_name']]['name'])) {

                $name_y = $this->imageUpload(
                    $_FILES[$options['file_name']]['name'],
                    $_FILES[$options['file_name']]['size'],
                    $_FILES[$options['file_name']]['tmp_name'],
                    $options['dir_key'],
                    $values[$options['file_delete']]
                );

                if (isset($name_y['error'])) {
                    throw new Exception($name_y['error']);
                }
                $values += [$options['file_name'] => $name_y];
            }

            if (isset($options['pass_key'])) {
                $values[$options['pass_key']] = md5($values[$options['pass_key']]);
            }
            if (isset($options['requiredpass_key'])) {
                if (empty($values[$options['requiredpass_key']])) {
                    unset($values[$options['requiredpass_key']]);
                }
            }


            $columns_id = $values[$options['columns']];
            unset($values[$options['insert_key']]);
            unset($values[$options['columns']]);
            unset($values[$options['file_delete']]);
            $values_execute = $values;
            $values_execute += [$options['columns'] => $columns_id];
            // echo "<pre>";
            // echo print_r(array_values($values));
            // echo print_r($values);
            // echo print_r($values_execute);
            // exit;



            $stmt = $this->db->prepare("UPDATE $table set {$this->addValue($values)} WHERE {$options['columns']}=?");
            $update = $stmt->execute(array_values($values_execute));
            if ($update) {
                return ['status' => TRUE];
            } else {
                return ['status' => FALSE];
            }
        } catch (\Throwable $th) {

            return ['status' => FALSE, 'error' => $th->getMessage()];
        }
    }

    public function delete($table, $columns, $values, $fileName = null)
    {

        try {
            if (!empty($fileName)) {
                unlink("dimg/$table/$fileName");
            }

            $stmt = $this->db->prepare("DELETE FROM $table WHERE $columns=?");
            $stmt->execute([htmlspecialchars($values)]);

            return ['status' => TRUE];
        } catch (\Throwable $th) {
            return ['status' => FALSE, 'error' => $th->getMessage()];
        }
    }

    public function imageUpload($name, $size, $tmp_name, $dir, $file_delete = null)
    {
        try {
            $izinli_uzantilar = ["jpg", "jpge", "png", "gif"];
            $ext = strtolower(substr($name, strpos($name, ".") + 1));
            if (!in_array($ext, $izinli_uzantilar)) {
                throw new Exception("Sadece Jpg | png | gif uzantılar kabul edilmektedir.");
            }

            if ($size > 1048576) {
                throw new Exception("Dosya boyutu çok büyük. (Min 1mb)");
            }


            $name_y = uniqid() . "." . $ext;

            if (!@move_uploaded_file($tmp_name, "dimg/$dir/$name_y")) {
                throw new Exception("Dosya yükleme hatası...");
            }
            if (!empty($file_delete)) {
                unlink("dimg/$dir/$file_delete");
            }
            return $name_y;
        } catch (\Throwable $th) {

            return ['status' => FALSE, 'error' => $th->getMessage()];
        }
    }

    public function adminInsert($admins_namesurname, $admins_username, $admins_pass, $admin_status)
    {

        try {
            $stmt = $this->db->prepare("INSERT INTO admins set admins_namesurname=?,admins_username=?,admins_pass=? , admin_status=?");
            $update = $stmt->execute([$admins_namesurname, $admins_username, $admins_pass, $admin_status]);
            if ($update) {
                return ['status' => TRUE];
            } else {
                return ['status' => FALSE];
            }
        } catch (\Throwable $th) {

            return ['status' => FALSE, 'error' => $th->getMessage()];
        }
    }

    public function adminsLogin($admins_username, $admins_pass, $remember)
    {

        try {
            $stmt = $this->db->prepare("SELECT * FROM admins WHERE admins_username=? AND admins_pass=? AND admin_status=?");


            $stmt->execute([$admins_username, $admins_pass, 1]);

            if ($stmt->rowCount()) {

                $row = $stmt->fetch(PDO::FETCH_ASSOC);

                $_SESSION["admins"] = [
                    "admins_username" => $admins_username,
                    "admins_namesurname" => $row['admins_namesurname'],
                    "admins_file" => $row['admins_file'],
                    "admins_id" => $row['admins_id'],
                    "admins_pass" => $admins_pass
                ];

                if ($remember) {
                    $admins = [
                        "admins_username" => $admins_username,
                        "admins_pass" => $admins_pass
                    ];
                    setcookie("adminsLogin", json_encode($admins), strtotime('+10 days'), "/");
                } else {
                    setcookie("adminsLogin", "", strtotime('-10 days'), "/");
                }


                return ['status' => TRUE];
            } else {
                return ['status' => FALSE];
            }
        } catch (\Throwable $th) {

            return ['status' => FALSE, 'error' => $th->getMessage()];
        }
    }

    public function read($table)
    {
        try {
            $stmt = $this->db->prepare("SELECT * FROM $table");
            $stmt->execute();

            return $stmt;
        } catch (\Throwable $th) {
            return ['status' => FALSE, 'error' => $th->getMessage()];
        }
    }

    public function wRead($table, $columns, $values, $options = [])
    {
        try {
            $stmt = $this->db->prepare("SELECT * FROM $table WHERE $columns=?");
            $stmt->execute([htmlspecialchars($values)]);

            return $stmt;
        } catch (\Throwable $th) {
            return ['status' => FALSE, 'error' => $th->getMessage()];
        }
    }

    public function qSql($sql, $options = [])
    {
        try {
            $stmt = $this->db->prepare($sql);
            $stmt->execute();

            return $stmt;
        } catch (\Throwable $th) {
            return ['status' => FALSE, 'error' => $th->getMessage()];
        }
    }
}
