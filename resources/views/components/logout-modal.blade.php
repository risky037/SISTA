<div id="logoutModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
    <div class="bg-white rounded-lg shadow-lg p-6 w-full max-w-sm">
        <h2 class="text-lg font-bold mb-4">Konfirmasi Logout</h2>
        <div class="mb-4 text-sm text-gray-700">
            Anda yakin ingin logout?
        </div>
        <div class="flex justify-end gap-3">
            <button onclick="closeModal()"
                class="bg-gray-200 hover:bg-gray-300 text-gray-800 px-4 py-2 rounded">Batal</button>
            <button onclick="document.getElementById('logout-form').submit();"
                class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded">Ya, Logout</button>
        </div>
    </div>
</div>