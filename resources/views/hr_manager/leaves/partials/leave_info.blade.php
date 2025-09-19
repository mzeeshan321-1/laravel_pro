<div class="row">
    <div class="col-lg-12">
        <div class="card position-relative rounded-4 border-0">
            <div class="card-body">
                <h5 class="card-title">Leave Summary</h5>

                <div class="position-relative">
                    <div id="leaveCarousel" class="carousel slide" data-bs-ride="carousel">

                        <!-- Carousel Inner -->
                        <div class="carousel-inner">
                            @if ($leaveTypes->isNotEmpty())
                                @foreach ($leaveTypes->chunk(3) as $index => $chunk)
                                    <div class="carousel-item {{ $index == 0 ? 'active' : '' }}">
                                        <div class="row justify-content-center">
                                            @foreach ($chunk as $leaveType)
                                                <div class="col-md-4">
                                                    <div class="card p-3 shadow-sm border-0 rounded-3">
                                                        <div class="card-body">
                                                            <h6 class="card-title text-center text-dark fw-bold">
                                                                {{ $leaveType->name ?? '' }}</h6>
                                                            <p class="text-dark m-1"><strong>Total:</strong>
                                                                {{ $leaveType->max_days ?? '' }}</p>
                                                            <p class="text-danger m-1"><strong>Used:</strong>
                                                                {{ optional($leaveType->leaveBalances->first())->used_days ?? 0 }}<sub><i
                                                                        class="bi bi-dash text-danger"></i></sub></p>
                                                            <p class="text-success m-1"><strong>Remaining:</strong>
                                                                {{ optional($leaveType->leaveBalances->first())->remaining_days ?? 0 }}<sub><i
                                                                        class="ri-add-fill text-success"></i></sub></p>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                @endforeach
                            @endif
                        </div>

                        <!-- Carousel Indicators -->
                        <div class="carousel-indicators position-absolute start-50 translate-middle-x"
                            style="bottom: -25px;">
                            @foreach ($leaveTypes->chunk(3) as $index => $chunk)
                                <button type="button" data-bs-target="#leaveCarousel"
                                    data-bs-slide-to="{{ $index }}" class="{{ $index == 0 ? 'active' : '' }}"
                                    aria-label="Slide {{ $index + 1 }}"
                                    style="background-color: rgba(0, 0, 0, 0.5); width: 10px; height: 10px; border-radius: 50%; border: none;">
                                </button>
                            @endforeach
                        </div>
                    </div>

                    <!-- Carousel Controls -->
                    <button class="carousel-control-prev position-absolute" type="button"
                        data-bs-target="#leaveCarousel" data-bs-slide="prev"
                        style="top: 50%; transform: translateY(-50%); left: -40px; z-index: 10;">
                        <span class="carousel-control-prev-icon bg-dark rounded-circle p-2"></span>
                        <span class="visually-hidden">Previous</span>
                    </button>

                    <button class="carousel-control-next position-absolute" type="button"
                        data-bs-target="#leaveCarousel" data-bs-slide="next"
                        style="top: 50%; transform: translateY(-50%); right: -40px; z-index: 10;">
                        <span class="carousel-control-next-icon bg-dark rounded-circle p-2"></span>
                        <span class="visually-hidden">Next</span>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
