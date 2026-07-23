/**
 * AdminLTE Asset Setup Script
 * Copies plugin assets from node_modules to the plugins/ directory.
 * This replicates what the official Publish.js build script does.
 */
'use strict';

const fs = require('fs');
const path = require('path');

const ROOT = __dirname;
const PLUGINS_DIR = path.join(ROOT, 'plugins');
const NODE_MODULES = path.join(ROOT, 'node_modules');

// Ensure plugins dir exists
if (!fs.existsSync(PLUGINS_DIR)) {
  fs.mkdirSync(PLUGINS_DIR, { recursive: true });
}

function copyFile(src, dest) {
  const destDir = path.dirname(dest);
  if (!fs.existsSync(destDir)) {
    fs.mkdirSync(destDir, { recursive: true });
  }
  if (fs.existsSync(src)) {
    fs.copyFileSync(src, dest);
    return true;
  }
  return false;
}

function copyDir(src, dest, filter) {
  if (!fs.existsSync(src)) {
    console.warn(`  SKIP (not found): ${src}`);
    return;
  }
  if (!fs.existsSync(dest)) {
    fs.mkdirSync(dest, { recursive: true });
  }
  const entries = fs.readdirSync(src, { withFileTypes: true });
  for (const entry of entries) {
    if (filter && !filter(entry.name)) continue;
    const srcPath = path.join(src, entry.name);
    const destPath = path.join(dest, entry.name);
    if (entry.isDirectory()) {
      copyDir(srcPath, destPath, filter);
    } else {
      fs.copyFileSync(srcPath, destPath);
    }
  }
}

// Only copy minified or specific files to keep things lean
const minOnly = name => name.endsWith('.min.js') || name.endsWith('.min.css') || name.endsWith('.map') || !name.includes('.');
const allFiles = name => !name.startsWith('.');

