<?php

chdir("..");
include_once("shared_inc/wiki_functions.inc.php");


test_it("[[User:Flominator]]", "User:Flominator", false);
test_it("[[User:Flominator|Flo]]", "User:Flominator", false);
test_it("[[Flominator|Flo]]", "Flominator", false);
test_it("[[Flo]]", "Flo", false);
test_it(" [[Flo]] ", "Flo", false);

test_it("[[User:Flominator]]", "Flominator", true);
test_it("[[User:Flominator|Flo]]", "Flominator", true);
test_it(" [[Flo]] ", "Flo", false);

test_it(" [[Flo ", false, false);
test_it("Flo ]] ", false, false);

function test_it($in, $out_expected, $do_cut)
{
    $out_actual = extract_link_target($in, $do_cut);
    
    echo "Test case " . $in;
    if($out_expected == $out_actual)
    {
        echo " <b>passed </b><br>";
    }
    else
    {
        echo " failed. Result was $out_actual<br>";
    }
}

