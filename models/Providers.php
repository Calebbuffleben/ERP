<?php

class Providers extends model {

    public function __construct() {
        parent::__construct();
    }

    public function getList($offset, $id_company) {
        $array = array();

        $sql = $this->db->prepare("SELECT * FROM providers WHERE id_company = :id_company LIMIT $offset, 10");
        $sql->bindValue(':id_company', $id_company);
        $sql->execute();

        if ($sql->rowCount() > 0) {
            $array = $sql->fetchAll();
        }

        return $array;
    }

    public function getCount($id_company) {
        $result = 0;

        $sql = $this->db->prepare("SELECT COUNT(*) as c FROM providers WHERE id_company = :id_company");
        $sql->bindValue("id_company", $id_company);
        $sql->execute();
        $row = $sql->fetch();

        $result = $row['c'];

        return $result;
    }

    public function getInfo($id, $id_company) {
        $array = array();

        $sql = $this->db->prepare("SELECT * FROM providers WHERE id = :id AND id_company = :id_company");
        $sql->bindValue(":id", $id);
        $sql->bindValue(":id_company", $id_company);
        $sql->execute();

        if ($sql->rowCount() > 0) {
            $array = $sql->fetch();
        }

        return $array;
    }

    public function add($id_company, $name, $email, $phone) {
        $sql = $this->db->prepare("INSERT INTO providers SET id_company = :id_company, name = :name, email = :email, phone = :phone");
        $sql->bindValue(":id_company", $id_company);
        $sql->bindValue(":name", $name);
        $sql->bindValue(":email", $email);
        $sql->bindValue(":phone", $phone);
        $sql->execute();
    }
    public function edit($id, $id_company, $name, $email, $phone){
        $sql = $this->db->prepare("UPDATE providers SET id_company = :id_company, name = :name, email = :email, "
                . "phone = :phone WHERE id = :id AND id_company = :id_company2");
        $sql->bindValue(":id", $id);
        $sql->bindValue(":id_company", $id_company);
        $sql->bindValue(":name", $name);
        $sql->bindValue(":email", $email);
        $sql->bindValue(":phone", $phone);
        $sql->bindValue(":id_company2", $id_company);
        $sql->execute();
    }

}
