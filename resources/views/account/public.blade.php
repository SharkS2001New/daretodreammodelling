@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="mb-4">
        <h2 class="fw-semibold h4 text-dark">Public information</h2>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Profile Picture Upload Form -->
    <div class="card mb-4">
        <div class="card-body">
            <h5 class="card-title">Profile Picture</h5>

            <form id="profileForm" action="{{ route('account.public.updateProfilePicture') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="d-flex align-items-center gap-4">
                <div>
                <img id="preview" 
                    src="{{ $publicInfo?->profile_picture ? asset('storage/'.$publicInfo->profile_picture) : 'https://via.placeholder.com/150?text=Upload+Photo' }}"
                    width="150" height="150" class="rounded-circle border object-fit-cover">
                </div>

                <div class="flex-grow-1">
                <div class="mb-3">
                    <input type="file" id="profileInput" name="profile_picture" accept="image/*" class="form-control" />
                    <div class="form-text">Max file size: 2MB. Supported: JPG, PNG, JPEG</div>
                </div>

                <button type="submit" id="submitBtn" class="btn btn-primary btn-sm">Upload Profile Picture</button>
                </div>
            </div>
            </form>
        </div>
        </div>

        <!-- Cropper Modal (Bootstrap 5) -->
        <div class="modal fade" id="cropperModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Crop your profile photo</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center">
                <img id="cropperImage" style="max-width:100%; display:block; margin:0 auto;" />
            </div>
            <div class="modal-footer">
                <button type="button" id="cropCancel" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" id="cropSave" class="btn btn-primary">Crop & Use</button>
            </div>
            </div>
        </div>
        </div>

    <!-- Info Form -->
    <form action="{{ route('account.public.update') }}" method="POST">
        @csrf
        <div class="card">
            <div class="card-body">
                <h5 class="card-title mb-4">Personal Information</h5>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Display name</label>
                        <input type="text" name="display_name" value="{{ old('display_name', $publicInfo?->display_name ?? '') }}" class="form-control @error('display_name') is-invalid @enderror">
                        @error('display_name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Age</label>
                        <input type="number" name="age" value="{{ old('age', $publicInfo?->age ?? '') }}" class="form-control @error('age') is-invalid @enderror">
                        @error('age') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Gender</label>
                        <select name="gender" class="form-control @error('gender') is-invalid @enderror">
                            <option value="">Select</option>
                            <option value="Male" {{ old('gender', $publicInfo?->gender ?? '')=='Male' ? 'selected' : '' }}>Male</option>
                            <option value="Female" {{ old('gender', $publicInfo?->gender ?? '')=='Female' ? 'selected' : '' }}>Female</option>
                            <option value="Other" {{ old('gender', $publicInfo?->gender ?? '')=='Other' ? 'selected' : '' }}>Other</option>
                        </select>
                        @error('gender') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Ethnicity</label>
                        <select name="ethnicity" class="form-control @error('ethnicity') is-invalid @enderror">
                            <option value="">Select Ethnicity</option>
                            @foreach(['Black/African','White/Caucasian','Hispanic/Latino','Asian','Middle Eastern','Mixed','Other'] as $ethnicity)
                                <option value="{{ $ethnicity }}" {{ old('ethnicity', $publicInfo?->ethnicity ?? '') == $ethnicity ? 'selected' : '' }}>
                                    {{ $ethnicity }}
                                </option>
                            @endforeach
                        </select>
                        @error('ethnicity') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Hair</label>
                        <select name="hair" class="form-control @error('hair') is-invalid @enderror">
                            <option value="">Select hair type</option>
                            @php
                                $hairOptions = [
                                    'Bald', 'Black', 'Brown', 'Blonde', 'Red', 'Auburn', 'Grey', 'White',
                                    'Dyed / Colored', 'Highlighted', 'Curly', 'Straight', 'Wavy', 'Other'
                                ];
                                $selectedHair = old('hair', $publicInfo?->hair ?? '');
                            @endphp

                            @foreach($hairOptions as $option)
                                <option value="{{ $option }}" {{ $selectedHair == $option ? 'selected' : '' }}>
                                    {{ $option }}
                                </option>
                            @endforeach
                        </select>
                        @error('hair') 
                            <div class="invalid-feedback">{{ $message }}</div> 
                        @enderror
                    </div>
                    <div class="col-md-6 form-group mb-3">
                        <label for="eyeColor">Eye Color</label>
                        @php
                            $availableEyeColors = [
                                "Amber", "Black", "Blue", "Brown", "Gray", "Green",
                                "Hazel", "Red", "Violet", "Heterochromia", "Other"
                            ];
                            $selectedEyeColor = old('eye', $publicInfo?->eye ?? '');
                        @endphp

                        <select name="eye" id="eye"
                                class="form-control @error('eye') is-invalid @enderror">
                            <option value="">Select Eye Color</option>
                            @foreach($availableEyeColors as $eyes)
                                <option value="{{ $eyes }}" {{ $selectedEyeColor == $eyes ? 'selected' : '' }}>
                                    {{ $eyes }}
                                </option>
                            @endforeach
                        </select>

                        @error('eye')
                            <span class="invalid-feedback d-block">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Height</label>
                        <input type="text" name="height" value="{{ old('height', $publicInfo?->height ?? '') }}" class="form-control @error('height') is-invalid @enderror">
                        @error('height') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Shoe Size</label>
                        <select name="shoes" class="form-control @error('shoes') is-invalid @enderror">
                            <option value="">Select Size</option>
                            @php
                                $sizes = [
                                    '36EU / 3US / 3UK',
                                    '37EU / 4US / 4UK',
                                    '38EU / 5US / 5UK',
                                    '39EU / 6US / 6UK',
                                    '40EU / 7US / 7UK',
                                    '41EU / 8US / 8UK',
                                    '42EU / 9US / 9UK',
                                    '43EU / 10US / 10UK',
                                    '44EU / 11US / 11UK',
                                    '45EU / 12US / 12UK',
                                    '46EU / 13US / 13UK',
                                    '47EU / 14US / 14UK',
                                    '48EU / 15US / 15UK',
                                    '49EU / 16US / 16UK',
                                ];
                            @endphp
                            @foreach($sizes as $size)
                                <option value="{{ $size }}" {{ old('shoes', $publicInfo?->shoes ?? '') == $size ? 'selected' : '' }}>
                                    {{ $size }}
                                </option>
                            @endforeach
                        </select>
                        @error('shoes') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Waist</label>
                        <input type="text" name="waist" value="{{ old('waist', $publicInfo?->waist ?? '') }}" class="form-control @error('waist') is-invalid @enderror">
                        @error('waist') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Hips</label>
                        <input type="text" name="hips" value="{{ old('hips', $publicInfo?->hips ?? '') }}" class="form-control @error('hips') is-invalid @enderror">
                        @error('hips') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Location</label>
                        <input type="text" name="location" value="{{ old('location', $publicInfo?->location ?? '') }}" class="form-control @error('location') is-invalid @enderror">
                        @error('location') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                   <div class="col-md-6 mb-3">
                        <label class="form-label">Nationality</label>
                        <select name="nationality" class="form-control @error('nationality') is-invalid @enderror">
                            <option value="">Select Country</option>
                            @foreach(\App\Helpers\CountryHelper::getCountries() as $country)
                                <option value="{{ $country }}" {{ old('nationality', $publicInfo?->nationality ?? '') == $country ? 'selected' : '' }}>
                                    {{ $country }}
                                </option>
                            @endforeach
                        </select>
                        @error('nationality') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="form-group mb-3">
                        <label for="languages">Languages</label>
                        <select name="languages[]" id="languages"
                                class="form-control @error('languages') is-invalid @enderror"
                                multiple>
                            @php
                                $availableLanguages = [
                                    "Afrikaans","Albanian","Arabic","Azerbaijani","Bengali","Bulgarian","Chinese","Croatian",
                                    "Czech","Danish","Dutch","English","Estonian","Filipino","Finnish","French","Georgian",
                                    "German","Greek","Gujarati","Hausa","Hebrew","Hindi","Hungarian","Icelandic","Indonesian",
                                    "Italian","Japanese","Kazakh","Korean","Latvian","Lithuanian","Macedonian","Malay",
                                    "Norwegian","Persian","Polish","Portuguese","Punjabi","Romanian","Russian","Serbian",
                                    "Slovak","Slovenian","Somali","Spanish","Swahili","Swedish","Tamil","Thai","Turkish",
                                    "Ukrainian","Urdu","Vietnamese","Zulu","Other"
                                ];
                                $selectedLanguages = is_array(old('languages'))
                                    ? old('languages')
                                    : explode(',', $publicInfo?->languages ?? '');
                            @endphp

                            @foreach($availableLanguages as $lang)
                                <option value="{{ $lang }}" {{ in_array($lang, $selectedLanguages ?? []) ? 'selected' : '' }}>
                                    {{ $lang }}
                                </option>
                            @endforeach
                        </select>
                        @error('languages')
                            <span class="invalid-feedback d-block">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="col-12 mb-3">
                        <label class="form-label">About me</label>
                        <textarea name="about_me" rows="4" class="form-control @error('about_me') is-invalid @enderror">{{ old('about_me', $publicInfo?->about_me ?? '') }}</textarea>
                        @error('about_me') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                </div>

                <button type="submit" class="btn btn-primary">Save changes</button>
            </div>
        </div>
    </form>
</div>
<script>
document.addEventListener('DOMContentLoaded', function () {
  const profileInput = document.getElementById('profileInput');
  const preview = document.getElementById('preview');
  const form = document.getElementById('profileForm');
  const cropperModalEl = document.getElementById('cropperModal');
  const cropperModal = new bootstrap.Modal(cropperModalEl, {});
  const cropperImage = document.getElementById('cropperImage');
  const cropSave = document.getElementById('cropSave');
  const submitBtn = document.getElementById('submitBtn');
  let cropper = null;
  let lastFileName = 'profile.jpg';

  // When user selects file -> open cropper
  profileInput.addEventListener('change', function (e) {
    const file = e.target.files && e.target.files[0];
    if (!file) return;
    lastFileName = file.name || 'profile.jpg';

    // Quick client-side validation
    const validTypes = ['image/jpeg','image/png','image/jpg'];
    if (!validTypes.includes(file.type)) {
      alert('Please select a JPG or PNG image.');
      profileInput.value = '';
      return;
    }

    const reader = new FileReader();
    reader.onload = function (ev) {
      cropperImage.src = ev.target.result;
      // destroy old cropper
      if (cropper) {
        cropper.destroy();
        cropper = null;
      }

      // show modal then init cropper when image is loaded
      cropperModal.show();

      cropperImage.onload = function () {
        cropper = new Cropper(cropperImage, {
          aspectRatio: 1,
          viewMode: 1,
          background: false,
          movable: true,
          zoomable: true,
          scalable: false,
          cropBoxResizable: true,
        });
      };
    };
    reader.readAsDataURL(file);
  });

  // When user clicks "Crop & Use"
  cropSave.addEventListener('click', function () {
    if (!cropper) {
      alert('Cropper not ready');
      return;
    }

    cropper.getCroppedCanvas({
      width: 400,
      height: 400,
      imageSmoothingQuality: 'high'
    }).toBlob(function (blob) {
      if (!blob) {
        alert('Crop failed, try again.');
        return;
      }

      // Create File from Blob
      const file = new File([blob], lastFileName, { type: 'image/jpeg' });

      // If DataTransfer supported, replace input.files (best route so PHP $_FILES is populated)
      if (window.DataTransfer) {
        try {
          const dt = new DataTransfer();
          dt.items.add(file);
          profileInput.files = dt.files;

          // Update preview to the cropped image
          preview.src = URL.createObjectURL(blob);

          // Close modal and let user submit (or auto-submit)
          cropperModal.hide();

          console.log('Cropped file placed into input.files:', profileInput.files);
          // Auto-submit or leave user to click upload button:
          // form.submit(); // <-- uncomment to auto-submit
        } catch (err) {
          console.error('DataTransfer assignment failed, will fallback to AJAX upload', err);
          ajaxUploadFallback(file);
        }
      } else {
        // No DataTransfer -> send via AJAX as FormData (fallback)
        ajaxUploadFallback(file);
      }
    }, 'image/jpeg', 0.9);
  });

  // Optional: fallback via AJAX (still hits same controller URL)
  function ajaxUploadFallback(file) {
    const fd = new FormData();
    fd.append('_token', '{{ csrf_token() }}');
    fd.append('profile_picture', file, lastFileName);

    // Show nice feedback
    submitBtn.disabled = true;
    submitBtn.innerText = 'Uploading...';

    fetch(form.action, {
      method: 'POST',
      body: fd,
      credentials: 'same-origin'
    }).then(res => res.json ? res.json().then(j=>j) : res.text())
      .then(response => {
        console.log('AJAX upload response', response);
        // If your controller returns redirect or JSON, adapt here.
        // We'll just reload to show change (safe)
        window.location.reload();
      })
      .catch(err => {
        console.error('AJAX upload error', err);
        alert('Upload failed, check console.');
      })
      .finally(() => {
        submitBtn.disabled = false;
        submitBtn.innerText = 'Upload Profile Picture';
      });
  }

  // Debug helper: before form submit, log if file present
  form.addEventListener('submit', function (e) {
    // if input.files empty -> block (so user doesn't accidentally submit empty)
    if (!profileInput.files || profileInput.files.length === 0) {
      e.preventDefault();
      alert('Please select and crop an image before uploading.');
      return;
    }

    console.log('Submitting. Input files:', profileInput.files);
    // allow submit to proceed normally; Laravel will get the file in $_FILES
  });

});
</script>
@endsection

@push('styles')
<style>
.object-fit-cover {
    object-fit: cover;
}
</style>
@endpush
