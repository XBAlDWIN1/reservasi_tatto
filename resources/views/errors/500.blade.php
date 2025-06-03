<!-- Server error -->
<!DOCTYPE html>
<html>

<head>
    <title>500 Error</title>
    <link href="https://unpkg.com/tailwindcss@^2/dist/tailwind.min.css" rel="stylesheet">
</head>

<body>
    <div class="flex justify-center items-center h-screen bg-gray-200">
        <div class="text-center">
            <h1 class="text-4xl font-medium">500</h1>
            <p class="text-xl font-medium m-6">Sorry, something went wrong on our end.</p>
            <a href="{{ url('/') }}" class="bg-blue-500 hover:bg-blue-600 text-white py-2 px-4 rounded">Go Home</a>
        </div>
    </div>
</body>

</html>