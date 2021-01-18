<?php
  include ('../../conn.php');
  use PhpOffice\PhpWord\PhpWord;
  use PhpOffice\PhpWord\IOFactory;
  use \Smalot\PdfParser\Parser;
  use PhpOffice\PhpWord\PhpSpreadsheet;
  $file = $destination;
  require '../../API/vendor/autoload.php';
  $reader = \PhpOffice\PhpSpreadsheet\IOFactory::createReader('Xlsx');
  $reader->setReadDataOnly(TRUE);
  $spreadsheet = $reader->load($file);
  $worksheet = $spreadsheet->getActiveSheet();
  $highestRow = $worksheet->getHighestRow(); // e.g. 10
  $highestColumn = $worksheet->getHighestColumn(); // e.g 'F'
  //$highestColumnIndex = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::columnIndexFromString($highestColumn);
  $highestColumnIndex = 2;
  for ($row = 1; $row <= $highestRow; ++$row) {
      $tmsrc="";
      $tmtrgt="";
      for ($col = 1; $col <= $highestColumnIndex; ++$col) {
        if($col==1)
        {
          $tmsrc = $worksheet->getCellByColumnAndRow($col, $row)->getValue();
        }
        else if($col==2)
        {
          $tmtrgt = $worksheet->getCellByColumnAndRow($col, $row)->getValue();
        }
      }
      $sql="INSERT INTO translationmemorybase (tmsheet_ID, sourceText, targertText) VALUES ('$tmsheet_ID', '$tmsrc', '$tmtrgt')";
      if (mysqli_query($conn, $sql)) {
        echo "新记录插入成功";
      } else {
        echo '<script type="text/javaScript">alert("导入记录失败！");点击此处 <a href="javascript:history.back(-1);">返回</a> 重试</script>';
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
      }
  }
 ?>
