<?php

use Illuminate\Support\Facades\Route;

Route::get('/{vue_capture?}',  fn () => view('welcome'))->where('vue_capture', '[\/\w\.-]*');
