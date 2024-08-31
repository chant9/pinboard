<?php

use Illuminate\Support\Facades\Schedule;


Schedule::command('app:scrap-pinboard')->daily();
Schedule::command('app:check-pinboard-urls')->daily();
