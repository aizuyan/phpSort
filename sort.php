<?php
/**
 * php的常用排序算法的介绍和实现
 * author   燕睿涛(luluyrt@163.com)
 */
class Sort{
    /**
     * 交换两个数据的顺序
     * int $a 
     * int $b 要交换的两个数据
     * int $flag 交换数据的方法
     */
    private static function swap(&$a,&$b,$flag=1){
        switch ($flag) {
            case 0:
                $tmp= $a;
                $a     = $b;
                $b     = $tmp;
                unset($tmp);
                break;
            case 1:
                $a     = $a + $b;
                $b     = $a - $b;
                $a     = $a - $b;
                break;
            
            default:
                # code...
                break;
        }
        return true;
    }

    /*******************************冒泡排序*******************************/
    /**
     *时间复杂度计算
     *冒泡排序的时间复杂度是:
     * (n-1) + (n-2) + ... + 2 + 1 = (((n-1)+1)/2)*(n-1) = (n^2-n)/2
     * 可以看出冒泡排序的时间复杂度是固定的，(n^2-n)/2或者O(n^2)
     * 但最好的情况是O(n)，所有的数据排序都正确，一次比较之后没有移动任何一个数据
     *
     */

    /**
     * array $arr 要排序的数组
     * boolean $flag true/false 升序/降序
     */
    public static function bubbleSort(&$arr,$flag=true){
        $flag ? self::bubbleSortUp($arr) : self::bubbleSortDown($arr);
    }

    /**
     * 冒泡排序的升序方法
     */
    private static function bubbleSortUp(&$arr){
        $len = count($arr);
        for($i = 0; $i < $len; $i++){
            for($j = 0; $j < $len - $i - 1; $j++){
                $arr[$j] > $arr[$j + 1] && 
                self::swap($arr[$j], $arr[$j+1]);
            }
        }
    }

    /**
     * 冒泡排序的降序方法
     */
    private static function bubbleSortDown(&$arr){
        $len = count($arr);
        for($i = 0; $i < $len; $i++){
            for($j = 0; $j < $len - $i - 1; $j++){
                $arr[$j] < $arr[$j + 1] &&
                self::swap($arr[$j], $arr[$j + 1]);
            }
        }
    }
    /*******************************冒泡排序 end*******************************/    


    /*******************************选择排序***********************************/    
    /**
     * 时间复杂度计算
     * 选择排序的时间复杂度是固定的
     * (n-1) + (n-2) + ... + 2 + 1 = (((n-1)+1)/2)*(n-1) = (n^2-n)/2
     * 可以看出冒泡排序的时间复杂度是固定的，(n^2-n)/2或者O(n^2)
     */
    /**
     * array $arr 要排序的数组
     * boolean $flag true/false 从小到大/从大到小
     */
    public static function selectionSort(&$arr,$flag=true){
        $flag ? self::selectionSortUp($arr) : self::selectionSortDown($arr);
    }
    /**
     * 选择排序升序
     */
    private static function selectionSortUp(&$arr){
        $len = count($arr);
        $tmp = null; //本次比较最小的元素下表
        for($i = 0; $i < $len; $i++){
            $tmp = $i;
            for($j = $i + 1; $j < $len; $j++){
                $tmp = $arr[$tmp] > $arr[$j] ? $j : $tmp;
            }
            $tmp != $i &&
            self::swap($arr[$tmp], $arr[$i]);
        }
    }
    /**
     * 选择排序降序
     */
    private static function selectionSortDown(&$arr){
        $len = count($arr);
        $tmp = null; //本次比较最小的元素下表
        for($i = 0; $i < $len; $i++){
            $tmp = $i;
            for($j = $i + 1; $j < $len; $j++){
                $tmp = $arr[$tmp] < $arr[$j] ? $j : $tmp;
            }
            $tmp != $i &&
            self::swap($arr[$tmp], $arr[$i]);
        }
    }
    /*******************************选择排序 end***********************************/ 

    /*******************************快速排序***************************************/
    /**
     * 快速排序采用了分治的思想，以数组中的一个数为基准将数组分为两部分，对这两部分进行递归
     * 挖坑填数+分治
     * 
     */
    public static function quickSort(&$arr,$flag=true){
        $len = count($arr) - 1;
        $flag ? self::quickSortUp($arr, 0, $len) : self::quickSortDown($arr, 0, $len);
    }

    /**
     * 快速排序升序
     */
    private static function quickSortUp(&$arr, $begin, $end){
        //停止递归的条件
        if($begin >= $end){
            return; 
        }
        //将数组的开始和结束下标进行存储，用与递归
        $_begin = $begin;
        $_end   = $end;

        //本次递归的划分标准
        $benchmark = $arr[$begin];
        while($begin < $end){
            //填上前面的坑，挖开后面的坑
            //先开始的一定要把等于的要交换了，不然挥排序出错
            while($begin < $end && $arr[$end] > $benchmark)
                $end--;
            //完成之后移动一个位置，下次循环时不用再次比较该正确的位置
            $begin < $end && self::swap($arr[$begin],$arr[$end]) && $end--;
            //填上后面的坑，挖开前面的坑
            while ($begin < $end && $arr[$begin] <= $benchmark)
                $begin++;
            $begin < $end && self::swap($arr[$begin],$arr[$end]) && $begin++;
        }
        $arr[$begin] = $benchmark;
        self::quickSortUp($arr, $_begin, $begin-1);
        self::quickSortUp($arr, $begin+1, $_end);
    }
    /**
     * 快速排序降序
     */
    private static function quickSortDown(&$arr, $begin, $end){
        if($begin >= $end){
            return;
        }
        $_begin     = $begin;
        $_end       = $end;
        $benchmark  = $arr[$begin];
        while($begin < $end){
            //这里一定要是小于号，确保后面任何一个等于benchmark的数被掠过，
            //例如：benckmark=1 , 1,-2,1,-2; 
            while($begin < $end && $arr[$end] < $benchmark)
                $end--;
            $begin < $end && self::swap($arr[$begin],$arr[$end]) && $end--;
            while($begin < $end && $arr[$begin] >= $benchmark)
                $begin++;
            $begin < $end && self::swap($arr[$begin], $arr[$end]) && $begin++;
        }
        $arr[$begin] = $benchmark;
        self::quickSortDown($arr, $_begin, $begin-1);
        self::quickSortDown($arr, $begin+1, $_end);
    }
    /*******************************快速排序 end***************************************/

}