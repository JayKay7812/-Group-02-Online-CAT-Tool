<?php
  include ('../../conn.php');
  # 载入composer自动加载文件
  require '../../API/vendor/autoload.php';
  # 给类文件的命名空间起个别名
  use PhpOffice\PhpSpreadsheet\Spreadsheet;
  # 实例化 Spreadsheet 对象
  $spreadsheet = new Spreadsheet();
  $tbsheetID=$_GET["tbsheetid"];
  $sql="SELECT sourceText,targetText,term_Definition FROM termbase WHERE translationsheet_ID='$tbsheetID'";
  $result=mysqli_query($conn,$sql);
  print_r($result);
  // 输出每行数据
  while($row = mysqli_fetch_assoc($result)) {
        $return[] = $row;
      #$count=count($row);//不能在循环语句中，由于每次删除row数组长度都减小
      #for($i=0;$i<$count;$i++){
      #    unset($row[$i]);//删除冗余数据
      #}
      #array_push($arr,$row);
  }
  # 获取活动工作薄
  $sheet = $spreadsheet->getActiveSheet();
  $sheet->setCellValue('A1','sourceText');
  $sheet->setCellValue('B1','targetText');
  $sheet->setCellValue('C1','term_Definition');
  $sheet->fromArray(
        $return,
        3,
        'A2'
    );
  # Xlsx类 将电子表格保存到文件
  use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
  $writer = new Xlsx($spreadsheet);

  $writer->save('download/'.$tbsheetID.'.xlsx');

  echo '<script type="text/javaScript">alert("导出术语表成功！");window.location.href="javascript:history.back(-1)";</script>';

 ?>
