
import Vue from "vue";

import Notifications from 'vue-notification';
Vue.use(Notifications);

import VueGoodTablePlugin from 'vue-good-table';
Vue.use(VueGoodTablePlugin);

import { Bar, HorizontalBar, Line, Pie, Doughnut } from 'vue-chartjs';

let chartData = {
        labels: [
            'January', 'February', 'March', 'April', 'May', 'June',
            'July', 'August', 'September', 'October', 'November', 'December',
        ],
        datasets: [
            {
                label: 'GitHub Commits',
                backgroundColor: '#4daff8',
                data: [40, 20, 12, 39, 10, 40, 39, 80, 40, 20, 12, 11],
            },
        ],
        data: [40, 20, 12, 39, 10, 40, 39, 80, 40, 20, 12, 11],
    },

    chartProps = {
        responsive: true,
        maintainAspectRatio: true,
    };

Vue.component('bar-chart', {
    extends: Bar,
    mounted () {
        this.renderChart(chartData, chartProps);
    }
});

Vue.component('horizontal-bar-chart', {
    extends: HorizontalBar,
    mounted () {
        this.renderChart(chartData, chartProps);
    }
});

Vue.component('line-chart', {
    extends: Line,
    mounted () {
        this.renderChart(chartData, chartProps);
    }
});

Vue.component('pie-chart', {
    extends: Pie,
    mounted () {
        this.renderChart(chartData, chartProps);
    }
});

Vue.component('doughnut-chart', {
    extends: Doughnut,
    mounted () {
        this.renderChart(chartData, chartProps);
    }
});

/**
 * Get a translation from the stack by it's group and key.
 *
 * @param group_dot_key_string
 */
function getTranslation(group_dot_key_string) {

    let [group, key] = group_dot_key_string.split('.');

    if (typeof Oxy.translations[group] === 'undefined' || typeof Oxy.translations[group][key] === 'undefined') {
        return group_dot_key_string;
    }

    return Oxy.translations[group][key];
}

import api from './requests';

import MediaUploads from './components/MediaUploads';

export default new Vue({

    el: '#oxy',

    components: {
        MediaUploads,
    },

    data: {
        locale: Oxy.locale,
        locales: Oxy.locales,
        models: Oxy.models || null,
        sidebarHidden: JSON.parse(sessionStorage.getItem('sidebarHidden')) || false,
    },

    methods: {
        confirmAndDestroy(model, question = "Delete selected item?") {
            if (confirm(question)) {
                api.destroy(model);
            }
        },

        cl(loggable) {console.log(loggable)},

        notify(text, type = '', duration = 3000) {
            this.$notify({
                type: type,
                text: text,
                duration: duration,
            });
        },

        formatActive(bool) {
            return bool ? 'active' : 'inactive';
        },

        trans(group_dot_key_string) {
            return getTranslation(group_dot_key_string);
        },
    },

    watch: {
        sidebarHidden() {
            sessionStorage.setItem('sidebarHidden', this.sidebarHidden)
        }
    },

    computed: {
    }
});