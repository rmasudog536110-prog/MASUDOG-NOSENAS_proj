<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Training Programs - FitClub</title>
    
     <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
 
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
   
    <script src="https://kit.fontawesome.com/41115896cd.js" crossorigin="anonymous"></script>
    
    <!-- Custom CSS -->
    <link rel="stylesheet" href="../HTML-CSS/styles.css">
</head>
<body>
    @include('index.header')

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

    <!-- Programs Section -->
    <section class="py-5 bg-light">
        <div class="container">
            <!-- Header -->
            <div class="text-center mb-5">
                <h1 class="display-4 fw-bold text-dark mb-3">
                    <i class="fas fa-dumbbell me-3 text-primary"></i>
                    Training Programs
                </h1>
                <p class="lead text-muted">
                    Professional programs designed for every fitness level
                </p>
            </div>

            <!-- Filter Buttons -->
            <div class="d-flex justify-content-center mb-5 flex-wrap gap-2">
                <a href="programs.php?level=all" 
                   class="btn <?php echo $filter === 'all' ? 'btn-primary' : 'btn-outline-primary'; ?> me-2 mb-2">
                    <i class="fas fa-bullseye me-1"></i> All Levels
                </a>
                <a href="programs.php?level=beginner" 
                   class="btn <?php echo $filter === 'beginner' ? 'btn-success' : 'btn-outline-success'; ?> me-2 mb-2">
                    <i class="fas fa-seedling me-1"></i> Beginner
                </a>
                <a href="programs.php?level=intermediate" 
                   class="btn <?php echo $filter === 'intermediate' ? 'btn-warning' : 'btn-outline-warning'; ?> me-2 mb-2">
                    <i class="fas fa-chart-line me-1"></i> Intermediate
                </a>
                <a href="programs.php?level=expert" 
                   class="btn <?php echo $filter === 'expert' ? 'btn-danger' : 'btn-outline-danger'; ?> me-2 mb-2">
                    <i class="fas fa-star me-1"></i> Expert
                </a>
                <a href="programs.php?level=hardcore" 
                   class="btn <?php echo $filter === 'hardcore' ? 'btn-dark' : 'btn-outline-dark'; ?> me-2 mb-2">
                    <i class="fas fa-fire me-1"></i> Hardcore
                </a>
            </div>

            <!-- Programs Grid -->
            <div class="row g-4">
                <?php foreach ($filteredPrograms as $program): ?>
                    <div class="col-lg-4 col-md-6">
                        <div class="card h-100 shadow-sm program-card">
                            <div class="card-body">
                                <!-- Program Header -->
                                <div class="d-flex align-items-center mb-3">
                                    <span class="fs-2 me-3"><?php echo $program['icon']; ?></span>
                                    <h5 class="card-title fw-bold text-dark mb-0">
                                        <?php echo htmlspecialchars($program['title']); ?>
                                    </h5>
                                </div>

                                <!-- Description -->
                                <p class="card-text text-muted mb-4">
                                    <?php echo htmlspecialchars($program['description']); ?>
                                </p>

                                <!-- Program Details -->
                                <div class="mb-4">
                                    <div class="row g-2 text-sm">
                                        <div class="col-6">
                                            <small class="text-muted">Duration:</small>
                                            <div class="fw-medium"><?php echo htmlspecialchars($program['duration']); ?></div>
                                        </div>
                                        <div class="col-6">
                                            <small class="text-muted">Workouts:</small>
                                            <div class="fw-medium"><?php echo $program['workouts']; ?></div>
                                        </div>
                                        <div class="col-12 mt-2">
                                            <small class="text-muted">Equipment:</small>
                                            <div class="fw-medium"><?php echo htmlspecialchars($program['equipment']); ?></div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Level Badge and Action -->
                                <div class="d-flex justify-content-between align-items-center">
                                    <span class="badge 
                                        <?php 
                                        switch($program['level']) {
                                            case 'beginner': echo 'bg-success'; break;
                                            case 'intermediate': echo 'bg-warning text-dark'; break;
                                            case 'expert': echo 'bg-danger'; break;
                                            case 'hardcore': echo 'bg-dark'; break;
                                            default: echo 'bg-primary';
                                        }
                                        ?> px-3 py-2">
                                        <?php echo ucfirst($program['level']); ?>
                                    </span>
                                    <button class="btn btn-primary btn-sm" onclick="viewProgram(<?php echo $program['id']; ?>)">
                                        <i class="fas fa-eye me-1"></i> View Program
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>

            <?php if (empty($filteredPrograms)): ?>
                <div class="text-center py-5">
                    <i class="fas fa-search fa-3x text-muted mb-3"></i>
                    <h4 class="text-muted">No programs found</h4>
                    <p class="text-muted">Try selecting a different level filter.</p>
                </div>
            <?php endif; ?>
        </div>
    </section>

     @include('index.footer')

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Custom JS -->
    <script src="script.js"></script>

    <script>
    function viewProgram(programId) {
        // You can implement program detail view here
        alert('Program details would be shown here. Program ID: ' + programId);
        // Example: window.location.href = 'program-detail.php?id=' + programId;
    }

    // Add card hover effects
    document.addEventListener('DOMContentLoaded', function() {
        const cards = document.querySelectorAll('.program-card');
        cards.forEach(card => {
            card.addEventListener('mouseenter', function() {
                this.style.transform = 'translateY(-5px)';
                this.style.transition = 'all 0.3s ease';
            });
            
            card.addEventListener('mouseleave', function() {
                this.style.transform = 'translateY(0)';
            });
        });
    });
    </script>
</body>
</html>