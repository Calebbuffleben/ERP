<?php

class Purchases extends model {

    public function getList($offset, $id_company) {
        $array = array();

        $sql = $this->db->prepare("SELECT
				purchases.id,
				purchases.total_price,
				purchases.status,
				providers.name
			FROM purchases
			LEFT JOIN providers ON providers.id = purchases.id_provider
			WHERE
				purchases.id_company = :id_company
			ORDER BY purchases.date_purchase DESC
			LIMIT $offset, 10");
        $sql->bindValue(":id_company", $id_company);
        $sql->execute();

        if ($sql->rowCount() > 0) {
            $array = $sql->fetchAll();
        }

        return $array;
    }

    public function addPurchase($id_company, $provider_name, $provider_email, $provider_phone, $id_user, $quant, $status, $total_price, $product_name, $unit_price) {
        $inventory = new Inventory();
        
        $sql = $this->db->prepare("INSERT INTO providers SET "
                . "id_company = :id_company, "
                . "name = :name, "
                . "email = :email, "
                . "phone = :phone");
        $sql->bindValue(":id_company", $id_company);
        $sql->bindValue(":name", $provider_name);
        $sql->bindValue(":email", $provider_email);
        $sql->bindValue(":phone", $provider_phone);
        $sql->execute();
        
        $id_provider = $this->db->lastInsertId();
        
        $sql = $this->db->prepare("INSERT INTO purchases SET id_company = :id_company, "
                . "date_purchase = NOW(), "
                . "id_user = :id_user, "
                . "total_price = :total_price, "
                . "id_provider = :id_provider, "
                . "status = :status");
        $sql->bindValue(":id_company", $id_company);
        $sql->bindValue(":id_user", $id_user);
        $sql->bindValue(":total_price", $total_price);
        $sql->bindValue(":id_provider", $id_provider);
        $sql->bindValue(":status", $status);
        $sql->execute();

        $id_purchase = $this->db->lastInsertId();

        $sql = $this->db->prepare("INSERT INTO purchases_products SET"
                . "id_purchase = :id_purchase, "
                . "name = :name, "
                . "quant = :quant, "
                . "purchase_price = :purchase_price, "
                . "id_company = :id_company");
        $sql->bindValue(":id_purchase", $id_purchase);
        $sql->bindValue(":name", $product_name);
        $sql->bindValue(":quant", $quant);
        $sql->bindValue(":purchase_price", $unit_price);
        $sql->bindValue(":id_company", $id_company);
        $sql->execute();

        $inventory->increase($id_company, $quant, $id_user);
    }

}