const plugins = [
  // [source_in_node_modules, dest_in_plugins, filter_fn]
  // Bootstrap
  ['bootstrap/dist/js/bootstrap.bundle.min.js',         'bootstrap/js/bootstrap.bundle.min.js'],
  ['bootstrap/dist/css/bootstrap.min.css',               'bootstrap/css/bootstrap.min.css'],

  // jQuery
  ['jquery/dist/jquery.min.js',                          'jquery/jquery.min.js'],

  // Font Awesome
  { dir: '@fortawesome/fontawesome-free',               dest: 'fontawesome-free' },

  // AdminLTE overlayScrollbars
  { dir: 'overlayscrollbars/js',                        dest: 'overlayScrollbars/js', filter: allFiles },
  { dir: 'overlayscrollbars/css',                       dest: 'overlayScrollbars/css', filter: allFiles },

  // Chart.js
  ['chart.js/dist/Chart.min.js',                        'chart.js/Chart.min.js'],
  ['chart.js/dist/Chart.min.css',                       'chart.js/Chart.min.css'],

  // Sparklines
  ['sparklines/src/jquery.sparkline.min.js',             'sparklines/sparkline.js'],

  // JQVMap
  { dir: 'jqvmap-novulnerability/dist',                 dest: 'jqvmap', filter: allFiles },

  // jQuery Knob
  ['jquery-knob-chif/js/jquery.knob.min.js',            'jquery-knob/jquery.knob.min.js'],

  // Moment.js
  ['moment/min/moment.min.js',                          'moment/moment.min.js'],

  // Daterange picker
  ['daterangepicker/daterangepicker.js',                'daterangepicker/daterangepicker.js'],
  ['daterangepicker/daterangepicker.css',               'daterangepicker/daterangepicker.css'],

  // Tempusdominus Bootstrap 4
  { dir: 'tempusdominus-bootstrap-4/build/js',          dest: 'tempusdominus-bootstrap-4/js', filter: allFiles },
  { dir: 'tempusdominus-bootstrap-4/build/css',         dest: 'tempusdominus-bootstrap-4/css', filter: allFiles },

  // iCheck Bootstrap
  ['icheck-bootstrap/icheck-bootstrap.min.css',         'icheck-bootstrap/icheck-bootstrap.min.css'],

  // Summernote
  ['summernote/dist/summernote-bs4.min.js',             'summernote/summernote-bs4.min.js'],
  ['summernote/dist/summernote-bs4.min.css',            'summernote/summernote-bs4.min.css'],
  { dir: 'summernote/dist/font',                        dest: 'summernote/font', filter: allFiles },

  // Select2
  ['select2/dist/js/select2.full.min.js',               'select2/js/select2.full.min.js'],
  ['select2/dist/css/select2.min.css',                  'select2/css/select2.min.css'],

  // DataTables core
  ['datatables.net/js/jquery.dataTables.min.js',        'datatables.net/js/jquery.dataTables.min.js'],
  ['datatables.net-bs4/js/dataTables.bootstrap4.min.js','datatables.net-bs4/js/dataTables.bootstrap4.min.js'],
  ['datatables.net-bs4/css/dataTables.bootstrap4.min.css','datatables.net-bs4/css/dataTables.bootstrap4.min.css'],

  // BS-Stepper
  ['bs-stepper/dist/js/bs-stepper.min.js',              'bs-stepper/js/bs-stepper.min.js'],
  ['bs-stepper/dist/css/bs-stepper.min.css',            'bs-stepper/css/bs-stepper.min.css'],

  // Dropzone
  ['dropzone/dist/min/dropzone.min.js',                 'dropzone/min/dropzone.min.js'],
  ['dropzone/dist/min/dropzone.min.css',                'dropzone/min/dropzone.min.css'],

  // Fullcalendar
  { dir: 'fullcalendar/main.min.js',                    dest: 'fullcalendar/main.min.js', single: true },
  { dir: 'fullcalendar/main.min.css',                   dest: 'fullcalendar/main.min.css', single: true },

  // Filterizr
  ['filterizr/dist/jquery.filterizr.min.js',            'filterizr/jquery.filterizr.min.js'],

  // Flag icon CSS
  { dir: 'flag-icon-css/css',                           dest: 'flag-icon-css/css', filter: allFiles },
  { dir: 'flag-icon-css/flags',                         dest: 'flag-icon-css/flags', filter: allFiles },

  // Ekko Lightbox
  ['ekko-lightbox/dist/ekko-lightbox.min.js',           'ekko-lightbox/dist/ekko-lightbox.min.js'],
  ['ekko-lightbox/dist/ekko-lightbox.css',              'ekko-lightbox/dist/ekko-lightbox.css'],

  // SweetAlert2
  ['sweetalert2/dist/sweetalert2.min.js',               'sweetalert2/dist/sweetalert2.min.js'],
  ['sweetalert2/dist/sweetalert2.min.css',              'sweetalert2/dist/sweetalert2.min.css'],

  // Toastr
  ['toastr/build/toastr.min.js',                        'toastr/toastr.min.js'],
  ['toastr/build/toastr.min.css',                       'toastr/toastr.min.css'],

  // Ion RangeSlider
  { dir: 'ion-rangeslider/js',                          dest: 'ion-rangeslider/js', filter: allFiles },
  { dir: 'ion-rangeslider/css',                         dest: 'ion-rangeslider/css', filter: allFiles },

  // Bootstrap Colorpicker
  ['bootstrap-colorpicker/dist/js/bootstrap-colorpicker.min.js', 'bootstrap-colorpicker/js/bootstrap-colorpicker.min.js'],
  ['bootstrap-colorpicker/dist/css/bootstrap-colorpicker.min.css','bootstrap-colorpicker/css/bootstrap-colorpicker.min.css'],

  // Bootstrap Slider
  ['bootstrap-slider/dist/bootstrap-slider.min.js',     'bootstrap-slider/js/bootstrap-slider.min.js'],
  ['bootstrap-slider/dist/css/bootstrap-slider.min.css','bootstrap-slider/css/bootstrap-slider.min.css'],

  // jsgrid
  ['jsgrid/dist/jsgrid.min.js',                        'jsgrid/js/jsgrid.min.js'],
  ['jsgrid/dist/jsgrid.min.css',                       'jsgrid/css/jsgrid.min.css'],
  ['jsgrid/dist/jsgrid-theme.min.css',                 'jsgrid/css/jsgrid-theme.min.css'],

  // jQuery Validation
  ['jquery-validation/dist/jquery.validate.min.js',     'jquery-validation/jquery.validate.min.js'],

  // jQuery UI
  ['jquery-ui-dist/jquery-ui.min.js',                  'jquery-ui/jquery-ui.min.js'],
  ['jquery-ui-dist/jquery-ui.min.css',                 'jquery-ui/jquery-ui.min.css'],
  { dir: 'jquery-ui-dist/images',                       dest: 'jquery-ui/images', filter: allFiles },

  // Inputmask
  ['inputmask/dist/jquery.inputmask.min.js',            'inputmask/jquery.inputmask.min.js'],

  // Pace Progress
  { dir: '@lgaitan/pace-progress/themes/blue',          dest: 'pace-progress/themes/blue', filter: allFiles },
  ['@lgaitan/pace-progress/dist/pace.min.js',           'pace-progress/pace.min.js'],

  // Popper.js
  ['popper.js/dist/umd/popper.min.js',                 'popper/popper.min.js'],

  // Fastclick
  ['fastclick/lib/fastclick.js',                        'fastclick/fastclick.js'],

  // Codemirror
  { dir: 'codemirror',                                  dest: 'codemirror', filter: name => name.endsWith('.js') || name.endsWith('.css') },
];

