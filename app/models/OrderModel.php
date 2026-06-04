<?php
class OrderModel
{
    private $conn;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function createOrder($name, $phone, $address, $items, $accountId = null)
    {
        try {
            $this->conn->beginTransaction();

            $stmt = $this->conn->prepare("INSERT INTO orders (name, phone, address, account_id) VALUES (:name, :phone, :address, :account_id)");
            $stmt->bindParam(':name', $name);
            $stmt->bindParam(':phone', $phone);
            $stmt->bindParam(':address', $address);
            $stmt->bindParam(':account_id', $accountId, $accountId === null ? PDO::PARAM_NULL : PDO::PARAM_INT);
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

    public function getOrders($accountId = null)
    {
        if ($accountId !== null) {
            $query = "SELECT o.*, a.username, a.avatar FROM orders o LEFT JOIN account a ON o.account_id = a.id WHERE o.account_id = :account_id ORDER BY o.order_date DESC";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':account_id', $accountId, PDO::PARAM_INT);
        } else {
            $query = "SELECT o.*, a.username, a.avatar FROM orders o LEFT JOIN account a ON o.account_id = a.id ORDER BY o.order_date DESC";
            $stmt = $this->conn->prepare($query);
        }
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

    public function updateStatus($orderId, $status)
    {
        $query = "UPDATE orders SET status = :status WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':status', $status);
        $stmt->bindParam(':id', $orderId, PDO::PARAM_INT);
        return $stmt->execute();
    }
}
