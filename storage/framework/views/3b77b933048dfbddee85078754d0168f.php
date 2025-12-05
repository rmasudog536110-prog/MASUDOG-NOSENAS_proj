<?php $__env->startSection('title', $exercise['name'] . ' - FitClub'); ?>
<?php $__env->startPush('styles'); ?>
<link rel="stylesheet" href="<?php echo e(asset('css/exercises.css')); ?>">

<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>


<?php echo $__env->make('index.header', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

    <section class="py-5 bg-light">
        <div class="container">
            <!-- Back Button -->
            <a href="<?php echo e(route('exercises.index')); ?>" class="btn btn-outline-primary mb-4">
                <i class="fas fa-arrow-left me-2"></i> Back to Exercises
            </a>

            <!-- Exercise Header -->
            <div class="card shadow-lg mb-5">
                <div class="card-body p-5">
                    <div class="d-flex align-items-center mb-4">
                        <span class="fs-1 me-4"><?php echo e($exercise['icon']); ?></span>
                        <div>
                            <h1 class="display-5 fw-bold mb-2"><?php echo e($exercise['name']); ?></h1>
                            <div class="d-flex gap-2">
                                <span class="badge 
                                    <?php switch($exercise['category']):
                                        case ('strength'): ?> bg-info <?php break; ?>
                                        <?php case ('cardio'): ?> bg-danger <?php break; ?>
                                        <?php case ('flexibility'): ?> bg-success <?php break; ?>
                                        <?php case ('functional'): ?> bg-warning text-dark <?php break; ?>
                                        <?php default: ?> bg-primary
                                    <?php endswitch; ?> fs-6 px-3 py-2">
                                    <?php echo e(ucfirst($exercise['category'])); ?>

                                </span>
                                <span class="badge 
                                    <?php switch($exercise['difficulty']):
                                        case ('beginner'): ?> bg-success <?php break; ?>
                                        <?php case ('intermediate'): ?> bg-warning text-dark <?php break; ?>
                                        <?php case ('expert'): ?> bg-danger <?php break; ?>
                                        <?php default: ?> bg-primary
                                    <?php endswitch; ?> fs-6 px-3 py-2">
                                    <?php echo e(ucfirst($exercise['difficulty'])); ?>

                                </span>
                            </div>
                        </div>
                    </div>

                    <p class="lead text-muted mb-4"><?php echo e($exercise['description']); ?></p>

                    <div class="row g-4">
                        <div class="col-md-4">
                            <div class="bg-light p-4 rounded">
                                <h6 class="fw-bold mb-2">Target Muscles</h6>
                                <div class="d-flex flex-wrap gap-1">
                                    <?php $__currentLoopData = $exercise['targetMuscles']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $muscle): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <span class="badge bg-primary bg-opacity-10 text-white">
                                            <?php echo e($muscle); ?>

                                        </span>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="bg-light p-4 rounded">
                                <h6 class="fw-bold mb-2">Equipment</h6>
                                <p class="text-muted mb-0"><?php echo e($exercise['equipment']); ?></p>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="bg-light p-4 rounded">
                                <h6 class="fw-bold mb-2">Recommended</h6>
                                <p class="text-muted mb-0">
                                    <?php echo e($exercise['defaultSets']); ?> sets × <?php echo e($exercise['defaultReps']); ?>

                                </p>
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
                                    0:<?php echo e(str_pad($exercise['defaultDuration'], 2, '0', STR_PAD_LEFT)); ?>

                                </div>
                                <div id="timerStatus" class="h5 text-muted">Ready to Start</div>
                                <div id="setCounter" class="text-muted">
                                    Set 1 of <?php echo e($exercise['defaultSets']); ?>

                                </div>
                            </div>

                            <!-- Timer Controls -->
                            <div class="d-flex justify-content-center gap-2 mb-4">
                                <button id="startBtn" class="btn btn-success" onclick="startTimer()">
                                    <i class="fas fa-play me-1"></i> Start
                                </button>
                                <button id="pauseBtn" class="btn btn-warning" onclick="pauseTimer()" disabled>
                                    <i class="fas fa-pause me-1"></i> Pause
                                </button>
                                <button id="resumeBtn" class="btn btn-success" onclick="resumeTimer()" style="display: none;">
                                    <i class="fas fa-play me-1"></i> Resume
                                </button>
                                <button id="resetBtn" class="btn btn-outline-secondary" onclick="resetTimer()" disabled>
                                    <i class="fas fa-redo me-1"></i> Reset
                                </button>
                            </div>
                            
                            <!-- Keyboard Shortcuts Info -->
                            <div class="text-center mb-3">
                                <small class="text-muted">
                                    <i class="fas fa-keyboard me-1"></i>
                                    <strong>Shortcuts:</strong> Space = Start/Pause | R = Reset | ← → = Navigate Steps
                                </small>
                            </div>

                            <!-- Timer Settings -->
                            <div class="row g-2">
                                <div class="col-4">
                                    <label class="form-label small">Sets</label>
                                    <input type="number" id="setsInput" class="form-control text-center"
                                        value="<?php echo e($exercise['defaultSets']); ?>" min="1" max="10">
                                </div>
                                <div class="col-4">
                                    <label class="form-label small">Work (sec)</label>
                                    <input type="number" id="workInput" class="form-control text-center"
                                        value="<?php echo e($exercise['defaultDuration']); ?>" min="10" max="300">
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
                                <?php $__currentLoopData = $exercise['instructions']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $instruction): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <div class="instruction-step mb-3 p-3 rounded cursor-pointer"
                                        data-step="<?php echo e($index); ?>" onclick="selectStep(<?php echo e($index); ?>)">
                                        <div class="d-flex align-items-start">
                                            <div class="step-number rounded-circle d-flex align-items-center justify-content-center me-3">
                                                <?php echo e($index + 1); ?>

                                            </div>
                                            <p class="mb-0"><?php echo e($instruction); ?></p>
                                        </div>
                                    </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
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
                    <!-- Exercise Demo -->
                    <div class="card shadow-sm mb-4">
                        <div class="card-body">
                            <h5 class="card-title mb-3">
                                <i class="fas fa-video me-2 text-primary"></i>
                                Exercise Demo
                            </h5>
                            <?php if(!empty($exercise['video_url'])): ?>
                                <div class="bg-dark rounded position-relative" style="height: 250px; cursor: pointer; overflow: hidden;" onclick="openVideoModal('<?php echo e($exercise['video_url']); ?>')">
                                    <div class="position-absolute top-50 start-50 translate-middle text-center">
                                        <div class="bg-danger rounded-circle d-inline-flex align-items-center justify-content-center" style="width: 80px; height: 80px;">
                                            <i class="fas fa-play text-white fa-2x"></i>
                                        </div>
                                        <p class="text-white mt-3 mb-0 fw-bold">Click to Watch Tutorial</p>
                                    </div>
                                    <div class="position-absolute bottom-0 start-0 end-0 bg-dark bg-opacity-75 p-2">
                                        <small class="text-white"><i class="fab fa-youtube me-1"></i> YouTube Tutorial</small>
                                    </div>
                                </div>
                            <?php else: ?>
                                <div class="bg-light rounded d-flex align-items-center justify-content-center" style="height: 200px;">
                                    <div class="text-center text-muted">
                                        <i class="fas fa-video-slash fa-3x mb-2"></i>
                                        <p class="mb-1">No video available</p>
                                    </div>
                                </div>
                            <?php endif; ?>
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
                                <?php $__currentLoopData = $exercise['tips']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tip): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <li class="mb-2">
                                        <i class="fas fa-check text-success me-2"></i>
                                        <?php echo e($tip); ?>

                                    </li>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
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
                                <?php $__currentLoopData = $exercise['variations']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $variation): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <li class="mb-2">
                                        <i class="fas fa-arrow-right text-info me-2"></i>
                                        <?php echo e($variation); ?>

                                    </li>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
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
                                <?php $__currentLoopData = $exercise['commonMistakes']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $mistake): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <li class="mb-2">
                                        <i class="fas fa-times text-danger me-2"></i>
                                        <?php echo e($mistake); ?>

                                    </li>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- YouTube Video Modal -->
    <div id="videoModal" style="display: none; position: fixed; top: 0; left: 0; right: 0; bottom: 0; background: rgba(0,0,0,0.9); z-index: 9999; align-items: center; justify-content: center;">
        <div style="position: relative; width: 90%; max-width: 900px;">
            <button onclick="closeVideoModal()" style="position: absolute; top: -40px; right: 0; background: transparent; border: none; color: white; font-size: 2rem; cursor: pointer;">
                <i class="fas fa-times"></i>
            </button>
            <div style="position: relative; padding-bottom: 56.25%; height: 0; overflow: hidden;">
                <iframe id="videoFrame" 
                        style="position: absolute; top: 0; left: 0; width: 100%; height: 100%;" 
                        frameborder="0" 
                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" 
                        allowfullscreen>
                </iframe>
            </div>
        </div>
    </div>

    
    <script src="<?php echo e(asset('js/exercise-timer.js')); ?>"></script>
    
    <script>
        function openVideoModal(videoUrl) {
            const modal = document.getElementById('videoModal');
            const iframe = document.getElementById('videoFrame');
            
            // Convert YouTube URL to embed URL
            let embedUrl = videoUrl;
            if (videoUrl.includes('youtube.com/watch?v=')) {
                const videoId = videoUrl.split('v=')[1].split('&')[0];
                embedUrl = `https://www.youtube.com/embed/${videoId}?autoplay=1`;
            } else if (videoUrl.includes('youtu.be/')) {
                const videoId = videoUrl.split('youtu.be/')[1].split('?')[0];
                embedUrl = `https://www.youtube.com/embed/${videoId}?autoplay=1`;
            }
            
            iframe.src = embedUrl;
            modal.style.display = 'flex';
        }

        function closeVideoModal() {
            const modal = document.getElementById('videoModal');
            const iframe = document.getElementById('videoFrame');
            
            iframe.src = '';
            modal.style.display = 'none';
        }

        // Close modal on outside click
        document.getElementById('videoModal')?.addEventListener('click', function(e) {
            if (e.target === this) {
                closeVideoModal();
            }
        });

        // Close modal on ESC key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closeVideoModal();
            }
        });
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('skeleton.layout', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Repo\MASUDOG-NOSENAS_proj\resources\views/index/exercise_details.blade.php ENDPATH**/ ?>