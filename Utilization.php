<?php
require_once 'DB.php';
require_once 'ParkingLot.php';

class Utilization
{
    private $utilizationId;
    private $userId;
    private $slotId;
    private $carNumber;
    private $intime;
    private $outtime;
    private $fare;

    public function __construct($utilizationId, $userId, $slotId, $carNumber, $intime, $outtime)
    {
        $this->utilizationId = $utilizationId;
        $this->userId = $userId;
        $this->slotId = $slotId;
        $this->carNumber = $carNumber;
        $this->intime = $intime;
        $this->outtime = $outtime;
    }

    public function getUtilizationId()
    {
        return $this->utilizationId;
    }

    public function getFare()
    {
        return $this->fare;
    }

    public function getUserId()
    {
        return $this->userId;
    }

    public function getSlotId()
    {
        return $this->slotId;
    }

    public function getCarNumber()
    {
        return $this->carNumber;
    }

    public function getIntime()
    {
        return $this->intime;
    }

    public function getOuttime()
    {
        return $this->outtime;
    }

    public function setOuttime($outtime)
    {
        $this->outtime = $outtime;
    }


    public function setFare($fare)
    {
        $this->fare = $fare;
    }

    public static function getDataBySessionId($userId)
    {
        $conn = DB::getConnection();
        $stmt = $conn->prepare("SELECT * FROM utilization WHERE userId = ? order by outtime DESC limit 1");
        $stmt->bind_param("i", $userId);
        $stmt->execute();
        $result = $stmt->get_result();
        $data = $result->fetch_assoc();
        $stmt->close();
        $dataheader = array('utilid', 'userId', 'slotId', 'carNo', 'intime', 'outtime', 'fare');
        $arrayCombine = array_combine($dataheader, $data);
        return $arrayCombine;
    }

    public static function recordIntime($userId, $slotId, $carNumber, $intime)
    {

        ParkingLot::updateSlotAvailability($slotId, 1);
        $conn = DB::getConnection();
        $stmt = $conn->prepare("INSERT INTO utilization (userId, slotId, carNumber, intime) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("iiss", $userId, $slotId, $carNumber, $intime);
        $result = $stmt->execute();
        $utilizationId = $stmt->insert_id;
        $stmt->close();
        return $utilizationId == 1;
    }

    public static function hasUserParkedCar($userId)
    {
        $conn = DB::getConnection();
        $stmt = $conn->prepare("SELECT COUNT(*) AS count FROM utilization WHERE userId = ? AND outtime IS NULL");
        $stmt->bind_param("i", $userId);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        $stmt->close();
        return $row['count'] == 1;
    }

    private static function isUserHasActiveUtilization($userId)
    {
        $conn = DB::getConnection();
        $stmt = $conn->prepare("SELECT * FROM utilization WHERE userId = ? AND outtime IS NULL");
        $stmt->bind_param("i", $userId);
        $stmt->execute();
        $result = $stmt->get_result();
        $stmt->close();
        return $result->num_rows == 1;
    }

    public static function getUtilizationBySlot($slotId)
    {
        $conn = DB::getConnection();
        $stmt = $conn->prepare("SELECT * FROM utilization WHERE slotId = ?");
        $stmt->bind_param("s", $slotId);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows === 1) {
            $row = $result->fetch_assoc();
            $utilization = new Utilization($row['utilizationId'], $row['userId'], $row['slotId'], $row['carNumber'], $row['intime'], $row['outtime']);
            $stmt->close();
            return $utilization;
        }
        $stmt->close();
        return null;
    }

    public static  function  getSlotIdFromDb($userId)
    {
        $conn = DB::getConnection();
        $stmt = $conn->prepare("SELECT slotId FROM utilization WHERE userId = ?  and utilizationId = (SELECT t.utilizationId FROM ( SELECT MAX(utilizationId) AS utilizationId   FROM utilization  ) AS t)");
        $stmt->bind_param("i", $userId);
        $stmt->execute();
        $stmt->bind_result($slotId);
        $stmt->fetch();
        $stmt->close();
        return $slotId;
    }

    public static function recordOuttime($userId)
    {
        $slotId1 = self::getSlotIdFromDb($userId);
        ParkingLot::updateSlotAvailability($slotId1, 0);
        $conn = DB::getConnection();
        $stmt = $conn->prepare("UPDATE utilization  SET outtime = NOW()  WHERE userId=? and  utilizationId = (SELECT t.utilizationId FROM ( SELECT MAX(utilizationId) AS utilizationId   FROM utilization  ) AS t)");
        $stmt->bind_param("i",  $userId);
        $stmt->execute();
        $utilizationId = $stmt->insert_id;
        $stmt->close();
    }

    public static function getAllUtilizations()
    {
        $conn = DB::getConnection();
        $query = "SELECT * FROM utilization";
        $result = $conn->query($query);
        $utilizations = array();
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $utilization = new Utilization(
                    $row['utilizationId'],
                    $row['userId'],
                    $row['slotId'],
                    $row['carNumber'],
                    $row['intime'],
                    $row['outtime'],
                    $row['fare']
                );
                $utilizations[] = $utilization;
            }
        }
        $result->close();
        $conn->close();
        return $utilizations;
    }


    public function update()
    {
        $conn = DB::getConnection();
        $stmt = $conn->prepare("UPDATE utilization SET outtime = ? WHERE utilizationId = ?");
        $stmt->bind_param("si", $this->outtime, $this->utilizationId);
        $result = $stmt->execute();
        $stmt->close();
        return $result;
    }

    public static function isSlotAssignedToUser($userId, $slotId)
    {
        $conn = DB::getConnection();
        $stmt = $conn->prepare("SELECT * FROM utilization WHERE userId = ? AND slotId = ?");
        $stmt->bind_param("is", $userId, $slotId);
        $stmt->execute();
        $result = $stmt->get_result();
        $stmt->close();
        return $result->num_rows === 1;
    }
}
