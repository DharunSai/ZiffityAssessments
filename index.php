<?php
session_start();
require_once 'php/DB.php';
require_once 'php/User.php';
require_once 'php/ParkingLot.php';
require_once 'php/Utilization.php';

if (!User::isLoggedIn()) {
    header("Location: php/login.php");
    exit();
}
$user = unserialize(User::getLoggedInUser());
$hasParkedCar = Utilization::hasUserParkedCar($user->getUserId());

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['park']) && $hasParkedCar != true) {
    $carNumber = $_POST['carNumber'];

    if ($hasParkedCar) {
        $error = "You have already parked a car.";
    } else {
        $selectedSlot = $_POST['selectedSlot'];
        $intime = date('Y-m-d H:i:s');
        if (ParkingLot::isSlotAvailable($selectedSlot)) {
            $utilizationId = Utilization::recordIntime($user->getUserId(), $selectedSlot, $carNumber, $intime);
            var_dump($utilizationId);

            if ($utilizationId) {
                ParkingLot::updateSlotAvailability($selectedSlot, 1);
                $success = "Car parked successfully!";

                header('Location: php/index.php');
            } else {
                $error = "Error while parking the car. Please try again.";
            }
        } else {
            $error = "Selected parking slot is not available.";
        }
    }
} elseif (isset($_POST['unpark']) &&  $hasParkedCar == true) {
        echo ("assigned" . ParkingLot::isSlotAssignedToUser($user->getUserId()));
    if (ParkingLot::isSlotAssignedToUser($user->getUserId())) {
       
        Utilization::recordOuttime($user->getUserId());
        
        header('Location: php/receipt.php');
        } 
        else {
        $error = "Selected parking slot is not assigned to you.";
    }
}
?>

<!DOCTYPE html>
<html>

<head>
<link rel="stylesheet" href="indexStyles.css">    
<title>Car Parking Vault - User Page</title>
</head>

<body>
    <h1 class="heading">Welcome, <?php echo $user->getUsername(); ?></h1>
    
    <div class="container">
    <?php if ($hasParkedCar) : $filledSlots = ParkingLot::getFilledSlots(); ?>
        <h2>Out Parking</h2>
        <form method="post">
            <label for="selectedSlot">Select Slot:</label>

            <input class="submit" type="submit" name="unpark" value="Unpark">
        </form>
    <?php else : ?>
        <h2>In Parking</h2>
        <?php
        $availableSlots = ParkingLot::getAvailableSlots();

        if (empty($availableSlots)) {
            echo "<p>No slots available at the moment. Please try again later.</p>";
        } else {
        ?>
            <form method="post">
                <label for="carNumber">Car Number:</label>
                <input type="text" id="carNumber" name="carNumber" required><br><br>
                <label for="selectedSlot">Select Slot:</label>

                <select id="selectedSlot" name="selectedSlot" required>
                    <?php foreach ($availableSlots as $slot) { ?>
                        <option value="<?php echo $slot; ?>">
                            <?php echo $slot; ?>
                        </option>
                    <?php } ?>
                </select><br><br>
                
                <input class="submit" type="submit" name="park" value="Park">
                        
            </form>
        <?php
        }
        ?>
    <?php endif; ?>
    </div>

    <div class="logout">
    <a href="logout.php">Logout</a>
    </div>
</body>

</html>