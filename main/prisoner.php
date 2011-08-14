<?php
require_once __DIR__ .'/../app/command-line/CommandLineTool.php';
require_once __DIR__ .'/../app/model/StringStrategyFactory.php';

\prisoner\CommandLineTool::initEnvironment();
$tool = new \prisoner\GenerateTool();
$tool->run();
