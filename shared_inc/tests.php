<?php

chdir("..");
include_once("shared_inc/wiki_functions.inc.php");

echo '<h1>extract_link_target</h2>';
test_it_link("[[User:Flominator]]", "User:Flominator", false);
test_it_link(" %nbsp;  [[User:Flominator]] %nbsp; ", "User:Flominator", false);
test_it_link("[[User:Flominator|Flo]]", "User:Flominator", false);
test_it_link("[[Flominator|Flo]]", "Flominator", false);
test_it_link("[[Flo]]", "Flo", false);
test_it_link(" [[Flo]] ", "Flo", false);
test_it_link("#WEITERLEITUNG[[Flo]] ", "Flo", false);

test_it_link("[[User:Flominator]]", "Flominator", true);
test_it_link("[[User:Flominator|Flo]]", "Flominator", true);
test_it_link(" [[Flo]] ", "Flo", false);

test_it_link(" [[Flo ", false, false);
test_it_link("Flo ]] ", false, false);

test_it_link("there was [[User:Flominator|Flo]] and some other, which was called [[User:Lupo|]]", "User:Flominator", false);
test_it_link("there was [[User:Flominator]] and some other, which was called [[User:Lupo|]]", "User:Flominator", false);

echo '<h1>extract_template_parameter</h2>';
test_it_template("{{Bilderangebot|Benutzer=Flominator}}", "Benutzer", "Flominator");
test_it_template("{{Bilderangebot|Benutzer=Flominator|Param2=anderer}}", "Benutzer", "Flominator");
test_it_template("{{Bilderangebot|Benutzer=Flominator
|Param2=anderer}}", "Benutzer", "Flominator");

test_it_template("{{Bilderangebot|Benutzer=Flominator
		|Param2=anderer}}", "Benutzer", "Flominator");

test_it_template("{{Bilderangebot|von=hier|Param2=und nicht von hier}}", "von", "hier");
test_it_template("{{Bilderangebot|Param2=und nicht von hier|von=hier}}", "von", "hier");
test_it_template("{{Bilderangebot|Param2=und nicht von hier| von = hier}}", "von", "hier");

test_it_template("{{Bilderangebot|Param2=und nicht von hier|von = hier}}", "von", "hier");
test_it_template("{{Bilderangebot|Param2=und nicht von hier| von = hier}}", "von", "hier");
test_it_template("{{Bilderangebot|Param2=und nicht von hier|  von = hier}}", "von", "hier");

test_it_template("{{Bilderangebot|Param2=und nicht von hier|nach = hier}}", "von", "");
//$is_debug =true;
function test_it_link($in, $out_expected, $do_cut)
{
    $out_actual = extract_link_target($in, $do_cut);
    
    echo "Test case <pre>" . $in . '</pre>';
    if($out_expected == $out_actual)
    {
        echo " <b>passed </b>";
    }
    else
    {
        echo " failed. Result was $out_actual";
    }
	echo "<br><hr>";
}



function test_it_template($in_text, $in_parameter, $out_expected)
{
    $out_actual = extract_template_parameter($in_text, $in_parameter);
    
    echo "Test case <pre>" . $in_text . " => " . $in_parameter . '</pre>';
	
	if($out_expected == $out_actual)
    {
        echo " <b>passed </b>";
    }
    else
    {
        echo " failed. Result was $out_actual";
    }
	
	echo "<br><hr>";
}

