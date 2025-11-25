// Exercise Timer and Step Navigation
let timerInterval;
let timeRemaining;
let isPaused = false;
let currentSet = 1;
let currentStep = 0;
let totalSets;
let defaultDuration;
let totalSteps;

// Initialize timer on page load
document.addEventListener('DOMContentLoaded', function() {
    // Get values from the page
    const timerDisplay = document.getElementById('timerDisplay');
    if (timerDisplay) {
        const timeText = timerDisplay.textContent.trim();
        const timeParts = timeText.split(':');
        defaultDuration = parseInt(timeParts[0]) * 60 + parseInt(timeParts[1]);
        timeRemaining = defaultDuration;
    }
    
    const setCounterText = document.getElementById('setCounter')?.textContent;
    if (setCounterText) {
        const match = setCounterText.match(/Set \d+ of (\d+)/);
        totalSets = match ? parseInt(match[1]) : 3;
    }
    
    const instructionSteps = document.querySelectorAll('.instruction-step');
    totalSteps = instructionSteps.length;
    
    // Highlight first step
    if (instructionSteps.length > 0) {
        instructionSteps[0].classList.add('active');
    }

    // Add event listeners for timer settings
    const setsInput = document.getElementById('setsInput');
    const workInput = document.getElementById('workInput');
    const restInput = document.getElementById('restInput');
    
    if (setsInput) {
        setsInput.addEventListener('input', function() {
            // Validate sets input
            let value = parseInt(this.value);
            if (isNaN(value) || value < 1) this.value = 1;
            if (value > 10) this.value = 10;
        });
        
        setsInput.addEventListener('change', function() {
            totalSets = parseInt(this.value) || 3;
            updateSetCounter();
            showNotification(`Sets updated to ${totalSets}.`);
        });
    }
    
    if (workInput) {
        workInput.addEventListener('input', function() {
            // Validate work duration input
            let value = parseInt(this.value);
            if (isNaN(value) || value < 10) this.value = 10;
            if (value > 300) this.value = 300;
        });
        
        workInput.addEventListener('change', function() {
            const newDuration = parseInt(this.value) || 30;
            defaultDuration = newDuration;
            if (!timerInterval) { // Only update if timer is not running
                timeRemaining = defaultDuration;
                updateTimerDisplay();
            } else {
                // Show notification that timer is running
                showNotification('Timer is running. Reset to apply new duration.');
            }
        });
    }
    
    if (restInput) {
        restInput.addEventListener('input', function() {
            // Validate rest duration input
            let value = parseInt(this.value);
            if (isNaN(value) || value < 15) this.value = 15;
            if (value > 180) this.value = 180;
        });
        
        restInput.addEventListener('change', function() {
            const newRestDuration = parseInt(this.value) || 60;
            // Rest duration is used in completeSet function
            // This will be applied on next set completion
            showNotification(`Rest duration updated to ${newRestDuration} seconds.`);
        });
    }
});

function startTimer() {
    if (timerInterval) return; // Already running
    
    const startBtn = document.getElementById('startBtn');
    const pauseBtn = document.getElementById('pauseBtn');
    const resetBtn = document.getElementById('resetBtn');
    const timerStatus = document.getElementById('timerStatus');
    
    startBtn.disabled = true;
    pauseBtn.disabled = false;
    resetBtn.disabled = false;
    timerStatus.textContent = 'Working Out';
    timerStatus.classList.add('text-success');
    
    isPaused = false;
    
    timerInterval = setInterval(() => {
        if (!isPaused && timeRemaining > 0) {
            timeRemaining--;
            updateTimerDisplay();
            
            if (timeRemaining === 0) {
                completeSet();
            }
        }
    }, 1000);
}

function pauseTimer() {
    const pauseBtn = document.getElementById('pauseBtn');
    const resumeBtn = document.getElementById('resumeBtn');
    const timerStatus = document.getElementById('timerStatus');
    
    isPaused = true;
    pauseBtn.style.display = 'none';
    resumeBtn.style.display = 'inline-block';
    resumeBtn.disabled = false;
    timerStatus.textContent = 'Paused';
    timerStatus.classList.remove('text-success');
    timerStatus.classList.add('text-warning');
}

function resumeTimer() {
    const pauseBtn = document.getElementById('pauseBtn');
    const resumeBtn = document.getElementById('resumeBtn');
    const timerStatus = document.getElementById('timerStatus');
    
    isPaused = false;
    pauseBtn.style.display = 'inline-block';
    resumeBtn.style.display = 'none';
    timerStatus.textContent = 'Working Out';
    timerStatus.classList.remove('text-warning');
    timerStatus.classList.add('text-success');
}

