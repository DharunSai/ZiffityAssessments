<?php
require_once 'DB.php';
require_once 'User.php';
require_once 'ParkingLot.php';
require_once 'Utilization.php';

session_start();

$userId = unserialize($_SESSION['user'])->getUserId();
$data = Utilization::getDataBySessionId($userId);
$outtimee = strtotime($data['outtime']);
$intimee = strtotime($data['intime']);
$username = unserialize($_SESSION['user'])->getUserName();
function calculateFair($intime, $outtime)
{
    $duration = ($outtime - $intime) / 3600;
    $fare = $duration * 8;
    return number_format($fare, 4) * 10;
}

$utilizationId = $data['utilid'];
$outtimee = strtotime($data['outtime']);
$intimee = strtotime($data['intime']);
$slotId = $data['slotId'];
$carNo = $data['carNo'];
$fare = calculateFair($intimee, $outtimee);

$conn = DB::getConnection();
$stmt = $conn->prepare("UPDATE utilization SET fare = $fare WHERE utilizationId = ?");
$stmt->bind_param("i",  $utilizationId);
$result = $stmt->execute();
$stmt->close();

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="receiptStyles.css">
    <title>Document</title>
</head>

<body>
    <h1>Your Bill</h1><br>
    <table>
        <tr>
            <th><b>Car Number</b></th>
            <th><b>Slot Id</b></th>
            <th><b>Username</b></th>
            <th><b>Intime</b></th>
            <th><b>OutTime</b></th>
            <th><b>Duration</b></th>
            <th><b>Fare</b></th>
        </tr>

        <tr>
            <td>
                <?php echo $carNo; ?>
            </td>
            <td>
                <?php echo $slotId; ?>
            </td>
            <td>
                <?php echo $username; ?>
            </td>
            <td>
                <?php echo $data['intime']; ?>
            </td>
            <td>
                <?php echo $data['outtime']; ?>
            </td>
            <td>
                <?php echo number_format(($outtimee - $intimee) / 3600, 3); ?>hrs
            </td>
            <td>
                <?php echo calculateFair($intimee, $outtimee); ?>
            </td>
        </tr>
    </table>
    <a href="index.php">Go back to booking</a>
</body>
</html>