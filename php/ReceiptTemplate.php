<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/receiptStyles.css">
    <title>Document</title>
</head>

<body>
    <h1>Your Bill</h1><br>

    <?php echo $data['intime'] ?>
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
                <?php echo $intime; ?>
            </td>
            <td>
                <?php echo $outtime; ?>
            </td>
            <td>
                <?php echo number_format(($outtimee - $intimee) / 3600, 3); ?>hrs
            </td>
            <td>
                <?php echo $fare; ?>
            </td>
        </tr>
    </table>
    <a href="index.php">Go back to booking</a>
</body>

</html>