import _ from 'lodash';
import Popper from 'popper.js';
import $ from 'jquery';
import axios from 'axios';
import 'bootstrap';

window._ = _;
window.Popper = Popper;
window.$ = window.jQuery = $;

window.axios = axios;
window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
