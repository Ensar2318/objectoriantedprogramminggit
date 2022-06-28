<?php
session_start();
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
            echo $th->getMessage();
            return false;
        }
    }
}
