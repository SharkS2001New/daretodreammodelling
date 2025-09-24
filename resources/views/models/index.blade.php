@extends('layouts.gallery')

@section('title', 'Models')

@section('content')
<main class="main">   
  <section id="portfolio" class="portfolio section">
    <div class="container">

      <!-- 🔎 Filter Form -->
      <form id="filters-form" method="GET" action="{{ route('models.index') }}" class="filters d-flex flex-wrap gap-2">       
        <!-- Nationality -->
        <div class="filter-dropdown">
          <select name="nationality" id="nationality" class="form-control">
            <option value="">Country</option>
            @foreach(\App\Helpers\CountryHelper::getCountries() as $country)
              <option value="{{ $country }}" {{ request('nationality') == $country ? 'selected' : '' }}>
                {{ $country }}
              </option>
            @endforeach
          </select>
        </div>

        <!-- Gender -->
        <div class="filter-dropdown">
          <select name="gender" class="form-control">
            <option value="">Gender</option>
            <option value="Male" {{ request('gender') == 'Male' ? 'selected' : '' }}>Male</option>
            <option value="Female" {{ request('gender') == 'Female' ? 'selected' : '' }}>Female</option>
            <option value="Other" {{ request('gender') == 'Other' ? 'selected' : '' }}>Other</option>
          </select>
        </div>

        <!-- Age (popup with slider) -->
        <div class="filter-dropdown">
          <select id="age-toggle" class="form-control">
            <option>Age</option>
          </select>
          <div class="filter-popup">
            <label class="form-label small">Please enter the age range.</label>
            <div id="age-slider"></div>
            <input type="hidden" name="age_min" id="age-min" value="{{ request('age_min', 18) }}">
            <input type="hidden" name="age_max" id="age-max" value="{{ request('age_max', 45) }}">
            <div class="mt-2"><span id="age-display"></span></div>
          </div>
        </div>

        <!-- Ethnicity -->
        <div class="filter-dropdown">
          <select name="ethnicity" class="form-control">
            <option value="">Ethnicity</option>
            @foreach(['Black/African','White/Caucasian','Hispanic/Latino','Asian','Middle Eastern','Mixed','Other'] as $eth)
              <option value="{{ $eth }}" {{ request('ethnicity') == $eth ? 'selected' : '' }}>{{ $eth }}</option>
            @endforeach
          </select>
        </div>

        <!-- Eye color -->
        <div class="filter-dropdown">
          <select name="eye" class="form-control">
            <option value="">Eye Color</option>
            @foreach(["Amber","Black","Blue","Brown","Gray","Green","Hazel","Red","Violet"] as $eye)
              <option value="{{ $eye }}" {{ request('eye') == $eye ? 'selected' : '' }}>{{ $eye }}</option>
            @endforeach
          </select>
        </div>

        <!-- Hair color -->
        <div class="filter-dropdown">
          <select name="hair" class="form-control">
            <option value="">Hair</option>
            @foreach(['Bald','Black','Brown','Blonde','Red','Auburn','Grey','White','Curly','Straight','Wavy'] as $hair)
              <option value="{{ $hair }}" {{ request('hair') == $hair ? 'selected' : '' }}>{{ $hair }}</option>
            @endforeach
          </select>
        </div>

        <!-- Shoes -->
        <div class="filter-dropdown">
          <select name="shoes" class="form-control">
            <option value="">Shoe Size</option>
            @foreach([
              '36EU / 3US / 3UK','37EU / 4US / 4UK','38EU / 5US / 5UK','39EU / 6US / 6UK',
              '40EU / 7US / 7UK','41EU / 8US / 8UK','42EU / 9US / 9UK','43EU / 10US / 10UK',
              '44EU / 11US / 11UK','45EU / 12US / 12UK','46EU / 13US / 13UK','47EU / 14US / 14UK',
              '48EU / 15US / 15UK','49EU / 16US / 16UK'
            ] as $size)
              <option value="{{ $size }}" {{ request('shoes') == $size ? 'selected' : '' }}>
                {{ $size }}
              </option>
            @endforeach
          </select>
        </div>

        <!-- Languages -->
        {{-- <div class="filter-dropdown languages-filter" style="min-width: 220px;">
          <select name="languages[]" id="languages" class="form-control languages-select" multiple>
            @foreach([
              "Afrikaans","Albanian","Arabic","Azerbaijani","Bengali","Bulgarian","Chinese","Croatian",
              "Czech","Danish","Dutch","English","Estonian","Filipino","Finnish","French","Georgian",
              "German","Greek","Gujarati","Hausa","Hebrew","Hindi","Hungarian","Icelandic","Indonesian",
              "Italian","Japanese","Kazakh","Korean","Latvian","Lithuanian","Macedonian","Malay",
              "Norwegian","Persian","Polish","Portuguese","Punjabi","Romanian","Russian","Serbian",
              "Slovak","Slovenian","Somali","Spanish","Swahili","Swedish","Tamil","Thai","Turkish",
              "Ukrainian","Urdu","Vietnamese","Zulu","Other"
            ] as $lang)
              <option value="{{ $lang }}" {{ in_array($lang, (array) request('languages')) ? 'selected' : '' }}>
                {{ $lang }}
              </option>
            @endforeach
          </select>
        </div> --}}

        <!-- Submit -->
        <div>
          <button type="submit" class="btn btn-primary">Filter</button>
        </div>
      </form>
      <br/>

      <!-- Gallery -->
      @if($photos->count() > 0)
        <div class="isotope-layout" data-default-filter="*" data-layout="masonry" data-sort="original-order">
          <div class="row gy-4 portfolio-container isotope-container">
            @foreach($photos as $photo)
            <div class="col-md-3 col-6 portfolio-item isotope-item filter-photography">
              <div class="portfolio-wrap position-relative">
                <img src="{{ asset('storage/' . $photo->file_path) }}" 
                    class="img-fluid"  
                    alt="Model Photo" 
                    data-id="{{ $photo->id }}" 
                    loading="lazy">

                  <!-- Like Icon -->
                  <button class="like-btn" data-id="{{ $photo->id }}">
                    @auth
                      @if($photo->likes->where('user_id', auth()->id())->count() > 0)
                        <i class="bi bi-heart-fill"></i>
                      @else
                        <i class="bi bi-heart"></i>
                      @endif
                    @else
                      <i class="bi bi-heart"></i>
                    @endauth
                  </button>

                <!-- Loader Overlay -->
                <div class="loader-overlay">
                  <div class="spinner-border text-light" role="status">
                    <span class="visually-hidden">Loading...</span>
                  </div>
                </div>
              </div>
            </div>
            @endforeach
          </div>
        </div>

        <div class="mt-4">
          {{ $photos->links() }}
        </div>
      @else
        <div class="alert alert-warning text-center mt-4">
          <p><strong>Sorry, no results found</strong></p>
          <p class="mb-0">Try searching most recent to see more models</p>
        </div>
      @endif

    </div>
  </section>