function resetTimer() {
    clearInterval(timerInterval);
    timerInterval = null;
    
    const startBtn = document.getElementById('startBtn');
    const pauseBtn = document.getElementById('pauseBtn');
    const resumeBtn = document.getElementById('resumeBtn');
    const resetBtn = document.getElementById('resetBtn');
    const timerStatus = document.getElementById('timerStatus');
    
    startBtn.disabled = false;
    pauseBtn.disabled = true;
    pauseBtn.style.display = 'inline-block';
    resumeBtn.style.display = 'none';
    resetBtn.disabled = true;
    
    timeRemaining = defaultDuration;
    currentSet = 1;
    isPaused = false;
    
    updateTimerDisplay();
    updateSetCounter();
    
    timerStatus.textContent = 'Ready to Start';
    timerStatus.classList.remove('text-success', 'text-warning');
}

function completeSet() {
    clearInterval(timerInterval);
    timerInterval = null;
    
    const timerStatus = document.getElementById('timerStatus');
    const restInput = document.getElementById('restInput');
    const restDuration = restInput ? parseInt(restInput.value) : 60;
    
    if (currentSet < totalSets) {
        // Rest period
        timerStatus.textContent = 'Rest Time!';
        timerStatus.classList.remove('text-success');
        timerStatus.classList.add('text-info');
        
        // Play completion sound (optional)
        playCompletionSound();
        
        // Show rest notification
        showNotification(`Set Complete! Take a ${restDuration} second rest.`);
        
        // Auto-start next set after rest
        setTimeout(() => {
            currentSet++;
            timeRemaining = defaultDuration;
            updateSetCounter();
            updateTimerDisplay();
            startTimer();
        }, restDuration * 1000); // Use dynamic rest duration
        
    } else {
        // Workout complete
        timerStatus.textContent = 'Workout Complete!';
        timerStatus.classList.remove('text-success');
        timerStatus.classList.add('text-primary');
        
        showNotification('🎉 Workout Complete! Great job!');
        playCompletionSound();
        
        const startBtn = document.getElementById('startBtn');
        const pauseBtn = document.getElementById('pauseBtn');
        const resetBtn = document.getElementById('resetBtn');
        
        startBtn.disabled = false;
        pauseBtn.disabled = true;
        resetBtn.disabled = false;
    }
}

function updateTimerDisplay() {
    const minutes = Math.floor(timeRemaining / 60);
    const seconds = timeRemaining % 60;
    const display = `${minutes}:${seconds.toString().padStart(2, '0')}`;
    
    const timerDisplay = document.getElementById('timerDisplay');
    if (timerDisplay) {
        timerDisplay.textContent = display;
    }
}

function updateSetCounter() {
    const setCounter = document.getElementById('setCounter');
    if (setCounter) {
        setCounter.textContent = `Set ${currentSet} of ${totalSets}`;
    }
}

function showNotification(message) {
    // Create notification element
    const notification = document.createElement('div');
    notification.className = 'alert alert-success position-fixed top-0 start-50 translate-middle-x mt-3';
    notification.style.zIndex = '9999';
    notification.textContent = message;
    
    document.body.appendChild(notification);
    
    // Remove after 3 seconds
    setTimeout(() => {
        notification.remove();
    }, 3000);
}

function playCompletionSound() {
    // Optional: Add audio feedback
    // const audio = new Audio('/sounds/complete.mp3');
    // audio.play();
}

// Step Navigation
function selectStep(stepIndex) {
    currentStep = stepIndex;
    
    // Update step indicator
    const stepIndicator = document.getElementById('stepIndicator');
    if (stepIndicator) {
        stepIndicator.textContent = `Step ${stepIndex + 1} of ${totalSteps}`;
    }
    
    // Highlight selected step
    const steps = document.querySelectorAll('.instruction-step');
    steps.forEach((step, index) => {
        if (index === stepIndex) {
            step.classList.add('active');
            step.style.backgroundColor = 'rgba(255, 102, 0, 0.1)';
            step.style.borderLeft = '4px solid var(--primary)';
        } else {
            step.classList.remove('active');
            step.style.backgroundColor = '';
            step.style.borderLeft = '';
        }
    });
}

function nextStep() {
    if (currentStep < totalSteps - 1) {
        selectStep(currentStep + 1);
    }
}

function previousStep() {
    if (currentStep > 0) {
        selectStep(currentStep - 1);
    }
}

// Keyboard shortcuts
document.addEventListener('keydown', function(e) {
    // Space bar to start/pause
    if (e.code === 'Space' && e.target.tagName !== 'INPUT') {
        e.preventDefault();
        const startBtn = document.getElementById('startBtn');
        const pauseBtn = document.getElementById('pauseBtn');
        
        if (!startBtn.disabled) {
            startTimer();
        } else if (!pauseBtn.disabled && !isPaused) {
            pauseTimer();
        } else if (isPaused) {
            resumeTimer();
        }
    }
    
    // R to reset
    if (e.code === 'KeyR' && e.target.tagName !== 'INPUT') {
        const resetBtn = document.getElementById('resetBtn');
        if (!resetBtn.disabled) {
            resetTimer();
        }
    }
    
    // Arrow keys for step navigation
    if (e.code === 'ArrowRight') {
        nextStep();
    }
    if (e.code === 'ArrowLeft') {
        previousStep();
    }
});
