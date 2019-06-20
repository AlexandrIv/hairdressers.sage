// import external dependencies
import 'jquery';
import 'slick-carousel/slick/slick.min';
import 'bootstrap-select/js/bootstrap-select';
import 'air-datepicker/src/js/air-datepicker';

import 'jquery-touchswipe/jquery.touchSwipe.min';
import 'moment/min/moment-with-locales.min';
import 'arrobefr-jquery-calendar/src/js/jquery-calendar';






// Import everything from autoload
import './autoload/**/*'

// import local dependencies
import Router from './util/Router';
import common from './routes/common';
import home from './routes/home';
import aboutUs from './routes/about';
import ajax from './routes/ajax';
import readmore from './custom/readmore.min';
import moment from 'moment/moment';


/** Populate Router instance with DOM routes */
const routes = new Router({
  // All pages
  common,
  // Home page
  home,
  // About Us page, note the change from about-us to aboutUs.
  aboutUs,
  // Ajax
  ajax,
  // Readmore
  readmore,
  moment,
});

// Load Events
jQuery(document).ready(() => routes.loadEvents());
