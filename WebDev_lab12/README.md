# WebDev Lab 12 - Progressive Web App

This lab contains a simple weather Progressive Web Application (PWA) built following the
instructions from *Лабораторна робота.PWA.pdf*. The application demonstrates how to
use a service worker and app manifest to provide offline capabilities.

Because the original weather API is currently unavailable, the app loads
forecast data from a local JSON file located at `data/forecast.json`. This
allows you to test offline behavior without a network connection.

To try the application open `index.html` in your browser. After the initial
load, the service worker caches the application shell and the fake forecast
data so that the interface continues working offline.

