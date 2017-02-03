<?php

namespace GeorgRinger\NewsTtcontentimport\Jobs;


use GeorgRinger\News\Domain\Service\NewsImportService;
use GeorgRinger\News\Jobs\AbstractImportJob;


class TtContentImportJob extends AbstractImportJob
{

    /**
     * @var int
     */
    protected $numberOfRecordsPerRun = 30000;

    protected $importServiceSettings = array(
        'findCategoriesByImportSource' => 'TT_CONTENT'
    );


    /**
     * @param \GeorgRinger\NewsTtcontentimport\Service\Import\TtContentDataProviderService $importDataProviderService
     */
    public function injectImportDataProviderService(\GeorgRinger\NewsTtcontentimport\Service\Import\TtContentDataProviderService $importDataProviderService)
    {
        $this->importDataProviderService = $importDataProviderService;
    }


    /**
     * Inject import service
     *
     * @param NewsImportService $importService
     * @return void
     */
    public function injectImportService(\GeorgRinger\News\Domain\Service\NewsImportService $importService)
    {
        $this->importService = $importService;
    }
}
