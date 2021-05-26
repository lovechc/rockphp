<?php
/**
 * Excel文件操作
 */

namespace tools;

use PhpOffice\PhpSpreadsheet\Cell\DataType;
use PhpOffice\PhpSpreadsheet\Exception;
use PhpOffice\PhpSpreadsheet\Reader;
use PhpOffice\PhpSpreadsheet\Writer;
use PhpOffice\PhpSpreadsheet\Spreadsheet;

class Excel
{
    /**
     * 获取列名 如:A
     * @param int $num [0 ~ 18277]
     * @return string
     * @throws Exception
     */
    private function getFieldName(int $num): string
    {
        $letter = ['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z'];
        $len = 26;  //26个字母

        //最多求三位 zzz列
        //个位 求模
        $one = $num % $len;

        //十位 每26位要进一
        $two = floor($num / $len) - 1;

        //百位 每26位要进一
        $three = floor($two / $len) - 1;

        $oneField = $twoField = $threeField = "";
        if ($three >= 0) {
            if ($three >= 26) {//最大zzz
                throw new Exception("超出最大列:ZZZ");
            }
            $threeField = $letter[$three];
        }
        if ($two >= 0) {
            if ($two >= $len) {
                $two = $two % $len;
            }
            $twoField = $letter[$two];
        }

        $oneField = $letter[$one];
        return $threeField . $twoField . $oneField;
    }

    /**
     * 读取excel
     * @param string $file excel文件路径
     * @return array
     * @throws \Exception
     */
    public static function readExcel(string $file): array
    {
        $data = [];//输出的数据
        $reader = new Reader\Xlsx();
        $spreadsheet = $reader->load($file);
        $names = $spreadsheet->getSheetNames();
        foreach ($names as $name) {
            $spreadsheet->setActiveSheetIndexByName($name);
            $data[] = $spreadsheet->getActiveSheet()->toArray();
        }
        return $data;
    }

    /**
     * 把数据导出为excel文件
     * 如果需要导出多页 excel文件，请重写
     * @param array $data 索引数组
     * @param string $filePath
     * @param string $title
     * @return bool
     * @throws Exception
     */
    public function putExcel(array $data, string $filePath = '', string $title = "sheet1"): bool
    {
        $spreadsheet = new Spreadsheet();
        $spreadsheet->getDefaultStyle()->getFont()->setName('宋体');
        $spreadsheet->getDefaultStyle()->getFont()->setSize('11');

        $spreadsheet->getProperties()
            ->setCreator("love")
            ->setLastModifiedBy("rock")
            ->setTitle("标题")
            ->setSubject("副标题")
            ->setDescription("excel 导出")
            ->setKeywords("php excel")
            ->setCategory("love");

        $sheet = $spreadsheet->getActiveSheet();
        if ($title)
            $sheet->setTitle($title);

        $r = 1; // 当前行
        foreach ($data as $row) {
            foreach ($row as $k => $v) {
                $field = self::getFieldName($k) . $r;
                $sheet->setCellValueExplicit($field, $v, DataType::TYPE_STRING);    // 设置单元格格式为string 并写入值
//                $sheet->setCellValue($field, $v);   // 设置值
//                $sheet->getStyle($field)->getAlignment()->setWrapText(true);  // 自动换行
            }
            $r++;
        }

        $writer = new Writer\Xlsx($spreadsheet);
        $writer->save($filePath);
        return true;
    }

}



