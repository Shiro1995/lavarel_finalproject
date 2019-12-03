<?php

namespace App\Console\Commands;

use App\Http\Controllers\API\DiseaseController;
use App\Model\Disease;
use Illuminate\Console\Command;

class cronFetchDetailDiseaseAutomatically extends Command
{
    protected $controller;
    protected $disease;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:cronFetchDetailDiseaseAutomatically';

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
    public function __construct(DiseaseController $controller, Disease $disease) {
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
        $typeOfDiseases = $this->disease->get();
        foreach ($typeOfDiseases as $item) {
            $this->controller->auto_disease($item);
        }
        return true;
    }
}
