<?php

namespace GeorgRinger\NewsTtcontentimport\Service\Import;

use DateTime;
use GeorgRinger\News\Service\Import\DataProviderServiceInterface;
use TYPO3\CMS\Core\Database\DatabaseConnection;
use TYPO3\CMS\Core\Utility\MathUtility;

class TtContentDataProviderService implements DataProviderServiceInterface, \TYPO3\CMS\Core\SingletonInterface
{

    const WHERE2 = 'sys_language_uid > 0 AND l18n_parent>0 AND deleted=0 AND pid IN(261,262,263)';
    const WHERE = 'deleted=0 AND pid IN(261,262,263)';
//    const WHERE = 'deleted=0 AND pid IN(261,262,263) AND uid in(1587)';

    protected $importSource = 'TT_CONTENT_IMPORT';

    public function getTotalRecordCount()
    {
        $res = $GLOBALS['TYPO3_DB']->exec_SELECTquery('count(*)',
            'tt_content',
            self::WHERE
        );

        list($count) = $GLOBALS['TYPO3_DB']->sql_fetch_row($res);
        $GLOBALS['TYPO3_DB']->sql_free_result($res);

        return (int)$count;
    }

    /**
     * Get the partial import data, based on offset + limit
     *
     * @param integer $offset offset
     * @param integer $limit limit
     * @return array
     */
    public function getImportData($offset = 0, $limit = 200)
    {
        $importData = array();

        $res = $this->getDb()->exec_SELECTquery('*',
            'tt_content',
            self::WHERE,
            '',
            'sys_language_uid ASC,l18n_parent ASC',
            $offset . ',' . $limit
        );

        while ($row = $GLOBALS['TYPO3_DB']->sql_fetch_assoc($res)) {

            $time = $this->getTime($row['subheader']);
            $importData[] = [
                'pid' => $this->getPid($row),
                'hidden' => $row['hidden'],
                'tstamp' => $row['tstamp'],
                'crdate' => $row['crdate'],
                'starttime' => $row['starttime'],
                'endtime' => $row['endtime'],
                'sorting' => $row['sorting'],
                'title' => $row['header'],
                'type' => 0,
                'bodytext' => $row['bodytext'],
//                'subheader' => $row['subheader'],
//                'notes' => $row['imported'],
                'l10n_parent' => $row['l18n_parent'],
                'sys_language_uid' => $row['sys_language_uid'],
                'editlock' => $row['editlock'],
                'author' => 'Architektur Dialoge',
                'author_email' => 'kontakt@architekturdialoge.ch',
                'datetime' => $time,
                'archive' => ($time > 0) ? ($time + 86400) : 0,
                'related_files' => $this->getRelatedFiles($row),
                'media' => $this->getMedia($row),


                'import_id' => $row['uid'],
                'import_source' => $this->importSource,
//                '_dynamicData' => [
                  #  'fullrow' => $row
//                ]
            ];

        }
        echo 'count:' . count($importData);
        $GLOBALS['TYPO3_DB']->sql_free_result($res);
        return $importData;
    }

    protected function getRelatedFiles(array $row)
    {

        $files = [];
        preg_match('/<link file:(.*)>PDF(.*)<\/link>/i',
            $row['bodytext'], $hits, PREG_OFFSET_CAPTURE);

        foreach ($hits as $hit) {
            $split = explode(' ', $hit[0]);
            if (MathUtility::canBeInterpretedAsInteger($split[0])) {
                $sysFile = $this->getDb()->exec_SELECTgetSingleRow(
                    '*',
                    'sys_file',
                    'uid=' . (int)$split[0]);
                if (is_array($sysFile)) {
                    $files[] = [
                        'file' => $split[0]
                    ];
                }
            }
        }

        return $files;
    }

    protected function getMedia(array $row)
    {

        $files = [];
        preg_match('/<link file:(.*)>MP3(.*)<\/link>/i',
            $row['bodytext'], $hits, PREG_OFFSET_CAPTURE);

        foreach ($hits as $hit) {
            $split = explode(' ', $hit[0]);
            if (MathUtility::canBeInterpretedAsInteger($split[0])) {
                $sysFile = $this->getDb()->exec_SELECTgetSingleRow(
                    '*',
                    'sys_file',
                    'uid=' . (int)$split[0]);
                if (is_array($sysFile)) {
                    $files[] = [
                        'image' => $split[0]
                    ];
                }
            }
        }

        return $files;
    }


    protected function getTime($string)
    {
        if (empty($string)) {
            return 0;
        }
        $string = strtolower($string);
        $search = [
            'januar' => '1',
            'janvier' => '1',
            'februar' => '2',
            'märz' => '3',
            'mÄrz' => '3',
            'april' => '4',
            'avril' => '4',
            'mai' => '5',
            'may' => '5',
            'juni' => '6',
            'juli' => '7',
            'august' => '8',
            'september' => '9',
            'septembre' => '9',
            'oktober' => '10',
            'october' => '10',
            'octobre' => '10',
            'oktobre' => '10',
            'november' => '11',
            'dezember' => '12',
            'december' => '12',
            '.' => '',
            '  ' => ' ',
        ];

        $string = str_replace(array_keys($search), array_values($search), $string);

        $split = explode('|', $string);
        $date = DateTime::createFromFormat('d m Y', trim($split[1]));
        if ($date) {


            if (isset($split[2]) && substr_count($split[2], ':') === 1) {
                $timeSplit = explode(':', $split[2]);
                $date->modify('+' . (int)$timeSplit[0] . ' hours');
                $date->modify('+' . (int)$timeSplit[1] . ' minutes');
            }

            return $date->getTimestamp();
        } else {

        }
        return 0;
    }

    /**
     * @param $row
     * @return int
     */
    protected function getPid($row)
    {
        switch ((int)$row['pid']) {
            case 261:
                $newPid = 259;
                break;
            case 262:
                $newPid = 255;
                break;
            case 263:
                $newPid = 258;
                break;
            default:
                $newPid = 200;
        }
        return $newPid;
    }

    /**
     * @return DatabaseConnection
     */
    protected function getDb()
    {
        return $GLOBALS['TYPO3_DB'];
    }


}
