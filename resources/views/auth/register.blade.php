<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body class="bg-blue-500 min-h-screen flex items-center justify-center p-4">
    <div class="w-full max-w-md">
        <div class="bg-white rounded-2xl shadow-lg p-6 md:p-8">
            <h1 class="text-3xl font-bold text-center mb-6">Register</h1>
            
            @if ($errors->any())
            <div class="bg-blue-100 border border-blue-400 text-blue-700 px-4 py-3 rounded mb-4">
                <ul class="list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif
            
            <form action="{{ route('register.post') }}" method="POST" id="registerForm">
                @csrf
                <input type="hidden" name="role" value="orangtua">
                
                <div class="mb-4">
                    <label for="name" class="block text-gray-700 text-sm font-bold mb-2">Name:</label>
                    <input type="text" class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-rose-400 @error('name') border-blue-500 @enderror" 
                           name="name" id="name" value="{{ old('name') }}" required>
                    @error('name')
                        <p class="text-blue-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="email" class="block text-gray-700 text-sm font-bold mb-2">Email:</label>
                    <input type="email" class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-rose-400 @error('email') border-blue-500 @enderror"
                           name="email" id="email" value="{{ old('email') }}" required>
                    @error('email')
                        <p class="text-blue-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="phone" class="block text-gray-700 text-sm font-bold mb-2">Phone Number:</label>
                    <input type="text" class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-rose-400 @error('phone') border-blue-500 @enderror"
                           name="phone" id="phone" value="{{ old('phone') }}">
                    @error('phone')
                        <p class="text-blue-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="address" class="block text-gray-700 text-sm font-bold mb-2">Address:</label>
                    <textarea class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-rose-400 @error('address') border-blue-500 @enderror"
                              name="address" id="address" rows="2">{{ old('address') }}</textarea>
                    @error('address')
                        <p class="text-blue-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="password" class="block text-gray-700 text-sm font-bold mb-2">Password:</label>
                    <input type="password" class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-rose-400 @error('password') border-blue-500 @enderror"
                           name="password" id="password" required>
                    @error('password')
                        <p class="text-blue-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-6">
                    <label for="password_confirmation" class="block text-gray-700 text-sm font-bold mb-2">Confirm Password:</label>
                    <input type="password" class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-rose-400"
                           name="password_confirmation" id="password_confirmation" required>
                </div>

                <button type="submit" class="w-full bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded-lg transition duration-200">
                    Register
                </button>

                <div class="text-center mt-4 text-sm">
                    Already have an account? 
                    <a href="{{ route('login') }}" class="text-blue-500 hover:text-blue-600 font-semibold">Login here</a>
                </div>
            </form>
        </div>
    </div>

    <script>
        // Check for form submission success
        document.getElementById('registerForm').addEventListener('submit', function(e) {
            // We'll let the form submit normally, but we'll add client-side validation
            // to ensure all required fields are filled
            const name = document.getElementById('name').value;
            const email = document.getElementById('email').value;
            const password = document.getElementById('password').value;
            const passwordConfirmation = document.getElementById('password_confirmation').value;
            
            if (!name || !email || !password || !passwordConfirmation) {
                e.preventDefault();
                Swal.fire({
                    icon: 'error',
                    title: 'Validation Error',
                    text: 'Please fill in all required fields',
                    confirmButtonColor: '#EF4444',
                });
                return;
            }
            
            if (password !== passwordConfirmation) {
                e.preventDefault();
                Swal.fire({
                    icon: 'error',
                    title: 'Password Mismatch',
                    text: 'Password and confirmation do not match',
                    confirmButtonColor: '#EF4444',
                });
                return;
            }
            
            if (password.length < 8) {
                e.preventDefault();
                Swal.fire({
                    icon: 'error',
                    title: 'Password Too Short',
                    text: 'Password must be at least 8 characters long',
                    confirmButtonColor: '#EF4444',
                });
                return;
            }
        });
    </script>
    
    @if (session('success'))
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            Swal.fire({
                icon: 'success',
                title: 'Registration Successful!',
                text: 'Please login to continue',
                confirmButtonColor: '#EF4444',
            }).then((result) => {
                window.location.href = "{{ route('login') }}";
            });
        });
    </script>
    @endif
</body>
</html>