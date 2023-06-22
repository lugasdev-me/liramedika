<x-bootstrap-layout>
    <div @style('background: radial-gradient(circle, rgba(124,231,244,1) 0%, rgba(0,116,255,1) 25%, rgba(168,222,255,1) 52%, rgba(7,121,194,1) 87%);')>
        <div class="container my-4 text-center d-flex fs-1 text-white fst-italic">
            BRI
        </div>

        <div class="container my-4 d-flex justify-content-between">
            <div class="card my-4 mx-4 shadow-lg" style="width: 18rem;">
                <div class="card-body">
                    <h5 class="card-title">Transfer</h5>
                    <h6 class="card-subtitle mb-2 text-muted"></h6>
                    <p class="card-text">
                        Menu untuk melakukan transfer lebih mudah.
                    </p>
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalTransfer">
                        Do it
                    </button>
                </div>
            </div>

            <div class="card my-4 mx-4 shadow-lg" style="width: 18rem;">
                <div class="card-body">
                    <h5 class="card-title">Tarik Tunai</h5>
                    <h6 class="card-subtitle mb-2 text-muted"></h6>
                    <p class="card-text">
                        Menu untuk melakukan tarik tunai.
                    </p>
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalTarikTunai">
                        Do it
                    </button>
                </div>
            </div>

            <div class="card my-4 mx-4 shadow-lg text-white" style="width: 18rem;">
                <div class="card-body bg-dark">
                    <h5 class="card-title">Top Up</h5>
                    <h6 class="card-subtitle mb-2 text-muted"></h6>
                    <p class="card-text">
                        Menu untuk mengisi saldo.
                    </p>
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalTopUp">
                        Do it
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div class="container">
        <table class="table">
            <thead>
                <tr>
                    <th>id</th>
                    <th>sender_id</th>
                    <th>recipient_id</th>
                    <th>amount</th>
                    <th>type</th>
                    <th>created_at</th>
                    <th>status</th>
                </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="modalTransfer" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Transfer</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="formTransfer">
                    <form>
                        <input class="form-control form-control-lg my-2" type="number" class="card-header" placeholder="Masukkan jumlah" name="amount" id="amount">
                        <input class="form-control form-control-lg my-2" type="number" class="card-header" placeholder="Masukkan rekening tujuan" name="recipient" id="recipient">
                        <div class="modal-footer">
                            <button type="button" class="btn btn-primary btn-transfer">Transfer</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="modalTarikTunai" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Tarik Tunai</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="card my-3">
                    <button data-amount="50000" class="card-header btn-tunai">
                      50.000
                    </button>
                </div>
                <div class="card my-3">
                    <button data-amount="100000" class="card-header btn-tunai">
                      100.000
                    </button>
                </div>
                <div class="card my-3">
                    <button data-amount="250000" class="card-header btn-tunai">
                      250.000
                    </button>
                </div>
                <div class="card my-3">
                    <button data-amount="300000" class="card-header btn-tunai w-full">
                      300.000
                    </button>
                </div>
                <p>Jumlah berbeda:</p>
                <form>
                    <input class="form-control form-control-lg" type="number" class="card-header" placeholder="Masukkan jumlah" name="amount" id="amountTunai">
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary btn-tunai-custom">Tarik</button>
                    </div>
                </form>
            </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="modalTopUp" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Top Up</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="formTopUp">
                    <form>
                        <input class="form-control form-control-lg my-2" type="number" class="card-header" placeholder="Masukkan jumlah" name="topup" id="topUp">
                        <div class="modal-footer">
                            <button type="button" class="btn btn-primary btn-topup">TopUp</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @section('script')
        <script>
            const account = localStorage.getItem('account') ?? null;
            const account_number = JSON.parse(account).account.account_number;
            getTrx();
            setCard();

            // add click button event
            async function getTrx() {
                var xhr = new XMLHttpRequest();
                xhr.open('GET', '/process/get-trx/'+account_number, true);
                xhr.onreadystatechange = function() {
                    if (xhr.readyState === 4 && xhr.status === 200) {
                        var response = JSON.parse(xhr.responseText);
                        // change trx table
                        var table = document.querySelector('table');
                        var tbody = table.querySelector('tbody');
                        tbody.innerHTML = '';
                        response.data.forEach((trx) => {
                            let status = '';
                            let text_status = '';
                            if(trx.status === 0) {
                                status = 'bg-warning text-black';
                                text_status = 'pending';
                            }
                            if(trx.status === 1) {
                                status = 'bg-success text-white';
                                text_status = 'sukses'
                            }
                            if(trx.status === 2) {
                                status = 'bg-danger text-white';
                                text_status = 'gagal';
                            }

                            tbody.innerHTML += `
                                <tr>
                                    <td class"text-red">${trx.id}</td>
                                    <td>${trx.sender_id}</td>
                                    <td>${trx.recipient_id}</td>
                                    <td>${trx.type == 'tarik_tunai' || trx.type == 'transfer' ? '-' : '+' }${trx.amount}</td>
                                    <td>${trx.type}</td>
                                    <td>${setDate(trx.created_at)}</td>
                                    <td class="${status}">${text_status}</td>
                                </tr>
                            `;
                        });
                    }
                };
                xhr.send();
            }

            function setDate(created_at){
                let time = Date.parse(created_at);
                let date = new Date(time);
                let dateString = date.toDateString();
                return dateString;
            }

            // isi card-number account dari local storage
            async function setCard(){
                const cardNumber = document.querySelectorAll('.card');
                cardNumber.forEach((card) => {
                    const text_card = card.querySelector('.card-subtitle');
                    if(text_card) {
                        text_card.innerHTML = `ID: ${account_number}`;
                    }
                });
            }

            const btn_tunai = document.querySelectorAll('.btn-tunai');
            btn_tunai.forEach((button) => {
                button.addEventListener('click', async (e) => {
                    // e.preventDefault();
                    createTrx(button, button.dataset.amount, 'tarik_tunai');
                });
            });

            const btn_tunai_custom = document.querySelector('.btn-tunai-custom');
            btn_tunai_custom.addEventListener('click', async (e) => {
                // e.preventDefault();
                const amount = document.getElementById('amountTunai').value;
                createTrx(btn_tunai_custom, amount, 'tarik_tunai');
            });

            const formTransfer = document.getElementById('formTransfer');
            const btn_transfer = document.querySelector('.btn-transfer');
            btn_transfer.addEventListener('click', async (e) => {
                e.preventDefault();
                const amount = formTransfer.querySelector('#amount').value;
                const recipient = formTransfer.querySelector('#recipient').value;
                createTrx(btn_transfer, amount, 'transfer', recipient);
            });

            const formTopUp = document.getElementById('formTopUp');
            const btn_topup = document.querySelector('.btn-topup');
            btn_topup.addEventListener('click', async (e) => {
                e.preventDefault();
                const amount = formTopUp.querySelector('#topUp').value;
                createTrx(btn_topup, amount, 'topup');
            });

            // add click button event
            async function createTrx(element, amount, type, recipient_number = account_number) {
                rawResponse = await fetch('/process/set-trx', {
                    method: 'POST',
                    headers: {
                    'Accept': 'application/json',
                    'Content-Type': 'application/json',
                    'x-csrf-token': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        sender_number: account_number,
                        recipient_number: recipient_number,
                        amount: amount,
                        type: type
                    })
                });
                const content = await rawResponse.json();
                alert(content.message);
                getTrx();
            }
        </script>
    @endsection
</x-bootstrap-layout>
