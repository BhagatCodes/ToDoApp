@auth
@php
$userName = Auth::user()->name;
@endphp
@endauth

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ $userName }} profile</title>
    @vite(['resources/js/app.js', 'resources/css/app.css'])
</head>
<body>
    <main class="!ml-0">
        <div class="flex items-center justify-between">
            <a href="/" class="bg-primary text-md flex gap-1 items-center text-white py-1 px-3 w-fit mb-3 rounded-sm">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" viewBox="0 0 256 256"><path d="M165.66,202.34a8,8,0,0,1-11.32,11.32l-80-80a8,8,0,0,1,0-11.32l80-80a8,8,0,0,1,11.32,11.32L91.31,128Z"></path></svg>
                Go to Home
            </a>
            <form action="{{ route('user.logout') }}" method="post">
                @csrf
                <button type="submit" class="bg-primary text-md flex gap-1 items-center text-white py-1 px-3 w-fit mb-3 rounded-sm">
                    Log Out
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" viewBox="0 0 256 256"><path d="M230.92,212c-15.23-26.33-38.7-45.21-66.09-54.16a72,72,0,1,0-73.66,0C63.78,166.78,40.31,185.66,25.08,212a8,8,0,1,0,13.85,8c18.84-32.56,52.14-52,89.07-52s70.23,19.44,89.07,52a8,8,0,1,0,13.85-8ZM72,96a56,56,0,1,1,56,56A56.06,56.06,0,0,1,72,96Z"></path></svg>
                </button>
            </form>
        </div>
        <p class="text-secondary text-2xl font-semibold mt-1 text-center">Profile Details</p>
        <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data" class="mt-6 mx-auto max-w-xl bg-white shadow-sm rounded-lg p-6">
            @csrf
            @method('PATCH')

            <div class="flex items-center gap-6">
                <div class="w-24 h-24 rounded-full overflow-hidden bg-gray-100 flex items-center justify-center">
                <img id="avatarPreview" src="{{ Auth::user()->profile ?? '../images/dummyProfile.jpg' }}" alt="avatar" class="w-full h-full object-cover">
                </div>
                <div>
                    <h2 class="text-lg font-semibold">{{ $userName }}</h2>
                    <p class="text-sm text-secondary">Update your password or upload a new profile image.</p>
                </div>
            </div>

            <div class="mt-6 space-y-4">
                <div>
                    <label class="block text-sm font-medium text-secondary">New Password</label>
                    <input type="password" name="password" class="mt-1 block w-full border rounded px-3 py-2" placeholder="Enter new password">
                </div>

                <div>
                    <label class="block text-sm font-medium text-secondary">Confirm Password</label>
                    <input type="password" name="password_confirmation" class="mt-1 block w-full border rounded px-3 py-2" placeholder="Confirm new password">
                </div>

                <div>
                    <label class="block text-sm font-medium text-secondary mb-2">Profile Image</label>
                    <div class="flex items-center gap-3">
                        <label for="profile_image" class="inline-flex items-center px-4 py-2 bg-white border border-dashed rounded-md cursor-pointer hover:bg-gray-50">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-primary mr-2" viewBox="0 0 20 20" fill="currentColor"><path d="M4 3a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V5a2 2 0 00-2-2H4z"/></svg>
                            <span class="text-sm">Upload image</span>
                        </label>
                        <input id="profile_image" type="file" name="profile_image" accept="image/*" class="hidden" onchange="previewAvatar(event)">
                        <span id="fileName" class="text-sm text-secondary">No file chosen</span>
                    </div>
                </div>

                <div class="pt-2 flex gap-3">
                    <button type="submit" class="bg-primary text-white py-2 px-4 rounded">Save Changes</button>
                    <a href="/" class="border border-gray-200 py-2 px-4 rounded text-sm">Cancel</a>
                </div>
            </div>
        </form>

        <script>
            function previewAvatar(e) {
                const file = e.target.files[0];
                const preview = document.getElementById('avatarPreview');
                const name = document.getElementById('fileName');
                if (!file) return;
                preview.src = URL.createObjectURL(file);
                name.textContent = file.name;
            }
        </script>
    </main>
</body>
</html>