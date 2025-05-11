<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-red-500 min-h-screen flex items-center justify-center p-4">
    <div class="w-full max-w-md">
        <div class="bg-white rounded-2xl shadow-lg p-6 md:p-8">
            <h1 class="text-3xl font-bold text-center mb-6">Register</h1>
            
            @if ($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                <ul class="list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif
            
            <form action="{{ route('register.post') }}" method="POST">
                @csrf
                <input type="hidden" name="role" value="orangtua">
                
                <div class="mb-4">
                    <label for="name" class="block text-gray-700 text-sm font-bold mb-2">Name:</label>
                    <input type="text" class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-rose-400 @error('name') border-red-500 @enderror" 
                           name="name" id="name" value="{{ old('name') }}" required>
                    @error('name')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="email" class="block text-gray-700 text-sm font-bold mb-2">Email:</label>
                    <input type="email" class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-rose-400 @error('email') border-red-500 @enderror"
                           name="email" id="email" value="{{ old('email') }}" required>
                    @error('email')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="phone" class="block text-gray-700 text-sm font-bold mb-2">Phone Number:</label>
                    <input type="text" class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-rose-400 @error('phone') border-red-500 @enderror"
                           name="phone" id="phone" value="{{ old('phone') }}">
                    @error('phone')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="address" class="block text-gray-700 text-sm font-bold mb-2">Address:</label>
                    <textarea class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-rose-400 @error('address') border-red-500 @enderror"
                              name="address" id="address" rows="2">{{ old('address') }}</textarea>
                    @error('address')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-4">
                    <label for="password" class="block text-gray-700 text-sm font-bold mb-2">Password:</label>
                    <input type="password" class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-rose-400 @error('password') border-red-500 @enderror"
                           name="password" id="password" required>
                    @error('password')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-6">
                    <label for="password_confirmation" class="block text-gray-700 text-sm font-bold mb-2">Confirm Password:</label>
                    <input type="password" class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-rose-400"
                           name="password_confirmation" id="password_confirmation" required>
                </div>

                <button type="submit" class="w-full bg-red-500 hover:bg-red-600 text-white font-bold py-2 px-4 rounded-lg transition duration-200">
                    Register
                </button>

                <div class="text-center mt-4 text-sm">
                    Already have an account? 
                    <a href="{{ route('login') }}" class="text-red-500 hover:text-red-600 font-semibold">Login here</a>
                </div>
            </form>
        </div>
    </div>
</body>
</html>