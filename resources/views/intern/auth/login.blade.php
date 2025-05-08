<x-layout>
    <div class="min-h-screen flex items-center justify-center bg-gradient-to-br from-blue-200 to-purple-200">
        <div class="bg-white p-8 rounded-2xl shadow-lg w-full max-w-md">
            <h2 class="text-3xl font-bold text-center text-blue-600 mb-6">Intern Login</h2>

            <form method="POST" action="{{ route('intern.login.submit') }}" id="intern_login_form">                
                @csrf

                <div class="mb-4">
                    <label for="email" class="block text-sm font-semibold text-gray-700">Email</label>
                    <input type="email" name="email" id="email" required
                        class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-400"
                        value="kachburhan@gmail.com">
                </div>

                <div class="mb-4">
                    <label for="password" class="block text-sm font-semibold text-gray-700">Password</label>
                    <input type="password" name="password" id="password" required
                        class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-400"
                        value="Test@123">
                </div>

                {{-- <div class="flex justify-between items-center mb-4">
                    <label class="flex items-center">
                        <input type="checkbox" name="remember" class="mr-2">
                        <span class="text-sm text-gray-600">Remember me</span>
                    </label>
                </div> --}}

                <button type="submit"
                    class="w-full bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded-lg transition duration-300">
                    Login
                </button>

                <p class="text-sm text-center mt-4 text-gray-600">
                    Don't have an account?
                    <a href="{{ route('intern.register') }}" class="text-purple-600 hover:underline">Register</a>
                </p>
            </form>
        </div>
    </div>
</x-layout>
