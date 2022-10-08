#!/usr/bin/env bash

# Update Chrome driver
php artisan dusk:update

# Detect Chrome Driver
php artisan dusk:chrome-driver --detect

# Start Chrome Driver
vendor/laravel/dusk/bin/chromedriver-mac-arm &

# Install Node dependencies and run in dev mode
npm install
npm run dev &

# Run laravel dev server
php artisan serve &
