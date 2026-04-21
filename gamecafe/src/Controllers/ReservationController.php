<?php
namespace App\Controllers;
use App\Services\AuthService;
use App\Services\ReservationService;
use App\Models\Reservation;

class ReservationController {
    
    public function __construct() {
        AuthService::requireLogin();
    }

    public function create() {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $date = $_POST['date'];
        $time = $_POST['time'];
        $guests = (int)$_POST['guests'];
        $customerName = $_POST['customer_name'] ?? '';
        $phone = $_POST['phone'] ?? '';


        $service = new ReservationService();

        if ($service->isCafeAvailable($date, $time, $guests)) {
            $reservationModel = new Reservation();

            $reservationModel->create([
                'user_id' => $_SESSION['user_id'],
                'guests_count' => $guests,
                'reservation_date' => $date,
                'reservation_time' => $time,
                'customer_name' => $customerName, 
                'phone' => $phone              
            ]);
            
            header('Location: /reservations/history?success=1');
            exit();
        } else {
            $error = "Désolé, aucune table n'est disponible pour " . $guests . " personnes à ce créneau.";
        }
    }

    require_once __DIR__ . '/../../views/reservations/create.php';
}

    public function history() {
        $reservationModel = new Reservation();
        $reservations = $reservationModel->getByUserId($_SESSION['user_id']);
        
        require_once __DIR__ . '/../../views/reservations/history.php';
    }
}