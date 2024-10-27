<?php 

class DetailOrderManager extends AbstractManager 
{

  public function findAll() : array
  {
    $query = $this->db->prepare('SELECT * FROM Detail_orders');
        $query->execute();
        $result = $query->fetchAll(PDO::FETCH_ASSOC);
        $detailOrders = [];

        foreach($result as $item)
        {
            $detailOrder = new DetailOrders($item["price"], $item["quatity"]);
            $detailOrder->setId($item["id"]);
            $detailOrders[] = $detailOrder;
        }

        return $detailOrders;
  }
 
}