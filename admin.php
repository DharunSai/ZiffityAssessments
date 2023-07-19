<?php
session_start();
require_once 'DB.php';
require_once 'User.php';
require_once 'Utilization.php';



$admin = $_SESSION['admin'];
$conn = DB::getConnection();
$stmt = $conn->prepare("SELECT * FROM utilization");
$stmt->execute();
$result = $stmt->get_result();

$data = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $fare = $row['fare'];
        $carNumber = $row['carNumber'];
        $inTime = $row['intime'];
        $outTime = $row['outtime'];
        $slotId = $row['slotId'];
        $userId = $row['userId'];

        $recordData = array(
            'fare' => $fare,
            'carNumber' => $carNumber,
            'inTime' => $inTime,
            'outTime' => $outTime,
            'slotId' => $slotId,
            'userId' => $userId
        );
        $data[] = $recordData;
    }
}
?>

<!DOCTYPE html>
<html>

<head>
    <link rel="stylesheet" href="adminStyles.css">
    <title>Car Parking Vault - Admin Page</title>
</head>

<body>
    <h1>Welcome, Admin</h1>
    <h2>Utilization Details</h2>
    
    <table>
        <tr>
            <th>Vehicle Number</th>
            <th>Intime</th>
            <th>OutTime Amount</th>
            <th>Slot Number</th>
            <th>Fare</th>
        </tr>
        <?php foreach ($data as $d) : ?>
            <tr>
                <td><?php echo $d['carNumber'] ?></td>
                <td><?php echo $d['inTime'] ?> </td>
                <td><?php echo $d['outTime'] ?></td>
                <td><?php echo $d['slotId'] ?></td>
                <td><?php echo $d['fare'] ?></td>

            </tr>
        <?php endforeach; ?>

    </table>
    <a href="login.php">Logout</a>
</body>

</html>