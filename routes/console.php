<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Artisan::command('import:csv {path}', function($path) {
    $this->info('Importing '.$path.'..');

    $contents = File::get($path);
    $this->info($contents);

    dump(str_getcsv($contents));


})->purpose('Import Google Form responses CSV file.');
 
