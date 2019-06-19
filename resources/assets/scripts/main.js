// import external dependencies
import 'jquery';
/*import '@fullcalendar/moment/main';
import '@fullcalendar/core/main';
import '@fullcalendar/daygrid/main';*/
import 'slick-carousel/slick/slick.min';
import 'bootstrap-select/js/bootstrap-select';
import 'air-datepicker/src/js/air-datepicker';


import { Calendar } from '@fullcalendar/core';
import dayGridPlugin from '@fullcalendar/daygrid';


// Import everything from autoload
import './autoload/**/*'

// import local dependencies
import Router from './util/Router';
import common from './routes/common';
import home from './routes/home';
import aboutUs from './routes/about';
import ajax from './routes/ajax';
import readmore from './custom/readmore.min';

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
});

// Load Events
jQuery(document).ready(() => routes.loadEvents());
