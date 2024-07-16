<?php 

class OrderManager extends AbstractManager 
{

  public function findAll() : array
  {
    $query = $this->db->prepare('SELECT * FROM orders');
        $query->execute();
        $result = $query->fetchAll(PDO::FETCH_ASSOC);
        $orders = [];

        foreach($result as $item)
        {
            $order = new Orders($item["status"], $item["totalPrice"], $item["date_order"], $item["hour_order"]);
            $order->setId($item["id"]);
            $orders[] = $order;
        }

        return $orders;
  }
}