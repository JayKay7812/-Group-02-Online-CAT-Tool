<?php
  include ('../conn.php');
    use PhpOffice\PhpWord\PhpWord;
    use PhpOffice\PhpWord\IOFactory;
    require 'PhpWord/vendor/autoload.php';
    $file = 'test.docx';
    $phpWord = new PhpWord();
    $sections = IOFactory::load($file)->getSections();
    $srctxt="";
    foreach($sections as $section)
    {
      $elements=$section->getElements();
      foreach($elements as $element)
      {
        if($element!="TextBreak")
        {
          $subelement=$element->getElements();
          foreach($subelement as $finaly){
            $srctxt=$srctxt.$finaly->getText();
          }
        }
      }
    }
    echo $srctxt."</br>";
    $special[0] = array();
    $special[1] = array();
    //替换特殊的
    $srctxt = special_replace("/www\.[\w]+\.(com|cn|org)/i",$srctxt);
    $srctxt = special_replace("/\.(com|cn|org)/i",$srctxt);
    $srctxt = special_replace("/[0-9]\.[0-9]/",$srctxt);
    //分句
    $temp =preg_split("/[\?\.\!]\s?/",trim($srctxt));
    array_pop($temp);
    //还原每句
    foreach($temp as $k => $v)
    {
      $temp[$k] = special_revert($v);
      $sql="INSERT INTO translationbase (translationsheet_ID, sourceText, translation_Property) VALUES (0, '$temp[$k]', 12)";
      if (mysqli_query($conn, $sql)) {
        echo "新记录插入成功";
      } else {
        echo '<script type="text/javaScript">alert("导入文件失败！");点击此处 <a href="javascript:history.back(-1);">返回</a> 重试</script>';
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
      }
    }

    function special_replace($pattern, $str){
        global $special;
        preg_match_all($pattern, $str, $temp);
        if(is_array($temp))
            foreach($temp[0] as $k => $v){
                $special[0][] = $v;
                $special[1][] = $temp2 = "|".md5($v)."|";
                $str = str_replace($v, $temp2, $str);
            }
        return $str;
    }

    function special_revert($str){
        global $special;
        return str_replace($special[1],$special[0],$str);
    }
  /* PDF
  use \Smalot\PdfParser\Parser;
  require 'vendor/autoload.php';
  $parser = new Parser();
  $pdf = $parser->parseFile('test.pdf');
  $con = $pdf->getText();
  print_r($con);
  */
  /*
  use PhpOffice\PhpWord\PhpSpreadsheet;
  use PhpOffice\PhpWord\IOFactory;
  require 'vendor/autoload.php';
  $file = 'test.xlsx';
  $reader = \PhpOffice\PhpSpreadsheet\IOFactory::createReader('Xlsx');
  $reader->setReadDataOnly(TRUE);
  $spreadsheet = $reader->load("test.xlsx");

  $worksheet = $spreadsheet->getActiveSheet();

  echo '<table>' . PHP_EOL;
  foreach ($worksheet->getRowIterator() as $row) {
      echo '<tr>' . PHP_EOL;
      $cellIterator = $row->getCellIterator();
      $cellIterator->setIterateOnlyExistingCells(TRUE);
      foreach ($cellIterator as $cell) {
          echo '<td>'.$cell->getValue().'</td>'.PHP_EOL;
      }
      echo '</tr>' . PHP_EOL;
  }
  echo '</table>' . PHP_EOL;
  */
?>
