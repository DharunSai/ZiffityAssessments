<?php
session_start();
require_once 'php/DB.php';
require_once 'php/User.php';
require_once 'php/Utilization.php';
class Admin
{
    private $isAdmin;
    private $utilizationData = [];
    public function __construct()
    {
        $this->fetchUtilizationData();
        
    }
    private function fetchUtilizationData()
    {
        $conn = DB::getConnection();
        $stmt = $conn->prepare("SELECT * FROM utilization");
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $this->utilizationData[] = $row;
            }
        }
    }

    public function generateAdminPage()
    {
        $dataRows = $this->generateDataRows();

        $html = <<<HTML
        <!DOCTYPE html>
        <html>
        <head>
            <link rel="stylesheet" href="css/adminStyles.css">
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
                $dataRows
            </table>
            <a href="php/login.php">Logout</a>
        </body>
        </html>
HTML;

        echo $html;
    }

    private function generateDataRows()
    {
        $dataRows = '';
        foreach ($this->utilizationData as $data) {
            $dataRows .= "<tr>
                            <td>{$data['carNumber']}</td>
                            <td>{$data['intime']}</td>
                            <td>{$data['outtime']}</td>
                            <td>{$data['slotId']}</td>
                            <td>{$data['fare']}</td>
                          </tr>";
        }

        return $dataRows;
    }
}

$admin = new Admin();
$admin->generateAdminPage();
