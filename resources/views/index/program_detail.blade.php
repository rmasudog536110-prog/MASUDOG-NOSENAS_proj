<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($program['title']); ?> - FitClub</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    
    <!-- Custom CSS -->
    <link rel="stylesheet" href="styles.css">
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
</head>
<body>
    <?php include 'includes/header.php'; ?>

    <!-- Flash Messages -->
    <?php if ($successMessage): ?>
        <div class="alert alert-success alert-dismissible fade show m-0" role="alert">
            <div class="container">
                <i class="fas fa-check-circle me-2"></i>
                <?php echo htmlspecialchars($successMessage); ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        </div>
    <?php endif; ?>

    <?php if ($errorMessage): ?>
        <div class="alert alert-danger alert-dismissible fade show m-0" role="alert">
            <div class="container">
                <i class="fas fa-exclamation-triangle me-2"></i>
                <?php echo htmlspecialchars($errorMessage); ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        </div>
    <?php endif; ?>

    <!-- Program Detail Section -->
    <section class="py-5 bg-light">
        <div class="container">
            <!-- Back Button -->
            <a href="programs.php" class="btn btn-outline-primary mb-4">
                <i class="fas fa-arrow-left me-2"></i> Back to Programs
            </a>

            <!-- Program Header -->
            <div class="card shadow-lg mb-5">
                <div class="card-body p-5">
                    <div class="d-flex align-items-center mb-4">
                        <span class="fs-1 me-4"><?php echo $program['icon']; ?></span>
                        <div>
                            <h1 class="display-5 fw-bold text-dark mb-2">
                                <?php echo htmlspecialchars($program['title']); ?>
                            </h1>
                            <span class="badge 
                                <?php 
                                switch($program['level']) {
                                    case 'beginner': echo 'bg-success'; break;
                                    case 'intermediate': echo 'bg-warning text-dark'; break;
                                    case 'expert': echo 'bg-danger'; break;
                                    case 'hardcore': echo 'bg-dark'; break;
                                    default: echo 'bg-primary';
                                }
                                ?> fs-6 px-3 py-2">
                                <?php echo ucfirst($program['level']); ?>
                            </span>
                        </div>
                    </div>

                    <p class="lead text-muted mb-4">
                        <?php echo htmlspecialchars($program['description']); ?>
                    </p>

                    <div class="row g-4">
                        <div class="col-md-4">
                            <div class="bg-light p-4 rounded text-center">
                                <div class="fs-3 fw-bold text-primary mb-1">
                                    <?php echo $program['duration']; ?>
                                </div>
                                <div class="text-muted">Duration</div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="bg-light p-4 rounded text-center">
                                <div class="fs-3 fw-bold text-success mb-1">
                                    <?php echo $program['totalWorkouts']; ?>
                                </div>
                                <div class="text-muted">Total Workouts</div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="bg-light p-4 rounded text-center">
                                <div class="text-muted mb-1">Equipment</div>
                                <div class="fw-medium text-dark">
                                    <?php echo htmlspecialchars($program['equipment']); ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Workout Sessions -->
            <h2 class="mb-4 fw-bold">
                <i class="fas fa-dumbbell me-2 text-primary"></i>
                Workout Sessions
            </h2>

            <?php foreach ($program['workouts'] as $index => $workout): ?>
                <div class="card shadow-sm mb-4">
                    <div class="card-header bg-primary text-white">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h5 class="mb-1 fw-bold">
                                    Week <?php echo $index + 1; ?>: <?php echo htmlspecialchars($workout['name']); ?>
                                </h5>
                                <div class="d-flex gap-3 text-primary-light">
                                    <span><i class="fas fa-clock me-1"></i> <?php echo $workout['duration']; ?> minutes</span>
                                    <span><i class="fas fa-dumbbell me-1"></i> <?php echo count($workout['exercises']); ?> exercises</span>
                                </div>
                            </div>
                            <button class="btn btn-light btn-lg" onclick="startWorkout(<?php echo $workout['id']; ?>)">
                                <i class="fas fa-play me-2"></i> Start Workout
                            </button>
                        </div>
                    </div>
                    
                    <div class="card-body">
                        <div class="row g-3">
                            <?php foreach ($workout['exercises'] as $exerciseIndex => $exercise): ?>
                                <div class="col-md-6">
                                    <div class="border rounded p-3 h-100">
                                        <div class="d-flex justify-content-between align-items-start mb-2">
                                            <h6 class="fw-bold mb-1">
                                                <?php echo $exerciseIndex + 1; ?>. <?php echo htmlspecialchars($exercise['name']); ?>
                                            </h6>
                                            <button class="btn btn-sm btn-outline-primary" 
                                                    onclick="toggleExerciseDetails(<?php echo $workout['id']; ?>_<?php echo $exerciseIndex; ?>)">
                                                <i class="fas fa-info-circle"></i>
                                            </button>
                                        </div>
                                        
                                        <div class="d-flex gap-3 text-muted small mb-2">
                                            <span><i class="fas fa-chart-bar me-1"></i> <?php echo $exercise['sets']; ?> sets</span>
                                            <span><i class="fas fa-sort-numeric-up me-1"></i> <?php echo $exercise['reps']; ?> reps</span>
                                        </div>
                                        
                                        <p class="text-muted small mb-0">
                                            <?php echo htmlspecialchars($exercise['description']); ?>
                                        </p>
                                        
                                        <!-- Collapsible details -->
                                        <div id="details_<?php echo $workout['id']; ?>_<?php echo $exerciseIndex; ?>" 
                                             class="mt-3" style="display: none;">
                                            <div class="bg-light rounded p-3">
                                                <h6 class="fw-bold mb-2">
                                                    <i class="fas fa-lightbulb me-1 text-warning"></i> Exercise Tips:
                                                </h6>
                                                <ul class="small mb-0">
                                                    <li>Focus on proper form over speed</li>
                                                    <li>Control the movement throughout</li>
                                                    <li>Breathe properly during execution</li>
                                                    <li>Rest adequately between sets</li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </section>

    <?php include 'includes/footer.php'; ?>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Custom JS -->
    <script src="script.js"></script>

    <script>
    function startWorkout(workoutId) {
        // Redirect to workout timer page
        window.location.href = 'workout-timer.php?id=' + workoutId;
    }

    function toggleExerciseDetails(exerciseId) {
        const details = document.getElementById('details_' + exerciseId);
        if (details.style.display === 'none') {
            details.style.display = 'block';
            details.style.animation = 'fadeIn 0.3s ease-in';
        } else {
            details.style.display = 'none';
        }
    }

    // Add animation keyframes
    const style = document.createElement('style');
    style.textContent = `
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-10px); }
            to { opacity: 1; transform: translateY(0); }
        }
    `;
    document.head.appendChild(style);
    </script>
</body>
</html>