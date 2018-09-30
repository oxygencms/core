// window._ = require('lodash');

window.Popper = require('popper.js').default;

try {
    window.$ = window.jQuery = require('jquery');

    require('bootstrap');
} catch (e) {}

window.Dropzone = require('dropzone');

// window.tinymce = require('tinymce');

import './requests';

import oxy from './vue';

window.oxy = oxy;

