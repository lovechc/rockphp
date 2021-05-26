<?php
/**
 * Csv文件工具
 */

namespace tools;

class Csv
{
    /**
     * 读取csv文件
     * @param string $file csv文件路径
     * @return array
     * @throws \Exception
     */
    public static function readCsv(string $file): array
    {
        setlocale(LC_ALL, 'zh_CN'); //linux系统下生效
        $data = [];   //文件数据
        if (!is_file($file) && !file_exists($file)) {
            throw new \Exception("文件异常或不存在");
        }
        $fp = fopen($file, "r");
        while (!feof($fp)) {
            $arr = fgetcsv($fp);
            if (is_array($arr)) {
                $data[] = $arr;
            }
        }
        fclose($fp);
        return $data;
    }

    /**
     * 写入csv
     * csv 只能记录字符串
     * 如果是想以数字字符串表示字符串，如:01232，单元格的显示数据将 是科学记数法，隐式数据还是 01232，但一旦被excel打开编辑，该值将就改为 1232
     * 如果有多种值都希望输出为字符串，请使用 excel类导出
     * @param array $data
     * @param string $fileName
     * @param string $path
     * @return bool
     * @throws \Exception
     */
    public static function putCsv(array $data, string $fileName, string $path): bool
    {
        try {
            if (!is_dir($path)) {
                mkdir($path, 0755, true);
            }
            $fileName = $path . DIRECTORY_SEPARATOR . $fileName . '.csv';
            $fp = fopen($fileName, 'w');
            foreach ($data as $item) {
                fputcsv($fp, $item);
            }
            fclose($fp);
            return true;
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }
}



