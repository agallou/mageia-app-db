<?php

use \mageekguy\atoum;

/*
Write all on stdout.
*/
$stdOutWriter = new atoum\writers\std\out();

/*
Generate a CLI report.
*/
$cliReport = new atoum\reports\realtime\cli();
$cliReport->addWriter($stdOutWriter);

atoum\scripts\runner::getAutorunner()->getRunner()->addReport($cliReport);

/*
 * Xunit report
 */
$xunit = new atoum\reports\asynchronous\xunit();
atoum\scripts\runner::getAutorunner()->getRunner()->addReport($xunit);


/*
 * Xunit writer
 */
$writer = new atoum\writers\file('log/atoum.xml');
$xunit->addWriter($writer);