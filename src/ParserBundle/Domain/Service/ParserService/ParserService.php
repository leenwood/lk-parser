<?php

namespace App\ParserBundle\Domain\Service\ParserService;

use App\ParserBundle\Domain\DTO\ParserService\Adapter\VacancyObject\SalaryObject;
use App\ParserBundle\Domain\DTO\ParserService\Adapter\VacancyObject\VacancyObject;
use App\ParserBundle\Domain\DTO\ParserService\Adapter\VacancyObject\VacancyPreviewObject;
use App\ParserBundle\Domain\Exception\AdapterServiceException;
use Exception;
use Generator;
use GuzzleHttp\Exception\GuzzleException;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Psr\Log\LoggerInterface;

class ParserService
{

    /**
     * @param AdapterService $adapterService
     * @param LoggerInterface $logger
     */
    public function __construct(
        private AdapterService  $adapterService,
        private LoggerInterface $logger
    )
    {
    }


    /**
     * @param string $text
     * @param string $region
     * @param string $path
     * @param int|null $time
     * @param string|null $additionalWords
     * @param array $requestOption
     *
     * @return void
     *
     * @throws AdapterServiceException
     * @throws Exception
     * @throws GuzzleException
     * @throws \PhpOffice\PhpSpreadsheet\Writer\Exception
     */
    public function parseVacancies(
        string  $text,
        string  $region,
        string  $path = '',
        ?int    $time = null,
        array   $requestOption = []
    ): void
    {
        if (is_null($time)) {
            $time = time();
        }
        $option = ['text' => $text];
        $option = array_merge($option, $requestOption);
        $countPages = $this->adapterService->getVacanciesPagesCount($region, $option);
        $filename = $path . "vacancies_" . $time . ".xlsx";
        $newDocument = false;

        try {
            $reader = IOFactory::load($filename);
        } catch (\Throwable $e) {
            $newDocument = true;
        }

        if ($newDocument) {
            $reader = new Spreadsheet();
            $activeSheet = $reader->getActiveSheet();
            $this->createHeader($activeSheet);

            $line = 2;

            foreach ($this->getVacanciesList($countPages, $region, $option) as $vacancies) {

                foreach ($vacancies->items as $key => $item) {
                    $vacancy = $this->adapterService->getVacancyById($item->id);
                    if ($this->checkAdditionalWords($additionalWords, $vacancy->description)) {
                        continue;
                    }

                    $this->setCellsValue($activeSheet, $line, $vacancy, $item);

                    $line++;
                }
            }
        } else {
            $activeLine = 0;
            $row = 1;
            $activeSheet = $reader->getActiveSheet();
            while (true) {
                $cellValue = $activeSheet->getCell("A" . $row)->getValue();
                if (empty($cellValue)) {
                    $activeLine = $row;
                    break;
                }

                if ($row === 1000000) {
                    throw new \Exception("Слишком большой документ");
                }
                $row++;
            }
            $line = $activeLine;
            foreach ($this->getVacanciesList($countPages, $region, $option) as $vacancies) {
                foreach ($vacancies->items as $key => $item) {
                    $vacancy = $this->adapterService->getVacancyById($item->id);
                    if ($this->checkAdditionalWords($additionalWords, $vacancy->description)) {
                        continue;
                    }

                    $this->setCellsValue($activeSheet, $line, $vacancy, $item);

                    $line++;
                }
            }
        }

        $writer = new Xlsx($reader);
        $writer->save($filename);
    }

    /**
     * @param int $countPages
     * @param string $region
     * @param array $option
     *
     * @return Generator
     *
     * @throws AdapterServiceException
     */
    private function getVacanciesList(int $countPages = 0, string $region = "", array $option = []): Generator
    {
        for ($count = 0; $count < $countPages; $count++) {
            yield $this->adapterService->getVacanciesByRegion($region, $count + 1, $option);
        }
    }

    /**
     * @param string|null $additionalWords
     * @param string|null $description
     *
     * @return bool
     */
    private function checkAdditionalWords(?string $additionalWords, ?string $description): bool
    {
        if (is_null($additionalWords) || is_null($description)) {
            return false;
        }

        $additionalWords = explode(",", $additionalWords);


        foreach ($additionalWords as $word) {
            if (str_contains($word, $description)) {
                return false;
            }
        }
        return true;
    }

    /**
     * @param Worksheet $activeSheet
     * @param int $line
     * @param VacancyObject $vacancy
     * @param VacancyPreviewObject $item
     *
     * @return void
     *
     * @throws Exception
     */
    private function setCellsValue(Worksheet $activeSheet, int $line, VacancyObject $vacancy, VacancyPreviewObject $item): void
    {
        $activeSheet->setCellValue("A" . $line, $line - 1);
        $activeSheet->setCellValue("B" . $line, $item->name);
        $activeSheet->setCellValue("C" . $line, $item->alternate_url);
        $activeSheet->setCellValue("D" . $line, $this->clearDescription($vacancy->description));
        $activeSheet->setCellValue("G" . $line, $this->salaryToString($vacancy->salary));
        $activeSheet->getStyle('D' . $line)->getAlignment()->setWrapText(true);
        $activeSheet->mergeCells("D" . $line . ":F" . $line);
        $activeSheet->setCellValue('H'. $line, $item->employer->name);
        $activeSheet->setCellValue('I'. $line, $item->employer->id);
    }

    /**
     * @param Worksheet $worksheet
     * @return void
     */
    private function createHeader(Worksheet $worksheet): void
    {
        $worksheet->setCellValue('A1', '№');
        $worksheet->setCellValue('B1', 'Название вакансии');
        $worksheet->setCellValue('C1', 'Ссылка');
        $worksheet->setCellValue('D1', 'Задача и функционал');
        $worksheet->setCellValue('E1', 'Требования');
        $worksheet->setCellValue('F1', 'Условиях (в том числе оплаты)');
        $worksheet->setCellValue('G1', 'Результирующий уровень ЗП');
        $worksheet->setCellValue('H1', 'Название компании');
        $worksheet->setCellValue('I1', 'ИД компании');
    }


    /**
     * @param SalaryObject|null $salaryObject
     * @return string
     */
    private function salaryToString(?SalaryObject $salaryObject): string
    {
        if (is_null($salaryObject)) {
            return "Зарплата неуказанна";
        }

        if ($salaryObject->from && $salaryObject->to) {
            return "От " . $salaryObject->from . " до " . $salaryObject->to;
        }

        if ($salaryObject->from && is_null($salaryObject->to)) {
            return "От " . $salaryObject->from;
        }

        if (is_null($salaryObject->from) && $salaryObject->to) {
            return "до " . $salaryObject->to;
        }

        return "Зарплата неуказанна";
    }


    /**
     * @param string $description
     * @return string
     */
    private function clearDescription(string $description): string
    {
        return str_replace(['<p>', '</p>', '<i>', '</i>', '<ul>', '</ul>', '<li>', '</li>', '<em>', '</em>', '<strong>', '</strong>'], '', $description);
    }
}