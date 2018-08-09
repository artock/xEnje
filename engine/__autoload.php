<?php

require(ROOT.'/engine/__cfg.php');

require_once(ROOT.CFG['RB']);
require_once(ROOT.CFG['RBAC']);
require_once(ROOT.CFG['UTILS']);
require_once(ROOT.CFG['TMPLTS']);

UTL::_dbconnect(CFG['db']['host'], CFG['db']['name'], CFG['db']['log'], CFG['db']['pass']);

$models = glob(CFG['MODELS']);

foreach ($models as $model) {
    require_once($model);
}

UTL::_console("[Load resources] - Done");

?>
