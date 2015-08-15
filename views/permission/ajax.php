<?
use liuxy\admin\widgets\GridTable;
use liuxy\admin\Module;
?>
<?
/**
 * @var $jtable \liuxy\admin\widgets\GridTable
 */
$jtable= GridTable::begin( [
    'header' => [
        'id'=>'#',
        'text'=>Module::t('name')
    ]]);?>
<?php foreach($data as $perm){

    $perm['id'] = substr($perm['id'],strlen('node_'),strlen($perm['id'])-strlen('node_'));
    echo $jtable->line($perm,['pid'=>$perm['id']],
        [
            'id'=>['href'=>'javascript:','onclick'=>'perm.get(this,\'node_'.$perm['id'].'\')'],
            'text'=>['href'=>'javascript:','onclick'=>'perm.get(this,\'node_'.$perm['id'].'\')']
        ]
        );
    ?>
<?}
if ($item) echo '<input type="hidden" id="goback" value="node_'.$item['parent_id'].'"/>';
?>
<? GridTable::end();?>