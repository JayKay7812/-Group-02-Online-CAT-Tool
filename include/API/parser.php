<?php
  include ('../conn.php');

  use PhpOffice\PhpWord\PhpWord;
  use PhpOffice\PhpWord\IOFactory;
  use \Smalot\PdfParser\Parser;
  use PhpOffice\PhpWord\PhpSpreadsheet;
  $file = $destination;
  echo($sourceLanguage);
  //文件解析
  if ($ftype=="docx")
  {
    require 'PhpWord/vendor/autoload.php';
    $phpWord = new PhpWord();
    function getTextElement($E)
    {
      $sections = IOFactory::load($E)->getSections();
      $srctxt="";
      foreach($sections as $section)
      {
            $elements=$section->getElements();
            $xas='';
            $result = [];
            $inResult=[];
            $text=[];
            foreach($elements as $inE) {
                $ns = get_class($inE);
                $elName = explode('\\', $ns)[3];
                print_r("name=".$elName."//");
                if($elName == 'TextRun') {
                  print_r("TextRunStart:");
                  $subelement=$inE->getElements();
                  foreach($subelement as $finaly){
                    $ns1 = get_class($finaly);
                    $elName1 = explode('\\', $ns1)[3];
                    print_r("name1=".$elName1.",");
                    if($elName1 == "Text")
                    {
                      $srctxt=$srctxt.$finaly->getText();
                      print_r("TextPart:".$finaly->getText());
                    }
                  }
                  echo '</br>';
                }
                else if($elName == "PreserveText")
                {
                  print_r($inE->getText()[4]);
                  $srctxt=$srctxt.$inE->getText()[4]."\n";
                }
        }
      print_r($srctxt);
      return $srctxt;
      }
    }
    $srctxt=getTextElement($file);
  }
  else if($ftype=="pdf")
  {
    require 'vendor/autoload.php';
    $parser = new Parser();
    $pdf = $parser->parseFile($file);
    $srctxt = $pdf->getText();
  }
  else if($ftype=="xlsx")
  {
    require 'vendor/autoload.php';
    $reader = \PhpOffice\PhpSpreadsheet\IOFactory::createReader('Xlsx');
    $reader->setReadDataOnly(TRUE);
    $spreadsheet = $reader->load($file);

    $worksheet = $spreadsheet->getActiveSheet();
    foreach ($worksheet->getRowIterator() as $row) {
        $cellIterator = $row->getCellIterator();
        $cellIterator->setIterateOnlyExistingCells(TRUE);
        foreach ($cellIterator as $cell) {
            $celltxt=$cell->getValue();
            $sql="INSERT INTO translationbase (translationsheet_ID, sourceText, translation_Property) VALUES ('$translationsheet_ID', '$celltxt', 12)";
            if (mysqli_query($conn, $sql)) {
              echo "新记录插入成功";
            } else {
              echo '<script type="text/javaScript">alert("导入记录失败！");点击此处 <a href="javascript:history.back(-1);">返回</a> 重试</script>';
              echo "Error: " . $sql . "<br>" . mysqli_error($conn);
            }
          }
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
  //英文分句
  if ($sourceLanguage=="en-US")
  {
    
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
      $sql="INSERT INTO translationbase (translationsheet_ID, sourceText, translation_Property) VALUES ('$translationsheet_ID', '$temp[$k]', 12)";
      if (mysqli_query($conn, $sql)) {
        echo "新记录插入成功";
      } else {
        echo '<script type="text/javaScript">alert("导入文件失败！");点击此处 <a href="javascript:history.back(-1);">返回</a> 重试</script>';
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
      }
    }

    
    
  }
  //中文分句
  else if($sourceLanguage=="zh-CN")
  {
    print("zh_CN");
    //分句
    $temp = preg_split("/(\n|，|。|！|？|；)/", $srctxt);
    //还原每句
    foreach($temp as $k => $v)
    {
      //$temp[$k] = special_revert($v);
      $sql="INSERT INTO translationbase (translationsheet_ID, sourceText, translation_Property) VALUES ('$translationsheet_ID', '$temp[$k]', 12)";
      if (mysqli_query($conn, $sql)) {
        echo "新记录插入成功";
      } else {
        echo '<script type="text/javaScript">alert("导入文件失败！");点击此处 <a href="javascript:history.back(-1);">返回</a> 重试</script>';
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
      }
    }
  }
?>
