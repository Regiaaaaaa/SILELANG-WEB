@echo off
cd /d D:\laragon\www\SILELANG-APP
php artisan schedule:run >> scheduler.log 2>&1
