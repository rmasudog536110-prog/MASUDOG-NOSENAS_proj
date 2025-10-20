<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($exercise['name']); ?> - FitClub</title>
    
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
    @include('index.header')

    <!-- Exercise Detail Section -->
    <section class="py-5 bg-light">
        <div class="container">
            <!-- Back Button -->
            <a href="exercises.php" class="btn btn-outline-primary mb-4">
                <i class="fas fa-arrow-left me-2"></i> Back to Exercises
            </a>

            <!-- Exercise Header -->
            <div class="card shadow-lg mb-5">
                <div class="card-body p-5">
                    <div class="d-flex align-items-center mb-4">
                        <span class="fs-1 me-4"><?php echo $exercise['icon']; ?></span>
                        <div>
                            <h1 class="display-5 fw-bold text-dark mb-2">
                                <?php echo htmlspecialchars($exercise['name']); ?>
                            </h1>
                            <div class="d-flex gap-2">
                                <span class="badge 
                                    <?php 
                                    switch($exercise['category']) {
                                        case 'strength': echo 'bg-info'; break;
                                        case 'cardio': echo 'bg-danger'; break;
                                        case 'flexibility': echo 'bg-success'; break;
                                        case 'functional': echo 'bg-warning text-dark'; break;
                                        default: echo 'bg-primary';
                                    }
                                    ?> fs-6 px-3 py-2">
                                    <?php echo ucfirst($exercise['category']); ?>
                                </span>
                                <span class="badge 
                                    <?php 
                                    switch($exercise['difficulty']) {
                                        case 'beginner': echo 'bg-success'; break;
                                        case 'intermediate': echo 'bg-warning text-dark'; break;
                                        case 'expert': echo 'bg-danger'; break;
                                        default: echo 'bg-primary';
                                    }
                                    ?> fs-6 px-3 py-2">
                                    <?php echo ucfirst($exercise['difficulty']); ?>
                                </span>
                            </div>
                        </div>
                    </div>

                    <p class="lead text-muted mb-4">
                        <?php echo htmlspecialchars($exercise['description']); ?>
                    </p>

                    <div class="row g-4">
                        <div class="col-md-4">
                            <div class="bg-light p-4 rounded">
                                <h6 class="fw-bold mb-2">Target Muscles</h6>
                                <div class="d-flex flex-wrap gap-1">
                                    <?php foreach ($exercise['targetMuscles'] as $muscle): ?>
                                        <span class="badge bg-primary bg-opacity-10 text-primary">
                                            <?php echo htmlspecialchars($muscle); ?>
                                        </span>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="bg-light p-4 rounded">
                                <h6 class="fw-bold mb-2">Equipment</h6>
                                <p class="text-muted mb-0"><?php echo htmlspecialchars($exercise['equipment']); ?></p>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="bg-light p-4 rounded">
                                <h6 class="fw-bold mb-2">Recommended</h6>
                                <p class="text-muted mb-0"><?php echo $exercise['defaultSets']; ?> sets × <?php echo $exercise['defaultReps']; ?></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row g-5">
                <!-- Timer & Instructions -->
                <div class="col-lg-6">
                    <!-- Timer Section -->
                    <div class="card shadow-sm mb-4">
                        <div class="card-body">
                            <h5 class="card-title mb-4">
                                <i class="fas fa-stopwatch me-2 text-primary"></i>
                                Workout Timer
                            </h5>
                            
                            <!-- Timer Display -->
                            <div class="text-center mb-4">
                                <div id="timerDisplay" class="display-3 fw-bold text-primary mb-2">
                                    0:<?php echo str_pad($exercise['defaultDuration'], 2, '0', STR_PAD_LEFT); ?>
                                </div>
                                <div id="timerStatus" class="h5 text-muted">Ready to Start</div>
                                <div id="setCounter" class="text-muted">Set 1 of <?php echo $exercise['defaultSets']; ?></div>
                            </div>

                            <!-- Timer Controls -->
                            <div class="d-flex justify-content-center gap-2 mb-4">
                                <button id="startBtn" class="btn btn-success" onclick="startTimer()">
                                    <i class="fas fa-play me-1"></i> Start
                                </button>
                                <button id="pauseBtn" class="btn btn-warning" onclick="pauseTimer()" disabled>
                                    <i class="fas fa-pause me-1"></i> Pause
                                </button>
                                <button id="resetBtn" class="btn btn-outline-secondary" onclick="resetTimer()">
                                    <i class="fas fa-redo me-1"></i> Reset
                                </button>
                            </div>

                            <!-- Timer Settings -->
                            <div class="row g-2">
                                <div class="col-4">
                                    <label class="form-label small">Sets</label>
                                    <input type="number" id="setsInput" class="form-control text-center" 
                                           value="<?php echo $exercise['defaultSets']; ?>" min="1" max="10">
                                </div>
                                <div class="col-4">
                                    <label class="form-label small">Work (sec)</label>
                                    <input type="number" id="workInput" class="form-control text-center" 
                                           value="<?php echo $exercise['defaultDuration']; ?>" min="10" max="300">
                                </div>
                                <div class="col-4">
                                    <label class="form-label small">Rest (sec)</label>
                                    <input type="number" id="restInput" class="form-control text-center" 
                                           value="60" min="15" max="180">
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Step-by-Step Instructions -->
                    <div class="card shadow-sm">
                        <div class="card-body">
                            <h5 class="card-title mb-4">
                                <i class="fas fa-list-ol me-2 text-primary"></i>
                                Step-by-Step Instructions
                            </h5>
                            
                            <div id="instructionsList">
                                <?php foreach ($exercise['instructions'] as $index => $instruction): ?>
                                    <div class="instruction-step mb-3 p-3 rounded cursor-pointer" 
                                         data-step="<?php echo $index; ?>" onclick="selectStep(<?php echo $index; ?>)">
                                        <div class="d-flex align-items-start">
                                            <div class="step-number rounded-circle d-flex align-items-center justify-content-center me-3">
                                                <?php echo $index + 1; ?>
                                            </div>
                                            <p class="mb-0"><?php echo htmlspecialchars($instruction); ?></p>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>

                            <div class="d-flex justify-content-between mt-3">
                                <button class="btn btn-outline-primary btn-sm" onclick="previousStep()">
                                    <i class="fas fa-chevron-left me-1"></i> Previous
                                </button>
                                <button class="btn btn-outline-primary btn-sm" onclick="nextStep()">
                                    Next <i class="fas fa-chevron-right ms-1"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Tips & Variations -->
                <div class="col-lg-6">
                    <!-- Demo Placeholder -->
                    <div class="card shadow-sm mb-4">
                        <div class="card-body">
                            <h5 class="card-title mb-3">
                                <i class="fas fa-video me-2 text-primary"></i>
                                Exercise Demo
                            </h5>
                            <div class="bg-light rounded d-flex align-items-center justify-content-center" style="height: 200px;">
                                <div class="text-center text-muted">
                                    <i class="fas fa-play-circle fa-3x mb-2"></i>
                                    <p class="mb-1">Demo video would be shown here</p>
                                    <small id="stepIndicator">Step 1 of <?php echo count($exercise['instructions']); ?></small>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Pro Tips -->
                    <div class="card shadow-sm mb-4">
                        <div class="card-body">
                            <h5 class="card-title mb-3">
                                <i class="fas fa-lightbulb me-2 text-warning"></i>
                                Pro Tips
                            </h5>
                            <ul class="list-unstyled">
                                <?php foreach ($exercise['tips'] as $tip): ?>
                                    <li class="mb-2">
                                        <i class="fas fa-check text-success me-2"></i>
                                        <?php echo htmlspecialchars($tip); ?>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    </div>

                    <!-- Variations -->
                    <div class="card shadow-sm mb-4">
                        <div class="card-body">
                            <h5 class="card-title mb-3">
                                <i class="fas fa-sync-alt me-2 text-info"></i>
                                Variations
                            </h5>
                            <ul class="list-unstyled">
                                <?php foreach ($exercise['variations'] as $variation): ?>
                                    <li class="mb-2">
                                        <i class="fas fa-arrow-right text-info me-2"></i>
                                        <?php echo htmlspecialchars($variation); ?>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    </div>

                    <!-- Common Mistakes -->
                    <div class="card shadow-sm">
                        <div class="card-body">
                            <h5 class="card-title mb-3">
                                <i class="fas fa-exclamation-triangle me-2 text-danger"></i>
                                Common Mistakes
                            </h5>
                            <ul class="list-unstyled">
                                <?php foreach ($exercise['commonMistakes'] as $mistake): ?>
                                    <li class="mb-2">
                                        <i class="fas fa-times text-danger me-2"></i>
                                        <?php echo htmlspecialchars($mistake); ?>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

     @include('index.footer')

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Custom JS -->
    <script src="script.js"></script>

    <script>
    let currentStep = 0;
    let timer = null;
    let timeRemaining = <?php echo $exercise['defaultDuration']; ?>;
    let isRunning = false;
    let currentSet = 1;
    let totalSets = <?php echo $exercise['defaultSets']; ?>;
    let isResting = false;

    // Timer Functions
    function startTimer() {
        if (!isRunning) {
            isRunning = true;
            document.getElementById('startBtn').disabled = true;
            document.getElementById('pauseBtn').disabled = false;
            
            timer = setInterval(() => {
                timeRemaining--;
                updateTimerDisplay();
                
                if (timeRemaining <= 0) {
                    if (!isResting && currentSet < totalSets) {
                        // Start rest period
                        isResting = true;
                        timeRemaining = parseInt(document.getElementById('restInput').value);
                        document.getElementById('timerStatus').textContent = '😌 Rest Time';
                    } else if (isResting) {
                        // Rest finished, next set
                        isResting = false;
                        currentSet++;
                        timeRemaining = parseInt(document.getElementById('workInput').value);
                        document.getElementById('timerStatus').textContent = '💪 Work Time';
                        updateSetCounter();
                    } else {
                        // Workout complete
                        completeWorkout();
                    }
                }
            }, 1000);
            
            document.getElementById('timerStatus').textContent = '💪 Work Time';
        }
    }

    function pauseTimer() {
        if (isRunning) {
            clearInterval(timer);
            isRunning = false;
            document.getElementById('startBtn').disabled = false;
            document.getElementById('pauseBtn').disabled = true;
            document.getElementById('timerStatus').textContent = '⏸️ Paused';
        }
    }

    function resetTimer() {
        clearInterval(timer);
        isRunning = false;
        isResting = false;
        currentSet = 1;
        timeRemaining = parseInt(document.getElementById('workInput').value);
        
        document.getElementById('startBtn').disabled = false;
        document.getElementById('pauseBtn').disabled = true;
        document.getElementById('timerStatus').textContent = 'Ready to Start';
        
        updateTimerDisplay();
        updateSetCounter();
    }

    function updateTimerDisplay() {
        const minutes = Math.floor(timeRemaining / 60);
        const seconds = timeRemaining % 60;
        document.getElementById('timerDisplay').textContent = 
            minutes + ':' + seconds.toString().padStart(2, '0');
    }

    function updateSetCounter() {
        document.getElementById('setCounter').textContent = 
            `Set ${currentSet} of ${totalSets}`;
    }

    function completeWorkout() {
        clearInterval(timer);
        isRunning = false;
        document.getElementById('timerStatus').textContent = '🎉 Workout Complete!';
        document.getElementById('startBtn').disabled = false;
        document.getElementById('pauseBtn').disabled = true;
        
        // Show completion message
        setTimeout(() => {
            alert('Congratulations! You completed the workout!');
        }, 100);
    }

    // Step Navigation Functions
    function selectStep(step) {
        currentStep = step;
        updateStepHighlight();
        updateStepIndicator();
    }

    function previousStep() {
        if (currentStep > 0) {
            currentStep--;
            updateStepHighlight();
            updateStepIndicator();
        }
    }

    function nextStep() {
        if (currentStep < <?php echo count($exercise['instructions']) - 1; ?>) {
            currentStep++;
            updateStepHighlight();
            updateStepIndicator();
        }
    }

    function updateStepHighlight() {
        const steps = document.querySelectorAll('.instruction-step');
        steps.forEach((step, index) => {
            if (index === currentStep) {
                step.style.backgroundColor = '#e3f2fd';
                step.style.border = '2px solid #2196f3';
                step.querySelector('.step-number').style.backgroundColor = '#2196f3';
                step.querySelector('.step-number').style.color = 'white';
            } else {
                step.style.backgroundColor = '#f8f9fa';
                step.style.border = '1px solid #dee2e6';
                step.querySelector('.step-number').style.backgroundColor = '#6c757d';
                step.querySelector('.step-number').style.color = 'white';
            }
        });
    }

    function updateStepIndicator() {
        document.getElementById('stepIndicator').textContent = 
            `Step ${currentStep + 1} of <?php echo count($exercise['instructions']); ?>`;
    }

    // Initialize
    document.addEventListener('DOMContentLoaded', function() {
        updateStepHighlight();
        updateSetCounter();
        
        // Add styles
        const style = document.createElement('style');
        style.textContent = `
            .instruction-step {
                background-color: #f8f9fa;
                border: 1px solid #dee2e6;
                transition: all 0.2s ease;
                cursor: pointer;
            }
            .instruction-step:hover {
                background-color: #e9ecef;
            }
            .step-number {
                width: 32px;
                height: 32px;
                background-color: #6c757d;
                color: white;
                font-size: 14px;
                font-weight: bold;
            }
        `;
        document.head.appendChild(style);
    });
    </script>
</body>
</html>