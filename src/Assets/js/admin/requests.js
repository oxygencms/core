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
    console.log(error.response);

    console.log(error.message);

    if (error.response && error.response.data && error.response.data.message) {
        oxy.notify(error.response.data.message, 'error', 5000);
    } else {
        oxy.notify(error.message, 'error', 5000);
    }
}

/**
 * Update the active attribute of a model.
 *
 * @param model
 * @returns {*|void|Promise<T | never>}
 */
function updateActive(model)
{
    let previousState = !model.active,
        url = `/admin/update/active/${model.model_name}/${model.id}`;

    axios.patch(url, {active: model.active})

        .then(showResponseNotification)

        .catch(error => {
            if (previousState !== model.active) {
                // set back the previous state
                model.active = previousState;
            }

            logErrorResponseAndShowErrorMessage(error);
        })
}

/**
 * Find and remove a model from the database.
 *
 * @param model
 */
function destroy(model)
{
    axios.delete(`/admin/seek-and-destroy/${model.model_name}/${model.id}`)
        .then(response => {

            // const index = oxy.models.indexOf(model);

            // oxy.models.splice(index, 1);

            oxy.models = oxy.models.filter(m => m.id !== model.id);

            showResponseNotification(response)

        }).catch(logErrorResponseAndShowErrorMessage);
}

function deleteSelectedModels() {
    // for
}

export default {

    destroy,

    updateActive,

    deleteSelectedModels,

    showResponseNotification,

    logErrorResponseAndShowErrorMessage,

}
