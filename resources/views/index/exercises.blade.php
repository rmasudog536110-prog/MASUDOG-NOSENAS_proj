<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Exercise Library - FitClub</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
    <script src="https://kit.fontawesome.com/41115896cd.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="../HTML-CSS/styles.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
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

    <!-- Exercise Library Section -->
    <section class="py-5 bg-light">
        <div class="container">
            <!-- Header -->
            <div class="text-center mb-5">
                <h1 class="display-4 fw-bold text-dark mb-3">
                    <i class="fas fa-book me-3 text-primary"></i>
                    Exercise Library
                </h1>
                <p class="lead text-muted">
                    Comprehensive collection of exercises for all fitness levels
                </p>
            </div>

            <!-- Search Bar -->
            <div class="row justify-content-center mb-4">
                <div class="col-md-6">
                    <div class="input-group">
                        <span class="input-group-text">
                            <i class="fas fa-search"></i>
                        </span>
                        <input type="text" 
                               class="form-control" 
                               id="exerciseSearch" 
                               placeholder="Search exercises..."
                               onkeyup="filterExercises()">
                    </div>
                </div>
            </div>

            <!-- Filter Buttons -->
            <div class="d-flex justify-content-center mb-5 flex-wrap gap-2">
                <a href="exercises.php?category=all" 
                   class="btn <?php echo $filter === 'all' ? 'btn-primary' : 'btn-outline-primary'; ?> me-2 mb-2">
                    <i class="fas fa-th-large me-1"></i> All Exercises
                </a>
                <a href="exercises.php?category=strength" 
                   class="btn <?php echo $filter === 'strength' ? 'btn-info' : 'btn-outline-info'; ?> me-2 mb-2">
                    <i class="fas fa-dumbbell me-1"></i> Strength
                </a>
                <a href="exercises.php?category=cardio" 
                   class="btn <?php echo $filter === 'cardio' ? 'btn-danger' : 'btn-outline-danger'; ?> me-2 mb-2">
                    <i class="fas fa-heart me-1"></i> Cardio
                </a>
                <a href="exercises.php?category=flexibility" 
                   class="btn <?php echo $filter === 'flexibility' ? 'btn-success' : 'btn-outline-success'; ?> me-2 mb-2">
                    <i class="fas fa-leaf me-1"></i> Flexibility
                </a>
                <a href="exercises.php?category=functional" 
                   class="btn <?php echo $filter === 'functional' ? 'btn-warning' : 'btn-outline-warning'; ?> me-2 mb-2">
                    <i class="fas fa-running me-1"></i> Functional
                </a>
            </div>

            <!-- Exercises Grid -->
            <div class="row g-3" id="exercisesGrid">
                <?php foreach ($filteredExercises as $exercise): ?>
                    <div class="col-lg-3 col-md-4 col-sm-6 exercise-item" 
                         data-name="<?php echo strtolower($exercise['name']); ?>"
                         data-category="<?php echo $exercise['category']; ?>">
                        <div class="card h-100 shadow-sm exercise-card">
                            <div class="card-body">
                                <!-- Exercise Header -->
                                <div class="d-flex align-items-center mb-2">
                                    <span class="fs-4 me-2"><?php echo $exercise['icon']; ?></span>
                                    <h6 class="card-title fw-bold text-dark mb-0">
                                        <?php echo htmlspecialchars($exercise['name']); ?>
                                    </h6>
                                </div>

                                <!-- Description -->
                                <p class="card-text text-muted small mb-3">
                                    <?php echo htmlspecialchars($exercise['description']); ?>
                                </p>

                                <!-- Tags -->
                                <div class="d-flex flex-wrap gap-1 mb-2">
                                    <span class="badge 
                                        <?php 
                                        switch($exercise['category']) {
                                            case 'strength': echo 'bg-info'; break;
                                            case 'cardio': echo 'bg-danger'; break;
                                            case 'flexibility': echo 'bg-success'; break;
                                            case 'functional': echo 'bg-warning text-dark'; break;
                                            default: echo 'bg-primary';
                                        }
                                        ?> text-uppercase">
                                        <?php echo $exercise['category']; ?>
                                    </span>
                                    <span class="badge 
                                        <?php 
                                        switch($exercise['difficulty']) {
                                            case 'beginner': echo 'bg-success'; break;
                                            case 'intermediate': echo 'bg-warning text-dark'; break;
                                            case 'expert': echo 'bg-danger'; break;
                                            default: echo 'bg-primary';
                                        }
                                        ?>">
                                        <?php echo ucfirst($exercise['difficulty']); ?>
                                    </span>
                                </div>

                                <!-- Equipment -->
                                <div class="text-muted small">
                                    <i class="fas fa-tools me-1"></i>
                                    <?php echo htmlspecialchars($exercise['equipment']); ?>
                                </div>
                            </div>
                            
                            <!-- Card Footer -->
                            <div class="card-footer bg-transparent border-0 pt-0">
                                <button class="btn btn-outline-primary btn-sm w-100" 
                                        onclick="viewExercise(<?php echo $exercise['id']; ?>)">
                                    <i class="fas fa-play me-1"></i> View Exercise
                                </button>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>

            <!-- No Results Message -->
            <div id="noResults" class="text-center py-5" style="display: none;">
                <i class="fas fa-search fa-3x text-muted mb-3"></i>
                <h4 class="text-muted">No exercises found</h4>
                <p class="text-muted">Try adjusting your search or filter criteria.</p>
            </div>

            <?php if (empty($filteredExercises)): ?>
                <div class="text-center py-5">
                    <i class="fas fa-dumbbell fa-3x text-muted mb-3"></i>
                    <h4 class="text-muted">No exercises found</h4>
                    <p class="text-muted">Try selecting a different category filter.</p>
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
    function viewExercise(exerciseId) {
        // You can implement exercise detail view here
        alert('Exercise details would be shown here. Exercise ID: ' + exerciseId);
        // Example: window.location.href = 'exercise-detail.php?id=' + exerciseId;
    }

    function filterExercises() {
        const searchTerm = document.getElementById('exerciseSearch').value.toLowerCase();
        const exercises = document.querySelectorAll('.exercise-item');
        let visibleCount = 0;

        exercises.forEach(exercise => {
            const exerciseName = exercise.getAttribute('data-name');
            const exerciseCategory = exercise.getAttribute('data-category');
            
            if (exerciseName.includes(searchTerm) || exerciseCategory.includes(searchTerm)) {
                exercise.style.display = 'block';
                visibleCount++;
            } else {
                exercise.style.display = 'none';
            }
        });

        // Show/hide no results message
        const noResults = document.getElementById('noResults');
        if (visibleCount === 0) {
            noResults.style.display = 'block';
        } else {
            noResults.style.display = 'none';
        }
    }

    // Add card hover effects
    document.addEventListener('DOMContentLoaded', function() {
        const cards = document.querySelectorAll('.exercise-card');
        cards.forEach(card => {
            card.addEventListener('mouseenter', function() {
                this.style.transform = 'translateY(-3px)';
                this.style.transition = 'all 0.3s ease';
                this.style.boxShadow = '0 4px 15px rgba(0,0,0,0.1)';
            });
            
            card.addEventListener('mouseleave', function() {
                this.style.transform = 'translateY(0)';
                this.style.boxShadow = '';
            });
        });
    });
    </script>
</body>
</html>