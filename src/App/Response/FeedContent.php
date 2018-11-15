<?php
/**
 * Tweakwise & Emico (https://www.tweakwise.com/ & https://www.emico.nl/) - All Rights Reserved
 *
 * @copyright Copyright (c) 2017-2017 Tweakwise.com B.V. (https://www.tweakwise.com)
 * @license   http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

namespace Emico\TweakwiseExport\App\Response;

use Emico\TweakwiseExport\Model\Export;
use Emico\TweakwiseExport\Model\Logger;
use Exception;

/**
 * Class FeedContent
 *
 * To string wrapper so output is not stored in memory but written to output on get content
 *
 * @package Emico\TweakwiseExport\App\Response
 */
class FeedContent {
    /**
     * @var Export
     */
    private $export;

    /**
     * @var Logger
     */
    private $log;

    /**
     * SomeFeedResponse constructor.
     *
     * @param Export $export
     * @param Logger $log
     */
    public function __construct(Export $export, Logger $log)
    {
        $this->export = $export;
        $this->log = $log;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        $resource = fopen('php://memory', 'wb');
        try {
            try {
                $this->export->getFeed($resource);
            } catch (Exception $e) {
                $this->log->error(sprintf('Failed to get feed due to %s', $e->getMessage()));
            }
        } finally {
            rewind($resource);
            $output = \stream_get_contents($resource);
            fclose($resource);
        }
        return $output;
    }
}