<!DOCTYPE html>
<html>
    <head>
        <style>
            table .c { color: red }
            .a .c { color: green }
        </style>
    </head>
    <body>
        <div>
            <h1>TEST1</h1>
            <table id="t">
                <tr>
                    <td class="c">Текст <span id="countdown" style="color: red"></span></td>
                </tr>
            </table>
            <input type="button" value="COLOR1" onmouseup="reset()" onclick="document.getElementsByTagName('tr')[0].className = 'a'"/> <!-- ячейка -->
            <input type="button" value="COLOR2" onmouseup="reset()" onclick="document.getElementsByClassName('c')[0].style.color = 'green'"/> <!-- ячейка -->
            <input type="button" value="COLOR3" onmouseup="reset()" onclick="document.getElementById('t').className = 'a'"/> <!-- ячейка -->
            <input type="button" value="COLOR4" onmouseup="reset()" onclick="colChange('row')"/> <!-- строка -->
            <input type="button" value="COLOR5" onmouseup="reset()" onclick="colChange('table')"/> <!-- таблица -->
            <span id="countdown" style="color: red"></span>
            <script>
                function colChange(element) {
                    document.getElementsByClassName("c")[0].removeAttribute("class");
                    if (element == 'table') {
                        document.getElementById('t').style.color = 'green';
                    }
                    if (element == 'row') {
                        document.getElementsByTagName('tr')[0].style.color = 'green';
                    }
                }
                function reset() {
                    var x = document.getElementById("countdown");
                    setTimeout(function(){ x.innerHTML="...3" }, 0);
                    setTimeout(function(){ x.innerHTML="..2" }, 1000);
                    setTimeout(function(){ x.innerHTML=".1" }, 2000);
                    setTimeout("location.reload(true);", 3000);
                }
            </script>
        </div>
        <div>
            <h1>TEST2</h1>
            <p>SELECT * FROM `category` WHERE `parent_category_id`=0 AND MID(name, 1, 4)='авто';</p>
            <p>SELECT * FROM category WHERE id IN (SELECT `parent_category_id` FROM category WHERE `parent_category_id` !=0 GROUP BY `parent_category_id` HAVING COUNT(*) BETWEEN 1 AND 3);</p>
            <p>SELECT * FROM category WHERE id NOT IN (SELECT DISTINCT `parent_category_id` FROM category);</p>
            <p>2й и 3й запросы можно ускорить, прописав количество категорий следующего уровня</p>
        </div>
        <div>
            <h1>TEST3</h1>
            <?php
            function isCorrect($str)
            {
                $brackets = array(
                    array('(', ')'),
                    array('{', '}')
                );
                $stack = array();
                for ($i = 0; $i < strlen($str); $i++) {
                    $br = $str[$i];
                    for ($j = 0; $j < count($brackets); $j++) {
                        if ($br == $brackets[$j][0]) {
                            array_push($stack, $br);
                            break;
                        } elseif ($br == $brackets[$j][1]) {
                            if (reset($brackets[$j]) == end($stack)) {
                                array_pop($stack);
                                break;
                            } else {
                                return false;
                            }
                        }
                    }
                }
                return true;
            }

            $assert = "";
            function assert_failed($file, $line) {
                echo "<p style='background: red; color: white'>Assertion failed in $file on line $line\n</p>";
                $GLOBALS['assert'] = 1;
            }

            assert_options (ASSERT_CALLBACK, 'assert_failed');
            assert_options (ASSERT_WARNING, 0);

            assert(isCorrect('') === true);
            assert(isCorrect('()') === true);
            assert(isCorrect('{()}') === true);
            assert(isCorrect('{()}{}') === true);
            assert(isCorrect('(())') === true);
            assert(isCorrect('{({({({()})})})}') === true);
            assert(isCorrect('{(})') === false);
            if (!$assert) {
                echo '<p style="background: green; color: white">Correct</p>';
            }
            ?>
            
        </div>
        <div>
            <h1>TEST4</h1>
        
        <?php
class Product
{
    var $name;
    var $price;
    function __construct($name, $price)
    {
        $this->name = $name;
        $this->price = $price;
    }
}

