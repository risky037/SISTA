<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1"/>
  <title>@yield('title') - SIA UICI</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet"/>
  <style>
    ::-webkit-scrollbar {width: 6px;height: 6px;}
    ::-webkit-scrollbar-thumb {background-color: #4a5568;border-radius: 10px;}
  </style>
</head>
<body class="bg-gray-100 font-sans text-gray-900">
  <div class="flex min-h-screen">
    <!-- Sidebar -->
    @include('partials.sidebar')

    <!-- Main -->
    <main class="flex-1 flex flex-col">
      @include('partials.topbar')
      <section class="flex-1 overflow-auto p-6">
        <div class="max-w-7xl mx-auto space-y-6">
          @yield('content')
        </div>
      </section>
    </main>
  </div>

<script>
function toggleSubmenu() {
  const submenu = document.getElementById("submenu-progres");
  const icon = document.getElementById("icon-progres");
  submenu.classList.toggle("hidden");
  icon.classList.toggle("fa-chevron-down");
  icon.classList.toggle("fa-chevron-up");
}
</script>
</body>
</html>
