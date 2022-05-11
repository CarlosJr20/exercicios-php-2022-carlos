<?php

namespace Galoa\ExerciciosPhp2022\WebScrapping;

use Box\Spout\Writer\Common\Creator\WriterEntityFactory;
use Box\Spout\Writer\Common\Creator\Style\StyleBuilder;
use Box\Spout\Common\Entity\Row;
class Scrapper
{
  public function scrap(\DOMDocument $dom): void
  {
    $list_n = $dom->getElementsByTagName('body')[0];
    $list_n = $list_n->childNodes[3]->childNodes[11];
    $docs_artc = [];
    foreach ($list_n->childNodes as $n) {
      if ($n->nodeName == "a") {
        $value = [];
        $authors = [];
        $value += ["ID" => $n->childNodes[2]->childNodes[1]->childNodes[1]->nodeValue];
        $value += ["Title" => $n->childNodes[0]->nodeValue];
        $value += ["Type" => $n->childNodes[2]->childNodes[0]->nodeValue];
        $i = 0;
        foreach ($n->childNodes[1]->childNodes as $a) {
          if ($a->nodeName == "span") {
            $authors += ["author-" . $i => [$a->nodeValue, $a->attributes[0]->nodeValue]];
          }
          $i++;
        }

        $value += ["Authors" => $authors];
        $docs_artc += [$n->childNodes[2]->childNodes[1]->childNodes[1]->nodeValue => $value];
      }
    }
    $writer = WriterEntityFactory::createXLSXWriter();
    $writer->openToFile(__DIR__ . '/../../webscrapping/New_Origin.xlsx');

    $sheet = $writer->getCurrentSheet();
    $sheet->setName('New_Origin');
   
    $Title = [
      WriterEntityFactory::createCell('ID'),
      WriterEntityFactory::createCell('TITLE'),
      WriterEntityFactory::createCell('TYPE'),
      WriterEntityFactory::createCell('AUTHOR 1'),
      WriterEntityFactory::createCell('AUTHOR 1 INSTITUTION'),
      WriterEntityFactory::createCell('AUTHOR 2'),
      WriterEntityFactory::createCell('AUTHOR 2 INSTITUTION'),
      WriterEntityFactory::createCell('AUTHOR 3'),
      WriterEntityFactory::createCell('AUTHOR 3 INSTITUTION'),
      WriterEntityFactory::createCell('AUTHOR 4'),
      WriterEntityFactory::createCell('AUTHOR 4 INSTITUTION'),
      WriterEntityFactory::createCell('AUTHOR 5'),
      WriterEntityFactory::createCell('AUTHOR 5 INSTITUTION'),
      WriterEntityFactory::createCell('AUTHOR 6'),
      WriterEntityFactory::createCell('AUTHOR 6 INSTITUTION'),
      WriterEntityFactory::createCell('AUTHOR 7'),
      WriterEntityFactory::createCell('AUTHOR 7 INSTITUTION'),
      WriterEntityFactory::createCell('AUTHOR 8'),
      WriterEntityFactory::createCell('AUTHOR 8 INSTITUTION'),
      WriterEntityFactory::createCell('AUTHOR 9'),
      WriterEntityFactory::createCell('AUTHOR 9 INSTITUTION')
    ];
    $titleRow = WriterEntityFactory::createRow($Title);
    $writer->addRow($titleRow);
    foreach ($docs_artc as $a) {
      $cells = [];
      array_push($cells, WriterEntityFactory::createCell($a['ID']));
      array_push($cells, WriterEntityFactory::createCell($a['Title']));
      array_push($cells, WriterEntityFactory::createCell($a['Type']));
      foreach ($a["Authors"] as $b) {
        array_push($cells, WriterEntityFactory::createCell($b[0]));
        array_push($cells, WriterEntityFactory::createCell($b[1]));
      }
      $titleRow = WriterEntityFactory::createRow($cells);
      $writer->addRow($titleRow);
    }
    $writer->close();
  }
}