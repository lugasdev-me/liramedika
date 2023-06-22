<x-atm-layout>
    <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gray-100 dark:bg-gray-900">
        <div class="w-full sm:max-w-md mt-6 px-6 py-4 bg-white dark:bg-black shadow-md overflow-hidden sm:rounded-lg">
            Pilih Menu ATM:
        </div>

        <button data-name="bri" class="w-full sm:max-w-md mt-6 px-6 py-4 bg-white dark:bg-gray-800 shadow-md overflow-hidden sm:rounded-lg">
            BRI
        </button>
        <button data-name="bni" class="w-full sm:max-w-md mt-6 px-6 py-4 bg-white dark:bg-gray-800 shadow-md overflow-hidden sm:rounded-lg">
            BNI
        </button>
        <button data-name="bca" class="w-full sm:max-w-md mt-6 px-6 py-4 bg-white dark:bg-gray-800 shadow-md overflow-hidden sm:rounded-lg">
            BCA
        </button>
    </div>

    @section('script')
        <script>
            // add click button event
            const buttons = document.querySelectorAll('button');
            buttons.forEach((button) => {
                button.addEventListener('click', () => {
                    window.location.href = '/atm/auth?bank=' + button.dataset.name;
                });
            });
        </script>
    @endsection
</x-atm-layout>
