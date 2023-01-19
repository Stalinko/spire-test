// Check if the DOMContentLoaded has already been completed
if (document.readyState !== 'loading') {
    start();
} else {
    document.addEventListener('DOMContentLoaded', start);
}

const STATE = {
};

/**
 * Entry point when DOM is loaded
 */
function start()
{
    document.getElementById('btn-validate').onclick = validateClick
    document.getElementById('btn-save').onclick = saveAddress
    document.getElementById('modal-select-address').addEventListener('hidden.bs.modal', onSaveModalHide)

}

/**
 * @param {MouseEvent} e
 */
function validateClick (e) {
    e.preventDefault();
    disableForm();

    const address = collectAddress(e.target.form);
    callValidationApi(address)
        .then(response => response.json())
        .then(json => {
            enableForm();

            if (!json.success) {
                showError(json.message);
            } else {
                showSaveModal(address, json.normalized_address);
            }
        })
}

/**
 * @param {String} message
 */
function showError(message)
{
    document.getElementById('error-text').innerText = message;
    const errorModal = new bootstrap.Modal('#modal-error');
    errorModal.show();
}

function disableForm()
{
    document.getElementById('btn-validate').setAttribute('disabled', 'disabled');
}

function enableForm()
{
    document.getElementById('btn-validate').removeAttribute('disabled');
}

/**
 * @param {HTMLFormElement} form
 * @returns {{zip, address_line2, address_line1, city, state}}
 */
function collectAddress(form)
{
    return {
        address_line1: form['address_line1'].value,
        address_line2: form['address_line2'].value,
        city: form['city'].value,
        state: form['state'].value,
        zip: form['zip'].value,
    };
}

/**
 * @param {Object} request
 * @returns {Promise<Response>}
 */
function callValidationApi(request)
{
    let params = new URLSearchParams(request);
    const url = '/api-validate.php?' + params;
    return fetch(url)
}

function showSaveModal(original_address, normalized_address)
{
    STATE.original_address = original_address;
    STATE.normalized_address = normalized_address;

    document.getElementById('address-original').innerText = formatAddress(original_address);
    document.getElementById('address-standardized').innerText = formatAddress(normalized_address);

    const saveModal = new bootstrap.Modal('#modal-select-address');
    saveModal.show();
}

function formatAddress(address)
{
    return `Address Line 1: ${address.address_line1}
Address Line 2: ${address.address_line2}
City: ${address.city}
State: ${address.state}
Zip Code: ${address.zip}`;
}

function saveAddress(e)
{
    e.target.setAttribute('disabled', 'disabled');

    const active_tab_id = document.querySelector('#modal-select-address .tab-pane.active').getAttribute('id');
    let selected_address;
    if (active_tab_id === 'tab-original-pane') {
        selected_address = STATE.original_address;
    } else {
        selected_address = STATE.normalized_address;
    }

    fetch('/api-save.php?' + new URLSearchParams(selected_address)).then(response => {
        if (response.status === 200) {
            document.getElementById('saving-success').classList.remove('d-none');
        }
    })
}

function onSaveModalHide()
{
    document.getElementById('saving-success').classList.add('d-none');
    document.getElementById('btn-save').removeAttribute('disabled');
}