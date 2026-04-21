<?php
namespace App\Services;
use App\Models\Reservation;
use App\Models\Table;

class ReservationService {
    private $reservationModel;
    private $tableModel;

    public function __construct() {
        $this->reservationModel = new Reservation();
        $this->tableModel = new Table();
    }

    public function isCafeAvailable($date, $time, $guestsCount) {
        $suitableTables = $this->tableModel->getTablesByCapacity($guestsCount);
        $totalSuitableTables = count($suitableTables);

        if ($totalSuitableTables === 0) {
            return false; 
        }

        $existingReservations = $this->reservationModel->getByDate($date);
        $conflicts = 0;

        foreach ($existingReservations as $res) {
            if ($res['reservation_time'] === $time && $res['status'] !== 'annulée') {
                $conflicts++;
            }
        }
        return $conflicts < $totalSuitableTables;
    }
}