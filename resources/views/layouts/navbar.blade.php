<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Library Management</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 text-gray-800">
    <!-- Navbar -->
    <nav class="bg-blue-600 text-white p-4">
        <div class="container mx-auto flex justify-between items-center">
            <!-- Brand Logo -->
            <div class="text-2xl font-bold">
                <a href="{{ route('members.index') }}" class="hover:text-blue-200">Library Management</a>
            </div>
            <!-- Navigation Links -->
            <div class="flex space-x-6">
                <a href="{{ route('members.index') }}" class="hover:text-blue-200">Members</a>
                <a href="{{ route('books.index') }}" class="hover:text-blue-200">Books</a>
                <a href="{{ route('borrows.index') }}" class="hover:text-blue-200">Borrow Records</a>
                <a href="{{ route('categories.index') }}" class="hover:text-blue-200">Categories</a>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="container mx-auto p-6">
        @yield('content')
    </main>

   
</body>
</html>