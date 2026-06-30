@extends('layouts.gallery')

@section('content')
<main class="main">
    <section id="portfolio" class="portfolio section pb-5">
        <div class="container">
            <x-page-heading class="mb-4" />

            <div class="models-filter-panel mb-4">
                <div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mb-3">
                    <div>
                        <p class="models-section__eyebrow text-uppercase fw-semibold mb-1">Find talent</p>
                        <h2 class="h5 fw-bold mb-0">Filter models</h2>
                    </div>
                    @if(request()->hasAny(['nationality', 'gender', 'ethnicity', 'eye', 'hair', 'shoes']) || (request()->filled('age_min') && request('age_min') != 18) || (request()->filled('age_max') && request('age_max') != 45))
                        <a href="{{ route('models.index') }}" class="btn btn-sm btn-outline-secondary">Clear filters</a>
                    @endif
                </div>

                <form id="filters-form" method="GET" action="{{ route('models.index') }}" class="models-filters d-flex flex-wrap gap-2">
                    <div class="filter-dropdown">
                        <select name="nationality" id="nationality" class="form-select models-filter-select">
                            <option value="">Country</option>
                            @foreach(\App\Helpers\CountryHelper::getCountries() as $country)
                                <option value="{{ $country }}" {{ request('nationality') == $country ? 'selected' : '' }}>{{ $country }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="filter-dropdown">
                        <select name="gender" class="form-select models-filter-select">
                            <option value="">Gender</option>
                            <option value="Male" {{ request('gender') == 'Male' ? 'selected' : '' }}>Male</option>
                            <option value="Female" {{ request('gender') == 'Female' ? 'selected' : '' }}>Female</option>
                            <option value="Other" {{ request('gender') == 'Other' ? 'selected' : '' }}>Other</option>
                        </select>
                    </div>

                    <div class="filter-dropdown" id="age-filter">
                        <button type="button" class="form-control age-filter-toggle" id="age-toggle" aria-expanded="false" aria-controls="age-popup">
                            <span id="age-toggle-label">Age</span>
                        </button>
                        <div class="filter-popup" id="age-popup">
                            <label class="form-label small mb-2">Enter age range</label>
                            <div class="row g-2 align-items-center mb-3">
                                <div class="col-5">
                                    <label for="age-min-input" class="form-label small mb-1">Min</label>
                                    <input type="number" class="form-control form-control-sm" id="age-min-input" min="16" max="65" value="{{ request('age_min', 18) }}">
                                </div>
                                <div class="col-2 text-center pt-4">–</div>
                                <div class="col-5">
                                    <label for="age-max-input" class="form-label small mb-1">Max</label>
                                    <input type="number" class="form-control form-control-sm" id="age-max-input" min="16" max="65" value="{{ request('age_max', 45) }}">
                                </div>
                            </div>
                            <div id="age-slider" class="mb-2"></div>
                            <input type="hidden" name="age_min" id="age-min" value="{{ request('age_min', 18) }}">
                            <input type="hidden" name="age_max" id="age-max" value="{{ request('age_max', 45) }}">
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="small text-muted" id="age-display"></span>
                                <button type="button" class="btn btn-sm btn-primary" id="age-apply">Apply</button>
                            </div>
                        </div>
                    </div>

                    <div class="filter-dropdown">
                        <select name="ethnicity" class="form-select models-filter-select">
                            <option value="">Ethnicity</option>
                            @foreach(['Black/African','White/Caucasian','Hispanic/Latino','Asian','Middle Eastern','Mixed','Other'] as $eth)
                                <option value="{{ $eth }}" {{ request('ethnicity') == $eth ? 'selected' : '' }}>{{ $eth }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="filter-dropdown">
                        <select name="eye" class="form-select models-filter-select">
                            <option value="">Eye color</option>
                            @foreach(["Amber","Black","Blue","Brown","Gray","Green","Hazel","Red","Violet"] as $eye)
                                <option value="{{ $eye }}" {{ request('eye') == $eye ? 'selected' : '' }}>{{ $eye }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="filter-dropdown">
                        <select name="hair" class="form-select models-filter-select">
                            <option value="">Hair</option>
                            @foreach(['Bald','Black','Brown','Blonde','Red','Auburn','Grey','White','Curly','Straight','Wavy'] as $hair)
                                <option value="{{ $hair }}" {{ request('hair') == $hair ? 'selected' : '' }}>{{ $hair }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="filter-dropdown">
                        <select name="shoes" class="form-select models-filter-select">
                            <option value="">Shoe size</option>
                            @foreach([
                                '36EU / 3US / 3UK','37EU / 4US / 4UK','38EU / 5US / 5UK','39EU / 6US / 6UK',
                                '40EU / 7US / 7UK','41EU / 8US / 8UK','42EU / 9US / 9UK','43EU / 10US / 10UK',
                                '44EU / 11US / 11UK','45EU / 12US / 12UK','46EU / 13US / 13UK','47EU / 14US / 14UK',
                                '48EU / 15US / 15UK','49EU / 16US / 16UK'
                            ] as $size)
                                <option value="{{ $size }}" {{ request('shoes') == $size ? 'selected' : '' }}>{{ $size }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <button type="submit" class="btn btn-primary">Apply filters</button>
                    </div>
                </form>
            </div>

            @if($photos->count() > 0)
                <p class="models-results-meta text-muted mb-3">
                    Showing {{ $photos->firstItem() }}–{{ $photos->lastItem() }} of {{ $photos->total() }} models
                </p>

                <div class="row g-4">
                    @foreach($photos as $photo)
                        <div class="col-lg-3 col-md-4 col-6">
                            <x-model-card :photo="$photo" />
                        </div>
                    @endforeach
                </div>

                <div class="mt-4">
                    {{ $photos->links() }}
                </div>
            @else
                <div class="models-empty-state text-center py-5">
                    <i class="bi bi-search fs-1 text-muted mb-3 d-block"></i>
                    <h3 class="h5 fw-bold mb-2">No models found</h3>
                    <p class="text-muted mb-3">Try adjusting your filters or browse all models.</p>
                    <a href="{{ route('models.index') }}" class="btn btn-outline-secondary rounded-pill">View all models</a>
                </div>
            @endif
        </div>
    </section>
</main>

<script>
document.addEventListener("DOMContentLoaded", function () {
  const ageFilter = document.getElementById('age-filter');
  const ageToggle = document.getElementById('age-toggle');
  const agePopup = document.getElementById('age-popup');
  const ageSlider = document.getElementById('age-slider');
  const minInput = document.getElementById('age-min');
  const maxInput = document.getElementById('age-max');
  const minNumberInput = document.getElementById('age-min-input');
  const maxNumberInput = document.getElementById('age-max-input');
  const display = document.getElementById('age-display');
  const toggleLabel = document.getElementById('age-toggle-label');
  const ageApply = document.getElementById('age-apply');

  function clampAge(value, fallback) {
    const num = parseInt(value, 10);
    if (Number.isNaN(num)) return fallback;
    return Math.min(65, Math.max(16, num));
  }

  function syncAgeValues(min, max, updateLabel) {
    const safeMin = Math.min(min, max);
    const safeMax = Math.max(min, max);
    minInput.value = safeMin;
    maxInput.value = safeMax;
    minNumberInput.value = safeMin;
    maxNumberInput.value = safeMax;
    if (ageSlider && ageSlider.noUiSlider) {
      ageSlider.noUiSlider.set([safeMin, safeMax]);
    }
    display.textContent = `${safeMin} y.o – ${safeMax} y.o`;
    if (updateLabel) {
      const isDefault = safeMin === 18 && safeMax === 45;
      toggleLabel.textContent = isDefault ? 'Age' : `${safeMin} – ${safeMax}`;
      ageToggle.classList.toggle('is-active', !isDefault);
    }
  }

  function updateAgeFromNumbers(updateLabel) {
    const min = clampAge(minNumberInput.value, 18);
    const max = clampAge(maxNumberInput.value, 45);
    syncAgeValues(min, max, updateLabel !== false);
  }

  if (ageFilter && ageToggle && agePopup) {
    ageToggle.addEventListener('click', function (event) {
      event.preventDefault();
      event.stopPropagation();
      const isOpen = ageFilter.classList.toggle('open');
      ageToggle.setAttribute('aria-expanded', isOpen ? 'true' : 'false');
    });

    document.addEventListener('click', function (event) {
      if (!ageFilter.contains(event.target)) {
        ageFilter.classList.remove('open');
        ageToggle.setAttribute('aria-expanded', 'false');
      }
    });

    agePopup.addEventListener('click', function (event) {
      event.stopPropagation();
    });
  }

  if (ageSlider && typeof noUiSlider !== 'undefined') {
    noUiSlider.create(ageSlider, {
      start: [clampAge(minInput.value, 18), clampAge(maxInput.value, 45)],
      connect: true,
      step: 1,
      range: { min: 16, max: 65 }
    });

    ageSlider.noUiSlider.on('update', function (values) {
      const min = Math.round(values[0]);
      const max = Math.round(values[1]);
      minInput.value = min;
      maxInput.value = max;
      minNumberInput.value = min;
      maxNumberInput.value = max;
      display.textContent = `${min} y.o – ${max} y.o`;
    });
  }

  if (minNumberInput && maxNumberInput) {
    ['change', 'input'].forEach(function (eventName) {
      minNumberInput.addEventListener(eventName, function () { updateAgeFromNumbers(false); });
      maxNumberInput.addEventListener(eventName, function () { updateAgeFromNumbers(false); });
    });
  }

  if (ageApply) {
    ageApply.addEventListener('click', function () {
      updateAgeFromNumbers(true);
      ageFilter.classList.remove('open');
      ageToggle.setAttribute('aria-expanded', 'false');
    });
  }

  const hasCustomAge = {{ (request()->filled('age_min') && request()->filled('age_max') && !(request('age_min') == 18 && request('age_max') == 45)) ? 'true' : 'false' }};
  syncAgeValues(clampAge(minInput.value, 18), clampAge(maxInput.value, 45), hasCustomAge);
});
</script>
@endsection
