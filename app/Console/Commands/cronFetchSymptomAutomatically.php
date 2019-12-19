<?php

namespace App\Console\Commands;

use App\Http\Controllers\API\Definitionscontroller;
use App\Model\Disease;
use Illuminate\Console\Command;

class cronFetchSymptomAutomatically extends Command
{
    protected $controller;
    protected $disease;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:cronFetchSymptomAutomatically';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Using for fetching all diseases';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(Definitionscontroller $controller, Disease $disease) {
        parent::__construct();
        $this->disease = $disease;
        $this->controller = $controller;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle() {
        $diseases = $this->disease->getByLevel();
        foreach ($diseases as $item) {
            $this->controller->auto_symptom($item);
        }
        return true;
    }
}
