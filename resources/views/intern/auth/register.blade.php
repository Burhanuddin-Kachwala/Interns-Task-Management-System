<x-layout>
    <div class="min-h-screen flex items-center justify-center bg-gradient-to-br from-green-200 to-blue-200">
        <div class="bg-white p-8 rounded-2xl shadow-lg w-full max-w-md">
            <h2 class="text-3xl font-bold text-center text-green-600 mb-6">Intern Register</h2>

            <form method="POST" action="{{ route('intern.register.submit') }}" id="intern_register_form">
                @csrf

                <div class="mb-4">
                    <label for="name" class="block text-sm font-semibold text-gray-700">Name</label>
                    <input type="text" name="name" id="name" required
                        class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-green-400">
                </div>

                <div class="mb-4">
                    <label for="email" class="block text-sm font-semibold text-gray-700">Email</label>
                    <input type="email" name="email" id="email" required
                        class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-green-400">
                </div>

                <div class="mb-4">
                    <label for="password" class="block text-sm font-semibold text-gray-700">Password</label>
                    <input type="password" name="password" id="password" required id="password"
                        class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-green-400">
                </div>

                <div class="mb-4">
                    <label for="password_confirmation" class="block text-sm font-semibold text-gray-700">Confirm Password</label>
                    <input type="password" name="password_confirmation" id="password_confirmation" required
                        class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-green-400">
                </div>

                <button type="submit"
                    class="w-full bg-green-500 hover:bg-green-600 text-white font-bold py-2 px-4 rounded-lg transition duration-300">
                    Register
                </button>

                <p class="text-sm text-center mt-4 text-gray-600">
                    Already have an account?
                    <a href="{{ route('intern.login') }}" class="text-blue-600 hover:underline">Login</a>
                </p>
            </form>
        </div>
    </div>
</x-layout>
