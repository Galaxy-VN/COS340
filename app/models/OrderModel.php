<?php
class OrderModel
{
    private $conn;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function createOrder($name, $phone, $address, $items)
    {
        try {
            $this->conn->beginTransaction();

            $stmt = $this->conn->prepare("INSERT INTO orders (name, phone, address) VALUES (:name, :phone, :address)");
            $stmt->bindParam(':name', $name);
            $stmt->bindParam(':phone', $phone);
            $stmt->bindParam(':address', $address);
            $stmt->execute();

            $orderId = $this->conn->lastInsertId();

            if ($orderId) {
                $stmtDetail = $this->conn->prepare("INSERT INTO order_details (order_id, product_id, quantity, price) VALUES (:order_id, :product_id, :quantity, :price)");
                
                foreach ($items as $item) {
                    $stmtDetail->bindParam(':order_id', $orderId);
                    $stmtDetail->bindParam(':product_id', $item['product_id']);
                    $stmtDetail->bindParam(':quantity', $item['quantity']);
                    $stmtDetail->bindParam(':price', $item['price']);
                    $stmtDetail->execute();
                }

                $this->conn->commit();
                return $orderId;
            }

            $this->conn->rollBack();
            return false;
        } catch (PDOException $e) {
            $this->conn->rollBack();
            return false;
        }
    }

    public function getOrders()
    {
        $query = "SELECT * FROM orders ORDER BY order_date DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getOrderById($id)
    {
        $query = "SELECT * FROM orders WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getOrderDetails($orderId)
    {
        $query = "SELECT od.*, p.name, p.image FROM order_details od LEFT JOIN product p ON od.product_id = p.id WHERE od.order_id = :order_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':order_id', $orderId);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
