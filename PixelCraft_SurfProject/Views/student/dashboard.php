<?php include __DIR__ . '/../includes/header.php'; ?>

<style>
    :root {
        --surf-bg: #FDF5F0;
        --surf-card: #FFFFFF;
        --surf-accent: #19C3B1;
        --surf-text: #0A2540;
        --surf-orange: #FFD9C0;
    }

    body { background-color: var(--surf-bg) !important; color: var(--surf-text); font-family: 'Inter', sans-serif; }
    
    .dashboard-container { max-width: 1100px; margin-top: 40px; }
    .welcome-text { font-weight: 800; font-size: 2.5rem; margin-bottom: 30px; }
    .welcome-text span { color: var(--surf-accent); }

    .card-custom { 
        background: var(--surf-card); 
        border: none; 
        border-radius: 25px; 
        box-shadow: 0 10px 30px rgba(0,0,0,0.02);
        padding: 30px;
    }

    .profile-img-wrapper {
        width: 100px; height: 100px;
        background: var(--surf-text);
        border-radius: 20px;
        overflow: hidden;
        margin-bottom: 20px;
    }
    .profile-img-wrapper img { width: 100%; height: 100%; object-fit: cover; }
    
    .skill-box {
        background: #F8FCFB;
        border: 1px solid #E3F2F1;
        border-radius: 15px;
        padding: 15px;
        margin-top: 20px;
    }
    .progress-surf { height: 6px; background: #E0E0E0; border-radius: 10px; margin-top: 10px; }
    .progress-bar-surf { background: var(--surf-accent); border-radius: 10px; }

    .agenda-item {
        background: white;
        border-radius: 20px;
        padding: 20px;
        margin-bottom: 15px;
        display: flex;
        align-items: center;
        transition: transform 0.2s;
        border: 1px solid #F1F1F1;
    }
    .agenda-date {
        width: 60px; height: 60px;
        background: #FBFBFB;
        border: 1px solid #EEE;
        border-radius: 15px;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        margin-right: 20px;
    }
    .agenda-date .day { font-weight: 800; font-size: 1.2rem; line-height: 1; }
    .agenda-date .month { font-size: 0.7rem; text-transform: uppercase; color: #888; }

    .badge-paid { background: #DFFFEF; color: #27AE60; font-weight: 700; font-size: 0.7rem; padding: 5px 12px; border-radius: 10px; }
    .badge-pending { background: var(--surf-orange); color: #E67E22; font-weight: 700; font-size: 0.7rem; padding: 5px 12px; border-radius: 10px; }

    .stat-card { border-radius: 20px; padding: 20px; color: var(--surf-text); }
    .stat-orange { background: var(--surf-orange); }
    .stat-cyan { background: #7FFFD4; }
</style>

<div class="container dashboard-container mb-5">
    <p class="text-muted mb-1 text-uppercase fw-bold small tracking-widest">Student Portal</p>
    <h1 class="welcome-text">Aloha, <span><?= explode(' ', $profile['full_name'])[0] ?>!</span></h1>

    <div class="row g-4">
        <div class="col-lg-4">
            <div class="card-custom mb-4">
                <div class="profile-img-wrapper">
                    <img src="https://ui-avatars.com/api/?name=<?= urlencode($profile['full_name']) ?>&background=0A2540&color=fff&size=128" alt="Avatar">
                </div>
                <h3 class="fw-bold mb-1"><?= htmlspecialchars($profile['full_name']) ?></h3>
                <p class="text-muted small"><i class="bi bi-geo-alt-fill me-1"></i> <?= $profile['country'] ?? 'Maroc' ?></p>

                <div class="skill-box">
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="small fw-bold text-muted">CURRENT SKILL LEVEL</span>
                        <i class="bi bi-water text-accent"></i>
                    </div>
                    <h5 class="fw-bold text-accent mb-0 mt-1"><?= $profile['level'] ?></h5>
                    <div class="progress-surf">
                        <?php 
                            $width = ($profile['level'] == 'Beginner') ? '33%' : (($profile['level'] == 'Intermediate') ? '66%' : '100%');
                        ?>
                        <div class="progress-bar-surf" style="width: <?= $width ?>; height: 100%;"></div>
                    </div>
                </div>
            </div>

            <div class="row g-3">
                <div class="col-6">
                    <div class="stat-card stat-orange">
                        <p class="small fw-bold mb-0 opacity-50 text-uppercase">Sessions</p>
                        <h2 class="fw-bold mb-0"><?= count($schedule) ?></h2>
                    </div>
                </div>
                <div class="col-6">
                    <div class="stat-card stat-cyan">
                        <p class="small fw-bold mb-0 opacity-50 text-uppercase">Hours</p>
                        <h2 class="fw-bold mb-0"><?= count($schedule) * 2 ?></h2>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-8">
            <div class="card-custom h-100" style="background: #FFF9F5;">
                <h4 class="fw-bold mb-2">My Agenda</h4>
                <p class="text-muted small mb-4">Your upcoming sessions at Taghazout Surf Expo</p>

                <?php if(empty($schedule)): ?>
                    <div class="text-center py-5">
                        <p class="text-muted">Aucune session prévue pour le moment.</p>
                    </div>
                <?php else: ?>
                    <?php foreach ($schedule as $lesson): ?>
                        <div class="agenda-item">
                            <div class="agenda-date">
                                <span class="day"><?= date('d', strtotime($lesson['lesson_date'])) ?></span>
                                <span class="month"><?= date('M', strtotime($lesson['lesson_date'])) ?></span>
                            </div>
                            <div class="flex-grow-1">
                                <h6 class="fw-bold mb-1"><?= htmlspecialchars($lesson['title']) ?></h6>
                                <div class="small text-muted">
                                    <i class="bi bi-clock me-1"></i> <?= date('H:i', strtotime($lesson['lesson_date'])) ?> AM
                                    <span class="mx-2">•</span>
                                    <i class="bi bi-person me-1"></i> Coach <?= htmlspecialchars($lesson['coach_name']) ?>
                                </div>
                            </div>
                            <div class="ms-auto text-end">
                            <?php if (isset($lesson['payment_status']) && $lesson['payment_status'] === 'Paid'): ?>
                            <span class="badge-paid">PAID</span>
                             <?php else: ?>
                             <span class="badge-pending">PENDING</span>
                             <?php endif; ?>
                             </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<?php include __DIR__ . '/../includes/footer.php'; ?>