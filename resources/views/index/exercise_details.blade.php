@extends('skeleton.layout')

@section('title', $exercise['name'] . ' - FitClub')

@section('content')

@include('index.header')

    <section class="py-5 bg-light">
        <div class="container">
            <!-- Back Button -->
            <a href="{{ route('exercises') }}" class="btn btn-outline-primary mb-4">
                <i class="fas fa-arrow-left me-2"></i> Back to Exercises
            </a>

            <!-- Exercise Header -->
            <div class="card shadow-lg mb-5">
                <div class="card-body p-5">
                    <div class="d-flex align-items-center mb-4">
                        <span class="fs-1 me-4">{{ $exercise['icon'] }}</span>
                        <div>
                            <h1 class="display-5 fw-bold text-dark mb-2">{{ $exercise['name'] }}</h1>
                            <div class="d-flex gap-2">
                                <span class="badge 
                                    @switch($exercise['category'])
                                        @case('strength') bg-info @break
                                        @case('cardio') bg-danger @break
                                        @case('flexibility') bg-success @break
                                        @case('functional') bg-warning text-dark @break
                                        @default bg-primary
                                    @endswitch fs-6 px-3 py-2">
                                    {{ ucfirst($exercise['category']) }}
                                </span>
                                <span class="badge 
                                    @switch($exercise['difficulty'])
                                        @case('beginner') bg-success @break
                                        @case('intermediate') bg-warning text-dark @break
                                        @case('expert') bg-danger @break
                                        @default bg-primary
                                    @endswitch fs-6 px-3 py-2">
                                    {{ ucfirst($exercise['difficulty']) }}
                                </span>
                            </div>
                        </div>
                    </div>

                    <p class="lead text-muted mb-4">{{ $exercise['description'] }}</p>

                    <div class="row g-4">
                        <div class="col-md-4">
                            <div class="bg-light p-4 rounded">
                                <h6 class="fw-bold mb-2">Target Muscles</h6>
                                <div class="d-flex flex-wrap gap-1">
                                    @foreach ($exercise['targetMuscles'] as $muscle)
                                        <span class="badge bg-primary bg-opacity-10 text-primary">
                                            {{ $muscle }}
                                        </span>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="bg-light p-4 rounded">
                                <h6 class="fw-bold mb-2">Equipment</h6>
                                <p class="text-muted mb-0">{{ $exercise['equipment'] }}</p>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="bg-light p-4 rounded">
                                <h6 class="fw-bold mb-2">Recommended</h6>
                                <p class="text-muted mb-0">
                                    {{ $exercise['defaultSets'] }} sets × {{ $exercise['defaultReps'] }}
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
                                    0:{{ str_pad($exercise['defaultDuration'], 2, '0', STR_PAD_LEFT) }}
                                </div>
                                <div id="timerStatus" class="h5 text-muted">Ready to Start</div>
                                <div id="setCounter" class="text-muted">
                                    Set 1 of {{ $exercise['defaultSets'] }}
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
                                <button id="resetBtn" class="btn btn-outline-secondary" onclick="resetTimer()">
                                    <i class="fas fa-redo me-1"></i> Reset
                                </button>
                            </div>

                            <!-- Timer Settings -->
                            <div class="row g-2">
                                <div class="col-4">
                                    <label class="form-label small">Sets</label>
                                    <input type="number" id="setsInput" class="form-control text-center"
                                        value="{{ $exercise['defaultSets'] }}" min="1" max="10">
                                </div>
                                <div class="col-4">
                                    <label class="form-label small">Work (sec)</label>
                                    <input type="number" id="workInput" class="form-control text-center"
                                        value="{{ $exercise['defaultDuration'] }}" min="10" max="300">
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
                                @foreach ($exercise['instructions'] as $index => $instruction)
                                    <div class="instruction-step mb-3 p-3 rounded cursor-pointer"
                                        data-step="{{ $index }}" onclick="selectStep({{ $index }})">
                                        <div class="d-flex align-items-start">
                                            <div class="step-number rounded-circle d-flex align-items-center justify-content-center me-3">
                                                {{ $index + 1 }}
                                            </div>
                                            <p class="mb-0">{{ $instruction }}</p>
                                        </div>
                                    </div>
                                @endforeach
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
                            <div class="bg-light rounded d-flex align-items-center justify-content-center" style="height: 200px;">
                                <div class="text-center text-muted">
                                    <i class="fas fa-play-circle fa-3x mb-2"></i>
                                    <p class="mb-1">Demo video would be shown here</p>
                                    <small id="stepIndicator">Step 1 of {{ count($exercise['instructions']) }}</small>
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
                                @foreach ($exercise['tips'] as $tip)
                                    <li class="mb-2">
                                        <i class="fas fa-check text-success me-2"></i>
                                        {{ $tip }}
                                    </li>
                                @endforeach
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
                                @foreach ($exercise['variations'] as $variation)
                                    <li class="mb-2">
                                        <i class="fas fa-arrow-right text-info me-2"></i>
                                        {{ $variation }}
                                    </li>
                                @endforeach
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
                                @foreach ($exercise['commonMistakes'] as $mistake)
                                    <li class="mb-2">
                                        <i class="fas fa-times text-danger me-2"></i>
                                        {{ $mistake }}
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Timer + Step JS --}}
    <script src="{{ asset('js/exercise-timer.js') }}"></script>
@endsection
