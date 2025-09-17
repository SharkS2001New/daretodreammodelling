@extends('layouts.app')

@section('title', 'Public information')

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
            <div class="d-flex align-items-center gap-4">
                <div>
                    <img src="{{ $publicInfo->profile_picture ? asset('storage/'.$publicInfo->profile_picture) : 'https://via.placeholder.com/150?text=Upload+Photo' }}" 
                         alt="Profile" 
                         width="150" 
                         height="150"
                         class="rounded-circle object-fit-cover border">
                </div>
                <div class="flex-grow-1">
                    <form action="{{ route('account.public.updateProfilePicture') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <input type="file" 
                                   name="profile_picture"
                                   accept="image/*"
                                   class="form-control">
                            <div class="form-text">Max file size: 2MB. Supported formats: JPG, PNG, JPEG</div>
                        </div>
                        <button type="submit" class="btn btn-primary btn-sm">Upload Profile Picture</button>
                    </form>
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
                        <input type="text" name="display_name" value="{{ old('display_name', $publicInfo->display_name) }}" class="form-control @error('display_name') is-invalid @enderror">
                        @error('display_name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Age</label>
                        <input type="number" name="age" value="{{ old('age', $publicInfo->age) }}" class="form-control @error('age') is-invalid @enderror">
                        @error('age') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Gender</label>
                        <select name="gender" class="form-control @error('gender') is-invalid @enderror">
                            <option value="">Select</option>
                            <option value="Male" {{ old('gender', $publicInfo->gender)=='Male' ? 'selected' : '' }}>Male</option>
                            <option value="Female" {{ old('gender', $publicInfo->gender)=='Female' ? 'selected' : '' }}>Female</option>
                            <option value="Other" {{ old('gender', $publicInfo->gender)=='Other' ? 'selected' : '' }}>Other</option>
                        </select>
                        @error('gender') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Ethnicity</label>
                        <select name="ethnicity" class="form-control @error('ethnicity') is-invalid @enderror">
                            <option value="">Select Ethnicity</option>
                            @foreach(['Black/African','White/Caucasian','Hispanic/Latino','Asian','Middle Eastern','Mixed','Other'] as $ethnicity)
                                <option value="{{ $ethnicity }}" {{ old('ethnicity', $publicInfo->ethnicity) == $ethnicity ? 'selected' : '' }}>
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
                                $selectedHair = old('hair', $publicInfo->hair);
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
                            // Match field name with DB column (use 'eye' if that's what your table stores)
                            $selectedEyeColor = old('eyeColor', $publicInfo->eye ?? '');
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
                        <input type="text" name="height" value="{{ old('height', $publicInfo->height) }}" class="form-control @error('height') is-invalid @enderror">
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
                                <option value="{{ $size }}" {{ old('shoes', $publicInfo->shoes) == $size ? 'selected' : '' }}>
                                    {{ $size }}
                                </option>
                            @endforeach
                        </select>
                        @error('shoes') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Waist</label>
                        <input type="text" name="waist" value="{{ old('waist', $publicInfo->waist) }}" class="form-control @error('waist') is-invalid @enderror">
                        @error('waist') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Hips</label>
                        <input type="text" name="hips" value="{{ old('hips', $publicInfo->hips) }}" class="form-control @error('hips') is-invalid @enderror">
                        @error('hips') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Location</label>
                        <input type="text" name="location" value="{{ old('location', $publicInfo->location) }}" class="form-control @error('location') is-invalid @enderror">
                        @error('location') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                   <div class="col-md-6 mb-3">
                        <label class="form-label">Nationality</label>
                        <select name="nationality" class="form-control @error('nationality') is-invalid @enderror">
                            <option value="">Select Country</option>
                            @foreach(\App\Helpers\CountryHelper::getCountries() as $country)
                                <option value="{{ $country }}" {{ old('nationality', $publicInfo->nationality) == $country ? 'selected' : '' }}>
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
                                    : explode(',', $publicInfo->languages ?? '');
                            @endphp

                            @foreach($availableLanguages as $lang)
                                <option value="{{ $lang }}" {{ in_array($lang, $selectedLanguages) ? 'selected' : '' }}>
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
                        <textarea name="about_me" rows="4" class="form-control @error('about_me') is-invalid @enderror">{{ old('about_me', $publicInfo->about_me) }}</textarea>
                        @error('about_me') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                </div>

                <button type="submit" class="btn btn-primary">Save changes</button>
            </div>
        </div>
    </form>
</div>
@endsection

@push('styles')
<style>
.object-fit-cover {
    object-fit: cover;
}
</style>
@endpush
