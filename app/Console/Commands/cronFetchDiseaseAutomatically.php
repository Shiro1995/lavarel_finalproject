<?php

namespace App\Console\Commands;

use App\Http\Controllers\API\DiseaseController;
use Illuminate\Console\Command;

class cronFetchDiseaseAutomatically extends Command
{
    protected $controller;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:cronFetchDiseaseAutomatically';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Using for fetching class of diseases';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(DiseaseController $controller) {
        parent::__construct();
        $this->controller = $controller;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle() {
        $this->controller->auto_type_disease();
    }
}
