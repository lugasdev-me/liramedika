<x-atm-layout>
    <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gray-100 dark:bg-gray-900">
        <div class="w-full sm:max-w-md mt-6 px-6 py-4 bg-white dark:bg-black shadow-md overflow-hidden sm:rounded-lg">
            {{-- form --}}
            <form>
                <div>
                    <label for="accountNumber">Masukan Account Number:</label>
                    <input type="text" name="accountNumber" id="accountNumber" class="w-full rounded-md shadow-md">
                </div>
                <div>
                    <label for="pin">Masukan PIN:</label>
                    <input type="password" name="pin" id="pin" class="w-full rounded-md shadow-md">
                </div>
                <button type="button" class="mt-4 px-3 py-3 text-white rounded-full" @style('background-color: blue;')>Submit</button>
            </form>
        </div>
    </div>

    @section('script')
        <script>
            // get params bank
            const urlParams = new URLSearchParams(window.location.search);
            const bank = urlParams.get('bank');

            // add click button event
            const buttons = document.querySelectorAll('button');
            buttons.forEach((button) => {
                button.addEventListener('click', (e) => {
                    e.preventDefault();
                    var xhr = new XMLHttpRequest();
                    // csrf
                    xhr.open('POST', '/process/auth', true);
                    xhr.setRequestHeader('Content-type', 'application/json');
                    xhr.setRequestHeader('X-CSRF-TOKEN', '{{ csrf_token() }}');
                    xhr.send(JSON.stringify({
                        accountNumber: document.querySelector('#accountNumber').value,
                        pin: document.querySelector('#pin').value,
                        bank: bank
                    }));

                    xhr.onload = function () {
                        if(xhr.status === 201) {
                            localStorage.setItem('account', JSON.stringify(JSON.parse(xhr.responseText)));
                            window.location.href = '/atm/' + bank;
                        }else{
                            alert(JSON.parse(xhr.responseText).message);
                        }
                    }
                });
            });
        </script>
    @endsection
</x-atm-layout>
