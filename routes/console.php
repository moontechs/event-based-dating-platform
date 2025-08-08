<?php

use Illuminate\Support\Facades\Schedule;

Schedule::command('connection:cleanup-old')->daily();
