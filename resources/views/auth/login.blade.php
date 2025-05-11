<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-red-500">
    <div class="min-h-screen flex items-center justify-center px-4 sm:px-6 lg:px-8">
        <div class="bg-white p-6 sm:p-8 rounded-lg shadow-lg w-full max-w-md mx-auto">
            <h2 class="text-2xl sm:text-3xl font-bold text-center text-red-500 mb-6 sm:mb-8">Login</h2>
            <form action="{{ route('login.post') }}" method="POST">
                @csrf
                <div class="mb-4 sm:mb-6">
                    <label for="email" class="block text-gray-700 text-sm font-bold mb-2">Email</label>
                    <input type="email" 
                           name="email" 
                           id="email" 
                           required 
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-transparent"
                           placeholder="Enter your email"
                    >
                </div>
                <div class="mb-4 sm:mb-6">
                    <label for="password" class="block text-gray-700 text-sm font-bold mb-2">Password</label>
                    <input type="password" 
                           name="password" 
                           id="password" 
                           required 
                           class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-transparent"
                           placeholder="Enter your password"
                    >
                </div>
                <button type="submit" 
                        class="w-full bg-red-500 text-white py-2 px-4 rounded-md hover:bg-red-600 transition duration-300 ease-in-out text-sm sm:text-base"
                >
                    Login
                </button>
                <div class="mt-4 text-center">
                    <p class="text-sm text-gray-600">
                        Don't have an account? 
                        <a href="{{ route('register') }}" class="text-red-500 hover:text-red-600 font-semibold">
                            Register here
                        </a>
                    </p>
                </div>
            </form>
        </div>
    </div>
</body>
</html>