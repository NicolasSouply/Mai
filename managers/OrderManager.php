<?php 

class OrderManager extends AbstractManager 
{
  public function __construct()
  {
      parent::__construct();
  }
  public function findOrdersByuserId(int $userId): array
  {
      $query = $this->db->prepare(
          "SELECT *
          FROM orders
          WHERE user_id = :user_id"
      );
      $parameters = [
          'user_id' => $userId
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