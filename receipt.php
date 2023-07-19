<?php
require_once 'DB.php';
require_once 'User.php';
require_once 'Utilization.php';

class Receipt
{
    private $user;
    private $data;

    public function __construct()
    {
        session_start();
        $this->user = unserialize($_SESSION['user']);
        $userId = $this->user->getUserId();
        $this->data = Utilization::getDataBySessionId($userId);
    }

    public function generateReceipt()
    {
        $intime=$this->data['intime'];
        $outtime=$this->data['outtime'];
        $outtimee = strtotime($this->data['outtime']);
        $intimee = strtotime($this->data['intime']);
        $username = $this->user->getUserName();
        $carNo = $this->data['carNo'];
        $slotId = $this->data['slotId'];
        $duration = ($outtime - $intime) / 3600;
        $fare = number_format($duration * 8,4)*100;
        $utilizationId = $this->data['utilid'];
        $fare = self::calculateFare($intimee, $outtimee);

        $conn = DB::getConnection();
        $stmt = $conn->prepare("UPDATE utilization SET fare = ? WHERE utilizationId = ?");
        $stmt->bind_param("di", $fare, $utilizationId);
        $result = $stmt->execute();
        $stmt->close();

        ob_start();
        include 'receiptTemplate.php';
        return ob_get_clean();
    }

    public static function calculateFare($intime, $outtime)
    {
        $duration = ($outtime - $intime) / 3600;
        $fare = $duration * 8;
        return number_format($fare, 4) * 10;
    }
}

$receipt = new Receipt();
$receiptHtml = $receipt->generateReceipt();
echo $receiptHtml;