let copied = 0;
let skipped = 0;

for (const plugin of plugins) {
  if (typeof plugin === 'string') continue; // skip plain strings (handled below)

  if (Array.isArray(plugin)) {
    // Simple file copy: [src_relative, dest_relative]
    const [src, dest] = plugin;
    const srcFull = path.join(NODE_MODULES, src);
    const destFull = path.join(PLUGINS_DIR, dest);
    if (copyFile(srcFull, destFull)) {
      console.log(`  ✓ ${dest}`);
      copied++;
    } else {
      console.warn(`  ✗ MISSING: ${src}`);
      skipped++;
    }
  } else if (typeof plugin === 'object') {
    if (plugin.single) {
      // Single file from a dir reference
      const srcFull = path.join(NODE_MODULES, plugin.dir);
      const destFull = path.join(PLUGINS_DIR, plugin.dest);
      if (copyFile(srcFull, destFull)) {
        console.log(`  ✓ ${plugin.dest}`);
        copied++;
      } else {
        console.warn(`  ✗ MISSING: ${plugin.dir}`);
        skipped++;
      }
    } else {
      // Directory copy
      const srcFull = path.join(NODE_MODULES, plugin.dir);
      const destFull = path.join(PLUGINS_DIR, plugin.dest);
      console.log(`  → Copying dir: ${plugin.dest}`);
      copyDir(srcFull, destFull, plugin.filter);
      copied++;
    }
  }
}

// Handle simple array entries (file pairs)
for (const plugin of plugins) {
  if (Array.isArray(plugin)) {
    const [src, dest] = plugin;
    const srcFull = path.join(NODE_MODULES, src);
    const destFull = path.join(PLUGINS_DIR, dest);
    if (copyFile(srcFull, destFull)) {
      console.log(`  ✓ ${dest}`);
      copied++;
    } else {
      console.warn(`  ✗ MISSING: ${src}`);
      skipped++;
    }
  }
}

console.log(`\nDone! Copied: ${copied}, Skipped: ${skipped}`);
console.log(`Plugins directory: ${PLUGINS_DIR}`);