class Discounts
{
    var $product1;
    var $discount;
    function __construct($discount, $product1)
    {
        $this->discount = $discount;
        $this->product1 = $product1;
    }
    function getDiscount()
    {
        return $this->discount;
    }
    function getPriceTotal()
    {
        return $this->product1->price * (100-$this->discount)/100;
    }
}
class DiscountsDuo extends Discounts
{
    var $product2;
    function __construct($discount, $product1, $product2)
    {
        parent::__construct($discount, $product1);
        $this->product2 = $product2;
    }
    function getPriceTotal()
    {
        return ($this->product1->price + $this->product2->price) * (100-$this->discount)/100;
    }
}
class DiscountsTrio extends Discounts
{
    var $product3;
    function __construct($discount, $product1, $product2, $product3)
    {
        parent::__construct($discount, $product1);
        $this->product2 = $product2;
        $this->product3 = $product3;
    }
    function getPriceTotal()
    {
        return ($this->product1->price + $this->product2->price + $this->product3->price) * (100-$this->discount)/100;
    }
}
class DiscountsDuoArray extends Discounts
{
    var $arrayAll;
    function __construct($discount, $product1, $array1)
    {
        parent::__construct($discount, $product1);
        //сортировать по цене
        $this->arrayAll = array();
        foreach ($array1 as $k) {
            array_push($this->arrayAll, new DiscountsDuo($discount, $product1, $k));
        }
    }
    function getPriceTotal()
    {
        throw new Exception('error');
    }
}
class DiscountManager
{
    var $discountsArray = array();
    function add($obj)
    {
        if($obj instanceof DiscountsDuoArray) {
            foreach ($obj->arrayAll as $k) {
                if ($k instanceof Discounts) {
                    array_push($this->discountsArray, $k);
                }
            }
        } elseif ($obj instanceof Discounts) {
            array_push($this->discountsArray, $obj);
        }
    }
}
class Order
{
    var $orderArray = array();
    function add($obj)
    {
        array_push($this->orderArray, $obj);
    }
    function getSum()
    {
        $sum = 0;
        foreach($this->orderArray as $k) {
            $sum += $k->price;
        }
        return $sum;
    }
}
class Calculator
{
    var $order;
    var $dm;
    var $total = array();
    function __construct($order, $dm)
    {
        $this->order = $order;
        $this->dm = $dm;
    }
    function getCalcDiscDuo($k)
    {
        do {
                $loop = "";
                if(($v1 = array_search($k->product1, $this->order->orderArray)) !== false) {
                    if(($v2 = array_search($k->product2, $this->order->orderArray)) !== false) {
                        array_push($this->total, $k->getPriceTotal());
                        unset($this->order->orderArray[$v1]);
                        unset($this->order->orderArray[$v2]);
                        $loop = "1"; 
                    }
                }
            } while ($loop);
    }
    function getCalcDiscTrio($k)
    {
        do {
                $loop = "";
                if(($v1 = array_search($k->product1, $this->order->orderArray)) !== false) {
                    if(($v2 = array_search($k->product2, $this->order->orderArray)) !== false) {
                        if(($v3 = array_search($k->product3, $this->order->orderArray)) !== false) {
                            array_push($this->total, $k->getPriceTotal());
                            unset($this->order->orderArray[$v1]);
                            unset($this->order->orderArray[$v2]);
                            unset($this->order->orderArray[$v3]);
                            $loop = "1";
                        }
                    }
                }
            } while ($loop);
    }
    function calculate()
    {
        $arrayFilter = array('A', 'C');
        function calcFilter($v)
        {
            if($v->name != 'A' && $v->name != 'C') {
                return true;
            }
        }
        function calcWalk(&$v, $k, $dcnt)
        {
            if(!in_array($v->name, $dcnt[1])) {
                $v->price *= $dcnt[0]; array_push($dcnt[1], $v->name);
            }
        }
        $cnt = count(array_filter($this->order->orderArray, "calcFilter"));
        if ($cnt >= 5) {
            array_walk($this->order->orderArray, "calcWalk", array(0.8, &$arrayFilter));
        } elseif ($cnt == 4) {
            array_walk($this->order->orderArray, "calcWalk", array(0.9, &$arrayFilter));
        } elseif ($cnt == 3) {
            array_walk($this->order->orderArray, "calcWalk", array(0.95, &$arrayFilter));
        }
        foreach($this->dm->discountsArray as $k) {
            if($k instanceof DiscountsDuo) {
                $this->getCalcDiscDuo($k);
            } elseif($k instanceof DiscountsTrio) {
                $this->getCalcDiscTrio($k);
            }
        }
        return $this->order->getSum() + array_sum($this->total);
    }
}

$a = new Product('A', 100);
$b = new Product('B', 200);
$c = new Product('C', 300);
$d = new Product('D', 400);
$e = new Product('E', 500);
$f = new Product('F', 600);
$g = new Product('G', 700);
$h = new Product('H', 800);
$i = new Product('I', 900);
$j = new Product('J', 1000);
$k = new Product('K', 1100);
$l = new Product('L', 1200);
$m = new Product('M', 1300);

$d1 = new DiscountsDuo(10, $a, $b);
$d2 = new DiscountsDuo(5, $d, $e);
$d3 = new DiscountsTrio(5, $e, $f, $g);
$d4 = new DiscountsDuoArray(5, $a, array($k, $l, $m));

$dm = new DiscountManager();
$dm->add($d1);
$dm->add($d2);
$dm->add($d3);
$dm->add($d4);

$order = new Order();
$order->add($a); $order->add($a); $order->add($b); $order->add($d); $order->add($e); $order->add($b); $order->add($m);
$order->add($e); $order->add($f); $order->add($g); $order->add($c); $order->add($a);
$order->add($a); $order->add($m);


$calc = new Calculator($order, $dm);

echo "Итого: ".$calc->calculate();

?>
        </div>
    </body>
</html>