</main>

<!-- Model Details Modal -->
<div class="modal fade" id="modelModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-xl modal-dialog-centered">
    <div class="modal-content rounded-4 shadow">
      <div class="modal-body p-4">
        <div class="d-flex justify-content-between">
          <div class="d-flex align-items-start gap-3">
            <!-- Image -->
            <img id="model-photo" src="" alt="Model Photo" class="img-fluid rounded" style="max-width: 350px;">

            <!-- Info -->
            <div>
              <h4 id="model-name"></h4>
              <p class="text-muted small" id="model-location"></p>
              <p class="fw-bold text-danger small mb-2">⭐ <span id="model-rating">0</span> (0)</p>

              <div class="mb-3">
                <button class="btn btn-outline-secondary btn-sm" id="save-btn">
                  <i class="bi bi-heart"></i> Save
                </button>
                <button class="btn btn-dark btn-sm">
                  <i class="bi bi-envelope"></i> Message
                </button>
              </div>
            </div>
          </div>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>

        <!-- Suggested Models -->
        <div class="mt-4">
          <h5>More models you may like</h5>
          <div id="suggested-models" class="d-flex gap-3 overflow-auto">
            <!-- dynamically filled -->
          </div>
        </div>
      </div>
    </div>
  </div>
</div>


<script>
  document.addEventListener("DOMContentLoaded", function () {
    // When photo is clicked
    document.querySelectorAll('.portfolio-wrap img').forEach(img => {
      img.addEventListener('click', function () {
        const photoId = this.dataset.id;

        // Fetch model details via API
        fetch(`/model/${photoId}/details`)
          .then(res => res.json())
          .then(data => {
            // Fill modal with data
            document.getElementById('model-photo').src = `/storage/${data.photo}`;
            document.getElementById('model-name').textContent = data.name;
            document.getElementById('model-location').textContent = `${data.city}, ${data.country}`;
            document.getElementById('model-rating').textContent = data.rating;

            // Suggested models
            let suggestionsHtml = '';
            data.suggested.forEach(m => {
              suggestionsHtml += `
                <div class="card border-0" style="width: 140px;">
                  <img src="/storage/${m.photo}" class="card-img-top rounded" alt="">
                  <div class="card-body p-2">
                    <p class="small mb-0 fw-bold">${m.name}</p>
                  </div>
                </div>`;
            });
            document.getElementById('suggested-models').innerHTML = suggestionsHtml;

            // Show modal
            new bootstrap.Modal(document.getElementById('modelModal')).show();
          })
          .catch(err => console.error(err));
      });
    });
  });

  document.addEventListener("DOMContentLoaded", function () {
  const form = document.getElementById('filters-form');

  // Remove empty filters before submitting
  form.addEventListener('submit', function (e) {
    const inputs = form.querySelectorAll('select, input');
    inputs.forEach(input => {
      if (!input.value || input.value.length === 0) {
        input.name = ''; // prevent from sending empty field
      }
    });
  });

});

  document.addEventListener("DOMContentLoaded", function() {
  const ageToggle = document.getElementById("age-toggle");
  const ageDropdown = ageToggle.closest(".filter-dropdown");

  ageToggle.addEventListener("click", function(e) {
    e.preventDefault();
    ageDropdown.classList.toggle("open");
  });

  // Example: Age slider (you can replace with noUiSlider if you use it)
  let min = document.getElementById("age-min").value;
  let max = document.getElementById("age-max").value;
  document.getElementById("age-display").textContent = `${min} - ${max} y.o`;
});

