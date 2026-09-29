import '../scss/main.scss';
import { initMobileMenu } from './mobile-menu.js';
/**
 * Main JavaScript for CPG Theme
 */
(function (Drupal) {
    'use strict';

    Drupal.behaviors.cpgThemeGlobal = {
        attach: function (context, settings) {
            console.log('CPG Theme initialized!');
            initMobileMenu();
        }
    };

    // Vite module HMR test hook (removed in production build by Vite)
    if (import.meta.hot) {
        import.meta.hot.accept((newModule) => {
            console.log('HMR applied for JS.');
        });
    }

})(window.Drupal || { behaviors: {} });
