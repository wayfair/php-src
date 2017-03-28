--TEST--
PDO Common: PDOStatement::debugDumpParams() with emulated prepares
--SKIPIF--
<?php
if (!extension_loaded('pdo_dblib')) die('skip not loaded');
require dirname(__FILE__) . '/config.inc';
require dirname(__FILE__) . '/../../../ext/pdo/tests/pdo_test.inc';
PDOTest::skip();
?>
--FILE--
<?php
require dirname(__FILE__) . '/../../../ext/pdo/tests/pdo_test.inc';
$db = PDOTest::test_factory(dirname(__FILE__) . '/common.phpt');

$stmt = $db->query('SELECT 1');

// "Sent SQL" shouldn't display
var_dump($stmt->debugDumpParams());

$stmt = $db->prepare('SELECT :bool, :int, :string, :null');
$stmt->bindValue(':bool', true, PDO::PARAM_BOOL);
$stmt->bindValue(':int', 123, PDO::PARAM_INT);
$stmt->bindValue(':string', 'foo', PDO::PARAM_STR);
$stmt->bindValue(':null', null, PDO::PARAM_NULL);
$stmt->execute();

// "Sent SQL" should display
var_dump($stmt->debugDumpParams());

?>
--EXPECT--
SQL: [8] SELECT 1
Params:  0
NULL
SQL: [34] SELECT :bool, :int, :string, :null
Sent SQL: [27] SELECT 1, 123, N'foo', NULL
Params:  4
Key: Name: [5] :bool
paramno=-1
name=[5] ":bool"
is_param=1
param_type=6
Key: Name: [4] :int
paramno=-1
name=[4] ":int"
is_param=1
param_type=1
Key: Name: [7] :string
paramno=-1
name=[7] ":string"
is_param=1
param_type=2
Key: Name: [5] :null
paramno=-1
name=[5] ":null"
is_param=1
param_type=0
NULL
