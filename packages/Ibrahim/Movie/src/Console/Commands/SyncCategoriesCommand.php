<?php

namespace Ibrahim\Movie\Console\Commands;

use Ibrahim\Movie\Repositories\EloquentCategoryRepository;
use Illuminate\Console\Command;

class SyncCategoriesCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sync:categories';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Display an inspiring quote';

    public $categoryRepository;

    /**
     * SyncCategoriesCommand constructor.
     * @param $categoryRepository
     */
    public function __construct(EloquentCategoryRepository $categoryRepository)
    {
        parent::__construct();
        $this->categoryRepository = $categoryRepository;
    }


    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->categoryRepository->syncCategories();
    }
}
