import axios from 'axios';

axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

/**
 * Next we will register the CSRF Token as a common header with axios so that
 * all outgoing HTTP requests automatically have it attached. This is just
 * a simple convenience so we don't have to attach every token manually.
 */

let token = document.head.querySelector('meta[name="csrf-token"]');

if (token) {
    axios.defaults.headers.common['X-CSRF-TOKEN'] = token.content;
} else {
    console.error('CSRF token not found: https://laravel.com/docs/csrf#csrf-x-csrf-token');
}

window.axios = axios;

import oxy from './vue';

/**
 * Show notification from server response.
 *
 * @param response
 */
function showResponseNotification(response)
{
    oxy.$notify(response.data.notification);
}

/**
 * Log the error.response to the console and show the error.message.
 *
 * @param error
 */
function logErrorResponseAndShowErrorMessage(error)
{
    console.log(error.response, error.message);

    if (error.response && error.response.data && error.response.data.message) {
        oxy.notify(error.response.data.message, 'error', 5000);
    } else {
        oxy.notify(error.message, 'error', 5000);
    }
}

/**
 * Find and remove a model from the database.
 *
 * @param model
 */
function destroy(model)
{
    let url = typeof model.destroy_url != 'undefined'
        ? model.destroy_url
        : `/admin/seek-and-destroy/${model.model_name}/${model.id}`;

    axios.delete(url)
        .then(response => {

            oxy.models = oxy.models.filter(m => m.id !== model.id);

            showResponseNotification(response)

        }).catch(logErrorResponseAndShowErrorMessage);
}

export default {
    axios,

    destroy,

    showResponseNotification,

    logErrorResponseAndShowErrorMessage,
}
