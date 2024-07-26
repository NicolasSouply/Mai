<?php 

class OrderManager extends AbstractManager 
{
  public function __construct()
  {
      parent::__construct();
  }
  public function findOrdersByClientId(int $clientId): array
  {
      $query = $this->db->prepare(
          "SELECT *
          FROM orders
          WHERE client_id = :client_id"
      );
      $parameters = [
          'client_id' => $clientId
      ];
      $query->execute($parameters);

      $result = $query->fetchAll(PDO::FETCH_ASSOC);
      $orders = [];

      foreach ($result as $item) {
          $order = new Orders(
              $item['status'],
              $item['total_price'],
              new DateTime($item['date_order']),
              new DateTime($item['hour_order'])
          );
          $order->setId($item['id']);
          $orders[] = $order;
      }

      return $orders;
  }  public function findAll() : array
  {
    $query = $this->db->prepare('SELECT * FROM orders');
        $query->execute();
        $result = $query->fetchAll(PDO::FETCH_ASSOC);
        
        $orders = [];
        foreach($result as $item)
        {
            $order = new Orders($item["status"], $item["totalPrice"], new DateTime ($item["date_order"]), new DateTime ($item["hour_order"])
          );
            $order->setId($item["id"]);
            $orders[] = $order;
        }

        return $orders;
  }
}