document.querySelectorAll('.like-btn').forEach(btn => {
  document.addEventListener("DOMContentLoaded", function () {
    // === Languages (Select2) ===
    $('#languages').select2({
      placeholder: "Select languages",
      allowClear: true,
      width: '100%'
    });

    // === Age Slider ===
    const ageSlider = document.getElementById('age-slider');
    const minInput = document.getElementById('age-min');
    const maxInput = document.getElementById('age-max');
    const display = document.getElementById('age-display');

    noUiSlider.create(ageSlider, {
      start: [minInput.value || 18, maxInput.value || 45],
      connect: true,
      step: 1,
      range: {
        'min': 16,
        'max': 65
      }
    });

    ageSlider.noUiSlider.on('update', function (values) {
      const min = Math.round(values[0]);
      const max = Math.round(values[1]);
      minInput.value = min;
      maxInput.value = max;
      display.textContent = `${min} y.o – ${max} y.o`;
    });
  });
  
  btn.addEventListener('click', function () {
    const icon = this.querySelector('i');
    const photoId = this.dataset.id;
    const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    const isLiked = icon.classList.contains('bi-heart-fill');
    const url = `/model/${photoId}/like`;

    const wrap = this.closest('.portfolio-wrap');
    const loader = wrap.querySelector('.loader-overlay');
    loader.style.display = 'flex'; // show loader

    fetch(url, {
      method: isLiked ? 'DELETE' : 'POST',
      headers: {
        'Content-Type': 'application/json',
        'X-CSRF-TOKEN': token
      },
      body: JSON.stringify({})
    })
      .then(res => {
        if (res.status === 401) {
          // 🔴 Not logged in
          alert("You must login to continue.");
          throw new Error("Unauthorized");
        }
        return res.json();
      })
      .then(data => {
        if (data.liked) {
          icon.classList.replace('bi-heart', 'bi-heart-fill');
        } else {
          icon.classList.replace('bi-heart-fill', 'bi-heart');
        }
      })
      .catch(err => {
        if (err.message !== "Unauthorized") {
          console.error('Error:', err);
        }
      })
      .finally(() => loader.style.display = 'none');
  });
});
</script>
@endsection
