<?php
namespace App\Services;
use App\Models\Session;
use DateTime;

class SessionService {
    private $sessionModel;

    public function __construct() {
        $this->sessionModel = new Session();
    }

    public function getActiveSessionsWithTimer() {
        $sessions = $this->sessionModel->getActiveSessions();
        $now = new DateTime(); 

        foreach ($sessions as &$session) {
            $startTime = new DateTime($session['start_time']);
            $interval = $startTime->diff($now);

            if ($interval->h > 0) {
                $session['elapsed_time'] = $interval->h . 'h ' . $interval->i . 'm';
            } else {
                $session['elapsed_time'] = $interval->i . 'm';
            }
            
            $session['total_minutes'] = ($interval->h * 60) + $interval->i;
        }

        return $sessions;
    }
}